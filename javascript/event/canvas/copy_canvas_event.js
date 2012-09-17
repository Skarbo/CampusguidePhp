CopyEvent.prototype = new Event();

function CopyEvent() {
}

// VARIABLES

CopyEvent.TYPE = "CopyEvent";

// /VARIABLES

// FUNCTIONS

CopyEvent.prototype.getType = function() {
	return CopyEvent.TYPE;
};

// /FUNCTIONS
