// CONSTRUCTOR
ElementBuildingAppCampusguideMainController.prototype = new AppCampusguideMainController();

function ElementBuildingAppCampusguideMainController(eventHandler, mode, query) {
	AppCampusguideMainController.apply(this, arguments);
}

// /CONSTRUCTOR

// VARIABLES

// /VARIABLES

// FUNCTIONS

// ... GET

/**
 * @return {ElementBuildingAppCampusguideMainView}
 */
ElementBuildingAppCampusguideMainController.prototype.getView = function() {
	return AppCampusguideMainController.prototype.getView.call(this);
};

// ... /GET

// ... DO

ElementBuildingAppCampusguideMainController.prototype.doBindEventHandler = function() {
	AppCampusguideMainController.prototype.doBindEventHandler.call(this);
};

// ... /DO

// ... RENDER

/**
 * @param {BuildingAppCampusguideMainView}
 *            view
 */
ElementBuildingAppCampusguideMainController.prototype.render = function(view) {
	AppCampusguideMainController.prototype.render.call(this, view);
};

// ... /RENDER

// /FUNCTIONS
