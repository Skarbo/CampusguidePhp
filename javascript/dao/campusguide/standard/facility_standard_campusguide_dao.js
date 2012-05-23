// CONSTRUCTOR
FacilityStandardCampusguideDao.prototype = new StandardCampusguideDao();

/**
 * @param {integer}
 *            mode
 */
function FacilityStandardCampusguideDao(mode) {
	StandardCampusguideDao.call(this, mode, FacilityStandardCampusguideDao.CONTROLLER_NAME);
}

// VARIABLES

FacilityStandardCampusguideDao.CONTROLLER_NAME = "facilities";

// /VARIABLES

// FUNCTIONS


// /FUNCTIONS
