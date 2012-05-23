/**
 * MenuFloorplannerBuilding event
 */
MenuFloorplannerBuildingEvent.prototype = new Event();

/**
 * MenuFloorplannerBuilding Event
 * 
 * @param {int}
 *            menu
 */
function MenuFloorplannerBuildingEvent(menu) {
	this.menu = menu;
}

// VARIABLES

MenuFloorplannerBuildingEvent.TYPE = "MenuFloorplannerBuildingEvent";

// /VARIABLES

// FUNCTIONS

/**
 * @return {string} menu
 */
MenuFloorplannerBuildingEvent.prototype.getMenu = function() {
	return this.menu;
};

MenuFloorplannerBuildingEvent.prototype.getType = function() {
	return MenuFloorplannerBuildingEvent.TYPE;
};

// /FUNCTIONS
