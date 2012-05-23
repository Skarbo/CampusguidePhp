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

/**
 * @param {Element}
 *            root
 */
PageMainView.prototype.draw = function(root) {
	this.setRoot(root);
};

// FUNCTIONS
