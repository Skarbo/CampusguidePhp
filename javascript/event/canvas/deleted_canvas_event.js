DeletedEvent.prototype = new Event();

function DeletedEvent(deleteType, deleted) {
	this.deleteType = deleteType;
	this.deleted = deleted;
}

DeletedEvent.TYPE = "DeletedEvent";

DeletedEvent.prototype.getDeleteType = function() {
	return this.deleteType;
};

DeletedEvent.prototype.getDeleted = function() {
	return this.deleted;
};

DeletedEvent.prototype.getType = function() {
	return DeletedEvent.TYPE;
};