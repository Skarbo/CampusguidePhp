SearchEvent.prototype = new Event();

/**
 * @param {String}
 *            search
 * @param {Object}
 *            Options as JSON
 */
function SearchEvent(search, options) {
	this.search = search;
	this.options = options || {};
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

/**
 * @returns {Object}
 */
SearchEvent.prototype.getOptions = function() {
	return this.options;
};

SearchEvent.prototype.getType = function() {
	return SearchEvent.TYPE;
};

// /FUNCTIONS
