/**
 * SelectEvent event
 */
SelectEvent.prototype = new Event();

/**
 * SelectEvent Event
 * 
 * @param {Number}
 *            lineFloor
 */
function SelectEvent(selectType, element) {
	this.selectType = selectType;
	this.element = element;
}

// VARIABLES

SelectEvent.TYPE = "SelectEvent";

// /VARIABLES

// FUNCTIONS

/**
 * @return {Object} element
 */
SelectEvent.prototype.getElement = function() {
	return this.element;
};

/**
 * @return {String} type
 */
SelectEvent.prototype.getSelectType = function() {
	return this.selectType;
};

SelectEvent.prototype.getType = function() {
	return SelectEvent.TYPE;
};

// /FUNCTIONS
