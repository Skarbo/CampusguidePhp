HighlightEvent.prototype = new Event();

function HighlightEvent(id) {
	this.id = id;
}

// VARIABLES

HighlightEvent.TYPE = "HighlightEvent";

// /VARIABLES

// FUNCTIONS

/**
 * @returns {int}
 */
HighlightEvent.prototype.getId = function() {
	return this.id;
};

HighlightEvent.prototype.getType = function() {
	return HighlightEvent.TYPE;
};

// /FUNCTIONS
