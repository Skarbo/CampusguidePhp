// CONSTRUCTOR

function PageMainView(view) {
	this.view = view;
}

// /CONSTRUCTOR

// VARIABLES

// /VARIABLES

// FUNCTIONS

/**
 * @param {MainView}
 *            view
 */
PageMainView.prototype.setView = function(view) {
	this.view = view;
};

/**
 * @returns {MainView}
 */
PageMainView.prototype.getView = function() {
	return this.view;
};

/**
 * @param {Element}
 *            root
 */
PageMainView.prototype.setRoot = function(root) {
	this.root = root;
};

/**
 * @returns {Element}
 */
PageMainView.prototype.getRoot = function() {
	return this.root;
};

// ... GET

/**
 * @returns {Number} Mode
 */
PageMainView.prototype.getMode = function() {
	return this.getView().getController().getMode();
};

/**
 * @returns {MainController} Event handler
 */
PageMainView.prototype.getController = function() {
	return this.getView().getController();
};

/**
 * @returns {EventHandler} Event handler
 */
PageMainView.prototype.getEventHandler = function() {
	return this.getController().getEventHandler();
};

// ... /GET

// ... DO

PageMainView.prototype.doBindEventHandler = function() {
};

// ... /DO

/**
 * @param {Element}
 *            root
 */
PageMainView.prototype.draw = function(root) {
	this.setRoot(root);
	this.doBindEventHandler();
};

// FUNCTIONS
