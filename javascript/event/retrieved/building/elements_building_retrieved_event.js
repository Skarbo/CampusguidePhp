/**
 * ElementsBuildingRetrieved event
 */
ElementsBuildingRetrievedEvent.prototype = new Event();

/**
 * ElementsBuildingRetrieved Event
 * 
 * @param {int}
 *            elementsId
 */
function ElementsBuildingRetrievedEvent(elements) {
	this.elements = elements;
}

// VARIABLES

ElementsBuildingRetrievedEvent.TYPE = "ElementsBuildingRetrievedEvent";

// /VARIABLES

// FUNCTIONS

/**
 * @return {Elemenet} elements
 */
ElementsBuildingRetrievedEvent.prototype.getElements = function() {
	return this.elements;
};

ElementsBuildingRetrievedEvent.prototype.getType = function() {
	return ElementsBuildingRetrievedEvent.TYPE;
};

// /FUNCTIONS
