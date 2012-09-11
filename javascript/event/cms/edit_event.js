/**
 * EditEvent event
 */
EditEvent.prototype = new Event();

/**
 * EditEvent Event
 */
function EditEvent(editType, edit) {
	this.editType = editType;
	this.edit = edit;
}

// VARIABLES

EditEvent.TYPE = "EditEvent";

// /VARIABLES

// FUNCTIONS

EditEvent.prototype.getEditType = function() {
	return this.editType;
};

EditEvent.prototype.getEdit = function() {
	return this.edit;
};

EditEvent.prototype.getType = function() {
	return EditEvent.TYPE;
};

// /FUNCTIONS
