MaximizedEvent.prototype = new Event();

function MaximizedEvent(isMaximized) {
	this.maximized = isMaximized;
}

// VARIABLES

MaximizedEvent.TYPE = "MaximizedEvent";

// /VARIABLES

// FUNCTIONS

MaximizedEvent.prototype.isMaximized = function() {
	return this.maximized;
};

MaximizedEvent.prototype.getType = function() {
	return MaximizedEvent.TYPE;
};

// /FUNCTIONS
