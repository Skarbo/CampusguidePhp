/**
 * Menu event
 */
MenuEvent.prototype = new Event();

/**
 * Menu Event
 * 
 * @param {int}
 *            menu
 */
function MenuEvent(menu, sidebar) {
	this.menu = menu;
	this.sidebar = sidebar;
}

// VARIABLES

MenuEvent.TYPE = "MenuEvent";

// /VARIABLES

// FUNCTIONS

/**
 * @return {string} menu
 */
MenuEvent.prototype.getMenu = function() {
	return this.menu;
};

/**
 * @return {string} sidebar
 */
MenuEvent.prototype.getSidebar = function() {
	return this.sidebar;
};

MenuEvent.prototype.getType = function() {
	return MenuEvent.TYPE;
};

// /FUNCTIONS
