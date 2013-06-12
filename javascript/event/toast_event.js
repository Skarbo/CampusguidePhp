ToastEvent.prototype = new Event();

function ToastEvent(message, length) {
	this.message = message;
	this.length = length || ToastEvent.LENGTH_SHORT;
}

// VARIABLES

ToastEvent.TYPE = "ToastEvent";
ToastEvent.LENGTH_SHORT = "short";
ToastEvent.LENGTH_LONG = "long";

// /VARIABLES

// FUNCTIONS

ToastEvent.prototype.getMessage = function() {
	return this.message;
};

ToastEvent.prototype.getLength = function() {
	return this.length;
};

ToastEvent.prototype.getType = function() {
	return ToastEvent.TYPE;
};

// /FUNCTIONS
