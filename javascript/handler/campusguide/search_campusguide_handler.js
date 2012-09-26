// CONSTRUCTOR

function SearchCampusguideHandler(eventHandler, mode, facilityDao, buildingDao, elementBuildingDao) {
	this.eventHandler = eventHandler;
	this.mode = mode;
	this.facilityDao = facilityDao;
	this.buildingDao = buildingDao;
	this.elementBuildingDao = elementBuildingDao;
}

// /CONSTRUCTOR

// VARIABLES

SearchCampusguideHandler.URI_SEARCH = "api_rest.php?/search/%s&mode=%s";
SearchCampusguideHandler.URI_SEARCH_TYPE = "api_rest.php?/search/%s/%s/%s&mode=%s%s";

SearchCampusguideHandler.TYPE_BUILDING = "building";

// /VARIABLES

// FUNCTIONS

// ... GETTERS/SETTERS

/**
 * @param {FacilityStandardCampusguideDao}
 *            facilityDao
 */
SearchCampusguideHandler.prototype.setFacilityDao = function(facilityDao) {
	this.facilityDao = facilityDao;
};

/**
 * @returns {FacilityStandardCampusguideDao}
 */
SearchCampusguideHandler.prototype.getFacilityDao = function() {
	return this.facilityDao;
};

/**
 * @param {BuildingStandardCampusguideDao}
 *            buildingDao
 */
SearchCampusguideHandler.prototype.setBuildingDao = function(buildingDao) {
	this.buildingDao = buildingDao;
};

/**
 * @returns {BuildingStandardCampusguideDao}
 */
SearchCampusguideHandler.prototype.getBuildingDao = function() {
	return this.buildingDao;
};

/**
 * @returns {ElementBuildingStandardCampusguideDao}
 */
SearchCampusguideHandler.prototype.getElementBuildingDao = function() {
	return this.elementBuildingDao;
};

// ... /GETTERS/SETTERS

// ... GET

/**
 * @return {Number}
 */
SearchCampusguideHandler.prototype.getMode = function() {
	return this.mode;
};

/**
 * @return {EventHandler}
 */
SearchCampusguideHandler.prototype.getEventHandler = function() {
	return this.eventHandler;
};

// ... /GET

// ... SEARCH

SearchCampusguideHandler.prototype.search = function(search) {
	var context = this;

	// Generate url
	var url = Core.sprintf(SearchCampusguideHandler.URI_SEARCH, encodeURI(search), this.getMode());

	// Do ajax
	$.ajax({
		url : url,
		dataType : "json",
		success : function(data) {
			context.handleSearchResult(data);
		},
		error : function(jqXHR, textStatus, errorThrown) {
			console.error(textStatus, errorThrown);
		}
	});

};

SearchCampusguideHandler.prototype.searchBuilding = function(search, buildingId, simple) {
	simple = simple || false;
	var context = this;

	// Generate url
	var url = Core.sprintf(SearchCampusguideHandler.URI_SEARCH_TYPE, encodeURI(search), SearchCampusguideHandler.TYPE_BUILDING, buildingId, this.getMode(), simple ? "&simple=true"
			: "");

	// Do ajax
	$.ajax({
		url : url,
		dataType : "json",
		success : function(data) {
			context.handleSearchResult(data);
		},
		error : function(jqXHR, textStatus, errorThrown) {
			console.error(textStatus, errorThrown);
		}
	});

};

SearchCampusguideHandler.prototype.handleSearchResult = function(data) {
	var context = this;
	var facilities = data.facilities || [];
	var buildings = data.buildings || [];
	var elements = data.elements || [];
	var isSimple = data.info ? data.info.simple : false;

	if (!isSimple) {
		this.getFacilityDao().addListToList(facilities);
		this.getBuildingDao().addListToList(buildings);
		this.getElementBuildingDao().addListToList(elements);

		this.getEventHandler().handle(new ResultSearchEvent({
			"facilities" : facilities,
			"buildings" : buildings,
			"elements" : elements
		}));
	} else {
		// TODO Woha.. ugly
		this.getFacilityDao().getList(facilities, function(list) {
			var facilitiesRetrieved = list;
			context.getBuildingDao().getList(buildings, function(list) {
				var buildingsRetrieved = list;
				context.getElementBuildingDao().getList(elements, function(list) {
					var elementsRetrieved = list;
					context.getEventHandler().handle(new ResultSearchEvent({
						"facilities" : facilitiesRetrieved,
						"buildings" : buildingsRetrieved,
						"elements" : elementsRetrieved
					}));
				});
			});
		});
	}
};

// ... /SEARCH

// FUNCTIONS
