// CONSTRUCTOR
BuildingCanvasPresenterView.prototype = new CanvasPresenterView();

function BuildingCanvasPresenterView(view) {
	CanvasPresenterView.apply(this, arguments);

	this.building = null;
	this.retrieveCount = 0;
	this.retrievedCount = 0;
};

// VARIABLES

BuildingCanvasPresenterView.TYPE_FLOORS = "floors";
BuildingCanvasPresenterView.TYPE_ELEMENTS = "elements";
BuildingCanvasPresenterView.TYPE_ELEMENT_ROOMS = "element_rooms";
BuildingCanvasPresenterView.TYPE_ELEMENT_DEVICES = "element_devices";
BuildingCanvasPresenterView.TYPE_NAVIGATION = "navigation";

BuildingCanvasPresenterView.Z_INDEX_FLOOR = 1000;
BuildingCanvasPresenterView.Z_INDEX_ELEMENT = 1500;
BuildingCanvasPresenterView.Z_INDEX_NAVIGATION = 2000;

$(function() {

	BuildingCanvasPresenterView.SETUP_FLOOR = {
		mode : Polygon.MODE_SHOW,
		shape : {
			fill : "#DEDBD6",
			stroke : "#CECBBD",
			strokeWidth : 2,
			opacity : 1
		},
		anchor : {
			visible : false,
			strokeWidth : 2,
			selected : {
				strokeWidth : 4
			}
		}
	};
	BuildingCanvasPresenterView.SETUP_ELEMENT_ROOM = {
		mode : Polygon.MODE_SHOW,
		shape : {
			fill : "#FFFFDE",
			stroke : "#BD8A63",
			strokeWidth : 2,
			selectable : true
		},
		anchor : {
			visible : false,
			strokeWidth : 2,
			selected : {
				strokeWidth : 4
			}
		},
		label : {
			visible : true,
			haselement : {
				visible : true
			}
		}
	};
	BuildingCanvasPresenterView.SETUP_ELEMENT_DEVICE = {
		mode : Polygon.MODE_SHOW,
		group : {
			visible : false
		},
		rectangle : {
			width : 10,
			height : 10,
			fill : "#000000",
			opacity : 0.9
		}
	};
	BuildingCanvasPresenterView.SETUP_NAVIGATION = {
		mode : Tree.MODE_SHOW,
		attrs : {
			opacity : 0.5
		},
		line : {
			stroke : "#424163",
			strokeWidth : 2
		},
		anchor : {
			visible : true,
			radius : 2,
			strokeWidth : 1,
			fill : "#232234",
			haselement : {
				fill : "red"
			}
		}
	};

	BuildingCanvasPresenterView.SETUP = {};
	BuildingCanvasPresenterView.SETUP[BuildingCanvasPresenterView.TYPE_FLOORS] = BuildingCanvasPresenterView.SETUP_FLOOR;
	BuildingCanvasPresenterView.SETUP[BuildingCanvasPresenterView.TYPE_ELEMENT_ROOMS] = BuildingCanvasPresenterView.SETUP_ELEMENT_ROOM;
	BuildingCanvasPresenterView.SETUP[BuildingCanvasPresenterView.TYPE_ELEMENT_DEVICES] = BuildingCanvasPresenterView.SETUP_ELEMENT_DEVICE;
	BuildingCanvasPresenterView.SETUP[BuildingCanvasPresenterView.TYPE_NAVIGATION] = BuildingCanvasPresenterView.SETUP_NAVIGATION;
});

// /VARIABLES

// FUNCTIONS

// ... GET

/**
 * @return {Number} Main floor, null if not found
 */
BuildingCanvasPresenterView.prototype.getMainBuildingFloor = function() {
	if (!this.building)
		return console.error("BuildingCanvasPresenterView.getMainBuildingFloor: Building is null", this.building);

	var buildingId = this.building.id;

	// Get Building Floors
	var buildingFloors = this.getBuildingFloorList().getFilteredList(function(floor) {
		return floor.buildingId == buildingId;
	});

	// Get main Floor
	var floorMain = null, i = 0;
	for (floorId in buildingFloors) {
		if (buildingFloors[floorId].main || i == 0)
			floorMain = floorId;
		i++;
	}

	return floorMain;
};

/**
 * @returns {Object}
 */
BuildingCanvasPresenterView.prototype.getSetup = function(type) {
	return BuildingCanvasPresenterView.SETUP[type] || {};
};

BuildingCanvasPresenterView.prototype.getLevelSwitchDirection = function(levelFrom, levelTo) {
	if (!levelFrom || !levelTo)
		return 1;

	var floorFrom = this.getBuildingFloorList().getItem(levelFrom);
	var floorTo = this.getBuildingFloorList().getItem(levelTo);

	if (!floorFrom || !floorTo)
		return 1;

	return floorFrom.order < floorTo.order ? 1 : -1;
};

