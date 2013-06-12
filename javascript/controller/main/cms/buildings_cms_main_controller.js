// CONSTRUCTOR
BuildingsCmsMainController.prototype = new CmsMainController();

function BuildingsCmsMainController(eventHandler, mode, query) {
	CmsMainController.apply(this, arguments);
	if (typeof BuildingcreatorHandler != "undefined")
	this.buildingcreatorHandler = new BuildingcreatorHandler(eventHandler, this.getDaoContainer(), mode);
	else
	this.buildingcreatorHandler = null;
	this.building = null;
	this.floors = {};
	this.elements = {};
	this.saving = false;
	this.saveCount = 0;
	this.editedCount = 0;
	this.buildingCreatorFloorsRetrieved = [];
	this.queryOld = {};
};

// /CONSTRUCTOR

// VARIABLES

BuildingsCmsMainController.RETRIEVE_COUNT = 4;

BuildingsCmsMainController.TYPE_FLOORS = "floors";
BuildingsCmsMainController.TYPE_ELEMENTS = "elements";
BuildingsCmsMainController.TYPE_NAVIGATION = "navigation";
BuildingsCmsMainController.BUILDINGCREATOR_TYPES = [ "elements", "navigations" ];

// /VARIABLES

// FUNCTIONS

// ... GET

/**
 * @return {BuildingsCmsMainView}
 */
BuildingsCmsMainController.prototype.getView = function() {
	return CmsMainController.prototype.getView.call(this);
};

BuildingsCmsMainController.prototype.getRetrieveCount = function() {
	return BuildingsCmsMainController.RETRIEVE_COUNT;
};

// ... /GET

// ... IS

/**
 * @return {boolean}
 */
BuildingsCmsMainController.prototype.isPageOverview = function() {
	return this.page == "overview";
};
/**
 * @return {boolean}
 */
BuildingsCmsMainController.prototype.isPageBuilding = function() {
	return this.page == "building";
};

// ... /IS

// ... HAS

// ... /HAS

// ... DO

BuildingsCmsMainController.prototype.doBindEventHandler = function() {
	CmsMainController.prototype.doBindEventHandler.call(this);
	var context = this;

	// EVENT

	// Retrieved event
	this.getEventHandler().registerListener(RetrievedEvent.TYPE,
	/**
	 * @param {RetrievedEvent}
	 *            event
	 */
	function(event) {
		switch (event.getRetrievedType()) {
		case "building":
			context.building = event.getRetrieved();
			break;

		case "building_floors":
			context.floors = event.getRetrieved();
			break;

		case "building_elements":
			context.elements = event.getRetrieved();
			break;
		}
	});

	// Edit event
	this.getEventHandler().registerListener(EditEvent.TYPE,
	/**
	 * @param {EditEvent}
	 *            event
	 */
	function(event) {
		switch (event.getEditType()) {
		case "building":
			context.doSave(event.getEdit());
			break;

		case "element":
			context.doElementSave(event.getEdit());
			break;
		}
	});

	// Edited event
	this.getEventHandler().registerListener(EditedEvent.TYPE,
	/**
	 * @param {EditedEvent}
	 *            event
	 */
	function(event) {
		switch (event.getEditType()) {
		case "floor":
			context.editedCount++;
			break;

		case "elements":
			context.editedCount++;
			break;

		case "navigation":
			context.editedCount++;
			break;
		}

		if (context.saving && context.saveCount == context.editedCount)
			location.reload();
	});

	// Floor select event
	this.getEventHandler().registerListener(FloorSelectEvent.TYPE,
	/**
	 * @param {FloorSelectEvent}
	 *            event
	 */
	function(event) {
		context.handleBuildingFloor(event.getFloorId());
	});

	// /EVENT

	if ((this.getQuery().page == "floorplanner" || this.getQuery().page == "buildingcreator" || (this.getQuery().page == "building" && this.getQuery().action == "view"))
			&& this.getQuery().id) {

		// Handle history
		$(window).hashchange(function() {
			context.handleHistory();
		});

		// History has change
		$(window).hashchange();

	}

};

