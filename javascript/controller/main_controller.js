// CONSTRUCTOR
MainController.prototype = new AbstractMainController();

function MainController(eventHandler, mode, query) {
	AbstractMainController.apply(this, arguments);
	this.facilityDao = new FacilityStandardDao(mode);
	this.buildingDao = new BuildingStandardDao(mode);
	this.elementBuildingDao = new ElementBuildingStandardDao(mode);
	this.floorBuildingDao = new FloorBuildingStandardDao(mode);
	this.searchHandler = new SearchHandler(eventHandler, mode, this.facilityDao, this.buildingDao, this.elementBuildingDao);
}

// /CONSTRUCTOR

// VARIABLES

// /VARIABLES

// FUNCTIONS

// ... GET

/**
 * @return {MainView}
 */
MainController.prototype.getView = function() {
	return AbstractMainController.prototype.getView.call(this);
};

/**
 * @return {FacilityStandardDao}
 */
MainController.prototype.getFacilityDao = function() {
	return this.facilityDao;
};

/**
 * @return {BuildingStandardDao}
 */
MainController.prototype.getBuildingDao = function() {
	return this.buildingDao;
};

/**
 * @return {ElementBuildingStandardDao}
 */
MainController.prototype.getElementBuildingDao = function() {
	return this.elementBuildingDao;
};

/**
 * @return {FloorBuildingStandardDao}
 */
MainController.prototype.getFloorBuildingDao = function() {
	return this.floorBuildingDao;
};

/**
 * @return {SearchHandler}
 */
MainController.prototype.getSearchHandler = function() {
	return this.searchHandler;
};

// ... /GET

// ... DO

MainController.prototype.doBindEventHandler = function() {
	AbstractMainController.prototype.doBindEventHandler.call(this);
};

// ... /DO

// ... RENDER

/**
 * @param {MainView}
 *            view
 */
MainController.prototype.render = function(view) {
	AbstractMainController.prototype.render.call(this, view);
};

// ... /RENDER

// /FUNCTIONS
