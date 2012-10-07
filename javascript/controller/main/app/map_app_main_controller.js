// CONSTRUCTOR
MapAppMainController.prototype = new AppMainController();

function MapAppMainController(eventHandler, mode, query) {
	AppMainController.apply(this, arguments);
}

// /CONSTRUCTOR

// VARIABLES

// /VARIABLES

// FUNCTIONS

// ... GET

/**
 * @return {MapAppMainView}
 */
MapAppMainController.prototype.getView = function() {
	return AppMainController.prototype.getView.call(this);
};

// ... /GET

// ... DO

MapAppMainController.prototype.doBindEventHandler = function() {
	AppMainController.prototype.doBindEventHandler.call(this);
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

MapAppMainController.prototype.handleMapLoaded = function() {
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
 * @param {MapAppMainView}
 *            view
 */
MapAppMainController.prototype.render = function(view) {
	AppMainController.prototype.render.call(this, view);
};

// ... /RENDER

// /FUNCTIONS
