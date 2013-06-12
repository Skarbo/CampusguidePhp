/**
 * SelectedEvent event
 */
SelectedEvent.prototype = new Event();

/**
 * SelectedEvent Event
 * 
 * @param {Number}
 *            lineFloor
 */
function SelectedEvent(selectedType, element) {
	this.selectedType = selectedType;
	this.element = element;
}

// VARIABLES

SelectedEvent.TYPE = "SelectedEvent";

// /VARIABLES

// FUNCTIONS

/**
 * @return {Object} element
 */
SelectedEvent.prototype.getElement = function() {
	return this.element;
};

/**
 * @return {String} type
 */
SelectedEvent.prototype.getSelectedType = function() {
	return this.selectedType;
};

SelectedEvent.prototype.getType = function() {
	return SelectedEvent.TYPE;
};

// /FUNCTIONS
