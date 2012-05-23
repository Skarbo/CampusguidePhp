/**
 * FloorsBuildingRetrieve event
 */
FloorsBuildingRetrieveEvent.prototype = new Event();

/**
 * FloorsBuildingRetrieve Event
 * 
 * @param {int}
 *            buildingId
 */
function FloorsBuildingRetrieveEvent(buildingId) {
	this.buildingId = buildingId;
}

// VARIABLES

FloorsBuildingRetrieveEvent.TYPE = "FloorsBuildingRetrieveEvent";

// /VARIABLES

// FUNCTIONS

/**
 * @return {int} buildingId
 */
FloorsBuildingRetrieveEvent.prototype.getBuildingId = function() {
	return this.buildingId;
};

FloorsBuildingRetrieveEvent.prototype.getType = function() {
	return FloorsBuildingRetrieveEvent.TYPE;
};

// /FUNCTIONS