/**
 * @param elementType
 * @param elementId
 * @returns {BuildingElementRoomPolygon}
 */
BuildingCanvasPresenterView.prototype.getBuildingElementElements = function(elementType, elementId) {
	var elements = null;

	switch (elementType) {
	case "device":
		elements = this.getElements(BuildingCanvasPresenterView.TYPE_ELEMENT_DEVICES, this.levelSelected);
		break;
	case "room":
		elements = this.getElements(BuildingCanvasPresenterView.TYPE_ELEMENT_ROOMS, this.levelSelected);
		break;
	}

	if (!elements)
		return;

	
	var children = elements.getChildren();
	for ( var i = 0; i < children.length; i++) {
		if (children[i].element && children[i].element.id == elementId)
			return children[i];
	}
	return null;
};

// ... ... LIST ADAPTER

/**
 * @returns {ListAdapter}
 */
BuildingCanvasPresenterView.prototype.getBuildingList = function() {
	throw new Error("BuildingCanvasPresenterView.getBuildingList should be overwritten");
};

/**
 * @returns {ListAdapter}
 */
BuildingCanvasPresenterView.prototype.getBuildingFloorList = function() {
	throw new Error("BuildingCanvasPresenterView.getBuildingFloorList should be overwritten");
};

/**
 * @returns {ListAdapter}
 */
BuildingCanvasPresenterView.prototype.getBuildingElementList = function() {
	throw new Error("BuildingCanvasPresenterView.getBuildingElementList should be overwritten");
};

/**
 * @returns {ListAdapter}
 */
BuildingCanvasPresenterView.prototype.getBuildingNavigationList = function() {
	throw new Error("BuildingCanvasPresenterView.getBuildingNavigationList should be overwritten");
};

// ... ... /LIST ADAPTER

// ... ... ELEMENT

/**
 * @return {Object}
 */
BuildingCanvasPresenterView.prototype.getCanvasLoaderElement = function() {
	throw new Error("BuildingCanvasPresenterView.getCanvasLoaderElement should be overwritten");
};

// ... ... /ELEMENT

// ... /GET

// ... CREATE

/**
 * @return {BuildingFloorPolygon}
 */
BuildingCanvasPresenterView.prototype.createBuildingFloorPolygon = function(attrs, setup) {
	var defaultSetup = this.getSetup(BuildingCanvasPresenterView.TYPE_FLOORS);
	return new BuildingFloorPolygon(attrs || {}, $.extend(true, defaultSetup, setup || {}));
};

/**
 * @return {BuildingElementRoomPolygon}
 */
BuildingCanvasPresenterView.prototype.createBuildingElementRoomPolygon = function(attrs, setup, element) {
	var defaultSetup = this.getSetup(BuildingCanvasPresenterView.TYPE_ELEMENT_ROOMS);
	return new BuildingElementRoomPolygon(attrs || {}, $.extend(true, defaultSetup, setup || {}), element || null);
};

/**
 * @return {BuildingElementDeviceShape}
 */
BuildingCanvasPresenterView.prototype.createBuildingElementDeviceShape = function(attrs, setup, element) {
	var defaultSetup = this.getSetup(BuildingCanvasPresenterView.TYPE_ELEMENT_DEVICES);
	return new BuildingElementDeviceShape(attrs || {}, $.extend(true, defaultSetup, setup || {}), element || null);
};

/**
 * @return {BuildingNavigationTree}
 */
BuildingCanvasPresenterView.prototype.createBuildingNavigationTree = function(attrs, setup) {
	var defaultSetup = this.getSetup(BuildingCanvasPresenterView.TYPE_NAVIGATION);
	return new BuildingNavigationTree(attrs || {}, $.extend(true, defaultSetup, setup || {}));
};

// ... /CREATE

// ... DO

