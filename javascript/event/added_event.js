AddedEvent.prototype = new Event();

/**
 * @param {Object}
 *            buildingId
 */
function AddedEvent(id, object, foreignId) {
	this.id = id;
	this.object = object;
	this.foreignId = foreignId;
}

// VARIABLES

AddedEvent.TYPE = "AddedEvent";

// /VARIABLES

// FUNCTIONS

/**
 * @return {int}
 */
AddedEvent.prototype.getId = function() {
	return this.id;
};

/**
 * @return {int}
 */
AddedEvent.prototype.getForeignId = function() {
	return this.foreignId;
};

/**
 * @return {Object}
 */
AddedEvent.prototype.getObject = function() {
	return this.object;
};

AddedEvent.prototype.getType = function() {
	return AddedEvent.TYPE;
};

// /FUNCTIONS
