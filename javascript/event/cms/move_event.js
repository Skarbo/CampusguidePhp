/**
 * MoveEvent event
 */
MoveEvent.prototype = new Event();

/**
 * MoveEvent Event
 * 
 * @param {Number}
 *            lineFloor
 */
function MoveEvent(moveType, element) {
	this.moveType = moveType;
	this.element = element;
}

// VARIABLES

MoveEvent.TYPE = "MoveEvent";

// /VARIABLES

// FUNCTIONS

/**
 * @return {Object} element
 */
MoveEvent.prototype.getElement = function() {
	return this.element;
};

/**
 * @return {String} type
 */
MoveEvent.prototype.getSelectType = function() {
	return this.moveType;
};

MoveEvent.prototype.getType = function() {
	return MoveEvent.TYPE;
};

// /FUNCTIONS
