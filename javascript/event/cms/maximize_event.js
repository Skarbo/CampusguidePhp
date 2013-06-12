MaximizeEvent.prototype = new Event();

function MaximizeEvent() {

}

// VARIABLES

MaximizeEvent.TYPE = "MaximizeEvent";

// /VARIABLES

// FUNCTIONS

MaximizeEvent.prototype.getType = function() {
	return MaximizeEvent.TYPE;
};

// /FUNCTIONS