BuildingCanvasPresenterView.prototype.doBindEventHandler = function() {
	CanvasPresenterView.prototype.doBindEventHandler.call(this);
	var context = this;

	// LIST ADAPTER

	// Building list
	this.getBuildingList().addNotifyOnChange(function(type, object) {
		switch (type) {
		case "add":
			context.handleRetrievedBuilding(object);
			break;
		}
	});

	// Building Floor list
	this.getBuildingFloorList().addNotifyOnChange(function(type, object) {
		switch (type) {
		case "addall":
			context.handleRetrievedBuildingFloors(object);
			break;
		}
	});

	// Building Element list
	this.getBuildingElementList().addNotifyOnChange(function(type, object) {
		switch (type) {
		case "add":
			context.handleChangedBuildingElement(object);
			break;
		case "addall":
			context.handleRetrievedBuildingElements(object);
			break;
		}
	});

	// Building Navigation list
	this.getBuildingNavigationList().addNotifyOnChange(function(type, object) {
		switch (type) {
		case "addall":
			context.handleRetrievedBuildingNavigation(object);
			break;
		}
	});

	// /LIST ADAPTER

	// EVENTS

	// Retrieve event
	this.getView().getController().getEventHandler().registerListener(RetrieveEvent.TYPE,
	/**
	 * @param {RetrieveEvent}
	 *            event
	 */
	function(event) {
		context.handleRetrieve(event.getRetrieveType());
	});

	// Retrieved event
	this.getView().getController().getEventHandler().registerListener(RetrievedEvent.TYPE,
	/**
	 * @param {RetrievedEvent}
	 *            event
	 */
	function(event) {
		context.handleRetrieved(event.getRetrievedType(), event.getRetrieved());
	});

	// ... CANVAS

	// Select event
	this.getView().getController().getEventHandler().registerListener(SelectEvent.TYPE,
	/**
	 * @param {SelectEvent}
	 *            event
	 */
	function(event) {
		context.handleSelect(event.getSelectType(), event.getObject());
	});

	// Floor select event
	this.getView().getController().getEventHandler().registerListener(FloorSelectEvent.TYPE,
	/**
	 * @param {FloorSelectEvent}
	 *            event
	 */
	function(event) {
		context.doLevelSelect(event.getFloorId());
	});

	// Fit event
	this.getView().getController().getEventHandler().registerListener(FitEvent.TYPE,
	/**
	 * @param {FitEvent}
	 *            event
	 */
	function(event) {
		context.doFit(event.getFitType(), event.getElement());
	});

	// Select canvas event
	this.getView().getController().getEventHandler().registerListener(SelectCanvasEvent.TYPE,
	/**
	 * @param {SelectCanvasEvent}
	 *            event
	 */
	function(event) {
		context.handleSelectCanvas(event.getSelectType(), event.getElement());
	});

	// ... /CANVAS

	// /EVENTS

	// CANVAS

	$(window).keydown(function(event) {
		// Bind shift
		if (event.which == 16) {
			context.stage.fire("selectable", {
				selectable : true
			});
		}
	}).keyup(function(event) {
		// Bind shift
		if (event.which == 16) {
			context.stage.fire("selectable", {
				selectable : false
			});
		}
	});

	this.getCanvasContentElement().bind("contextmenu", function(e) {
		return false;
	});

	// ... MOUSE SCROLL

	// Get wrapper dom
	var canvasWrapper = document.getElementById(this.getCanvasContentElement().attr("id"));

	// Adding the event listerner for Mozilla
	if (window.addEventListener)
		canvasWrapper.addEventListener('DOMMouseScroll', function(event) {
			event.preventDefault();
			context.handleScroll(event);
		}, false);

	// for IE/OPERA etc
	canvasWrapper.onmousewheel = function(event) {
		event.preventDefault();
		context.handleScroll(event);
	};

	// ... /MOUSE SCROLL

	// /CANVAS

};

BuildingCanvasPresenterView.prototype.doFit = function(type, element) {
	if (!type || !element)
		return console.error("BuildingCanvasPresenterView.doFit: Type or element not given", type, element);

	switch (type) {
	case "room":
		var elementElement = this.getBuildingElementElements(element.typeGroup, element.id);
		if (elementElement)
			this.doFitToStage(type, elementElement.getCoordinates());
		break;
	}
};

// ... /DO

// ... HANDLE

// ... ... RETRIEVED

BuildingCanvasPresenterView.prototype.handleRetrieve = function(type) {
	switch (type) {
	case "buildingcreator":
		this.getCanvasLoaderElement().show();
		this.getCanvasContentElement().hide();
		this.getCanvasLoaderElement().find(".loading_building").show();
		this.retrieveCount++;
		break;

//	case "building":
//		this.getCanvasLoaderElement().find(".loading_building").show();
//		this.retrieveCount++;
//		break;
//
//	case "building_floors":
//		this.getCanvasLoaderElement().find(".loading_floors").show();
//		this.retrieveCount++;
//		break;
//
//	case "building_elements":
//		this.getCanvasLoaderElement().find(".loading_elements").show();
//		this.retrieveCount++;
//		break;
//
//	case "building_navigation":
//		this.getCanvasLoaderElement().find(".loading_navigation").show();
//		this.retrieveCount++;
//		break;
	}
};

