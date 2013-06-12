// CONSTRUCTOR
BuildingcreatorBuildingsCmsCanvasPresenterView.prototype = new BuildingCanvasPresenterView();

function BuildingcreatorBuildingsCmsCanvasPresenterView(view) {
	BuildingCanvasPresenterView.apply(this, arguments);

	this.floorMapShow = true;
	this.typeSelected = BuildingCanvasPresenterView.TYPE_FLOORS;
};

BuildingcreatorBuildingsCmsCanvasPresenterView.TYPE_FLOORS_MAP = "floors_map";
BuildingcreatorBuildingsCmsCanvasPresenterView.Z_INDEX_MAP = 500;

// VARIABLES

$(function() {

	BuildingcreatorBuildingsCmsCanvasPresenterView.SETUP_FLOOR = $.extend(true, {}, BuildingCanvasPresenterView.SETUP_FLOOR, {
		shape : {
			opacity : 0.5
		}
	});
	BuildingcreatorBuildingsCmsCanvasPresenterView.SETUP_FLOOR_EDIT = $.extend(true, {}, BuildingcreatorBuildingsCmsCanvasPresenterView.SETUP_FLOOR, {
		mode : Polygon.MODE_EDIT,
		shape : {
			fill : "#DEDBD6",
			stroke : "#CECBBD",
			strokeWidth : 2,
			opacity : 0.9,
			selected : {
				strokeWidth : 4,
				stroke : "#FF9999"
			}
		},
		anchor : {
			visible : true
		}
	});

	BuildingcreatorBuildingsCmsCanvasPresenterView.SETUP_ELEMENT_ROOM_EDIT = $.extend(true, {}, BuildingCanvasPresenterView.SETUP_ELEMENT_ROOM, {
		mode : Polygon.MODE_EDIT,
		shape : {
			fill : "#FFFFDE",
			stroke : "#BD8A63",
			strokeWidth : 2,
			opacity : 0.5,
			selected : {
				fill : "#C9DAF8",
				strokeWidth : 4
			}
		},
		anchor : {
			visible : true
		},
		label : {
			visible : true
		}
	});

	BuildingcreatorBuildingsCmsCanvasPresenterView.SETUP_ELEMENT_DEVICE = $.extend(true, {}, BuildingCanvasPresenterView.SETUP_ELEMENT_DEVICE, {
		group : {
			visible : true,
			opacity : 0.5
		}
	});
	BuildingcreatorBuildingsCmsCanvasPresenterView.SETUP_ELEMENT_DEVICE_EDIT = $.extend(true, {}, BuildingcreatorBuildingsCmsCanvasPresenterView.SETUP_ELEMENT_DEVICE, {
		mode : Polygon.MODE_EDIT,
		group : {
			visible : true,
			opacity : 1,
			selected : {}
		},
		rectangle : {
			selected : {
				fill : "#417EE6"
			}
		}
	});

	BuildingcreatorBuildingsCmsCanvasPresenterView.SETUP_NAVIGATION_EDIT = $.extend(true, {}, BuildingCanvasPresenterView.SETUP_NAVIGATION, {
		mode : Tree.MODE_EDIT,
		line : {
			stroke : "#424163",
			strokeWidth : 4
		},
		anchor : {
			visible : true,
			fill : "#15A89E",
			stroke : "#0C635D",
			radius : 8
		}
	});

	BuildingcreatorBuildingsCmsCanvasPresenterView.SETUP = {};

	BuildingcreatorBuildingsCmsCanvasPresenterView.SETUP[BuildingCanvasPresenterView.TYPE_FLOORS] = {};
	BuildingcreatorBuildingsCmsCanvasPresenterView.SETUP[BuildingCanvasPresenterView.TYPE_FLOORS][BuildingCanvasPresenterView.TYPE_FLOORS] = BuildingcreatorBuildingsCmsCanvasPresenterView.SETUP_FLOOR_EDIT;
	BuildingcreatorBuildingsCmsCanvasPresenterView.SETUP[BuildingCanvasPresenterView.TYPE_FLOORS][BuildingCanvasPresenterView.TYPE_ELEMENT_ROOMS] = BuildingCanvasPresenterView.SETUP_ELEMENT_ROOM;
	BuildingcreatorBuildingsCmsCanvasPresenterView.SETUP[BuildingCanvasPresenterView.TYPE_FLOORS][BuildingCanvasPresenterView.TYPE_ELEMENT_DEVICES] = BuildingcreatorBuildingsCmsCanvasPresenterView.SETUP_ELEMENT_DEVICE;
	BuildingcreatorBuildingsCmsCanvasPresenterView.SETUP[BuildingCanvasPresenterView.TYPE_FLOORS][BuildingCanvasPresenterView.TYPE_NAVIGATION] = BuildingCanvasPresenterView.SETUP_NAVIGATION;

	BuildingcreatorBuildingsCmsCanvasPresenterView.SETUP[BuildingCanvasPresenterView.TYPE_ELEMENTS] = {};
	BuildingcreatorBuildingsCmsCanvasPresenterView.SETUP[BuildingCanvasPresenterView.TYPE_ELEMENTS][BuildingCanvasPresenterView.TYPE_FLOORS] = BuildingcreatorBuildingsCmsCanvasPresenterView.SETUP_FLOOR;
	BuildingcreatorBuildingsCmsCanvasPresenterView.SETUP[BuildingCanvasPresenterView.TYPE_ELEMENTS][BuildingCanvasPresenterView.TYPE_ELEMENT_ROOMS] = BuildingcreatorBuildingsCmsCanvasPresenterView.SETUP_ELEMENT_ROOM_EDIT;
	BuildingcreatorBuildingsCmsCanvasPresenterView.SETUP[BuildingCanvasPresenterView.TYPE_ELEMENTS][BuildingCanvasPresenterView.TYPE_ELEMENT_DEVICES] = BuildingcreatorBuildingsCmsCanvasPresenterView.SETUP_ELEMENT_DEVICE_EDIT;
	BuildingcreatorBuildingsCmsCanvasPresenterView.SETUP[BuildingCanvasPresenterView.TYPE_ELEMENTS][BuildingCanvasPresenterView.TYPE_NAVIGATION] = BuildingCanvasPresenterView.SETUP_NAVIGATION;

	BuildingcreatorBuildingsCmsCanvasPresenterView.SETUP[BuildingCanvasPresenterView.TYPE_NAVIGATION] = {};
	BuildingcreatorBuildingsCmsCanvasPresenterView.SETUP[BuildingCanvasPresenterView.TYPE_NAVIGATION][BuildingCanvasPresenterView.TYPE_FLOORS] = BuildingcreatorBuildingsCmsCanvasPresenterView.SETUP_FLOOR;
	BuildingcreatorBuildingsCmsCanvasPresenterView.SETUP[BuildingCanvasPresenterView.TYPE_NAVIGATION][BuildingCanvasPresenterView.TYPE_ELEMENT_ROOMS] = BuildingCanvasPresenterView.SETUP_ELEMENT_ROOM;
	BuildingcreatorBuildingsCmsCanvasPresenterView.SETUP[BuildingCanvasPresenterView.TYPE_NAVIGATION][BuildingCanvasPresenterView.TYPE_ELEMENT_DEVICES] = BuildingcreatorBuildingsCmsCanvasPresenterView.SETUP_ELEMENT_DEVICE;
	BuildingcreatorBuildingsCmsCanvasPresenterView.SETUP[BuildingCanvasPresenterView.TYPE_NAVIGATION][BuildingCanvasPresenterView.TYPE_NAVIGATION] = BuildingcreatorBuildingsCmsCanvasPresenterView.SETUP_NAVIGATION_EDIT;
});

