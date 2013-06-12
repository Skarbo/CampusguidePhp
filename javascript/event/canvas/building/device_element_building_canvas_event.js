DeviceElementBuildingCanvasEvent.prototype = new Event();

function DeviceElementBuildingCanvasEvent(device) {
	this.device = device;
}

// VARIABLES

DeviceElementBuildingCanvasEvent.TYPE = "DeviceElementBuildingCanvasEvent";

// /VARIABLES

// FUNCTIONS

DeviceElementBuildingCanvasEvent.prototype.getDevice = function() {
	return this.device;
};

DeviceElementBuildingCanvasEvent.prototype.getType = function() {
	return DeviceElementBuildingCanvasEvent.TYPE;
};

// /FUNCTIONS
