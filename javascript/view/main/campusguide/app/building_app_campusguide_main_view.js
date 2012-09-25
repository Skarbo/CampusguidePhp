// CONSTRUCTOR
BuildingAppCampusguideMainView.prototype = new AppCampusguideMainView();

function BuildingAppCampusguideMainView(wrapperId) {
	AppCampusguideMainView.apply(this, arguments);
	this.building = null;
	this.floors = {};
	this.elements = {};

	this.buildingCanvas = new BuildingAppCanvasCampusguidePresenterView(this);
}

// /CONSTRUCTOR

// VARIABLES

// /VARIABLES

// FUNCTIONS

// ... GET

/**
 * @return {BuildingAppCampusguideMainController}
 */
BuildingAppCampusguideMainView.prototype.getController = function() {
	return AppCampusguideMainView.prototype.getController.call(this);
};

/**
 * @return {Object}
 */
BuildingAppCampusguideMainView.prototype.getBuildingCanvasWrapperElement = function() {
	return this.getWrapperElement().find("#building_canvas_wrapper");
};

// ... /GET

// ... DO

BuildingAppCampusguideMainView.prototype.doBindEventHandler = function() {
	AppCampusguideMainView.prototype.doBindEventHandler.call(this);
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

};

// ... /DO

// ... DRAW

BuildingAppCampusguideMainView.prototype.draw = function(controller) {
	AppCampusguideMainView.prototype.draw.call(this, controller);

	// Draw Building canvas
	this.buildingCanvas.draw(this.getBuildingCanvasWrapperElement());
};

// ... /DRAW

// /FUNCTIONS