// /VARIABLES

// FUNCTIONS

// ... GET

/**
 * @return {BuildingsCmsMainController}
 */
BuildingcreatorBuildingsCmsCanvasPresenterView.prototype.getController = function() {
	return BuildingCanvasPresenterView.prototype.getController.call(this);
};

/**
 * @return {DaoContainer}
 */
BuildingcreatorBuildingsCmsCanvasPresenterView.prototype.getDaoContainer = function() {
	return this.getController().getDaoContainer();
};

// ... ... LIST ADAPTER

/**
 * @returns {ListAdapter}
 */
BuildingcreatorBuildingsCmsCanvasPresenterView.prototype.getBuildingList = function() {
	return this.getDaoContainer().getBuildingDao().getListAdapter();
};

/**
 * @returns {ListAdapter}
 */
BuildingcreatorBuildingsCmsCanvasPresenterView.prototype.getBuildingFloorList = function() {
	return this.getDaoContainer().getFloorBuildingDao().getListAdapter();
};

/**
 * @returns {ListAdapter}
 */
BuildingcreatorBuildingsCmsCanvasPresenterView.prototype.getBuildingElementList = function() {
	return this.getDaoContainer().getElementBuildingDao().getListAdapter();
};

/**
 * @returns {ListAdapter}
 */
