/**
 * FacilitiesRetrieved event
 */
FacilitiesRetrievedEvent.prototype = new Event();

/**
 * FacilitiesRetrieved Event
 * @param {Object} facilities
 */
function FacilitiesRetrievedEvent(facilities) {
	this.facilities = facilities;
}

// VARIABLES

FacilitiesRetrievedEvent.TYPE = "FacilitiesRetrievedEvent";

// /VARIABLES

// FUNCTIONS

FacilitiesRetrievedEvent.prototype.getType = function() {
	return FacilitiesRetrievedEvent.TYPE;
};

/**
 * @returns {Object}
 */
FacilitiesRetrievedEvent.prototype.getFacilities = function() {
	return this.facilities;
};

// /FUNCTIONS
