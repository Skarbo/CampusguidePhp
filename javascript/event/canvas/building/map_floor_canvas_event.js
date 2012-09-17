MapFloorEvent.prototype = new Event();

function MapFloorEvent() {
}

MapFloorEvent.TYPE = "MapFloorEvent";

MapFloorEvent.prototype.getType = function() {
	return MapFloorEvent.TYPE;
};