BuildingcreatorBuildingsCmsCanvasPresenterView.prototype.getBuildingNavigationList = function() {
	return this.getDaoContainer().getNavigationBuildingDao().getListAdapter();
};

// ... ... /LIST ADAPTER

// ... ... CANVAS

/**
 * @return {Object}
 */
BuildingcreatorBuildingsCmsCanvasPresenterView.prototype.getCanvasContentElement = function() {
	return this.getRoot().find("#buildingcreator_planner_content_canvas_content_wrapper");
};

/**
 * @return {Object}
 */
BuildingcreatorBuildingsCmsCanvasPresenterView.prototype.getCanvasLoaderElement = function() {
	return this.getRoot().find("#buildingcreator_planner_content_canvas_loader_wrapper");
};

// ... ... /CANVAS

/**
 * @returns {Object}
 */
BuildingcreatorBuildingsCmsCanvasPresenterView.prototype.getSetup = function(type) {
	var setupDefault = BuildingcreatorBuildingsCmsCanvasPresenterView.SETUP[this.typeSelected];
	if (!setupDefault)
		return {};
	var setup = setupDefault[type];
	return setup || {};
};

// ... /GET

// ... DO

BuildingcreatorBuildingsCmsCanvasPresenterView.prototype.doBindEventHandler = function() {
	BuildingCanvasPresenterView.prototype.doBindEventHandler.call(this);
	var context = this;

	// EVENTS

	// Map floor event
	this.getEventHandler().registerListener(MapFloorEvent.TYPE,
	/**
	 * @param {MapFloorEvent}
	 *            event
	 */
	function(event) {
		context.doFloorMapToggle();
	});

	// Menu event
	this.getEventHandler().registerListener(MenuEvent.TYPE,
	/**
	 * @param {MenuEvent}
	 *            event
	 */
	function(event) {
		context.handleMenuSelect(event.getMenu());
	});

	// Saving event
	this.getEventHandler().registerListener(SaveEvent.TYPE,
	/**
	 * @param {SaveEvent}
	 *            event
	 */
	function(event) {
		if (event.getSaveType() == "building") {
			context.doSave();
		}
	});

	// Saving event
	this.getEventHandler().registerListener(SavingEvent.TYPE,
	/**
	 * @param {SavingEvent}
	 *            event
	 */
	function(event) {
		context.handleSaving();
	});

	// Polygon event
	this.getEventHandler().registerListener(PolygonEvent.TYPE,
	/**
	 * @param {PolygonEvent}
	 *            event
	 */
	function(event) {
		context.doPolygonDraw();
	});

	// Polygon line event
	this.getEventHandler().registerListener(PolygonLineEvent.TYPE,
	/**
	 * @param {PolygonLineEvent}
	 *            event
	 */
	function(event) {
		if (context.getView().selected && context.getView().selected.type == "polygon_anchor")
			context.doPolygonLine(context.getView().selected.element, event.getLineType());
	});

	// Copy event
	this.getEventHandler().registerListener(CopyEvent.TYPE,
	/**
	 * @param {CopyEvent}
	 *            event
	 */
	function(event) {
		context.handleSelectedCopy();
	});

	// Delete event
	this.getView().getController().getEventHandler().registerListener(DeleteEvent.TYPE,
	/**
	 * @param {DeleteEvent}
	 *            event
	 */
	function(event) {
		context.handleSelectedDelete();
	});

	// Add history event
	this.getView().getController().getEventHandler().registerListener(AddHistoryEvent.TYPE,
	/**
	 * @param {AddHistoryEvent}
	 *            event
	 */
	function(event) {
		// context.handleHistoryAdd(event.getHistory());
	});

	// Undo history event
	this.getView().getController().getEventHandler().registerListener(UndoHistoryEvent.TYPE,
	/**
	 * @param {UndoHistoryEvent}
	 *            event
	 */
	function(event) {
		context.handleHistoryUndo();
	});

	// ... BUILDING ELEMENT CANVAS

	// Device element building canvas event
	this.getView().getController().getEventHandler().registerListener(DeviceElementBuildingCanvasEvent.TYPE,
	/**
	 * @param {DeviceElementBuildingCanvasEvent}
	 *            event
	 */
	function(event) {
		context.doBuildingElementDeviceDraw(event.getDevice());
	});

	// ... /BUILDING ELEMENT CANVAS

	// /EVENTS

	// Toolbar
	$("#toolbar_test").click(function() {
		context.doNavigationDraw();
	});

	$(document).keydown(function(e) {
		if (e.keyCode == 37) {
			context.stage.move(10, 0);
			context.stage.draw();
			return false;
		}
		if (e.keyCode == 38) {
			context.stage.move(0, 10);
			context.stage.draw();
			return false;
		}
		if (e.keyCode == 39) {
			context.stage.move(-10, 0);
			context.stage.draw();
			return false;
		}
		if (e.keyCode == 40) {
			context.stage.move(0, -10);
			context.stage.draw();
			return false;
		}
	});

};

