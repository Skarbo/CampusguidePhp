/**
 * EditedEvent event
 */
EditedEvent.prototype = new Event();

/**
 * EditedEvent Event
 */
function EditedEvent(editType, edit) {
	this.editType = editType;
	this.edit = edit;
}

// VARIABLES

EditedEvent.TYPE = "EditedEvent";

// /VARIABLES

// FUNCTIONS

EditedEvent.prototype.getEditType = function() {
	return this.editType;
};

EditedEvent.prototype.getEdit = function() {
	return this.edit;
};

EditedEvent.prototype.getType = function() {
	return EditedEvent.TYPE;
};

// /FUNCTIONS