BuildingsCmsMainController.prototype.doSave = function(save) {
	if (!save || typeof save != "object")
		return console.error("BuildingsCmsMainController.doSave: Save object is empty");
	if (this.saving)
		return console.error("BuildingsCmsMainController.doSave: Is already saving");
	var context = this;
	console.log("BuildingsCmsMainController.doSave", save);
	for (type in save) {

		switch (type) {

		case BuildingsCmsMainController.TYPE_NAVIGATION:
			// NAVIGATION
			for ( var floorId in save[type]) {
				var navigationsData = save[type][floorId];
				if (navigationsData.changed) {
					this.saveCount++;
					this.getDaoContainer().getNavigationBuildingDao().navigations(floorId, navigationsData, function(nodes) {
						context.getEventHandler().handle(new EditedEvent("navigation", nodes));
					});
				}
			}
			break;

		case BuildingsCmsMainController.TYPE_FLOORS:
			// FLOORS
			for ( var floorId in save[type]) {
				var floorData = save[type][floorId];
				var changed = false;
				for ( var i in floorData) {
					if (floorData[i].changed)
						changed = true;
				}
				var floor = this.getDaoContainer().getFloorBuildingDao().getListAdapter().getItem(floorId);

				if (floor && changed) {
					this.saveCount++;
					this.getDaoContainer().getFloorBuildingDao().edit(floorId, {
						coordinates : floorData
					}, function(floor, floors) {
						context.getEventHandler().handle(new EditedEvent("floor", floor));
					});
				}
			}
			break;

		case BuildingsCmsMainController.TYPE_ELEMENTS:

			// ELEMENTS
			for ( var floorId in save[type]) {
				var elementsData = save[type][floorId];

				for ( var i in elementsData) {
					var elementData = elementsData[i];
					var element = this.getDaoContainer().getElementBuildingDao().getListAdapter().getItem(elementData.elementId);

					// Edit Element
					if (element && !elementData.deleted) { // && elementData.changed) {
						this.saveCount++;
						this.getDaoContainer().elementBuildingDao.edit(element.id, elementData, function(element, elements) {
							context.getEventHandler().handle(new EditedEvent("elements", elements));
						});
					}
					// Delete Element
					else if (element && elementData.deleted) {
						this.saveCount++;
						this.getDaoContainer().elementBuildingDao.delete_(element.id, function(element, elements) {
							context.getEventHandler().handle(new EditedEvent("elements", elements));
						});
					}
					// New Element
					else if (!element) {
						this.saveCount++;
						this.getDaoContainer().elementBuildingDao.add(elementData, floorId, function(element, elements) {
							context.getEventHandler().handle(new EditedEvent("elements", elements));
						});
					}
				}
			}
			break;
		}

	}

	if (this.saveCount > 0) {
		this.saving = true;
		this.getEventHandler().handle(new SavingEvent());
	} else
		console.info("BuildingsCmsMainController.doSave: Nothing to save");
};

BuildingsCmsMainController.prototype.doElementSave = function(element) {
	if (!element || !element.id)
		return console.error("BuildingsCmsMainController.doElementSave: Element is illegal", element);
	var context = this;

	var elementOriginal = this.getDaoContainer().getElementBuildingDao().getListAdapter().getItem(element.id);
	if (!elementOriginal)
		return console.error("BuildingsCmsMainController.doElementSave: Original Element is null", element, elementOriginal);

	this.getEventHandler().handle(new ToastEvent("Saving Element"));
	this.getDaoContainer().getElementBuildingDao().edit(elementOriginal.id, element, function() {
		context.getEventHandler().handle(new ToastEvent("Element saved"));
	});
};

// ... /DO

// ... HANDLE

BuildingsCmsMainController.prototype.handleHistory = function() {
	var hash = this.getHash();

	// Menu
	if ((hash.menu && hash.menu != this.queryOld.menu) || (hash.sidebar && hash.sidebar != this.queryOld.sidebar)) {
		this.getEventHandler().handle(new MenuEvent(hash.menu, hash.sidebar));
	}

	// Floor
	if (hash.floor && hash.floor != this.queryOld.floor) {
		this.getEventHandler().handle(new FloorSelectEvent(hash.floor));
	}

	this.queryOld = hash;
};

BuildingsCmsMainController.prototype.handleBuildingFloor = function(floorId) {
	var context = this;
	floorId = parseInt(floorId) || null;
	var buildingId = this.getQuery().id;

	if (floorId && jQuery.inArray(floorId, this.buildingCreatorFloorsRetrieved) > -1)
		return console.info("BuildingsCmsMainController.handleBuildingFloor: Floor is already retrieved", floorId);

	this.getEventHandler().handle(new RetrieveEvent("buildingcreator", buildingId));

	this.buildingcreatorHandler.retrieveBuilding(buildingId, [ floorId ], BuildingsCmsMainController.BUILDINGCREATOR_TYPES, {
		success : function(data) {
			context.buildingCreatorFloorsRetrieved = context.buildingCreatorFloorsRetrieved.concat(data.info.floors);
			context.getEventHandler().handle(new RetrievedEvent("buildingcreator", data));
		}
	});

};

// ... /HANDLE

// ... RENDER

/**
 * @param {BuildingsCmsMainView}
 *            view
 */
BuildingsCmsMainController.prototype.render = function(view) {
	CmsMainController.prototype.render.call(this, view);
	var context = this;

	if ((this.getQuery().page == "buildingcreator" || this.getQuery().page == "building") && this.getQuery().id) {
		if (!this.getHash().floor)
			this.handleBuildingFloor(null);

		// var buildingId = this.getQuery().id;
		// var floorIds = this.getHash().floor ? [ this.getHash().floor ] : [];

		// // Send Buildingcreator retrieve event
		// this.getEventHandler().handle(new RetrieveEvent("buildingcreator",
		// buildingId));
		//
		// // Retrieve building
		// this.buildingcreatorHandler.retrieveBuilding(buildingId, floorIds,
		// BuildingsCmsMainController.BUILDINGCREATOR_TYPES, function(data) {
		// // Buildingcreator retrieved event
		// context.getEventHandler().handle(new
		// RetrievedEvent("buildingcreator", data));
		// });

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
