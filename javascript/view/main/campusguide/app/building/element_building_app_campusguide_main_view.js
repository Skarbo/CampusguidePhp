// CONSTRUCTOR
ElementBuildingAppCampusguideMainView.prototype = new AppCampusguideMainView();

function ElementBuildingAppCampusguideMainView(wrapperId) {
	AppCampusguideMainView.apply(this, arguments);
}

// /CONSTRUCTOR

// VARIABLES

// /VARIABLES

// FUNCTIONS

// ... GET

/**
 * @return {ElementBuildingAppCampusguideMainController}
 */
ElementBuildingAppCampusguideMainView.prototype.getController = function() {
	return AppCampusguideMainView.prototype.getController.call(this);
};

// ... /GET

// ... DO

ElementBuildingAppCampusguideMainView.prototype.doBindEventHandler = function() {
	AppCampusguideMainView.prototype.doBindEventHandler.call(this);
};

// ... /DO

// ... DRAW

ElementBuildingAppCampusguideMainView.prototype.draw = function(controller) {
	AppCampusguideMainView.prototype.draw.call(this, controller);
};

// ... /DRAW

// /FUNCTIONS
