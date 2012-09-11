/**
 * DeleteEvent event
 */
DeleteEvent.prototype = new Event();

/**
 * DeleteEvent Event
 */
function DeleteEvent() {
}

// VARIABLES

DeleteEvent.TYPE = "DeleteEvent";

// /VARIABLES

// FUNCTIONS

DeleteEvent.prototype.getType = function() {
	return DeleteEvent.TYPE;
};

// /FUNCTIONS
