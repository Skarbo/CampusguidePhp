/**
 * SelectCanvasEvent event
 */ SelectCanvasEvent.prototype = new Event();

/**
 * SelectCanvasEvent Event
 * 
 * @param {Number}
 *            lineFloor
 */
function SelectCanvasEvent(selectType, element) {
	this.selectType = selectType;
	this.element = element;
}

// VARIABLES
 SelectCanvasEvent.TYPE = "SelectCanvasEvent";

// /VARIABLES

// FUNCTIONS

/**
 * @return {Object} element
 */ SelectCanvasEvent.prototype.getElement = function() {
	return this.element;
};

/**
 * @return {String} type
 */ SelectCanvasEvent.prototype.getSelectType = function() {
	return this.selectType;
};
 SelectCanvasEvent.prototype.getType = function() {
	return SelectCanvasEvent.TYPE;
};

// /FUNCTIONS
