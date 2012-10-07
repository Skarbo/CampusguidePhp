// CONSTRUCTOR

function SearchHandler(eventHandler, mode, facilityDao, buildingDao, elementBuildingDao) {
	this.eventHandler = eventHandler;
	this.mode = mode;
	this.facilityDao = facilityDao;
	this.buildingDao = buildingDao;
	this.elementBuildingDao = elementBuildingDao;
}

// /CONSTRUCTOR

// VARIABLES

SearchHandler.URI_SEARCH = "api_rest.php?/search/%s&mode=%s";
SearchHandler.URI_SEARCH_TYPE = "api_rest.php?/search/%s/%s/%s&mode=%s%s";

SearchHandler.TYPE_BUILDING = "building";

// /VARIABLES

// FUNCTIONS

// ... GETTERS/SETTERS

/**
 * @param {FacilityStandardDao}
 *            facilityDao
 */
SearchHandler.prototype.setFacilityDao = function(facilityDao) {
	this.facilityDao = facilityDao;
};

/**
 * @returns {FacilityStandardDao}
 */
SearchHandler.prototype.getFacilityDao = function() {
	return this.facilityDao;
};

/**
 * @param {BuildingStandardDao}
 *            buildingDao
 */
SearchHandler.prototype.setBuildingDao = function(buildingDao) {
	this.buildingDao = buildingDao;
};

/**
 * @returns {BuildingStandardDao}
 */
SearchHandler.prototype.getBuildingDao = function() {
	return this.buildingDao;
};

/**
 * @returns {ElementBuildingStandardDao}
 */
SearchHandler.prototype.getElementBuildingDao = function() {
	return this.elementBuildingDao;
};

// ... /GETTERS/SETTERS

// ... GET

/**
 * @return {Number}
 */
SearchHandler.prototype.getMode = function() {
	return this.mode;
};

/**
 * @return {EventHandler}
 */
SearchHandler.prototype.getEventHandler = function() {
	return this.eventHandler;
};

// ... /GET

// ... SEARCH

SearchHandler.prototype.search = function(search) {
	var context = this;

	// Generate url
	var url = Core.sprintf(SearchHandler.URI_SEARCH, encodeURI(search), this.getMode());

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

SearchHandler.prototype.searchBuilding = function(search, buildingId, simple) {
	simple = simple || false;
	var context = this;

	// Generate url
	var url = Core.sprintf(SearchHandler.URI_SEARCH_TYPE, encodeURI(search), SearchHandler.TYPE_BUILDING, buildingId, this.getMode(), simple ? "&simple=true"
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

SearchHandler.prototype.handleSearchResult = function(data) {
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
