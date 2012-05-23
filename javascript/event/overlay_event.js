OverlayEvent.prototype = new Event();

/**
 * @param {Object} options
 * @param {string} overlayId
 */
function OverlayEvent(options, overlayId) {
	this.options = options;
	this.overlayId = overlayId || "overlay";
}

// VARIABLES

OverlayEvent.TYPE = "OverlayEvent";

// /VARIABLES

// FUNCTIONS

/**
 * @returns {string} Overlay ID
 */
OverlayEvent.prototype.getOverlayId = function() {
	return this.overlayId;
};

/**
 * @returns {Object} Options
 */
OverlayEvent.prototype.getOptions = function() {
	return this.options;
};

OverlayEvent.prototype.getType = function() {
	return OverlayEvent.TYPE;
};

// /FUNCTIONS
