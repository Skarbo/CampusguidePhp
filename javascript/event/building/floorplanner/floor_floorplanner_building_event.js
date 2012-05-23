/**
 * FloorFloorplannerBuilding event
 */
FloorFloorplannerBuildingEvent.prototype = new Event();

/**
 * FloorFloorplannerBuilding Event
 * 
 * @param {Number}
 *            floorId
 */
function FloorFloorplannerBuildingEvent(floorId) {
	this.floorId = floorId;
}

// VARIABLES

FloorFloorplannerBuildingEvent.TYPE = "FloorFloorplannerBuildingEvent";

// /VARIABLES

// FUNCTIONS

/**
 * @return {Number} floorId
 */
FloorFloorplannerBuildingEvent.prototype.getFloorId = function() {
	return this.floorId;
};

FloorFloorplannerBuildingEvent.prototype.getType = function() {
	return FloorFloorplannerBuildingEvent.TYPE;
};

// /FUNCTIONS
