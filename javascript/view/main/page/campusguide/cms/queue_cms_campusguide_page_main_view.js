// CONSTRUCTOR
QueueCmsCampusguidePageMainView.prototype = new PageMainView();

function QueueCmsCampusguidePageMainView(view, queue) {
	PageMainView.apply(this, arguments);
	this.queue = queue;
	this.stage = null;
	this.buildingLayer = null;
};

// /CONSTRUCTOR

// VARIABLES

// /VARIABLES

// FUNCTIONS

// ... GETTERS/SETTERS

/**
 * @param {Kinetic.Stage}
 *            stage
 */
QueueCmsCampusguidePageMainView.prototype.setStage = function(stage) {
	this.stage = stage;
};

/**
 * @returns {Kinetic.Stage}
 */
QueueCmsCampusguidePageMainView.prototype.getStage = function() {
	return this.stage;
};

/**
 * @param {Kinetic.Layer}
 *            group
 */
QueueCmsCampusguidePageMainView.prototype.setBuildingLayer = function(buildingLayer) {
	this.buildingLayer = buildingLayer;
};

/**
 * @returns {Kinetic.Layer}
 */
QueueCmsCampusguidePageMainView.prototype.getBuildingLayer = function() {
	return this.buildingLayer;
};

// ... /GETTERS/SETTERS

// ... GET

/**
 * @return {CmsCampusguideMainView}
 */
QueueCmsCampusguidePageMainView.prototype.getView = function() {
	return PageMainView.prototype.getView.call(this);
};

/**
 * @return {Object}
 */
QueueCmsCampusguidePageMainView.prototype.getQueue = function() {
	return this.queue;
};

// ... /GET

// ... DO

QueueCmsCampusguidePageMainView.prototype.doBindEventHandler = function() {

	var context = this;

	// Building retrieved event
	this.getView().getController().getEventHandler().registerListener(BuildingRetrievedEvent.TYPE,
	/**
	 * @param {BuildingRetrievedEvent}
	 *            event
	 */
	function(event) {
		if (context.getQueue().buildingId == event.getBuilding().id) {
			context.handleBuildingRetrieved(event.getBuilding());
		}
	});

};

// ... /DO

// ... HANDLE

QueueCmsCampusguidePageMainView.prototype.handleBuildingRetrieved = function(building) {

	// Draw Building
	this.drawBuilding(building);

};

// ... /HANDLE

/**
 * @param {Element}
 *            root
 */
QueueCmsCampusguidePageMainView.prototype.draw = function(root) {
	PageMainView.prototype.draw.call(this, root);

	// Bind
	this.doBindEventHandler();

	// CANVAS

	// Initiate Kinetic Stage
	var canvasWrapper = $("#queue");

	if (this.getQueue().arguments && this.getQueue().arguments.size) {
		var buildingWidth = this.getQueue().arguments.size[0];
		var buildingHeight = this.getQueue().arguments.size[1];
		canvasWrapper.width(buildingWidth);
		canvasWrapper.height(buildingHeight);
	}

	this.setStage(new Kinetic.Stage({
		"container" : canvasWrapper.attr("id"),
		"width" : canvasWrapper.width(),
		"height" : canvasWrapper.height()
	}));

	// Initiate building layer
	this.setBuildingLayer(new Kinetic.Layer({
		name : "building"
	}));

	// Add layer to stage
	this.getStage().add(this.getBuildingLayer());

	// /CANVAS

};

QueueCmsCampusguidePageMainView.prototype.drawBuilding = function(building) {
	var context = this;
	
	var maxBounds = CanvasUtil.getMaxBounds(building.coordinates);

	var buildingWidth = maxBounds[2] - maxBounds[0];
	var buildingHeight = maxBounds[3] - maxBounds[1];

	var width = this.getStage().getWidth();
	var height = this.getStage().getHeight();

	var widthScale = width / buildingWidth;
	var heightScale = height / buildingHeight;
	var scale = Math.floor((heightScale < widthScale ? heightScale : widthScale) * 1000) / 1000;

	var buildingWidthScaled = buildingWidth * scale;
	var buildingHeightScaled = buildingHeight * scale;
	var buildingWidthTransform = Math.round((width - buildingWidthScaled) / 2);
	var buildingHeightTransform = Math.round((height - buildingHeightScaled) / 2);

	// Draw building border
	var buildingBorder = new Kinetic.Shape({
		drawFunc : function() {
			var context = this.getContext();
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

	// Set building scale
	this.getBuildingLayer().setScale(scale);

	// Set building coordinate
	this.getBuildingLayer().setX(buildingWidthTransform);
	this.getBuildingLayer().setY(buildingHeightTransform);

	// Draw layer
	this.getBuildingLayer().draw();

	// Get image data
	this.getStage().toDataURL(
			{
				callback : function(dataUrl) {
					// Send Building command event
					context.getView().getController().getEventHandler().handle(
							new BuildingCommandEvent(building.id, context.getQueue().id, dataUrl));
				}
			});

};

// /FUNCTIONS
