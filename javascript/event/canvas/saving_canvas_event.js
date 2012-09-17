SavingEvent.prototype = new Event();

function SavingEvent() {
}

// VARIABLES

SavingEvent.TYPE = "SavingEvent";

// /VARIABLES

// FUNCTIONS

SavingEvent.prototype.getType = function() {
	return SavingEvent.TYPE;
};

// /FUNCTIONS
