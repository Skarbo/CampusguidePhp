// CONSTRUCTOR
BuildingStandardCampusguideDao.prototype = new StandardCampusguideDao();

/**
 * @param {integer}
 *            mode
 */
function BuildingStandardCampusguideDao(mode) {
	StandardCampusguideDao.call(this, mode, BuildingStandardCampusguideDao.CONTROLLER_NAME);
	this.foreignField = "facilityId";
}

// VARIABLES

BuildingStandardCampusguideDao.CONTROLLER_NAME = "buildings";

// /VARIABLES

// FUNCTIONS


// /FUNCTIONS
