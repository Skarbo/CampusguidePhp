BuildingMapLoadedEvent.prototype = new Event();

function BuildingMapLoadedEvent() {
}

// VARIABLES

BuildingMapLoadedEvent.TYPE = "BuildingMapLoadedEvent";

// /VARIABLES

// FUNCTIONS

BuildingMapLoadedEvent.prototype.getType = function() {
	return BuildingMapLoadedEvent.TYPE;
};

// /FUNCTIONS
