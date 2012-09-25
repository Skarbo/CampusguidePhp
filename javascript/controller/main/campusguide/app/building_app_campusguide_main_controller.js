// CONSTRUCTOR
BuildingAppCampusguideMainController.prototype = new AppCampusguideMainController();

function BuildingAppCampusguideMainController(eventHandler, mode, query) {
	AppCampusguideMainController.apply(this, arguments);
}

// /CONSTRUCTOR

// VARIABLES

// /VARIABLES

// FUNCTIONS

// ... GET

/**
 * @return {BuildingAppCampusguideMainView}
 */
BuildingAppCampusguideMainController.prototype.getView = function() {
	return AppCampusguideMainController.prototype.getView.call(this);
};

// ... /GET

// ... DO

BuildingAppCampusguideMainController.prototype.doBindEventHandler = function() {
	AppCampusguideMainController.prototype.doBindEventHandler.call(this);
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

BuildingAppCampusguideMainController.prototype.handleHistory = function() {
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

// ... /HANDLE

// ... RENDER

/**
 * @param {BuildingAppCampusguideMainView}
 *            view
 */
BuildingAppCampusguideMainController.prototype.render = function(view) {
	AppCampusguideMainController.prototype.render.call(this, view);
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