BuildingCanvasPresenterView.prototype.handleRetrieved = function(type, retrieved) {
	switch (type) {
	case "buildingcreator":
		this.getCanvasLoaderElement().find(".loading_building").hide();
		this.retrievedCount++;
		break;

//	case "building":
//		this.handleRetrievedBuilding(retrieved);
//		this.getCanvasLoaderElement().find(".loading_building").hide();
//		this.retrievedCount++;
//		break;
//
//	case "building_floors":
//		this.handleRetrievedBuildingFloors(retrieved);
//		this.getCanvasLoaderElement().find(".loading_floors").hide();
//		this.retrievedCount++;
//		break;
//
//	case "building_elements":
//		this.handleRetrievedBuildingElements(retrieved);
//		this.getCanvasLoaderElement().find(".loading_elements").hide();
//		this.retrievedCount++;
//		break;
//
//	case "building_navigation":
//		this.handleRetrievedBuildingNavigation(retrieved);
//		this.getCanvasLoaderElement().find(".loading_elements").hide();
//		this.retrievedCount++;
//		break;
	}

	if (type == "buildingcreator") { //this.retrievedCount == this.getController().getRetrieveCount()) {
		this.getCanvasLoaderElement().hide();
		this.getCanvasContentElement().show();
		
		var floorSelect = retrieved.info.floors[0] || this.getMainBuildingFloor() || this.levelSelected;

//		var floorSelect = this.levelSelected;
//		if (!floorSelect)
//			floorSelect = this.getMainBuildingFloor();

//		this.getEventHandler().handle(new FloorSelectEvent(floorSelect));
		this.handleLoaded();
		this.doLevelSelect(floorSelect);
	}
};

BuildingCanvasPresenterView.prototype.handleRetrievedBuilding = function(building) {
	if (typeof building != "object")
		return console.error("BuildingCanvasPresenterView.handleRetrievedBuilding: Building is not object", building);
	this.building = building;
};

BuildingCanvasPresenterView.prototype.handleRetrievedBuildingFloors = function(floors) {
	if (typeof floors != "object")
		return console.error("BuildingCanvasPresenterView.handleRetrievedBuilding: Floors is not object", floors);

	// Draw Floors
	for (floorId in floors) {
		this.drawBuildingFloor(floors[floorId]);
	}
};

BuildingCanvasPresenterView.prototype.handleRetrievedBuildingElements = function(elements) {
	if (typeof elements != "object")
		return console.error("BuildingCanvasPresenterView.handleRetrievedBuildingElements: Elements is not object", elements);

	// Draw Elements
	for (elementId in elements) {
		if (!elements[elementId].deleted)
			this.drawBuildingElement(elements[elementId]);
	}
};

BuildingCanvasPresenterView.prototype.handleRetrievedBuildingNavigation = function(nodes) {
	if (typeof nodes != "object")
		return console.error("BuildingCanvasPresenterView.handleRetrievedBuildingNavigation: Navigation nodes is not object", nodes);

	var floorData = {};
	for ( var nodeId in nodes) {
		var node = nodes[nodeId];
		if (!floorData[node.floorId])
			floorData[node.floorId] = {
				anchors : {},
				relationship : {}
			};

		floorData[node.floorId].anchors[nodeId] = node;
		floorData[node.floorId].relationship[nodeId] = node.edges;
	}

	this.drawBuildingNavigation(floorData);
};

// ... ... /RETRIEVED

// ... ... SELECTED

BuildingCanvasPresenterView.prototype.handleSelect = function(type, object) {
	switch (type) {
	case "element":
		var elementElement = this.getBuildingElementElements(object.typeGroup, object.id);
		if (elementElement) {
			if (object.typeGroup == "room")
				this.handleSelectCanvas("polygon", elementElement);
			else if (object.typeGroup == "device")
				this.handleSelectCanvas("device_shape", elementElement);
		}
		break;
	}
};

BuildingCanvasPresenterView.prototype.handleSelectCanvas = function(type, element) {
	if (this.getView().selected.element) {
		this.getView().selected.element.deselect();
	}

	if (!type || !element) {
		if (this.getView().selected.element)
			this.getView().selected.element.getLayer().draw();
		this.getView().selected = {};
		return;
	}

	this.getView().selected = {
		type : null,
		element : null
	};

	if (!element.isVisible())
		return;

	this.getView().selected = {
		type : type,
		element : element
	};

	this.getView().selected.element.select();

	switch (type) {
	case "polygon":
		// this.getView().selected.element.moveToTop();
		this.getView().selected.element.getLayer().draw();
		break;

	case "polygon_anchor":
		// this.getView().selected.element.polygon.moveToTop();
		this.getView().selected.element.getLayer().draw();
		break;

	case "device_shape":
		break;

	default:
		this.getView().selected = {};
	}

};

// ... ... /SELECTED

BuildingCanvasPresenterView.prototype.handleChangedBuildingElement = function(element) {
	if (!element)
		return console.error("BuildingCanvasPresenterView.handleChangedBuildingElement: Element is empty", element);
	var elementElements = this.getBuildingElementElements(element.id);

	if (elementElements) {
		elementElements.element = element;
		elementElements.createLabelIcon();
		elementElements.getLayer().draw();
	}
};

BuildingCanvasPresenterView.prototype.handleLoaded = function() {
	
};

