/**
 * FacilitiesRetrieve event
 */
FacilitiesRetrieveEvent.prototype = new Event();

/**
 * FacilitiesRetrieve Event
 */
function FacilitiesRetrieveEvent() {
}

// VARIABLES

FacilitiesRetrieveEvent.TYPE = "FacilitiesRetrieveEvent";

// /VARIABLES

// FUNCTIONS

FacilitiesRetrieveEvent.prototype.getType = function() {
	return FacilitiesRetrieveEvent.TYPE;
};

// /FUNCTIONS
