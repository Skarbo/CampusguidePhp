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
ElementBuildingStandardCampusguideDao.prototype.getBuilding = function(buildingId, callback) {
	var context = this;
	this.ajax.query(Core.sprintf("%s/%s", "building", buildingId), function(single, list) {
		context.addListToList(list);
		callback(single, list);
	});
};

/**
 * @param {Object}
 *            id
 * @param {function}
 *            callback
 * @return {Object}
 */
ElementBuildingStandardCampusguideDao.prototype.delete_ = function(id, callback) {
	this.ajax.query(Core.sprintf("%s/%s", "delete", id), callback);
};

// /FUNCTIONS
