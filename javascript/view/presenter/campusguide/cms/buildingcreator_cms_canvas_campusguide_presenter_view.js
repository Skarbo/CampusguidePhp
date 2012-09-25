// CONSTRUCTOR
BuildingcreatorCmsCanvasCampusguidePresenterView.prototype = new CanvasCampusguidePresenterView();

function BuildingcreatorCmsCanvasCampusguidePresenterView(view) {
	CanvasCampusguidePresenterView.apply(this, arguments);

	this.layers["floors_map"] = {};
	this.groups["floors_map"] = {};

	this.floorMapShow = true;
	this.retrieved = 0;
};

// VARIABLES

BuildingcreatorCmsCanvasCampusguidePresenterView.TYPE_FLOORS_MAP = "floors_map";

// /VARIABLES

// FUNCTIONS

// ... GET

/**
 * @return {Object}
 */
BuildingcreatorCmsCanvasCampusguidePresenterView.prototype.getCanvasContentElement = function() {
	return this.getRoot().find("#buildingcreator_planner_content_canvas_content_wrapper");
};

// ... ... CANVAS

/**
 * @return {Object}
 */
BuildingcreatorCmsCanvasCampusguidePresenterView.prototype.getCanvasContentElement = function() {
	return this.getRoot().find("#buildingcreator_planner_content_canvas_content_wrapper");
};

/**
 * @return {Object}
 */
BuildingcreatorCmsCanvasCampusguidePresenterView.prototype.getCanvasLoaderElement = function() {
	return this.getRoot().find("#buildingcreator_planner_content_canvas_loader_wrapper");
};

/**
 * @return {Object}
 */
BuildingcreatorCmsCanvasCampusguidePresenterView.prototype.getCanvasLoaderStatusElement = function() {
	return this.getCanvasLoaderElement().find("#buildingcreator_planner_content_canvas_loader_status_wrapper");
};

// ... ... /CANVAS

// ... /GET

// ... DO

BuildingcreatorCmsCanvasCampusguidePresenterView.prototype.doBindEventHandler = function() {
	CanvasCampusguidePresenterView.prototype.doBindEventHandler.call(this);
	var context = this;

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
		context.handleRetrieved(event.getRetrievedType());
	});

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
	this.getEventHandler().registerListener(SavingEvent.TYPE,
	/**
	 * @param {SavingEvent}
	 *            event
	 */
	function(event) {
		context.handleSaving();
	});

	// /EVENTS

};

BuildingcreatorCmsCanvasCampusguidePresenterView.prototype.doFloorSelect = function(floorId) {
	if (!floorId)
		return CanvasCampusguidePresenterView.prototype.doFloorSelect.call(this, floorId);

	// Show/hide Floors map
	var floorsMap = this.getGroups(BuildingcreatorCmsCanvasCampusguidePresenterView.TYPE_FLOORS_MAP);
	for (id in floorsMap) {
		if (id == floorId && this.floorMapShow) {
			floorsMap[id].show();
		} else {
			floorsMap[id].hide();
		}
	}

	// Parent Floor select
	CanvasCampusguidePresenterView.prototype.doFloorSelect.call(this, floorId);
};

BuildingcreatorCmsCanvasCampusguidePresenterView.prototype.doFloorMapToggle = function() {
	if (!this.floorSelected)
		return;

	var floorMap = this.getGroup(BuildingcreatorCmsCanvasCampusguidePresenterView.TYPE_FLOORS_MAP, this.floorSelected);

	if (!floorMap)
		return;

	this.floorMapShow = !this.floorMapShow;

	if (this.floorMapShow)
		floorMap.show();
	else
		floorMap.hide();

	floorMap.getLayer().draw();
};

// ... /DO

// ... HANDLE

BuildingcreatorCmsCanvasCampusguidePresenterView.prototype.handleRetrieve = function(type) {
	switch (type) {
	case "building":
		this.getCanvasLoaderStatusElement().find(".loading_building").show();
		break;

	case "building_floors":
		this.getCanvasLoaderStatusElement().find(".loading_floors").show();
		break;

	case "building_elements":
		this.getCanvasLoaderStatusElement().find(".loading_elements").show();
		break;
	}
};

BuildingcreatorCmsCanvasCampusguidePresenterView.prototype.handleRetrieved = function(type) {
	switch (type) {
	case "building":
		this.getCanvasLoaderStatusElement().find(".loading_building").hide();
		this.retrieved++;
		break;

	case "building_floors":
		this.getCanvasLoaderStatusElement().find(".loading_floors").hide();
		this.retrieved++;
		break;

	case "building_elements":
		this.getCanvasLoaderStatusElement().find(".loading_elements").hide();
		this.retrieved++;
		break;
	}

	if (this.retrieved == 3) {
		this.getCanvasLoaderElement().hide();
		this.getCanvasContentElement().show();

		// Select Floor
		var selectMainFloor = function(floors) {
			var floorMain = null;
			var i = 0;
			for (floorId in floors) {
				if (floors[floorId].main || i == 0)
					floorMain = floorId;
				i++;
			}
			return floorMain;
		};

		var floorSelect = this.floorSelected ? this.floorSelected : selectMainFloor(this.getView().getFloors());
		this.getEventHandler().handle(new FloorSelectEvent(floorSelect));
	}
};

BuildingcreatorCmsCanvasCampusguidePresenterView.prototype.handleMenuSelect = function(menu) {
	var type = "";
	switch (menu) {
	case MenuBuildingcreatorCmsCampusguidePresenterView.TYPE_ELEMENTS:
		type = CanvasCampusguidePresenterView.TYPE_ELEMENTS;
		break;
	case MenuBuildingcreatorCmsCampusguidePresenterView.TYPE_NAVIGATION:
		type = CanvasCampusguidePresenterView.TYPE_NAVIGATION;
		break;

	default:
		type = CanvasCampusguidePresenterView.TYPE_FLOORS;
		break;
	}

	this.handleTypeSelect([ type ]);
};

BuildingcreatorCmsCanvasCampusguidePresenterView.prototype.handleSaving = function(type) {
	this.getCanvasLoaderStatusElement().children().hide();
	this.getCanvasLoaderStatusElement().find(".saving").show();
	this.getCanvasLoaderElement().show();
	this.getCanvasContentElement().hide();
};

// ... /HANDLE

// ... DRAW

BuildingcreatorCmsCanvasCampusguidePresenterView.prototype.drawFloor = function(floor, width, height) {
	var context = this;

	// Initiate layer
	var layer = new Kinetic.Layer({
		name : "floor_map_layer",
		id : floor.id
	});

	// Initiate group
	var group = new Kinetic.Group({
		name : "floor_map_group",
		id : floor.id,
		visible : false
	});

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

		// Add image to group
		group.add(image);
		image.setZIndex(0);
		layer.height = imageObj.height;
		layer.width = imageObj.width;

		// Draw Floor
		// context.drawFloorLayer(floor, layer.width, layer.height);
		CanvasCampusguidePresenterView.prototype.drawFloor.call(context, floor, layer.width, layer.height);

		// Draw layer
		layer.draw();

	};
	imageObj.src = Core.sprintf("image/%s/building/floor/%s_%s.png", this.getMode(), floor.buildingId, floor.id);

	// Set Floor layer
	this.setLayer("floors_map", floor.id, layer);

	// Set floor group
	this.setGroup("floors_map", floor.id, group);

	// Add group to layer
	layer.add(group);

	// Add layer to stage
	this.stage.add(layer);

};

// ... /DRAW

// /FUNCTIONS
