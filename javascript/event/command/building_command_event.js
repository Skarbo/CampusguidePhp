BuildingCommandEvent.prototype = new Event();

function BuildingCommandEvent(buildingId, queueId, imageData) {
	this.buildingId = buildingId;
	this.queueId = queueId;
	this.imageData = imageData;
}

// VARIABLES

BuildingCommandEvent.TYPE = "BuildingCommandEvent";

// /VARIABLES

// FUNCTIONS

/**
 * @return {int} buildingId
 */
BuildingCommandEvent.prototype.getBuildingId = function() {
	return this.buildingId;
};

/**
 * @return {int} queueId
 */
BuildingCommandEvent.prototype.getQueueId = function() {
	return this.queueId;
};

/**
 * @return {string} imageData
 */
BuildingCommandEvent.prototype.getImageData = function() {
	return this.imageData;
};

BuildingCommandEvent.prototype.getType = function() {
	return BuildingCommandEvent.TYPE;
};

// /FUNCTIONS
