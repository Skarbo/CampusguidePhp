PolygonLineEvent.prototype = new Event();

function PolygonLineEvent(lineType) {
	this.lineType = lineType;
}

// VARIABLES

PolygonLineEvent.TYPE = "PolygonLineEvent";

// /VARIABLES

// FUNCTIONS

PolygonLineEvent.prototype.getLineType = function() {
	return this.lineType;
};

PolygonLineEvent.prototype.getType = function() {
	return PolygonLineEvent.TYPE;
};

// /FUNCTIONS
