SavingEvent.prototype = new Event();

function SavingEvent(editType, edit) {
	this.editType = editType;
}

// VARIABLES

SavingEvent.TYPE = "SavingEvent";

// /VARIABLES

// FUNCTIONS

SavingEvent.prototype.getEditType = function() {
	return this.editType;
};

SavingEvent.prototype.getType = function() {
	return SavingEvent.TYPE;
};

// /FUNCTIONS
