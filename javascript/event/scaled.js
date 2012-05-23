/**
 * Scaled event
 */
ScaledEvent.prototype = new Event();

/**
 * Scaled Event
 * 
 * @param {float} scale Scale size
 */
function ScaledEvent(scale) {
	this.scale = scale;
}

// VARIABLES

ScaledEvent.TYPE = "ScaledEvent";

// /VARIABLES

// FUNCTIONS

/**
 * @returns {float} Scale size
 */
ScaledEvent.prototype.getScale = function() {
	return this.scale;
};

ScaledEvent.prototype.getType = function() {
	return ScaledEvent.TYPE;
};

// /FUNCTIONS
