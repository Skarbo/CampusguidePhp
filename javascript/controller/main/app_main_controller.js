// CONSTRUCTOR
AppMainController.prototype = new MainController();

function AppMainController(eventHandler, mode, query) {
	MainController.apply(this, arguments);
	this.navigateHandler = new NavigateHandler(eventHandler, mode);
}

// /CONSTRUCTOR

// VARIABLES

// /VARIABLES

// FUNCTIONS

// ... GET

/**
 * @return {AppMainView}
 */
AppMainController.prototype.getView = function() {
	return MainController.prototype.getView.call(this);
};

/**
 * @return {NavigateHandler}
 */
AppMainController.prototype.getNavigateHandler = function() {
	return this.navigateHandler;
};

// ... /GET

// ... DO

AppMainController.prototype.doBindEventHandler = function() {
	MainController.prototype.doBindEventHandler.call(this);
	var context = this;

	// EVENTS

	// Search event
	this.getEventHandler().registerListener(SearchEvent.TYPE,
	/**
	 * @param {SearchEvent}
	 *            event
	 */
	function(event) {
		context.handleSearch(event.getSearch(), event.getOptions());
	});

	// /EVENTS

};

// ... /DO

// ... HANDLE

AppMainController.prototype.handleSearch = function(search, options) {

	// Search
	this.getSearchHandler().search(search);

};

// ... /HANDLE

// ... RENDER

/**
 * @param {AppMainView}
 *            view
 */
AppMainController.prototype.render = function(view) {
	MainController.prototype.render.call(this, view);
};

// ... /RENDER

// /FUNCTIONS
