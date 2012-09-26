// CONSTRUCTOR
AppCampusguideMainController.prototype = new CampusguideMainController();

function AppCampusguideMainController(eventHandler, mode, query) {
	CampusguideMainController.apply(this, arguments);
}

// /CONSTRUCTOR

// VARIABLES

// /VARIABLES

// FUNCTIONS

// ... GET

/**
 * @return {AppCampusguideMainView}
 */
AppCampusguideMainController.prototype.getView = function() {
	return CampusguideMainController.prototype.getView.call(this);
};

// ... /GET

// ... DO

AppCampusguideMainController.prototype.doBindEventHandler = function() {
	CampusguideMainController.prototype.doBindEventHandler.call(this);
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

AppCampusguideMainController.prototype.handleSearch = function(search, options) {

	// Search
	this.getSearchHandler().search(search);

};

// ... /HANDLE

// ... RENDER

/**
 * @param {AppCampusguideMainView}
 *            view
 */
AppCampusguideMainController.prototype.render = function(view) {
	CampusguideMainController.prototype.render.call(this, view);
};

// ... /RENDER

// /FUNCTIONS