BuildingcreatorBuildingsCmsCanvasPresenterView.prototype.doNavigationDraw = function() {
	var navigation = this.getElements(BuildingCanvasPresenterView.TYPE_NAVIGATION, this.levelSelected);
	if (!navigation)
		return console.error("BuildingcreatorBuildingsCmsCanvasPresenterView.doNavigationDraw: Navigation is null");
	navigation = navigation.getChildren()[0];
	if (!navigation)
		return console.error("BuildingcreatorBuildingsCmsCanvasPresenterView.doNavigationDraw: Navigation is null");

	navigation.createTree();
	navigation.getLayer().draw();
};

BuildingcreatorBuildingsCmsCanvasPresenterView.prototype.doPolygonDraw = function() {
	var polygon = null;
	switch (this.typeSelected) {
	case BuildingCanvasPresenterView.TYPE_ELEMENTS:
		var polygons = this.getElements(BuildingCanvasPresenterView.TYPE_ELEMENT_ROOMS, this.levelSelected);
		if (!polygons)
			return console.error("BuildingcreatorBuildingsCmsCanvasPresenterView.doPolygonDraw: Polygons is null");
		polygon = this.createBuildingElementRoomPolygon();
		break;
	case BuildingCanvasPresenterView.TYPE_FLOORS:
		var polygons = this.getElements(BuildingCanvasPresenterView.TYPE_FLOORS, this.levelSelected);
		if (!polygons)
			return console.error("BuildingcreatorBuildingsCmsCanvasPresenterView.doPolygonDraw: Polygons is null");
		polygon = this.createBuildingFloorPolygon();
		break;

	default:
		return console.error("BuildingcreatorBuildingsCmsCanvasPresenterView.doPolygonDraw: Selected type is not a polygon", this.typeSelected);
	}

	polygons.add(polygon);
	polygon.createPolygon();
	polygon.getLayer().draw();
};

BuildingcreatorBuildingsCmsCanvasPresenterView.prototype.doBuildingElementDeviceDraw = function(deviceType) {
	if (!deviceType)
		return console.error("BuildingcreatorBuildingsCmsCanvasPresenterView.doBuildingElementDeviceDraw: Device type is null");
	var devices = this.getElements(BuildingCanvasPresenterView.TYPE_ELEMENT_ROOMS, this.levelSelected);
	if (!devices)
		return console.error("BuildingcreatorBuildingsCmsCanvasPresenterView.doBuildingElementDeviceDraw: Devices is null");
	var device = this.createBuildingElementDeviceShape(null, null, {
		type : deviceType,
		typeGroup : 'device'
	});
	devices.add(device);
	device.createIcon();
	device.create();
	device.getLayer().draw();
};

