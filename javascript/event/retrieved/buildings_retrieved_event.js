/**
 * BuildingsRetrieved event
 */
BuildingsRetrievedEvent.prototype = new Event();

/**
 * BuildingsRetrieved Event
 * @param {Object} facilities
 */
function BuildingsRetrievedEvent(facilities) {
	this.facilities = facilities;
}

// VARIABLES

BuildingsRetrievedEvent.TYPE = "BuildingsRetrievedEvent";

// /VARIABLES

// FUNCTIONS

BuildingsRetrievedEvent.prototype.getType = function() {
	return BuildingsRetrievedEvent.TYPE;
};

/**
 * @returns {Object}
 */
BuildingsRetrievedEvent.prototype.getBuildings = function() {
	return this.facilities;
};

// /FUNCTIONS
