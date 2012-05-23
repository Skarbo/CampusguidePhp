AddEvent.prototype = new Event();

/**
 * @param {Object}
 *            buildingId
 */
function AddEvent(object, foreignId) {
	this.object = object;
	this.foreignId = foreignId;
}

// VARIABLES

AddEvent.TYPE = "AddEvent";

// /VARIABLES

// FUNCTIONS

/**
 * @return {int}
 */
AddEvent.prototype.getForeignId = function() {
	return this.foreignId;
};

/**
 * @return {Object}
 */
AddEvent.prototype.getObject = function() {
	return this.object;
};

AddEvent.prototype.getType = function() {
	return AddEvent.TYPE;
};

// /FUNCTIONS
