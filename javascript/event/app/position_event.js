PositionEvent.prototype = new Event();

function PositionEvent(lanLon) {
	this.lanLon = lanLon;
}

// VARIABLES

PositionEvent.TYPE = "PositionEvent";

// /VARIABLES

// FUNCTIONS

PositionEvent.prototype.getLanLon = function() {
	return this.lanLon;
};

PositionEvent.prototype.getType = function() {
	return PositionEvent.TYPE;
};

// /FUNCTIONS
