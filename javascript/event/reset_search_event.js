ResetSearchEvent.prototype = new Event();

function ResetSearchEvent() {	
	Event.apply(this, arguments);
}

// VARIABLES

ResetSearchEvent.TYPE = "ResetSearchEvent";

// /VARIABLES

// FUNCTIONS


ResetSearchEvent.prototype.getType = function() {
	return ResetSearchEvent.TYPE;
};

// /FUNCTIONS
