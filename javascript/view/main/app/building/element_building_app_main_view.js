// CONSTRUCTOR
ElementBuildingAppMainView.prototype = new AppMainView();

function ElementBuildingAppMainView(wrapperId) {
	AppMainView.apply(this, arguments);
}

// /CONSTRUCTOR

// VARIABLES

// /VARIABLES

// FUNCTIONS

// ... GET

/**
 * @return {ElementBuildingAppMainController}
 */
ElementBuildingAppMainView.prototype.getController = function() {
	return AppMainView.prototype.getController.call(this);
};

// ... /GET

// ... DO

ElementBuildingAppMainView.prototype.doBindEventHandler = function() {
	AppMainView.prototype.doBindEventHandler.call(this);
};

// ... /DO

// ... DRAW

ElementBuildingAppMainView.prototype.draw = function(controller) {
	AppMainView.prototype.draw.call(this, controller);
};

// ... /DRAW

// /FUNCTIONS
