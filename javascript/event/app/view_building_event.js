ViewBuildingEvent.prototype = new Event();

function ViewBuildingEvent(buildingId) {
	this.buildingId = buildingId;
}

// VARIABLES

ViewBuildingEvent.TYPE = "ViewBuildingEvent";

// /VARIABLES

// FUNCTIONS

ViewBuildingEvent.prototype.getBuildingId = function() {
	return this.buildingId;
};

ViewBuildingEvent.prototype.getType = function() {
	return ViewBuildingEvent.TYPE;
};

// /FUNCTIONS
