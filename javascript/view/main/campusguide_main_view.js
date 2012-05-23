// CONSTRUCTOR
CampusguideMainView.prototype = new MainView();

/**
 * @param {string}
 *            wrapperId Wrapper id
 */
function CampusguideMainView(wrapperId) {
	MainView.apply(this, arguments);
	this.wrapperId = wrapperId;
}

// /CONSTRUCTOR

// VARIABLES

// /VARIABLES

// FUNCTIONS

// ... GET

/**
 * @return {CampusguideMainController}
 */
CampusguideMainView.prototype.getController = function() {
	return MainView.prototype.getController.call(this);
};

/**
 * @return {string}
 *            wrapper id
 */
CampusguideMainView.prototype.getWrapperId = function() {
	return this.wrapperId;
};

/**
 * @return {Object}
 */
CampusguideMainView.prototype.getWrapperElement = function() {
	return $(Core.sprintf("#%s", this.getWrapperId()));
};

// ... /GET

// /FUNCTIONS
