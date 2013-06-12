// CONSTRUCTOR
BuildingAppMainView.prototype = new AppMainView();

function BuildingAppMainView(wrapperId) {
	AppMainView.apply(this, arguments);
	this.building = null;
	this.floors = {};
	this.elements = {};

	this.selected = {
		type : null,
		element : null
	};
	this.selectedCopy = this.selected;
	this.history = [];

	this.buildingCanvas = new BuildingCanvasAppPresenterView(this);
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

	// // Initiate hammer on wrapper
	// wrapperElement.hammer({
	// prevent_default : true,
	// scale_treshold : 0,
	// drag_min_distance : 0
	// });
	//
	// // Bind transform
	// wrapperElement.bind("transformend", function(event) {
	// console.log("Transform end: " + event.scale + ", " + (event.scale > 1 ?
	// "up" : "down"));
	// context.getController().getEventHandler().handle(new
	// ScaleEvent(event.scale > 1, true));
	// });

	// wrapperElement.hammer().on("pinch", function(event) {
	// console.log(event);
	// context.getController().getEventHandler().handle(new
	// ScaleEvent(event.gesture.direction == "up", true));
	// });

	// wrapperElement.hammer({
	// transform_always_block: true,
	// transform_min_scale: 1,
	// drag_block_horizontal: true,
	// drag_block_vertical: true,
	// drag_min_distance: 0
	// }).on("transform", function(event){
	// console.log("Transform", event.scale > 1 ? "Up" : "Down", event);
	// context.getController().getEventHandler().handle(new
	// ScaleEvent(event.scale > 1, true));
	// });

	// /PINCH/DRAG

	// MENU

	// Search
	this.getWrapperElement().find(".actionbar_menu_search").on("touchclick", function(event) {
		event.preventDefault();
		context.getController().getEventHandler().handle(new OverlayEvent({}, "search_overlay"));
		context.getWrapperElement().find("#search_input").select();
		
		var maxHeight = $("#search_overlay").innerHeight() - $("#search_input_wrapper").outerHeight();
		context.getWrapperElement().find("#search_result_wrapper").css("max-height", maxHeight - 20);
	});

	// Location
	this.getWrapperElement().find(".menu_button_location").on("touchclick", function(event) {
		event.preventDefault();
		context.doPositionSet();
	});

	// /MENU

};

BuildingAppMainView.prototype.doPositionSet = function() {
	this.getEventHandler().handle(new ToastEvent("Place position", ToastEvent.LENGTH_LONG));
	this.buildingCanvas.doPositionSet();
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
	// this.getSearchHandler().search(search);

};

// ... /HANDLE

// /FUNCTIONS
