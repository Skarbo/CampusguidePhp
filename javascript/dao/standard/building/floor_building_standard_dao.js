// CONSTRUCTOR
FloorBuildingStandardDao.prototype = new StandardDao();

/**
 * @param {integer}
 *            mode
 */
function FloorBuildingStandardDao(mode) {
	StandardDao.call(this, mode, FloorBuildingStandardDao.CONTROLLER_NAME);
	this.foreignField = "buildingId";
}

// VARIABLES

FloorBuildingStandardDao.CONTROLLER_NAME = "buildingfloors";

// /VARIABLES

// FUNCTIONS


// /FUNCTIONS
