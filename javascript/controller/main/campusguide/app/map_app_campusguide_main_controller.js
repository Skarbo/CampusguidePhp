// CONSTRUCTOR
MapAppCampusguideMainController.prototype = new AppCampusguideMainController();

function MapAppCampusguideMainController(eventHandler, mode, query) {
	AppCampusguideMainController.apply(this, arguments);
}

// /CONSTRUCTOR

// VARIABLES

// /VARIABLES

// FUNCTIONS

// ... GET

/**
 * @return {MapAppCampusguideMainView}
 */
MapAppCampusguideMainController.prototype.getView = function() {
	return AppCampusguideMainController.prototype.getView.call(this);
};

// ... /GET

// ... DO

MapAppCampusguideMainController.prototype.doBindEventHandler = function() {
	AppCampusguideMainController.prototype.doBindEventHandler.call(this);
	var context = this;

	// MAP

	this.getEventHandler().registerListener(MaploadedEvent.TYPE,
	/**
	 * @param {MaploadedEvent}
	 *            event
	 */
	function(event) {
		context.handleMapLoaded();
	});

	// /MAP

};

// ... /DO

// ... HANDLE

MapAppCampusguideMainController.prototype.handleMapLoaded = function() {
	var context = this;

	this.getFacilityDao().getAll(function(facilities) {
		var facilityIds = [];
		for (facilityId in facilities) {
			facilityIds.push(facilityId);
		}
		context.getEventHandler().handle(new FacilitiesRetrievedEvent(facilities));
		context.getBuildingDao().getForeign(facilityIds, function(buildings) {
			context.getEventHandler().handle(new BuildingsRetrievedEvent(buildings));
		});
	});
};

// ... /HANDLE

// ... RENDER

/**
 * @param {MapAppCampusguideMainView}
 *            view
 */
MapAppCampusguideMainController.prototype.render = function(view) {
	AppCampusguideMainController.prototype.render.call(this, view);
};

// ... /RENDER

// /FUNCTIONS
