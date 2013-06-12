SelectEvent.prototype = new Event();

function SelectEvent(selectType, object) {
	this.selectType = selectType;
	this.object = object;
}

// VARIABLES

SelectEvent.TYPE = "SelectEvent";

// /VARIABLES

// FUNCTIONS

/**
 * @return {Object} object
 */
SelectEvent.prototype.getObject = function() {
	return this.object;
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
