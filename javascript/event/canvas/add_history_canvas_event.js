AddHistoryEvent.prototype = new Event();

function AddHistoryEvent(history) {
	this.history = history;
}

// VARIABLES

AddHistoryEvent.TYPE = "AddHistoryEvent";

// /VARIABLES

// FUNCTIONS

AddHistoryEvent.prototype.getHistory = function() {
	return this.history;
};

AddHistoryEvent.prototype.getType = function() {
	return AddHistoryEvent.TYPE;
};

// /FUNCTIONS
