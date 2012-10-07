// CONSTRUCTOR
MainView.prototype = new AbstractMainView();

/**
 * @param {string}
 *            wrapperId Wrapper id
 */
function MainView(wrapperId) {
	AbstractMainView.apply(this, arguments);
	this.wrapperId = wrapperId;
}

// /CONSTRUCTOR

// VARIABLES

// /VARIABLES

// FUNCTIONS

// ... GET

/**
 * @return {MainController}
 */
MainView.prototype.getController = function() {
	return AbstractMainView.prototype.getController.call(this);
};

/**
 * @return {string}
 *            wrapper id
 */
MainView.prototype.getWrapperId = function() {
	return this.wrapperId;
};

/**
 * @return {Object}
 */
MainView.prototype.getWrapperElement = function() {
	return $(Core.sprintf("#%s", this.getWrapperId()));
};

// ... /GET

// /FUNCTIONS
