/**
 * Scale event
 */
ScaleEvent.prototype = new Event();

/**
 * Scale Event
 * 
 * @param {bollean}
 *            scaleUp True if scale up, false if scale down
 */
function ScaleEvent(scaleUp, animate) {
	this.scaleUp = scaleUp;
	this.animate = animate || false;
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

/**
 * @returns {Boolean} True if to animate
 */
ScaleEvent.prototype.isAnimate = function() {
	return this.animate;
};

ScaleEvent.prototype.getType = function() {
	return ScaleEvent.TYPE;
};

// /FUNCTIONS
