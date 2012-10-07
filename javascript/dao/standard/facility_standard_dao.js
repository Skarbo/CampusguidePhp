// CONSTRUCTOR
FacilityStandardDao.prototype = new StandardDao();

/**
 * @param {integer}
 *            mode
 */
function FacilityStandardDao(mode) {
	StandardDao.call(this, mode, FacilityStandardDao.CONTROLLER_NAME);
}

// VARIABLES

FacilityStandardDao.CONTROLLER_NAME = "facilities";

// /VARIABLES

// FUNCTIONS


// /FUNCTIONS
