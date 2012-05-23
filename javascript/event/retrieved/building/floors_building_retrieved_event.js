/**
 * FloorsBuildingRetrieved event
 */
FloorsBuildingRetrievedEvent.prototype = new Event();

/**
 * FloorsBuildingRetrieved Event
 * 
 * @param {int}
 *            floorsId
 */
function FloorsBuildingRetrievedEvent(floors) {
	this.floors = floors;
}

// VARIABLES

FloorsBuildingRetrievedEvent.TYPE = "FloorsBuildingRetrievedEvent";

// /VARIABLES

// FUNCTIONS

/**
 * @return {Elemenet} floors
 */
FloorsBuildingRetrievedEvent.prototype.getFloors = function() {
	return this.floors;
};

FloorsBuildingRetrievedEvent.prototype.getType = function() {
	return FloorsBuildingRetrievedEvent.TYPE;
};

// /FUNCTIONS
