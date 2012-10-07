// CONSTRUCTOR
BuildingStandardDao.prototype = new StandardDao();

/**
 * @param {integer}
 *            mode
 */
function BuildingStandardDao(mode) {
	StandardDao.call(this, mode, BuildingStandardDao.CONTROLLER_NAME);
	this.foreignField = "facilityId";
}

// VARIABLES

BuildingStandardDao.CONTROLLER_NAME = "buildings";

// /VARIABLES

// FUNCTIONS


// /FUNCTIONS
