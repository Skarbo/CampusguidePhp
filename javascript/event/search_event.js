SearchEvent.prototype = new Event();

function SearchEvent(search, options) {	
	Event.call(this, options);
	this.search = search;
}

// VARIABLES

SearchEvent.TYPE = "SearchEvent";

// /VARIABLES

// FUNCTIONS

/**
 * @returns {String}
 */
SearchEvent.prototype.getSearch = function() {
	return this.search;
};

SearchEvent.prototype.getType = function() {
	return SearchEvent.TYPE;
};

// /FUNCTIONS
