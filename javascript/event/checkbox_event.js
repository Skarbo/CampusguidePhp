CheckboxEvent.prototype = new Event();

/**
 * @param {Object}
 *            checkbox
 * @param {Object}
 *            checkboxes
 */
function CheckboxEvent(checkbox, checkboxes) {
	this.checkbox = checkbox;
	this.checkboxes = checkboxes;
}

// VARIABLES

CheckboxEvent.TYPE = "CheckboxEvent";

// /VARIABLES

// FUNCTIONS

/**
 * @return {Object}
 */
CheckboxEvent.prototype.getCheckbox = function() {
	return this.checkbox;
};

/**
 * @return {Object}
 */
CheckboxEvent.prototype.getCheckboxes = function() {
	return this.checkboxes;
};

CheckboxEvent.prototype.getType = function() {
	return CheckboxEvent.TYPE;
};

// /FUNCTIONS
