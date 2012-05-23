/**
 * ElementsBuildingRetrieve event
 */
ElementsBuildingRetrieveEvent.prototype = new Event();

/**
 * ElementsBuildingRetrieve Event
 * 
 * @param {int}
 *            buildingId
 */
function ElementsBuildingRetrieveEvent(buildingId) {
	this.buildingId = buildingId;
}

// VARIABLES

ElementsBuildingRetrieveEvent.TYPE = "ElementsBuildingRetrieveEvent";

// /VARIABLES

// FUNCTIONS

/**
 * @return {int} buildingId
 */
ElementsBuildingRetrieveEvent.prototype.getBuildingId = function() {
	return this.buildingId;
};

ElementsBuildingRetrieveEvent.prototype.getType = function() {
	return ElementsBuildingRetrieveEvent.TYPE;
};

// /FUNCTIONS
