// CONSTRUCTOR
ElementBuildingAppMainController.prototype = new AppMainController();

function ElementBuildingAppMainController(eventHandler, mode, query) {
	AppMainController.apply(this, arguments);
}

// /CONSTRUCTOR

// VARIABLES

// /VARIABLES

// FUNCTIONS

// ... GET

/**
 * @return {ElementBuildingAppMainView}
 */
ElementBuildingAppMainController.prototype.getView = function() {
	return AppMainController.prototype.getView.call(this);
};

// ... /GET

// ... DO

ElementBuildingAppMainController.prototype.doBindEventHandler = function() {
	AppMainController.prototype.doBindEventHandler.call(this);
};

// ... /DO

// ... RENDER

/**
 * @param {BuildingAppMainView}
 *            view
 */
ElementBuildingAppMainController.prototype.render = function(view) {
	AppMainController.prototype.render.call(this, view);
};

// ... /RENDER

// /FUNCTIONS
