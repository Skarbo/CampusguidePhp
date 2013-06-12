 FitEvent.prototype = new Event();


function FitEvent(fitType, element) {
	this.fitType = fitType;
	this.element = element;
}

// VARIABLES
 FitEvent.TYPE = "FitEvent";

// /VARIABLES

// FUNCTIONS

/**
 * @return {Object} element
 */ FitEvent.prototype.getElement = function() {
	return this.element;
};

/**
 * @return {String} type
 */ FitEvent.prototype.getFitType = function() {
	return this.fitType;
};
 FitEvent.prototype.getType = function() {
	return FitEvent.TYPE;
};

// /FUNCTIONS
