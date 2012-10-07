// CONSTRUCTOR
AdminCmsMainView.prototype = new CmsMainView();

function AdminCmsMainView(wrapperId) {
	CmsMainView.apply(this, arguments);
	this.searchDelayTimer = null;
};

// /CONSTRUCTOR

// VARIABLES

AdminCmsMainView.SEARCH_DELAY = 500;

// /VARIABLES

// FUNCTIONS

// ... GET

AdminCmsMainView.prototype.getErrorsTableElement = function() {
	return this.getWrapperElement().find("#errors_page_wrapper table.errors");
};

AdminCmsMainView.prototype.getErrorRowsElement = function() {
	return this.getErrorsTableElement().find("tbody.error");
};

AdminCmsMainView.prototype.getErrorSearchInputElement = function() {
	return this.getWrapperElement().find("#errors_search");
};

AdminCmsMainView.prototype.getErrorResetButtonElement = function() {
	return this.getWrapperElement().find("#errors_search_reset");
};

// ... /GET

// ... DO

AdminCmsMainView.prototype.doBindEventHandler = function() {
	CmsMainView.prototype.doBindEventHandler.call(this);
	var context = this;

	// ... ERRORS
	
	var errorRows = this.getErrorRowsElement();
	errorRows.bind("click", {
		"errorRows" : errorRows
	}, function(event) {
		var isHighlighted = $(this).hasClass("highlight");
		if (!isHighlighted) {
			event.data.errorRows.removeClass("highlight");
			$(this).addClass("highlight");
			//$(document).scrollTop($(this).position().top);
		}
	});
	
	// ... ... SEARCH

	this.getErrorsTableElement().tableSearch({
		"display" : "tbody.error",
		"search" : ".message, .file, .url, .exception",
		"noresult" : "#errors_noerrors"
	});

	this.getErrorSearchInputElement().keyup(function(event) {
		context.doSearch(event.target.value, true);
	});

	this.getErrorResetButtonElement().click(function() {
		context.getController().getEventHandler().handle(new SearchEvent(""));
	});

	this.getController().getEventHandler().registerListener(SearchEvent.TYPE,
	/**
	 * @param {SearchEvent}
	 *            event
	 */
	function(event) {
		context.getErrorsTableElement().tableSearch("search", event.getSearch());
	});

	// /... ... /SEARCH
	
	// ... /ERRORS
	
};

AdminCmsMainView.prototype.doSearch = function(search, delay) {

	// Delay search
	if (delay != undefined && delay == true) {
		var context = this;
		clearTimeout(this.searchDelayTimer);
		this.searchDelayTimer = setTimeout(function() {
			context.doSearch(search, false);
		}, AdminCmsMainView.SEARCH_DELAY);
		return;
	}

	// Do search
	this.getController().getEventHandler().handle(new SearchEvent(search));

};

// ... /DO

AdminCmsMainView.prototype.draw = function(controller) {
	CmsMainView.prototype.draw.call(this, controller);
	
	$(".gui").gui();
};

// /FUNCTIONS
