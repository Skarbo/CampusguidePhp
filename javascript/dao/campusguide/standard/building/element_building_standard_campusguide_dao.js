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

/**
 * @param {Object}
 *            buildingId
 * @param {function}
 *            callback
 * @return {Object}
 */
StandardCampusguideDao.prototype.getBuilding = function(buildingId, callback) {
	this.ajax.query(Core.sprintf("%s/%s", "building", buildingId), callback);
};

// /FUNCTIONS
