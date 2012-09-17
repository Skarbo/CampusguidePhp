UndoHistoryEvent.prototype = new Event();

function UndoHistoryEvent() {
}

// VARIABLES

UndoHistoryEvent.TYPE = "UndoHistoryEvent";

// /VARIABLES

// FUNCTIONS

UndoHistoryEvent.prototype.getType = function() {
	return UndoHistoryEvent.TYPE;
};

// /FUNCTIONS
