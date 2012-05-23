/**
 * BuildingRetrieved event
 */
BuildingRetrievedEvent.prototype = new Event();

/**
 * BuildingRetrieved Event
 * 
 * @param {int}
 *            buildingId
 */
function BuildingRetrievedEvent(building) {
	this.building = building;
}

// VARIABLES

BuildingRetrievedEvent.TYPE = "BuildingRetrievedEvent";

// /VARIABLES

// FUNCTIONS

/**
 * @return {Elemenet} building
 */
BuildingRetrievedEvent.prototype.getBuilding = function() {
	return this.building;
};

BuildingRetrievedEvent.prototype.getType = function() {
	return BuildingRetrievedEvent.TYPE;
};

// /FUNCTIONS
