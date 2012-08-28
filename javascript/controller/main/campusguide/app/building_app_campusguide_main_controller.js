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

};

// ... /DO

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

		// Get Building
		this.getBuildingDao().get(buildingId, function(building) {

			// Send Building retrieved event
			context.getEventHandler().handle(new BuildingRetrievedEvent(building));

		}, true);

	}

};

// ... /RENDER

// /FUNCTIONS
