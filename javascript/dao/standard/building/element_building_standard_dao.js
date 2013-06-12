// CONSTRUCTOR
ElementBuildingStandardDao.prototype = new StandardDao();

/**
 * @param {integer}
 *            mode
 */
function ElementBuildingStandardDao(mode) {
	StandardDao.call(this, mode, ElementBuildingStandardDao.CONTROLLER_NAME);
	this.foreignField = "buildingId";
}

// VARIABLES

ElementBuildingStandardDao.CONTROLLER_NAME = "buildingelements";

// /VARIABLES

// FUNCTIONS

/**
 * @param {Object}
 *            buildingId
 * @param {function}
 *            callback
 * @return {Object}
 */
ElementBuildingStandardDao.prototype.getBuilding = function(buildingId, callback) {
	var context = this;
	this.ajax.query(Core.sprintf("%s/%s", "building", buildingId), function(single, list) {
		context.getListAdapter().addAll(list);
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
ElementBuildingStandardDao.prototype.delete_ = function(id, callback) {
	this.ajax.query(Core.sprintf("%s/%s", "delete", id), callback);
};

// /FUNCTIONS
