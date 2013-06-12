// CONSTRUCTOR
MainController.prototype = new AbstractMainController();

function MainController(eventHandler, mode, query) {
	AbstractMainController.apply(this, arguments);
	this.daoContainer = new DaoContainer(mode);
	this.searchHandler = new SearchHandler(eventHandler, mode, this.daoContainer);
}

// /CONSTRUCTOR

// VARIABLES

// /VARIABLES

// FUNCTIONS

// ... GET

/**
 * @return {MainView}
 */
MainController.prototype.getView = function() {
	return AbstractMainController.prototype.getView.call(this);
};

/**
 * @return {DaoContainer}
 */
MainController.prototype.getDaoContainer = function() {
	return this.daoContainer;
};

/**
 * @return {SearchHandler}
 */
MainController.prototype.getSearchHandler = function() {
	return this.searchHandler;
};

// ... /GET

// ... DO

MainController.prototype.doBindEventHandler = function() {
	AbstractMainController.prototype.doBindEventHandler.call(this);
};

// ... /DO

// ... RENDER

/**
 * @param {MainView}
 *            view
 */
MainController.prototype.render = function(view) {
	AbstractMainController.prototype.render.call(this, view);
};

// ... /RENDER

// /FUNCTIONS
