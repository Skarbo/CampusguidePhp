/**
 * FloorFloorplannerBuilding event
 */
FloorBuildingEvent.prototype = new Event();

/**
 * FloorFloorplannerBuilding Event
 * 
 * @param {Number}
 *            floorId
 */
function FloorBuildingEvent(floorId) {
	this.floorId = floorId;
}

// VARIABLES

FloorBuildingEvent.TYPE = "FloorBuildingEvent";

// /VARIABLES

// FUNCTIONS

/**
 * @return {Number} floorId
 */
FloorBuildingEvent.prototype.getFloorId = function() {
	return this.floorId;
};

FloorBuildingEvent.prototype.getType = function() {
	return FloorBuildingEvent.TYPE;
};

// /FUNCTIONS
