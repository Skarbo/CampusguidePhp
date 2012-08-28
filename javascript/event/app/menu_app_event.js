MenuAppEvent.prototype = new Event();

function MenuAppEvent(id) {
	Event.call(this, Array.prototype.slice.call(arguments).slice(1));
	this.id = id;
}

// VARIABLES

MenuAppEvent.TYPE = "MenuAppEvent";

// /VARIABLES

// FUNCTIONS

MenuAppEvent.prototype.getId = function() {
	return this.id;
};

MenuAppEvent.prototype.getType = function() {
	return MenuAppEvent.TYPE;
};

// /FUNCTIONS
