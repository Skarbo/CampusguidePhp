OverlayCloseEvent.prototype = new Event();

function OverlayCloseEvent(overlayId) {
	this.overlayId = overlayId || "overlay";
}

// VARIABLES

OverlayCloseEvent.TYPE = "OverlayCloseEvent";

// /VARIABLES

// FUNCTIONS

OverlayCloseEvent.prototype.getOverlayId = function() {
	return this.overlayId;
};


OverlayCloseEvent.prototype.getType = function() {
	return OverlayCloseEvent.TYPE;
};

// /FUNCTIONS
