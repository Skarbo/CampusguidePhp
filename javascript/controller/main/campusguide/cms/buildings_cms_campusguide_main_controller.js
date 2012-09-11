// CONSTRUCTOR
BuildingsCmsCampusguideMainController.prototype = new CmsCampusguideMainController();

function BuildingsCmsCampusguideMainController(eventHandler, mode, query) {
	CmsCampusguideMainController.apply(this, arguments);
};

// /CONSTRUCTOR

// VARIABLES

// /VARIABLES

// FUNCTIONS

// ... GET

/**
 * @return {BuildingsCmsCampusguideMainView}
 */
BuildingsCmsCampusguideMainController.prototype.getView = function() {
	return CmsCampusguideMainController.prototype.getView.call(this);
};

// ... /GET

// ... IS

/**
 * @return {boolean}
 */
BuildingsCmsCampusguideMainController.prototype.isPageOverview = function() {
	return this.page == "overview";
};
/**
 * @return {boolean}
 */
BuildingsCmsCampusguideMainController.prototype.isPageBuilding = function() {
	return this.page == "building";
};

// ... /IS

// ... DO

BuildingsCmsCampusguideMainController.prototype.doBindEventHandler = function() {
	CmsCampusguideMainController.prototype.doBindEventHandler.call(this);
	var context = this;

	// EVENT

	// Edit event
	this.getEventHandler().registerListener(EditEvent.TYPE,
	/**
	 * @param {EditEvent}
	 *            event
	 */
	function(event) {
		switch (event.getEditType()) {
		case "floor":
			context.doFloorSave(event.getEdit());
			break;
		}
	});

	// Edit event
	this.getEventHandler().registerListener(EditedEvent.TYPE,
	/**
	 * @param {EditedEvent}
	 *            event
	 */
	function(event) {
		switch (event.getEditType()) {
		case "floor":
			location.reload();
			break;
		}
	});

	// /EVENT

	// Page Floorplanner
	if ((this.getQuery().page == "floorplanner" || this.getQuery().page == "buildingcreator") && this.getQuery().id) {

		// Handle history
		$(window).hashchange(function() {
			context.handleHistory();
		});

		// History has change
		$(window).hashchange();

	}

};

BuildingsCmsCampusguideMainController.prototype.doFloorSave = function(floor) {
	var context = this;

	if (!floor)
		return;

	this.getFloorBuildingDao().edit(floor.id, floor, function(floor, floors) {
		context.getEventHandler().handle(new EditedEvent("floor", floor));
	});

};

// ... /DO

// ... HANDLE

BuildingsCmsCampusguideMainController.prototype.handleHistory = function() {

	// Get hash floor
	var floor = this.getHash().floor;

	if (floor) {
		// Send Floor Building event
		this.getEventHandler().handle(new FloorBuildingEvent(floor), "FloorsBuildingRetrievedEvent");
	}

	// // Get hash menu
	// var menu = this.getHash().menu;
	//	
	// // Send menu event
	// this.getEventHandler().handle(new MenuFloorplannerBuildingEvent(menu));

};

// ... /HANDLE

// ... RENDER

/**
 * @param {BuildingsCmsCampusguideMainView}
 *            view
 */
BuildingsCmsCampusguideMainController.prototype.render = function(view) {
	CmsCampusguideMainController.prototype.render.call(this, view);
	var context = this;

	// Page Floorplanner
	if ((this.getQuery().page == "floorplanner" || this.getQuery().page == "buildingcreator") && this.getQuery().id) {

		var buildingId = this.getQuery().id;

		// Send Building retrieve event
		this.getEventHandler().handle(new BuildingRetrieveEvent(buildingId));

		// Get Building
		this.getBuildingDao().get(buildingId, function(building) {

			// Send Building retrieved event
			context.getEventHandler().handle(new BuildingRetrievedEvent(building));

			// Send Elements Building retrieve event
			context.getEventHandler().handle(new ElementsBuildingRetrieveEvent(buildingId));

			// Send Floors Building retrieve Event
			context.getEventHandler().handle(new FloorsBuildingRetrieveEvent(buildingId));

			// Get Elements
			context.getElementBuildingDao().getForeign(building.id, function(elements) {

				// Send Elements Building retrieved event
				context.getEventHandler().handle(new ElementsBuildingRetrievedEvent(elements));

			}, true);

			// Get Floors
			context.getFloorBuildingDao().getForeign(building.id, function(floors) {

				// Send Floors Building retrieved event
				context.getEventHandler().handle(new FloorsBuildingRetrievedEvent(floors));

			}, true);

		}, true);

	}
};

// ... /RENDER

// /FUNCTIONS
