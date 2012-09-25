OrientationEvent.prototype = new Event();

function OrientationEvent() {
	
}

// VARIABLES

OrientationEvent.TYPE = "OrientationEvent";

// /VARIABLES

// FUNCTIONS

OrientationEvent.prototype.getType = function() {
	return OrientationEvent.TYPE;
};

// /FUNCTIONS
