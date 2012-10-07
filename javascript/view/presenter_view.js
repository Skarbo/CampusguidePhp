// CONSTRUCTOR

function PresenterView(view) {
	this.view = view;
}

// /CONSTRUCTOR

// VARIABLES

// /VARIABLES

// FUNCTIONS

/**
 * @returns {AbstractView}
 */
PresenterView.prototype.getView = function() {
	return this.view;
};

/**
 * @returns {Object}
 */
PresenterView.prototype.getRoot = function() {
	return this.root;
};

// ... GET

/**
 * @returns {AbstractMainController} Event handler
 */
PresenterView.prototype.getController = function() {
	return this.getView().getController();
};

/**
 * @returns {Number} Mode
 */
PresenterView.prototype.getMode = function() {
	return this.getController().getMode();
};

/**
 * @returns {EventHandler} Event handler
 */
PresenterView.prototype.getEventHandler = function() {
	return this.getController().getEventHandler();
};

// ... /GET

// ... DO

PresenterView.prototype.doBindEventHandler = function() {
};

// ... /DO

/**
 * @param {Object}
 *            root
 */
PresenterView.prototype.draw = function(root) {
	this.root = root;
	this.doBindEventHandler();
};

// FUNCTIONS