BuildingcreatorBuildingsCmsCanvasPresenterView.prototype.doLevelSelect = function(floorId) {
	if (!floorId)
		return console.error("BuildingcreatorBuildingsCmsCanvasPresenterView.doLevelSelect: Floor not given", floorId);

	// SETUP

	// Navigation
	var navigationLayer = this.getLayer(BuildingCanvasPresenterView.TYPE_NAVIGATION, floorId);
	if (navigationLayer) {
		navigationLayer.fire("setup", {
			'type' : "tree",
			'setup' : this.getSetup(BuildingCanvasPresenterView.TYPE_NAVIGATION)
		});
	}

	// Elements
	var elementsLayer = this.getLayer(BuildingCanvasPresenterView.TYPE_ELEMENTS, floorId);
	if (elementsLayer) {
		elementsLayer.fire("setup", {
			'type' : "polygon",
			'setup' : this.getSetup(BuildingCanvasPresenterView.TYPE_ELEMENT_ROOMS)
		});
		elementsLayer.fire("setup", {
			'type' : "device_shape",
			'setup' : this.getSetup(BuildingCanvasPresenterView.TYPE_ELEMENT_DEVICES)
		});
	}

	// Floor
	var floorLayer = this.getLayer(BuildingCanvasPresenterView.TYPE_FLOORS, floorId);
	if (floorLayer) {
		floorLayer.fire("setup", {
			'type' : "polygon",
			'setup' : this.getSetup(BuildingCanvasPresenterView.TYPE_FLOORS)
		});
	}

	// /SETUP

	BuildingCanvasPresenterView.prototype.doLevelSelect.call(this, floorId);

	// Move selected layer to top
	var layer = this.getLayer(this.typeSelected, floorId);
	if (layer)
		layer.moveToTop();

	// De-select
	this.getEventHandler().handle(new SelectCanvasEvent());

	// Re-draw stage
	this.stage.draw();

};

BuildingcreatorBuildingsCmsCanvasPresenterView.prototype.doFloorMapToggle = function() {
	if (!this.levelSelected)
		return;

	var floorMap = this.getGroup(BuildingcreatorBuildingsCmsCanvasPresenterView.TYPE_FLOORS_MAP, this.levelSelected);
	if (!floorMap)
		return;

	this.floorMapShow = !this.floorMapShow;

	if (this.floorMapShow)
		floorMap.show();
	else
		floorMap.hide();

	floorMap.getLayer().draw();
};

BuildingcreatorBuildingsCmsCanvasPresenterView.prototype.doSave = function() {
	var saveData = {};

	// FLOORS

	var floors = this.elements[BuildingCanvasPresenterView.TYPE_FLOORS];
	saveData[BuildingsCmsMainController.TYPE_FLOORS] = {};
	for ( var floorId in floors) {
		saveData[BuildingsCmsMainController.TYPE_FLOORS][floorId] = [];
		for ( var i in floors[floorId].children) {
			if (!floors[floorId].children.deleted)
				saveData[BuildingsCmsMainController.TYPE_FLOORS][floorId].push(floors[floorId].children[i].toData());
		}
	}

	// /FLOORS

	// ELEMENTS

	saveData[BuildingsCmsMainController.TYPE_ELEMENTS] = {};

	var elements = this.elements[BuildingCanvasPresenterView.TYPE_ELEMENT_ROOMS];
	for ( var floorId in elements) {
		if (!saveData[BuildingsCmsMainController.TYPE_ELEMENTS][floorId])
			saveData[BuildingsCmsMainController.TYPE_ELEMENTS][floorId] = [];
		for ( var i in elements[floorId].children) {
			saveData[BuildingsCmsMainController.TYPE_ELEMENTS][floorId].push(elements[floorId].children[i].toData());
		}
	}

	var elements = this.elements[BuildingCanvasPresenterView.TYPE_ELEMENT_DEVICES];
	for ( var floorId in elements) {
		if (!saveData[BuildingsCmsMainController.TYPE_ELEMENTS][floorId])
			saveData[BuildingsCmsMainController.TYPE_ELEMENTS][floorId] = [];
		for ( var i in elements[floorId].children) {
			saveData[BuildingsCmsMainController.TYPE_ELEMENTS][floorId].push(elements[floorId].children[i].toData());
		}
	}

	// /ELEMENTS

	// NAVIGATION

	var navigations = this.elements[BuildingCanvasPresenterView.TYPE_NAVIGATION];
	saveData[BuildingsCmsMainController.TYPE_NAVIGATION] = {};
	for ( var floorId in navigations) {
		var navigation = navigations[floorId].children[0];
		if (navigation) {
			saveData[BuildingsCmsMainController.TYPE_NAVIGATION][floorId] = navigation.toData();
		}
	}

	// /NAVIGATION

	this.getEventHandler().handle(new EditEvent("building", saveData));
};

