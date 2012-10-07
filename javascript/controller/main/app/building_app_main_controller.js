// CONSTRUCTOR
BuildingAppMainController.prototype = new AppMainController();

function BuildingAppMainController(eventHandler, mode, query) {
	AppMainController.apply(this, arguments);
}

// /CONSTRUCTOR

// VARIABLES

// /VARIABLES

// FUNCTIONS

// ... GET

/**
 * @return {BuildingAppMainView}
 */
BuildingAppMainController.prototype.getView = function() {
	return AppMainController.prototype.getView.call(this);
};

// ... /GET

// ... DO

BuildingAppMainController.prototype.doBindEventHandler = function() {
	AppMainController.prototype.doBindEventHandler.call(this);
	var context = this;

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
	if (hash.floor) {
		this.getEventHandler().handle(new FloorSelectEvent(hash.floor), "RetrievedEvent",
		/**
		 * @param {RetrievedEvent}
		 *            event
		 */
		function(event) {
			return event.getRetrievedType() == "building_floors";
		});
	}

};

BuildingAppMainController.prototype.handleSearch = function(search, options) {
	var buildingId = this.getQuery().id;
	
	// Search
	this.getSearchHandler().searchBuilding(search, buildingId, true);
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

		// Send Building retrieve event
		this.getEventHandler().handle(new RetrieveEvent("building", buildingId));

		// Get Building
		this.getBuildingDao().get(buildingId, function(building) {

			// Building retrieved event
			context.getEventHandler().handle(new RetrievedEvent("building", building));

			// Floors retrieve event
			context.getEventHandler().handle(new RetrieveEvent("building_floors", buildingId));

			// Retrieve Floors
			context.getFloorBuildingDao().getForeign(building.id, function(floors) {

				// Floors retrieved event
				context.getEventHandler().handle(new RetrievedEvent("building_floors", floors));

				// Elements retrieve event
				context.getEventHandler().handle(new RetrieveEvent("building_elements", buildingId));

				// Retrieve Elements
				context.getElementBuildingDao().getBuilding(building.id, function(element, elements) {

					// Elements retrieved event
					context.getEventHandler().handle(new RetrievedEvent("building_elements", elements));

				}, true);

			}, true);

		}, true);

	}

};

// ... /RENDER

// /FUNCTIONS
