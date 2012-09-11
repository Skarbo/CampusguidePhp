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
	var hash = this.getHash();

	// Menu
	if (hash.menu || hash.sidebar) {
		this.getEventHandler().handle(new MenuEvent(hash.menu, hash.sidebar));
	}

	// Floor
	if (hash.floor) {
		this.getEventHandler().handle(new FloorBuildingEvent(hash.floor), "RetrievedEvent",
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
		this.getEventHandler().handle(new RetrieveEvent("building", buildingId));

		// Get Building
		this.getBuildingDao().get(buildingId, function(building) {

			// Building retrieved event
			context.getEventHandler().handle(new RetrievedEvent("building", building));

			// Elements retrieve event
			context.getEventHandler().handle(new RetrieveEvent("building_elements", buildingId));

			// Floors retrieve event
			context.getEventHandler().handle(new RetrieveEvent("building_floors", buildingId));

			// Retrieve Elements
			context.getElementBuildingDao().getForeign(building.id, function(elements) {

				// Elements retrieved event
				context.getEventHandler().handle(new RetrievedEvent("building_elements", elements));

			}, true);

			// Retrieve Floors
			context.getFloorBuildingDao().getForeign(building.id, function(floors) {

				// Floors retrieved event
				context.getEventHandler().handle(new RetrievedEvent("building_floors", floors));

			}, true);

		}, true);

	}
};

// ... /RENDER

// /FUNCTIONS
