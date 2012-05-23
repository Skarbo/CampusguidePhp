/**
 * BuildingRetrieve event
 */
BuildingRetrieveEvent.prototype = new Event();

/**
 * BuildingRetrieve Event
 * 
 * @param {int}
 *            buildingId
 */
function BuildingRetrieveEvent(buildingId) {
	this.buildingId = buildingId;
}

// VARIABLES

BuildingRetrieveEvent.TYPE = "BuildingRetrieveEvent";

// /VARIABLES

// FUNCTIONS

/**
 * @return {int} buildingId
 */
BuildingRetrieveEvent.prototype.getBuildingId = function() {
	return this.buildingId;
};

BuildingRetrieveEvent.prototype.getType = function() {
	return BuildingRetrieveEvent.TYPE;
};

// /FUNCTIONS
