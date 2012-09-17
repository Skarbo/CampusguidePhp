SaveEvent.prototype = new Event();

function SaveEvent(saveType) {
	this.saveType = saveType;
}

// VARIABLES

SaveEvent.TYPE = "SaveEvent";

// /VARIABLES

// FUNCTIONS

SaveEvent.prototype.getSaveType = function() {
	return this.saveType;
};

SaveEvent.prototype.getType = function() {
	return SaveEvent.TYPE;
};

// /FUNCTIONS
