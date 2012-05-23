// CONSTRUCTOR
ElementBuildingStandardCampusguideDao.prototype = new StandardCampusguideDao();

/**
 * @param {integer}
 *            mode
 */
function ElementBuildingStandardCampusguideDao(mode) {
	StandardCampusguideDao.call(this, mode, ElementBuildingStandardCampusguideDao.CONTROLLER_NAME);
	this.foreignField = "buildingId";
}

// VARIABLES

ElementBuildingStandardCampusguideDao.CONTROLLER_NAME = "buildingelements";

// /VARIABLES

// FUNCTIONS


// /FUNCTIONS