// ... /DO

// ... HANDLE

BuildingcreatorBuildingsCmsCanvasPresenterView.prototype.handleMenuSelect = function(menu) {
	var type = "";
	switch (menu) {
	case MenuBuildingcreatorBuildingsCmsPresenterView.TYPE_ELEMENTS:
		type = BuildingCanvasPresenterView.TYPE_ELEMENTS;
		break;
	case MenuBuildingcreatorBuildingsCmsPresenterView.TYPE_NAVIGATION:
		type = BuildingCanvasPresenterView.TYPE_NAVIGATION;
		break;

	default:
		type = BuildingCanvasPresenterView.TYPE_FLOORS;
		break;
	}
	this.typeSelected = type;

	if (this.levelSelected)
		this.doLevelSelect(this.levelSelected);
};

BuildingcreatorBuildingsCmsCanvasPresenterView.prototype.handleSaving = function(type) {
	this.getCanvasLoaderElement().find("#buildingcreator_planner_content_canvas_loader_status_wrapper").children().hide().filter(".saving").show();
	this.getCanvasLoaderElement().show();
	this.getCanvasContentElement().hide();
	// this.getCanvasLoaderStatusElement().children().hide();
	// this.getCanvasLoaderStatusElement().find(".saving").show();
	// this.getCanvasLoaderElement().show();
	// this.getCanvasContentElement().hide();
};

BuildingcreatorBuildingsCmsCanvasPresenterView.prototype.handleNavigationAnchor = function(navigationAnchor, pointer) {
	var pos = this.stage.getPosition();
	var offset = this.stage.getOffset();
	var scale = this.stage.getScale();
	var elements = this.getElements(BuildingCanvasPresenterView.TYPE_ELEMENT_ROOMS, this.levelSelected);

	if (elements) {
		// this.stage.setPosition(0, 0);
		// this.stage.setOffset(0, 0);
		// this.stage.setScale(1, 1);
		var position = pointer;

		var elementIntersect = null;
		for ( var i in elements.children) {
			if (elements.children[i].intersects(position)) {
				elementIntersect = elements.children[i];
				break;
			}
		}

		// this.stage.setPosition(pos);
		// this.stage.setOffset(offset);
		// this.stage.setScale(scale);

		var isUpdate = false;
		if (elementIntersect && elementIntersect.attrs.name == "polygon" && elementIntersect.type == "building_element_polygon") {
			isUpdate = navigationAnchor.elementId != elementIntersect.element.id;
			navigationAnchor.elementId = elementIntersect.element.id;
		} else {
			isUpdate = navigationAnchor.elementId != null;
			navigationAnchor.elementId = null;
		}
		if (isUpdate) {
			navigationAnchor.updateSetup();
			navigationAnchor.getLayer().draw();
		}
	}

};

// ... ... SELECT

BuildingcreatorBuildingsCmsCanvasPresenterView.prototype.handleSelectedCopy = function() {

	// COPY

	if (this.getView().selected.element) {
		if (this.getView().selected.type != "polygon")
			return;
		this.getView().selectedCopy = this.getView().selected;
	}

	// /COPY

	// PASTE

	if (!this.getView().selected.element) {
		if (this.getView().selectedCopy.type != "polygon" || !this.getView().selectedCopy.element)
			return;

		// var polygons = this.getView().selectedCopy.element.getParent();
		var polygons = this.getElements(this.typeSelected, this.levelSelected);
		if (polygons) {
			var polygon = this.getView().selectedCopy.element.copy();
			polygons.add(polygon);
			polygon.bind();
			if (this.getView().selectedCopy.element.getLayer()._id == polygons.getLayer()._id)
				polygon.move(20, 20);
			polygon.getLayer().draw();

			this.getEventHandler().handle(new AddHistoryEvent({}));
		}
	}

	// /PASTE

};