// ... /HANDLE

// ... DRAW

BuildingCanvasPresenterView.prototype.draw = function(root) {
	CanvasPresenterView.prototype.draw.call(this, root);
	var context = this;

	// ON

	// this.stage.on("dragend", function(event) {
	// event.cancelBubble = true;
	// });
	//
	this.stage.on("click", function(event) {
		if (event.which == 3) {
			// context.getEventHandler().handle(new SelectCanvasEvent(null));
			this.fire("deselect", event);
		}
	});
	//
	// // this.stage.on("change", function(event) {
	// // // context.getEventHandler().handle(new AddHistoryEvent({}));
	// // });
	//
	this.stage.on("select", function(event) {
		context.getEventHandler().handle(new SelectCanvasEvent(event.type, event.node));
	});

	this.stage.on("deselect", function(event) {
		context.getEventHandler().handle(new SelectCanvasEvent());
	});

	this.stage.on("dragend", function(event) {
		context.setStageSettings();
	});

	// /ON

	// this.stage.draw();

};

BuildingCanvasPresenterView.prototype.drawBuildingFloor = function(floor) {
	if (typeof floor != "object")
		return console.error("BuildingCanvasPresenterView.drawBuildingFloor: Floor is not object", floor);

	// Layer
	var layer = new Kinetic.Layer({
		name : "building_floor_layer",
		id : floor.id,
		zindex : BuildingCanvasPresenterView.Z_INDEX_FLOOR
	});
	this.stage.add(layer);
	layer.setVisible(false);
	this.setLayer(BuildingCanvasPresenterView.TYPE_FLOORS, floor.id, layer);

	// Group
	var group = new Kinetic.Group({
		name : "building_floor_group",
		id : floor.id,
		visible : true
	});
	layer.add(group);
	this.setGroup(BuildingCanvasPresenterView.TYPE_FLOORS, floor.id, group);

	// Set bounds
	this.setBound(group);

	// Building Floor polygons
	var buildingFloorPolygons = new Kinetic.Group({
		name : "building_floor_polygons"
	});
	group.add(buildingFloorPolygons);
	this.setElements(BuildingCanvasPresenterView.TYPE_FLOORS, floor.id, buildingFloorPolygons);

	// Create Building Floor polygon
	if (floor.coordinates && jQuery.isArray(floor.coordinates)) {
		var coordinates = floor.coordinates;
		for (i in coordinates) {
			var polygon = this.createBuildingFloorPolygon();
			polygon.fromData(coordinates[i]);
			buildingFloorPolygons.add(polygon);
			polygon.bind();
		}
	} else
		console.error("BuildingCanvasPresenterView.drawFloor: Floor coordinates is not array", floor);

	layer.setZIndex(BuildingCanvasPresenterView.Z_INDEX_FLOOR);

	this.drawBuildingElementsLayer(floor);
	this.drawBuildingNavigationLayer(floor);

	layer.draw();
};

BuildingCanvasPresenterView.prototype.drawBuildingElementsLayer = function(floor) {
	// Layer
	var layer = new Kinetic.Layer({
		name : "building_element_layer",
		id : floor.id,
		zindex : BuildingCanvasPresenterView.Z_INDEX_ELEMENT
	});
	this.stage.add(layer);
	layer.setVisible(false);
	this.setLayer(BuildingCanvasPresenterView.TYPE_ELEMENTS, floor.id, layer);
	layer.setZIndex(BuildingCanvasPresenterView.Z_INDEX_ELEMENT);

	// Group
	var group = new Kinetic.Group({
		name : "building_element_group",
		id : floor.id
	});
	layer.add(group);
	this.setGroup(BuildingCanvasPresenterView.TYPE_ELEMENTS, floor.id, group);

	// Building Element rooms
	var rooms = new Kinetic.Group({
		name : "building_element_rooms",
		id : floor.id
	});
	group.add(rooms);
	this.setElements(BuildingCanvasPresenterView.TYPE_ELEMENT_ROOMS, floor.id, rooms);
	rooms.setZIndex(100);

	// Building Element devices
	var devices = new Kinetic.Group({
		name : "building_element_devices",
		id : floor.id
	});
	group.add(devices);
	this.setElements(BuildingCanvasPresenterView.TYPE_ELEMENT_DEVICES, floor.id, devices);
	devices.setZIndex(1000);

	this.setBound(group);

};

