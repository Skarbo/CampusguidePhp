// CONSTRUCTOR
NavigationBuildingStandardDao.prototype = new StandardDao();

/**
 * @param {integer}
 *            mode
 */
function NavigationBuildingStandardDao(mode) {
	StandardDao.call(this, mode, NavigationBuildingStandardDao.CONTROLLER_NAME);
	this.foreignField = "floorId";
}

// VARIABLES

NavigationBuildingStandardDao.CONTROLLER_NAME = "buildingnavigation";

// /VARIABLES

// FUNCTIONS

/**
 * @param {Object}
 *            buildingId
 * @param {function}
 *            callback
 * @return {Object}
 */
NavigationBuildingStandardDao.prototype.getBuilding = function(buildingId, callback) {
	var context = this;
	this.ajax.query(Core.sprintf("%s/%s", "building", buildingId), function(single, list) {
		context.getListAdapter().addAll(list);
		callback(single, list);
	});
};

NavigationBuildingStandardDao.prototype.navigations = function(floorId, navigationData, callback) {
	var context = this;
	this.ajax.post(Core.sprintf("%s/%s", "navigation", floorId), {
		'object' : navigationData
	}, function(single, list) {
		context.getListAdapter().clear();
		context.getListAdapter().addAll(list);
		callback(list);
	});
};

// /FUNCTIONS