BuildingcreatorBuildingsCmsCanvasPresenterView.prototype.handleSelectedDelete = function() {
	if (!this.getView().selected.element)
		return false;
	var selected = this.getView().selected;
	var parent = selected.element.getParent();

	// Deselect
	this.getEventHandler().handle(new SelectCanvasEvent());

	// Delete selected
	selected.element.erase();

	// Draw layer
	parent.getLayer().draw();

	// Deleted event
	if (selected.type == "polygon" && selected.element.type == "building_element_polygon" && selected.element.element) {
		this.getEventHandler().handle(new ToastEvent("Deleting element"));
		this.getEventHandler().handle(new DeletedEvent("element", selected.element.element.id));
	}

	// Add history
	this.getEventHandler().handle(new AddHistoryEvent({
		type : "delete",
		element : selected,
		parent : parent
	}));
};

// ... ... /SELECT

BuildingcreatorBuildingsCmsCanvasPresenterView.prototype.handleHistoryUndo = function() {
	if (this.getView().history.length == 0)
		return;
	var historyObject = this.getView().history.pop();

	switch (historyObject.type) {
	case "delete":
		historyObject.node.undo();
		break;
	case "moved":
		historyObject.node.undoMove();
		break;
	}

	this.getEventHandler().handle(new UndidHistoryEvent(historyObject));

	if (historyObject.node)
		historyObject.node.getLayer().draw();
};

// ... /HANDLE

// ... DRAW

BuildingcreatorBuildingsCmsCanvasPresenterView.prototype.draw = function(root) {
	BuildingCanvasPresenterView.prototype.draw.call(this, root);
	var context = this;

	// BIND

	this.stage.on("change", function(event) {
		context.getEventHandler().handle(new AddHistoryEvent({
			type : event.type,
			node : event.node
		}));
		if (event.node.attrs.name == "tree_anchor" && event.type == "moved") {
			context.handleNavigationAnchor(event.node, event.pointer);
		}
	});

	// /BIND

};

BuildingcreatorBuildingsCmsCanvasPresenterView.prototype.drawBuildingFloor = function(floor) {
	BuildingCanvasPresenterView.prototype.drawBuildingFloor.call(this, floor);
	var context = this;

	if (typeof floor != "object")
		return console.error("BuildingcreatorBuildingsCmsCanvasPresenterView.drawBuildingFloor: Floor is not an object");

	// MAP

	// Layer
	var layerMap = new Kinetic.Layer({
		name : "floor_map_layer",
		id : floor.id,
		zindex : BuildingcreatorBuildingsCmsCanvasPresenterView.Z_INDEX_MAP
	});
	this.stage.add(layerMap);
	layerMap.setVisible(false);
	this.setLayer(BuildingcreatorBuildingsCmsCanvasPresenterView.TYPE_FLOORS_MAP, floor.id, layerMap);

	// Group
	var groupMap = new Kinetic.Group({
		name : "floor_map_group",
		id : floor.id
	});
	layerMap.add(groupMap);
	this.setGroup(BuildingcreatorBuildingsCmsCanvasPresenterView.TYPE_FLOORS_MAP, floor.id, groupMap);

	// Create image object
	var imageObj = new Image();
	imageObj.onload = function() {

		// Create image
		var image = new Kinetic.Image({
			name : "map",
			x : 0,
			y : 0,
			image : imageObj,
			height : imageObj.height,
			width : imageObj.width
		});

		// Set bounds
		context.setBound(groupMap, imageObj.height, imageObj.width);

		// Add image to group
		groupMap.add(image);

		layerMap.moveToBottom();

		// Draw layer
		layerMap.draw();

	};
	imageObj.onerror = function() {

	};
	imageObj.src = Core.sprintf("image/%s/building/floor/%s_%s.png", this.getMode(), floor.buildingId, floor.id);

	// Set bounds
	this.setBound(groupMap);

	layerMap.setZIndex(BuildingcreatorBuildingsCmsCanvasPresenterView.Z_INDEX_MAP);

	layerMap.draw();

	// /MAP

};

// ... /DRAW

// /FUNCTIONS