BuildingCanvasPresenterView.prototype.drawBuildingNavigationLayer = function(floor) {

	// Layer
	var layer = new Kinetic.Layer({
		name : "building_navigation_layer",
		id : floor.id,
		zindex : BuildingCanvasPresenterView.Z_INDEX_NAVIGATION
	});
	this.stage.add(layer);
	layer.setVisible(false);
	this.setLayer(BuildingCanvasPresenterView.TYPE_NAVIGATION, floor.id, layer);
	layer.setZIndex(BuildingCanvasPresenterView.Z_INDEX_NAVIGATION);

	// Group
	var group = new Kinetic.Group({
		name : "building_navigation_group",
		id : floor.id
	});
	layer.add(group);
	this.setGroup(BuildingCanvasPresenterView.TYPE_NAVIGATION, floor.id, group);

	// Building Navigation trees
	var trees = new Kinetic.Group({
		name : "building_element_trees",
		id : floor.id
	});
	group.add(trees);
	this.setElements(BuildingCanvasPresenterView.TYPE_NAVIGATION, floor.id, trees);

	// Set bounds
	this.setBound(group);

	// Create Navigation tree
	var navigationTree = this.createBuildingNavigationTree();
	trees.add(navigationTree);
	navigationTree.bind();

	// Set Navigation
	this.setElements(BuildingCanvasPresenterView.TYPE_NAVIGATION, floor.id, trees);

};

/**
 * Draw Building Element
 * 
 * @param element
 */
BuildingCanvasPresenterView.prototype.drawBuildingElement = function(element) {

	// ROOM

	if (element.typeGroup == "room") {
		var buildingElementRooms = this.getElements(BuildingCanvasPresenterView.TYPE_ELEMENT_ROOMS, element.floorId);
		if (!buildingElementRooms)
			return console.error("BuildingCanvasPresenterView.drawBuildingElement: BuildingElementRooms is null");

		// Create Building Element Room polygon
		var polygon = this.createBuildingElementRoomPolygon(null, null, element);
		buildingElementRooms.add(polygon);
		polygon.fromData(element.coordinates);
		polygon.bind();
	}

	// /ROOM

	// DEVICE

	else if (element.typeGroup == "device") {
		var buildingElementDevices = this.getElements(BuildingCanvasPresenterView.TYPE_ELEMENT_DEVICES, element.floorId);
		if (!buildingElementDevices)
			return console.error("BuildingCanvasPresenterView.drawBuildingElement: BuildingElementDevices is null");

		// Create Building Element Device shape
		if (element.coordinates && jQuery.isArray(element.coordinates)) {
			var device = this.createBuildingElementDeviceShape(null, null, element);
			buildingElementDevices.add(device);
			device.createIcon();
			device.fromData(element.coordinates);
			device.bind();
		} else
			console.error("BuildingCanvasPresenterView.drawBuildingElement: BuildingElementRoom coordinates is not array", element);

	}

	// /DEVICE

};

/**
 * Draw Building Navigation
 * 
 * @param navigations
 */
BuildingCanvasPresenterView.prototype.drawBuildingNavigation = function(navigations) {
	if (typeof navigations != "object")
		return console.error("BuildingCanvasPresenterView.drawBuildingNavigation: Navigations is not object", navigations);

	for ( var floorId in navigations) {
		var tree = this.getElements(BuildingCanvasPresenterView.TYPE_NAVIGATION, floorId);

		if (tree) {
			var navigationTree = tree.getChildren()[0];

			if (navigationTree) {
				navigationTree.fromData(navigations[floorId]);
				navigationTree.bind();
			} else
				console.error("BuildingCanvasPresenterView.drawBuildingNavigation: Navigation tree is null for floor", floorId, navigations[floorId]);
		} else
			console.error("BuildingCanvasPresenterView.drawBuildingNavigation: Tree navigation for floor is null", floorId);
	}

};

// ... /DRAW

// /FUNCTIONS

// CLASS

