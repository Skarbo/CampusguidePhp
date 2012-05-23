// CONSTRUCTOR
FloorBuildingStandardCampusguideDao.prototype = new StandardCampusguideDao();

/**
 * @param {integer}
 *            mode
 */
function FloorBuildingStandardCampusguideDao(mode) {
	StandardCampusguideDao.call(this, mode, FloorBuildingStandardCampusguideDao.CONTROLLER_NAME);
	this.foreignField = "buildingId";
}

// VARIABLES

FloorBuildingStandardCampusguideDao.CONTROLLER_NAME = "buildingfloors";

// /VARIABLES

// FUNCTIONS


// /FUNCTIONS
