// CONSTRUCTOR
function DaoContainer(mode) {
	this.facilityDao = new FacilityStandardDao(mode);
	this.buildingDao = new BuildingStandardDao(mode);
	this.elementBuildingDao = new ElementBuildingStandardDao(mode);
	this.floorBuildingDao = new FloorBuildingStandardDao(mode);
	this.navigationBuildingDao = new NavigationBuildingStandardDao(mode);
}
// /CONSTRUCTOR

// VARIABLES

// /VARIABLES

// FUNCTIONS

/**
 * @return {FacilityStandardDao}
 */
DaoContainer.prototype.getFacilityDao = function() {
	return this.facilityDao;
};

/**
 * @return {BuildingStandardDao}
 */
DaoContainer.prototype.getBuildingDao = function() {
	return this.buildingDao;
};

/**
 * @return {ElementBuildingStandardDao}
 */
DaoContainer.prototype.getElementBuildingDao = function() {
	return this.elementBuildingDao;
};

/**
 * @return {FloorBuildingStandardDao}
 */
DaoContainer.prototype.getFloorBuildingDao = function() {
	return this.floorBuildingDao;
};

/**
 * @return {NavigationBuildingStandardDao}
 */
DaoContainer.prototype.getNavigationBuildingDao = function() {
	return this.navigationBuildingDao;
};

// /FUNCTIONS
