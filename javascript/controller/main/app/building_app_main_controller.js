// CONSTRUCTOR
BuildingAppMainController.prototype = new AppMainController();

function BuildingAppMainController(eventHandler, mode, query) {
	AppMainController.apply(this, arguments);
	this.buildingcreatorHandler = new BuildingcreatorHandler(eventHandler, this.getDaoContainer(), mode);
	this.queryOld = {};
	this.buildingCreatorFloorsRetrieved = [];
}

BuildingAppMainController.BUILDINGCREATOR_TYPES = [ "elements", "navigations" ];

// /CONSTRUCTOR

// VARIABLES

BuildingAppMainController.RETRIEVE_COUNT = 4;

// /VARIABLES

// FUNCTIONS

// ... GET

/**
 * @return {BuildingAppMainView}
 */
BuildingAppMainController.prototype.getView = function() {
	return AppMainController.prototype.getView.call(this);
};

BuildingAppMainController.prototype.getRetrieveCount = function() {
	return BuildingAppMainController.RETRIEVE_COUNT;
};

// ... /GET

// ... DO

BuildingAppMainController.prototype.doBindEventHandler = function() {
	AppMainController.prototype.doBindEventHandler.call(this);
	var context = this;

	// Floor select event
	this.getEventHandler().registerListener(FloorSelectEvent.TYPE,
	/**
	 * @param {FloorSelectEvent}
	 *            event
	 */
	function(event) {
		context.handleBuildingFloor(event.getFloorId());
	});
	
	// Handle history
	$(window).hashchange(function() {
		context.handleHistory();
	});

	// History has change
	$(window).hashchange();

};

// ... /DO

// ... HANDLE

BuildingAppMainController.prototype.handleHistory = function() {
	var hash = this.getHash();
	// Floor
	if (hash.floor && hash.floor != this.queryOld.floor) {
		this.getEventHandler().handle(new FloorSelectEvent(hash.floor));
	}

	this.queryOld = hash;
};

BuildingAppMainController.prototype.handleSearch = function(search, options) {
	var buildingId = this.getQuery().id;

	// Search
	this.getSearchHandler().searchBuilding(search, buildingId, true);
};

BuildingAppMainController.prototype.handleBuildingFloor = function(floorId) {
	var context = this;
	floorId = parseInt(floorId) || null;
	var buildingId = this.getQuery().id;

	if (floorId && jQuery.inArray(floorId, this.buildingCreatorFloorsRetrieved) > -1)
		return console.info("BuildingsCmsMainController.handleBuildingFloor: Floor is already retrieved", floorId);

	this.getEventHandler().handle(new RetrieveEvent("buildingcreator", buildingId));

	this.buildingcreatorHandler.retrieveBuilding(buildingId, [ floorId ], BuildingAppMainController.BUILDINGCREATOR_TYPES, {
		success : function(data) {
			context.buildingCreatorFloorsRetrieved = context.buildingCreatorFloorsRetrieved.concat(data.info.floors);
			context.getEventHandler().handle(new RetrievedEvent("buildingcreator", data));
		}
	});
};

// ... /HANDLE

// ... RENDER

/**
 * @param {BuildingAppMainView}
 *            view
 */
BuildingAppMainController.prototype.render = function(view) {
	AppMainController.prototype.render.call(this, view);
	var context = this;

	var buildingId = this.getQuery().id;

	if (buildingId) {
		if (!this.getHash().floor)
			this.handleBuildingFloor(null);

		// // Send Building retrieve event
		// this.getEventHandler().handle(new RetrieveEvent("building",
		// buildingId));
		//
		// // Get Building
		// this.getDaoContainer().getBuildingDao().get(buildingId,
		// function(building) {
		//
		// // Building retrieved event
		// context.getEventHandler().handle(new RetrievedEvent("building",
		// building));
		//
		// // Floors retrieve event
		// context.getEventHandler().handle(new RetrieveEvent("building_floors",
		// buildingId));
		//
		// // Retrieve Floors
		// context.getDaoContainer().getFloorBuildingDao().getForeign(building.id,
		// function(floors) {
		//
		// // Floors retrieved event
		// context.getEventHandler().handle(new
		// RetrievedEvent("building_floors", floors));
		//
		// // Elements retrieve event
		// context.getEventHandler().handle(new
		// RetrieveEvent("building_elements", buildingId));
		//
		// // Retrieve Elements
		// context.getDaoContainer().getElementBuildingDao().getBuilding(building.id,
		// function(element, elements) {
		//
		// // Elements retrieved event
		// context.getEventHandler().handle(new
		// RetrievedEvent("building_elements", elements));
		//
		// }, true);
		//
		// // Navigation retrieve event
		// context.getEventHandler().handle(new
		// RetrieveEvent("building_navigation", buildingId));
		//
		// // Retrieve Navigation
		// context.getDaoContainer().getNavigationBuildingDao().getBuilding(building.id,
		// function(element, elements) {
		//
		// // Elements retrieved event
		// context.getEventHandler().handle(new
		// RetrievedEvent("building_navigation", elements));
		//
		// }, true);
		//
		// }, true);
		//
		// }, true);

	}

};

// ... /RENDER

// /FUNCTIONS
