FitToScaleEvent.prototype = new Event();

function FitToScaleEvent() {
}

// VARIABLES

FitToScaleEvent.TYPE = "FitToScaleEvent";

// /VARIABLES

// FUNCTIONS

FitToScaleEvent.prototype.getType = function() {
	return FitToScaleEvent.TYPE;
};

// /FUNCTIONS
