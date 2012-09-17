PolygonEvent.prototype = new Event();

function PolygonEvent() {
}

// VARIABLES

PolygonEvent.TYPE = "PolygonEvent";

// /VARIABLES

// FUNCTIONS

PolygonEvent.prototype.getType = function() {
	return PolygonEvent.TYPE;
};

// /FUNCTIONS
