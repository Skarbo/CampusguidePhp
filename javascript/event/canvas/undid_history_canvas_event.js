UndidHistoryEvent.prototype = new Event();

function UndidHistoryEvent(history) {
	this.history = history;
}

// VARIABLES

UndidHistoryEvent.TYPE = "UndidHistoryEvent";

// /VARIABLES

// FUNCTIONS

UndidHistoryEvent.prototype.getHistory = function() {
	return this.history;
};

UndidHistoryEvent.prototype.getType = function() {
	return UndidHistoryEvent.TYPE;
};

// /FUNCTIONS
