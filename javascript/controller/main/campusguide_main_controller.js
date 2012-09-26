// CONSTRUCTOR
CampusguideMainController.prototype = new MainController();

function CampusguideMainController(eventHandler, mode, query) {
	MainController.apply(this, arguments);
	this.facilityDao = new FacilityStandardCampusguideDao(mode);
	this.buildingDao = new BuildingStandardCampusguideDao(mode);
	this.elementBuildingDao = new ElementBuildingStandardCampusguideDao(mode);
	this.floorBuildingDao = new FloorBuildingStandardCampusguideDao(mode);
	this.searchHandler = new SearchCampusguideHandler(eventHandler, mode, this.facilityDao, this.buildingDao, this.elementBuildingDao);
}

// /CONSTRUCTOR

// VARIABLES

// /VARIABLES

// FUNCTIONS

// ... GET

/**
 * @return {CampusguideMainView}
 */
CampusguideMainController.prototype.getView = function() {
	return Controller.prototype.getView.call(this);
};

/**
 * @return {FacilityStandardCampusguideDao}
 */
CampusguideMainController.prototype.getFacilityDao = function() {
	return this.facilityDao;
};

/**
 * @return {BuildingStandardCampusguideDao}
 */
CampusguideMainController.prototype.getBuildingDao = function() {
	return this.buildingDao;
};

/**
 * @return {ElementBuildingStandardCampusguideDao}
 */
CampusguideMainController.prototype.getElementBuildingDao = function() {
	return this.elementBuildingDao;
};

/**
 * @return {FloorBuildingStandardCampusguideDao}
 */
CampusguideMainController.prototype.getFloorBuildingDao = function() {
	return this.floorBuildingDao;
};

/**
 * @return {SearchCampusguideHandler}
 */
CampusguideMainController.prototype.getSearchHandler = function() {
	return this.searchHandler;
};

// ... /GET

// ... DO

CampusguideMainController.prototype.doBindEventHandler = function() {
	MainController.prototype.doBindEventHandler.call(this);
};

// ... /DO

// ... RENDER

/**
 * @param {CampusguideMainView}
 *            view
 */
CampusguideMainController.prototype.render = function(view) {
	MainController.prototype.render.call(this, view);
};

// ... /RENDER

// /FUNCTIONS
