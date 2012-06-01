// CONSTRUCTOR

function SearchCampusguideHandler(eventHandler, mode, facilityDao, buildingDao) {
	this.eventHandler = eventHandler;
	this.mode = mode;
	this.facilityDao = facilityDao;
	this.buildingDao = buildingDao;
}

// /CONSTRUCTOR

// VARIABLES

SearchCampusguideHandler.URI_SEARCH = "api_rest.php?/search/%s&mode=%s";

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

SearchCampusguideHandler.prototype.handleSearchResult = function(data) {

	var facilities = data.facilities || [];
	var buildings = data.buildings || [];

	// Facilities
	this.getFacilityDao().addListToList(facilities);

	// Buildings
	this.getBuildingDao().addListToList(buildings);

	// Send search result event
	this.getEventHandler().handle(new ResultSearchEvent({ "facilities" : facilities, "buildings" : buildings }));

};

// ... /SEARCH

// FUNCTIONS
