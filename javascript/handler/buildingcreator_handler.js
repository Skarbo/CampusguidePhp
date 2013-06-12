// CONSTRUCTOR

function BuildingcreatorHandler(eventHandler, daoContainer, mode) {
	this.eventHandler = eventHandler;
	this.daoContainer = daoContainer;
	this.mode = mode;
}

// /CONSTRUCTOR

// VARIABLES

BuildingcreatorHandler.URI_BUILDING = "api_rest.php?/buildingcreator/%s&mode=%s";
BuildingcreatorHandler.FLOORIDS_SPLITTER = "_";
BuildingcreatorHandler.TYPES_SPLITTER = "_";

// VARIABLES

// FUNCTIONS

// ... GET

/**
 * @return {Number}
 */
BuildingcreatorHandler.prototype.getMode = function() {
	return this.mode;
};

/**
 * @return {EventHandler}
 */
BuildingcreatorHandler.prototype.getEventHandler = function() {
	return this.eventHandler;
};

/**
 * @return {DaoContainer}
 */
BuildingcreatorHandler.prototype.getDaoContainer = function() {
	return this.daoContainer;
};

// ... /GET

/**
 * @param {Array}
 *            floorIds
 * @param {Array}
 *            types
 * @param {Object}
 *            callback { success : function, error : function }
 */
BuildingcreatorHandler.prototype.retrieveBuilding = function(buildingId, floorIds, types, callback) {
	var context = this;
	floorIds = floorIds || [];
	types = types || [];

	// Generate url
	var url = Core.sprintf(BuildingcreatorHandler.URI_BUILDING, Core.sprintf("%s/%s/%s", buildingId, floorIds.join(BuildingcreatorHandler.FLOORIDS_SPLITTER), types
			.join(BuildingcreatorHandler.TYPES_SPLITTER)), this.getMode());

	// Do ajax
	$.ajax({
		url : url,
		type : "get",
		dataType : "json",
		success : function(data) {
			context.handleRetrievedBuilding(data);
			if (callback.success)
				callback.success(data);
		},
		error : function(jqXHR, textStatus, errorThrown) {
			console.error(textStatus, errorThrown);
			if (callback.error)
				callback.error(textStatus, errorThrown);
		}
	});

};

BuildingcreatorHandler.prototype.handleRetrievedBuilding = function(data) {
	if (data.building)
		this.getDaoContainer().getBuildingDao().getListAdapter().add(data.building.id, data.building);
	if (data.floors)
		this.getDaoContainer().getFloorBuildingDao().getListAdapter().addAll(data.floors);

	if (data.elements)
		this.getDaoContainer().getElementBuildingDao().getListAdapter().addAll(data.elements);

	if (data.navigations)
		this.getDaoContainer().getNavigationBuildingDao().getListAdapter().addAll(data.navigations);
};

// /FUNCTIONS
