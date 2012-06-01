ResultSearchEvent.prototype = new Event();

function ResultSearchEvent(results) {
	Event.call(this, Array.prototype.slice.call(arguments).slice(1));
	this.results = results;
}

// VARIABLES

ResultSearchEvent.TYPE = "ResultSearchEvent";

// /VARIABLES

// FUNCTIONS

/**
 * @returns {Object}
 */
ResultSearchEvent.prototype.getResults = function() {
	return this.results;
};

ResultSearchEvent.prototype.getType = function() {
	return ResultSearchEvent.TYPE;
};

// /FUNCTIONS
