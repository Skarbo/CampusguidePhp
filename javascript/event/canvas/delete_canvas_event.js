DeleteEvent.prototype = new Event();

function DeleteEvent() {
}

DeleteEvent.TYPE = "DeleteEvent";

DeleteEvent.prototype.getType = function() {
	return DeleteEvent.TYPE;
};