var BuildingFloorPolygon, BuildingFloorPolygonLabel;
$(function() {

	// ... BUILDING FLOOR POLYGON

	// ... ... LABEL

	BuildingFloorPolygonLabel = function(config, polygon) {
		PolygonLabel.call(this, config, polygon);
	};
	BuildingFloorPolygonLabel.prototype = {};
	Kinetic.Util.extend(BuildingFloorPolygonLabel, PolygonLabel);

	// ... ... /LABEL

	// ... ... POLYGON

	BuildingFloorPolygon = function(config, setup) {
		Polygon.call(this, config, setup);
	};
	BuildingFloorPolygon.prototype = {};
	Kinetic.Util.extend(BuildingFloorPolygon, Polygon);

	// ... ... /POLYGON

	// ... /BUILDING FLOOR POLYGON

	// ... BUILDING ELEMENT POLYGON

	// ... ... LABEL

	BuildingElementRoomPolygonLabel = function(config, polygon) {
		PolygonLabel.call(this, config, polygon);
	};
	BuildingElementRoomPolygonLabel.prototype = {
		setLabelText : function() {
			if (this.polygon.element && this.polygon.element.name) {
				this.getText().setText(this.polygon.element.name);
				this.getText().setFontStyle("normal");
			} else {
				this.getText().setText("Unnamed");
				this.getText().setFontStyle("italic");
			}
		}
	};
	Kinetic.Util.extend(BuildingElementRoomPolygonLabel, PolygonLabel);

	// ... ... /LABEL

	// ... ... SHAPE

	BuildingElementRoomPolygonShape = function(config, polygon) {
		PolygonShape.call(this, config, polygon);
	};
	BuildingElementRoomPolygonShape.prototype = {
		handleClick : function(event) {
			if (!this.polygon.isCreating) {
				if (event.which == 1) {
					event.cancelBubble = true;
					this.getStage().fire("select", {
						'type' : "polygon",
						'node' : this.polygon
					});
				}
			}
		}
	};
	Kinetic.Util.extend(BuildingElementRoomPolygonShape, PolygonShape);

	// ... ... /SHAPE

	// ... ... POLYGON

	BuildingElementRoomPolygon = function(config, setup, element) {
		Polygon.call(this, config, setup);
		this.element = element || null;
		this.type = "building_element_polygon";
	};
	BuildingElementRoomPolygon.prototype = {
		createLabel : function(config) {
			return new BuildingElementRoomPolygonLabel(config, this);
		},
		createLabelIcon : function() {
			if (this.element) {
				var icon = IconBuildingCanvasUtil.createBuildingElementTypeIcon(this.element.type, this.element.typeGroup, {
					'fill' : "#333333",
					'stroke' : "#333333"
				});
				if (icon) {
					this.label.setIcon(icon);
					if (this.element.type == "wc" || this.element.type == "stairs" || this.element.type == "elevator" || this.element.type == "cafeteria") {
						this.label.noText = true;
					}
				}
				this.label.setLabelText();
			}
		},
		createShape : function(config) {
			return new BuildingElementRoomPolygonShape(config, this);
		},
		toData : function() {
			var data = {
				coordinates : {
					coordinates : this.getCoordinates(),
					center : this.label.toData()
				},
				changed : this.changed,
				deleted : this.deleted,
				changed : this.changed,
				deleted : this.deleted,
				typeGroup : "room"
			};
			if (this.element)
				data.elementId = this.element.id;
			return data;
		}
	};
	Kinetic.Util.extend(BuildingElementRoomPolygon, Polygon);

	// ... ... /POLYGON

	// ... /BUILDING ELEMENT POLYGON

	// ... BUILDING NAVIGATION TREE

	// ... ... ANCHOR

	BuildingNavigationTreeAnchor = function(config, tree) {
		TreeAnchor.call(this, config, tree);
		this.elementId = null;
	};
	BuildingNavigationTreeAnchor.prototype = {
		toData : function() {
			var data = TreeAnchor.prototype.toData.call(this);
			data["elementId"] = this.elementId;
			return data;
		},
		fromData : function(data) {
			if (data && data.elementId)
				this.elementId = data.elementId;
			TreeAnchor.prototype.fromData.call(this, data);
		},
		updateSetup : function() {
			TreeAnchor.prototype.updateSetup.call(this);
			if (this.tree.setup["anchor"]["haselement"] && this.elementId) {
				this.setAttrs(this.tree.setup["anchor"]["haselement"]);
			}
		}
	};
	Kinetic.Util.extend(BuildingNavigationTreeAnchor, TreeAnchor);

	// ... ... /ANCHOR

	// ... ... TREE

	BuildingNavigationTree = function(config, setup) {
		Tree.call(this, config, setup);
		this.type = "building_navigation_tree";
	};
	BuildingNavigationTree.prototype = {
		createAnchor : function(config) {
			return new BuildingNavigationTreeAnchor(config, this);
		}
	};
	Kinetic.Util.extend(BuildingNavigationTree, Tree);

	// ... ... /TREE

	// ... /BUILDING NAVIGATION TREE

	// ... BILDING ELEMENT DEVICE SHAPE

	BuildingElementDeviceShape = function(config, setup, element) {
		config = config || {};
		setup = setup || {};
		Kinetic.Group.call(this, $.extend(true, {
			name : "building_element_device",
			draggable : false,
			visible : false,
			width : 10,
			height : 10,
			offset : {
				x : 5,
				y : 5
			}
		}, setup['group'], config));

		this.setup = setup;
		this.setDraggable(this.setup.mode == Polygon.MODE_EDIT);
		this.element = element || null;
		this.isCreating = false;
		this.isSelected = false;
		this.changed = false;
		this.deleted = false;
		this.icon = null;

		// ... NODES

		this.rectangle = new Kinetic.Rect({
			width : 10,
			height : 10,
			fill : "#000000",
			opacity : 0.9
		});
		this.rectangle.setAttrs(setup['rectangle']);
		this.add(this.rectangle);

		// ... /NODES

		// ... ON

		this.on("dragend", function(event) {
			event.cancelBubble = true;
			this.moveToTop();
			this.changed = true;

			if (this.setup.mode == Polygon.MODE_EDIT) {
				this.getStage().fire("change", {
					node : this,
					type : "moved"
				});
			}
		});
		this.on("mouseover", function() {
			if (this.setup.mode == Polygon.MODE_EDIT) {
				$(this.getStage().content).css("cursor", "pointer");
			}
		});
		this.on("mouseout", function() {
			if (this.setup.mode == Polygon.MODE_EDIT) {
				$(this.getStage().content).css("cursor", "default");
			}
		});

		this.on("click", function(event) {
			if (this.setup.mode == Polygon.MODE_EDIT) {
				if (!this.isCreating) {
					if (event.which == 1) {
						this.getStage().fire("select", {
							type : "device_shape",
							node : this
						});
					} else if (event.which == 3 && this.isSelected) {
						this.getStage().fire("delete", {
							type : "device_shape",
							node : this
						});
						this.erase();
						this.getLayer().draw();
					}
				}
			}
		});

		// ... /ON

	};
	BuildingElementDeviceShape.prototype = {
		updateSetup : function(setup) {
			this.setup = $.extend(true, {}, this.setup, setup);
			this.setAttrs(this.setup["group"]);
			this.setDraggable(this.setup.mode == Polygon.MODE_EDIT);
			this.getLayer().draw();
		},
		setIcon : function(icon) {
			if (icon) {
				if (this.icon)
					this.icon.destroy();
				this.icon = icon;
				this.add(icon);
			}
			if (this.icon) {
				this.icon.setPosition((this.getWidth() / 2) - (icon.getWidth() / 2), (icon.getHeight() * -1) - 5);
			}
		},
		createIcon : function() {
			if (this.element) {
				var icon = IconBuildingCanvasUtil.createBuildingElementTypeIcon(this.element.type, this.element.typeGroup, {
					'fill' : "#333333",
					'stroke' : "#333333"
				});
				this.setIcon(icon);
			}
		},
		toData : function() {
			var coordinate = this.getPosition();
			var data = {
				coordinates : [ Core.roundNumber(coordinate.x, 2), Core.roundNumber(coordinate.y, 2) ]
			};
			data.typeGroup = "device";
			if (this.element)
				data.elementId = this.element.id;
			if (this.element)
				data.type = this.element.type;
			data.deleted = this.deleted;
			data.changed = this.changed;
			return data;
		},
		fromData : function(data) {
			if (!jQuery.isArray(data))
				return console.warn("BuildingElementDeviceShape.fromData: Data is not an array", data);

			var x = parseFloat(data[0]);
			var y = parseFloat(data[1]);

			this.setPosition(x, y);
		},
		bind : function() {
			var context = this;
			this.getLayer().on("setup", function(event) {
				if (event.type == "device_shape") {
					context.updateSetup(event.setup);
				}
			});
		},
		select : function() {
			this.isSelected = true;
			this.moveToTop();
			this.setAttrs(this.setup['group']['selected']);
			this.rectangle.setAttrs(this.setup['rectangle']['selected']);
			this.getLayer().draw();
		},
		deselect : function() {
			this.isSelected = false;
			this.setAttrs(this.setup['group']);
			this.rectangle.setAttrs(this.setup['rectangle']);
		},
		erase : function() {
			this.hide();
			this.deleted = true;
		},
		getCoordinates : function() {
			var position = this.getPosition();
			return [ Core.roundNumber(position.x, 2), Core.roundNumber(position.y, 2) ];
		},
		create : function(event) {
			var namespace = "mousemove.draw_device mouseup.draw_device";
			var positionRelative = KineticjsUtil.getPointerRelativePosition(this.getStage());
			var position = positionRelative ? positionRelative : {
				x : 0,
				y : 0
			};
			this.changed = true;

			// New device
			if (!event) {
				var context = this;
				this.isCreating = true;

				// Bind events
				this.getLayer().off(namespace);
				this.getLayer().on(namespace, function(event) {
					context.create(event);
				});
			} else if (positionRelative) {
				event.cancelBubble = true;

				// Move
				if (event.type == "mousemove") {
					this.show();
					if (!this.isDragging()) {
						this.setPosition(position);
						this.startDrag();
					}
				}
				// Place
				else if (event.type == "mouseup") {
					if (this.getStage().isDragging())
						return;
					this.stopDrag();
					this.isCreating = false;
					this.getLayer().off(namespace);
					// Cancel placing
					if (event.which == 3) {
						event.preventDefault();
						this.destroy();
						return;
					}

					this.bind();
					this.getStage().fire("change", {
						node : this,
						type : "created"
					});
				}
			}
		}
	};
	Kinetic.Util.extend(BuildingElementDeviceShape, Kinetic.Group);

	// ... /BUILDING ELEMENT DEVICE SHAPE

});

// /CLASS
