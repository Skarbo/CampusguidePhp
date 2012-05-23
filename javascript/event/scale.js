/**
 * Scale event
 */
ScaleEvent.prototype = new Event();

/**
 * Scale Event
 * 
 * @param {bollean} scaleUp True if scale up, false if scale down
 */
function ScaleEvent(scaleUp) {
	this.scaleUp = scaleUp;
}

// VARIABLES

ScaleEvent.TYPE = "ScaleEvent";

// /VARIABLES

// FUNCTIONS

/**
 * @returns {boolean} True if scale up, false if scale down
 */
ScaleEvent.prototype.isScaleUp = function() {
	return this.scaleUp;
};

ScaleEvent.prototype.getType = function() {
	return ScaleEvent.TYPE;
};

// /FUNCTIONS
