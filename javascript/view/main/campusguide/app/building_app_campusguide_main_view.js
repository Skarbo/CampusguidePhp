// CONSTRUCTOR
BuildingAppCampusguideMainView.prototype = new AppCampusguideMainView();

function BuildingAppCampusguideMainView(wrapperId) {
	AppCampusguideMainView.apply(this, arguments);
	this.stage = null;
	this.buildingLayer = null;
	this.scale = 1.0;
}

// /CONSTRUCTOR

// VARIABLES

// /VARIABLES

// FUNCTIONS

// ... GETTERS/SETTERS

/**
 * @param {Kinetic.Stage}
 *            stage
 */
BuildingAppCampusguideMainView.prototype.setStage = function(stage) {
	this.stage = stage;
};

/**
 * @returns {Kinetic.Stage}
 */
BuildingAppCampusguideMainView.prototype.getStage = function() {
	return this.stage;
};

/**
 * @param {Kinetic.Layer}
 *            group
 */
BuildingAppCampusguideMainView.prototype.setBuildingLayer = function(buildingLayer) {
	this.buildingLayer = buildingLayer;
};

/**
 * @returns {Kinetic.Layer}
 */
BuildingAppCampusguideMainView.prototype.getBuildingLayer = function() {
	return this.buildingLayer;
};

// ... /GETTERS/SETTERS

// ... GET

/**
 * @return {BuildingAppCampusguideMainController}
 */
BuildingAppCampusguideMainView.prototype.getController = function() {
	return AppCampusguideMainView.prototype.getController.call(this);
};

// ... /GET

// ... DO

BuildingAppCampusguideMainView.prototype.doBindEventHandler = function() {
	AppCampusguideMainView.prototype.doBindEventHandler.call(this);
	var context = this;

	// EVENTS

	// Building retrieved event
	this.getController().getEventHandler().registerListener(BuildingRetrievedEvent.TYPE,
	/**
	 * @param {BuildingRetrievedEvent}
	 *            event
	 */
	function(event) {
		context.handleBuildingRetrieved(event.getBuilding());
	});

	// Handle "Scale" event
	this.getController().getEventHandler().registerListener(ScaleEvent.TYPE, function(event) {
		context.handleScaleEvent(event);
	});

	// /EVENTS

	// MOUSE SCROLL

	// Get wrapper dom
	var wrapperDom = document.getElementById("building_canvas_wrapper");

	// Adding the event listerner for Mozilla
	if (window.addEventListener)
		wrapperDom.addEventListener('DOMMouseScroll', function(event) {
			context.handleWrapperScroll(event);
		}, false);

	// for IE/OPERA etc
	wrapperDom.onmousewheel = function(event) {
		context.handleWrapperScroll(event);
	};

	// /MOUSE SCROLL

	// PINCH/DRAG

	// Get wrapper element
	var wrapperElement = this.getWrapperElement().find("#building_canvas_wrapper");

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
	
	// Bind drag
//	wrapperElement.bind("dragend", function(event) {
//		console.log("Drag end: " + event.direction + ", " + event.touches.length);
//	});

	// /PINCH/DRAG

};

/**
 * Scale stage
 * 
 * @param {boolean}
 *            scaleUp True if scale up, false if scale down
 */
BuildingAppCampusguideMainView.prototype.doScale = function(scaleUp) {
	
	var pt = this.getStage().getUserPosition();
	
	// Scale stage
	// var scaleOld = this.scale;
	this.scale += CanvasMainView.SCALE_SIZE * (scaleUp ? 1 : -1);
	this.scale = Math.max(this.scale, 0);
	// var scaleDiff = this.scale - scaleOld;
	
	// Set stage scale
	this.getStage().setScale(this.scale);
	
	// Re-draw stage
	this.getBuildingLayer().draw();
	
};

// ... /DO

// ... HANDLE

BuildingAppCampusguideMainView.prototype.handleBuildingRetrieved = function(building) {

	this.drawBuilding(building);

};

BuildingAppCampusguideMainView.prototype.handleWrapperScroll = function(event) {

	var delta = 0;

	if (!event)
		event = window.event;

	// normalize the delta
	if (event.wheelDelta) {
		// IE and Opera
		delta = event.wheelDelta / 60;

	} else if (event.detail) {
		// W3C
		delta = -event.detail / 2;
	}

	// Send Scale event
	if (delta != 0) {
		this.getController().getEventHandler().handle(new ScaleEvent(delta > 0));
	}

};

/**
 * Handle scale event
 * 
 * @param {ScaleEvent}
 *            Scale event
 */
BuildingAppCampusguideMainView.prototype.handleScaleEvent = function(event) {

	// Do scale
	this.doScale(event.isScaleUp());

};

// ... /HANDLE

// ... DRAW

BuildingAppCampusguideMainView.prototype.draw = function(controller) {
	AppCampusguideMainView.prototype.draw.call(this, controller);

	// CANVAS

	// Initiate Kinetic Stage
	var canvasWrapper = this.getWrapperElement().find("#building_canvas");
	this.setStage(new Kinetic.Stage({
		"container" : canvasWrapper.attr("id"),
		"width" : canvasWrapper.width(),
		"height" : canvasWrapper.height(),
		draggable : true,
		x : 50,
		y : 50
	}));

	// Initiate building layer
	this.setBuildingLayer(new Kinetic.Layer({
		name : "building",
		clearBeforeDraw : true,
		draggable : true
	}));
	
	// Add layer to stage
	this.getStage().add(this.getBuildingLayer());

	//this.getStage().setDraggable(true);

	// /CANVAS

};

BuildingAppCampusguideMainView.prototype.drawBuilding = function(building) {
	
	// Draw building border
	var buildingBorder = new Kinetic.Shape({
		drawFunc : function(context) {
			context.beginPath();
			context.lineWidth = 2;
			context.strokeStyle = "#BD8A63";
			context.shadowColor = "#B5B2AD";
			context.fillStyle = "#DEDFDE";
			context.shadowBlur = 8;
			context.shadowOffsetX = 4;
			context.shadowOffsetY = 4;

			// Foreach coordinates
			for (i in building.coordinates) {
				if (i == 0) {
					context.moveTo(building.coordinates[i][0], building.coordinates[i][1]);
				} else {
					context.lineTo(building.coordinates[i][0], building.coordinates[i][1]);
				}
			}

			context.closePath();
			context.stroke();
			context.fill();
		}
	});

	// Add building to building layer
	this.getBuildingLayer().add(buildingBorder);

	// Set z-order
	//buildingBorder.setZIndex(1);

	// Draw layer
	this.getBuildingLayer().draw();

};

// ... /DRAW

// /FUNCTIONS
