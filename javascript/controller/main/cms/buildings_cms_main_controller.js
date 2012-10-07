// CONSTRUCTOR
BuildingsCmsMainController.prototype = new CmsMainController();

function BuildingsCmsMainController(eventHandler, mode, query) {
	CmsMainController.apply(this, arguments);
	this.building = null;
	this.floors = {};
	this.elements = {};
	this.saving = false;
	this.saveCount = 0;
	this.editedCount = 0;
};

// /CONSTRUCTOR

// VARIABLES

BuildingsCmsMainController.TYPE_FLOORS = "floors";
BuildingsCmsMainController.TYPE_ELEMENTS = "elements";
BuildingsCmsMainController.TYPE_NAVIGATION = "navigation";

// /VARIABLES

// FUNCTIONS

// ... GET

/**
 * @return {BuildingsCmsMainView}
 */
BuildingsCmsMainController.prototype.getView = function() {
	return CmsMainController.prototype.getView.call(this);
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
		}

		if (context.saving && context.saveCount == context.editedCount)
			location.reload();
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

BuildingsCmsMainController.prototype.doSave = function(save) {
	var context = this;

	var polygons = null, coordinatesArray = [], coordinates = "", element = 0;
	for (type in save) {
		for (id in save[type]) {
			polygons = save[type][id];
			coordinatesArray = [];
			coordinates = "";
			switch (type) {

			case BuildingsCmsMainController.TYPE_FLOORS:
				// FLOORS
				for (i in polygons.children) {
					if (!polygons.children[i].deleted)
						coordinatesArray.push(polygons.children[i].toData());
				}
				coordinates = coordinatesArray.join("$");

				if (this.floors[id] ? coordinates == this.floors[id].coordinates : !coordinates)
					continue;

				this.saveCount++;
				this.floorBuildingDao.edit(id, {
					coordinates : coordinates
				}, function(floor, floors) {
					context.getEventHandler().handle(new EditedEvent("floor", floor));
				});
				break;

			case BuildingsCmsMainController.TYPE_ELEMENTS:
				// ELEMENTS
				for (i in polygons.children) {
					coordinates = polygons.children[i].toData();
					element = polygons.children[i].object.element;

					// Edit Element
					if (element && element.id && !polygons.children[i].deleted) {
						if (this.elements[element.id] ? coordinates == this.elements[element.id].coordinates : !coordinates)
							continue;

						this.saveCount++;
						this.elementBuildingDao.edit(element.id, {
							coordinates : coordinates
						}, function(element, elements) {
							context.getEventHandler().handle(new EditedEvent("elements", elements));
						});
					}
					// Delete Element
					else if (element && element.id && polygons.children[i].deleted) {
						this.saveCount++;
						this.elementBuildingDao.delete_(element.id, function(element, elements) {
							context.getEventHandler().handle(new EditedEvent("elements", elements));
						});
					}
					// New Element
					else if (!element) {
						if (!coordinates)
							continue;

						this.saveCount++;
						this.elementBuildingDao.add(id, {
							coordinates : coordinates
						}, function(element, elements) {
							context.getEventHandler().handle(new EditedEvent("elements", elements));
						});
					}

				}
				break;

			}
		}
	}

	if (this.saveCount > 0) {
		this.saving = true;
		this.getEventHandler().handle(new SavingEvent());
	}
};

BuildingsCmsMainController.prototype.doElementSave = function(element) {
	if (!element || !element.id || !element.name)
		return;

	if (!this.elements[element.id])
		return;

	var context = this;

	this.elementBuildingDao.edit(element.id, element, function(element, elements) {
		context.getEventHandler().handle(new EditedEvent("element", element));
	});
};

// ... /DO

// ... HANDLE

BuildingsCmsMainController.prototype.handleHistory = function() {
	var hash = this.getHash();

	// Menu
	if (hash.menu || hash.sidebar) {
		this.getEventHandler().handle(new MenuEvent(hash.menu, hash.sidebar));
	}

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
 * @param {BuildingsCmsMainView}
 *            view
 */
BuildingsCmsMainController.prototype.render = function(view) {
	CmsMainController.prototype.render.call(this, view);
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
