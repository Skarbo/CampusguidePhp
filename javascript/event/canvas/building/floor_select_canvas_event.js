/**
 * FloorSelect event
 */
FloorSelectEvent.prototype = new Event();

/**
 * FloorSelect Event
 * 
 * @param {Number}
 *            floorId
 */
function FloorSelectEvent(floorId) {
	this.floorId = floorId;
}

// VARIABLES

FloorSelectEvent.TYPE = "FloorSelectEvent";

// /VARIABLES

// FUNCTIONS

/**
 * @return {Number} floorId
 */
FloorSelectEvent.prototype.getFloorId = function() {
	return this.floorId;
};

FloorSelectEvent.prototype.getType = function() {
	return FloorSelectEvent.TYPE;
};

// /FUNCTIONS
