// CONSTRUCTOR
BuildingAppMainView.prototype = new AppMainView();

function BuildingAppMainView(wrapperId) {
	AppMainView.apply(this, arguments);
	this.building = null;
	this.floors = {};
	this.elements = {};

	this.buildingCanvas = new BuildingAppCanvasPresenterView(this);
}

// /CONSTRUCTOR

// VARIABLES

// /VARIABLES

// FUNCTIONS

// ... GET

/**
 * @return {BuildingAppMainController}
 */
BuildingAppMainView.prototype.getController = function() {
	return AppMainView.prototype.getController.call(this);
};

/**
 * @return {Object}
 */
BuildingAppMainView.prototype.getBuildingCanvasWrapperElement = function() {
	return this.getWrapperElement().find("#building_canvas_wrapper");
};

// ... /GET

// ... DO

BuildingAppMainView.prototype.doBindEventHandler = function() {
	AppMainView.prototype.doBindEventHandler.call(this);
	var context = this;

	// EVENTS

	// Retrieved event
	this.getController().getEventHandler().registerListener(RetrievedEvent.TYPE,
	/**
	 * @param {RetrievedEvent}
	 *            event
	 */
	function(event) {
		switch (event.getRetrievedType()) {
		case "building":
			context.building = event.getRetrieved();
			break;

		case "building_floors":
			context.floors = event.getRetrieved();
			break;

		case "building_elements":
			context.elements = event.getRetrieved();
			break;
		}
	});

	// Register "Search" listener
	this.getEventHandler().registerListener(SearchEvent.TYPE,
	/**
	 * @param {SearchEvent}
	 *            event
	 */
	function(event) {
		context.handleSearch(event.getSearch(), event.getOptions());
	});

	// /EVENTS

	// PINCH/DRAG

	// Get wrapper element
	var wrapperElement = this.getBuildingCanvasWrapperElement();

	// Initiate hammer on wrapper
	wrapperElement.hammer({
		prevent_default : true,
		scale_treshold : 0,
		drag_min_distance : 0
	});

	// Bind transform
	wrapperElement.bind("transformend", function(event) {
		console.log("Transform end: " + event.scale + ", " + (event.scale > 1 ? "up" : "down"));
		context.getController().getEventHandler().handle(new ScaleEvent(event.scale > 1));
	});

	// /PINCH/DRAG

	// MENU

	// Search
	this.getWrapperElement().find(".actionbar_menu_search").click(function(event) {
		event.preventDefault();
		context.getController().getEventHandler().handle(new OverlayEvent({}, "search_overlay"));
		context.getWrapperElement().find("#search_input").select();
	});

	// /MENU

};

// ... /DO

// ... DRAW

BuildingAppMainView.prototype.draw = function(controller) {
	AppMainView.prototype.draw.call(this, controller);

	// Draw Building canvas
	this.buildingCanvas.draw(this.getBuildingCanvasWrapperElement());
};

// ... /DRAW

// ... HANDLE

BuildingAppMainView.prototype.handleSearch = function(search) {

	// Search
	//this.getSearchHandler().search(search);

};

// ... /HANDLE

// /FUNCTIONS
