// CONSTRUCTOR
FloorplannerBuildingCmsPageMainView.prototype = new PageMainView();

function FloorplannerBuildingCmsPageMainView(view) {
	PageMainView.apply(this, arguments);
	this.stage = null;
	this.buildingLayer = null;
	this.buildingFloorSelectorLayer = null;
	this.scale = 1.0;
};

// /CONSTRUCTOR

// VARIABLES

FloorplannerBuildingCmsPageMainView.SCALE_SIZE = 0.05;

FloorplannerBuildingCmsPageMainView.FLOOR_SELECTOR_COLOR_HIGHLIGHT = "#FFE599";
FloorplannerBuildingCmsPageMainView.FLOOR_SELECTOR_COLOR_DEFAULT = "#CFE2F3";
FloorplannerBuildingCmsPageMainView.FLOOR_SELECTOR_COLOR_SELECTED = "#EA9999";

FloorplannerBuildingCmsPageMainView.ELEMENT_COLOR_DEFAULT = "rgba(255,255,222,1)";
FloorplannerBuildingCmsPageMainView.ELEMENT_COLOR_HIGHLIGHT = "#CCCCFF";

// /VARIABLES

// FUNCTIONS

// ... GETTERS/SETTERS

/**
 * @param {Kinetic.Stage}
 *            stage
 */
FloorplannerBuildingCmsPageMainView.prototype.setStage = function(stage) {
	this.stage = stage;
};

/**
 * @returns {Kinetic.Stage}
 */
FloorplannerBuildingCmsPageMainView.prototype.getStage = function() {
	return this.stage;
};

/**
 * @param {Kinetic.Layer}
 *            group
 */
FloorplannerBuildingCmsPageMainView.prototype.setBuildingLayer = function(buildingLayer) {
	this.buildingLayer = buildingLayer;
};

/**
 * @returns {Kinetic.Layer}
 */
FloorplannerBuildingCmsPageMainView.prototype.getBuildingLayer = function() {
	return this.buildingLayer;
};

/**
 * @param {Kinetic.Layer}
 *            layer
 */
FloorplannerBuildingCmsPageMainView.prototype.setBuildingFloorSelectorLayer = function(
		buildingFloorSelectorLayer) {
	this.buildingFloorSelectorLayer = buildingFloorSelectorLayer;
};

/**
 * @returns {Kinetic.Layer}
 */
FloorplannerBuildingCmsPageMainView.prototype.getBuildingFloorSelectorLayer = function() {
	return this.buildingFloorSelectorLayer;
};

/**
 * @param {float}
 *            scale
 */
FloorplannerBuildingCmsPageMainView.prototype.setScale = function(scale) {
	this.scale = scale;
};

/**
 * @returns {float}
 */
FloorplannerBuildingCmsPageMainView.prototype.getScale = function() {
	return this.scale;
};

// ... /GETTERS/SETTERS

// ... GET

/**
 * @return {BuildingsCmsMainView}
 */
FloorplannerBuildingCmsPageMainView.prototype.getView = function() {
	return PageMainView.prototype.getView.call(this);
};

// ... /GET

// ... DO

FloorplannerBuildingCmsPageMainView.prototype.doBindEventHandler = function() {

	var context = this;

	// EVENTS

	// Building retrieved event
	this.getView().getController().getEventHandler().registerListener(BuildingRetrievedEvent.TYPE,
	/**
	 * @param {BuildingRetrievedEvent}
	 *            event
	 */
	function(event) {
		context.handleBuildingRetrieved(event.getBuilding());
	});

	// Elements Building retrieved event
	this.getView().getController().getEventHandler().registerListener(ElementsBuildingRetrievedEvent.TYPE,
	/**
	 * @param {ElementsBuildingRetrievedEvent}
	 *            event
	 */
	function(event) {
		context.handleBuildingElementsRetrieved(event.getElements());
	});

	// Floors Building retrieved event
	this.getView().getController().getEventHandler().registerListener(FloorsBuildingRetrievedEvent.TYPE,
	/**
	 * @param {FloorsBuildingRetrievedEvent}
	 *            event
	 */
	function(event) {
		context.handleBuildingFloorsRetrieved(event.getFloors());
	});

	// Handle "Scale" event
	this.getView().getController().getEventHandler().registerListener(ScaleEvent.TYPE, function(event) {
		context.handleScaleEvent(event);
	});

	// /EVENTS

	// MOUSE SCROLL

	// Get wrapper dom
	var wrapperDom = document.getElementById("floorplanner_planner_content_canvas_wrapper");

	// Adding the event listerner for Mozilla
	if (window.addEventListener)
		wrapperDom.addEventListener('DOMMouseScroll', function(event) {
			event.preventDefault();
			context.handleWrapperScroll(event);
		}, false);

	// for IE/OPERA etc
	wrapperDom.onmousewheel = function(event) {
		event.preventDefault();
		context.handleWrapperScroll(event);
	};

	// /MOUSE SCROLL

	// TOOLBAR

	$("#scale_inc").click(function(event) {
		event.preventDefault();
		context.getView().getController().getEventHandler().handle(new ScaleEvent(true));
	});
	$("#scale_dec").click(function(event) {
		event.preventDefault();
		context.getView().getController().getEventHandler().handle(new ScaleEvent(false));
	});

	// /TOOLBAR

	// MENU

	// Bind menu buttons
	$("#floorplanner_menu_left_wrapper [data-menu]").click(function(event) {
		context.getView().getController().updateHash({
			"menu" : $(event.target).attr("data-menu")
		});
	});

	// Menu event
	this.getView().getController().getEventHandler().registerListener(MenuFloorplannerBuildingEvent.TYPE,
	/**
	 * @param {MenuFloorplannerBuildingEvent}
	 *            event
	 */
	function(event) {
		context.handleMenu(event.getMenu());
	});

	// /MENU

	// FLOORPLANNER

	// Floor floorplanner event
	this.getView().getController().getEventHandler().registerListener(FloorFloorplannerBuildingEvent.TYPE,
	/**
	 * @param {FloorFloorplannerBuildingEvent}
	 *            event
	 */
	function(event) {
		// Update hash
		context.getView().getController().updateHash({
			"floor" : event.getFloorId()
		});

		// Select Floor
		context.doFloorSelect(event.getFloorId());
	});

	// /FLOORPLANNER

};

/**
 * Scale stage
 * 
 * @param {boolean}
 *            scaleUp True if scale up, false if scale down
 */
FloorplannerBuildingCmsPageMainView.prototype.doScale = function(scaleUp) {
var cursorPosition = this.getStage().getUserPosition();
if (cursorPosition){

}
else
{
	//CanvasUtil.centerLayer(this.getBuildingLayer());
}
	// Scale stage
	// var scaleOld = this.scale;
	this.scale += FloorplannerBuildingCmsPageMainView.SCALE_SIZE * (scaleUp ? 1 : -1);
	this.scale = Math.max(this.scale, 0);
	// var scaleDiff = this.scale - scaleOld;

	// Set stage scale
	this.getBuildingLayer().setScale(this.scale);

	// Center building layer
	CanvasUtil.centerLayer(this.getBuildingLayer());
	
	// Re-draw stage
	this.getBuildingLayer().draw();

};

FloorplannerBuildingCmsPageMainView.prototype.doFloorSelect = function(floorId) {
	var floorsSelect = this.getBuildingFloorSelectorLayer().get(".floors");
	var floors = floorsSelect.length > 0 ? floorsSelect[0].children : [];
	var legendTextSelect = this.getBuildingFloorSelectorLayer().get(".text");
	var legendText = legendTextSelect.length > 0 ? legendTextSelect[0] : {};

	// Foreach floors
	var floorSelectedIndex = null, floorSelectIndex = null;
	for (i in floors) {

		// Move floor up
		if (floorSelectedIndex == null && floorSelectIndex != null) {
			var newY = floors[i].attrs.y - 10;
			floors[i].transitionTo({
				"y" : newY,
				"duration" : 0.1
			});
		}
		// Move floor down
		if (floorSelectedIndex != null && floorSelectIndex == null) {
			var newY = floors[i].attrs.y + 10;
			floors[i].transitionTo({
				"y" : newY,
				"duration" : 0.1
			});
		}
		// Select floor
		if (floors[i].floor.id == floorId) {
			floorSelectIndex = i;
			floors[i].isSelected = true;
			floors[i].setFill(FloorplannerBuildingCmsPageMainView.FLOOR_SELECTOR_COLOR_SELECTED);

			// Set legend text
			legendText.setText(floors[i].floor.name);
		}
		// Selected floor
		if (floors[i].isSelected && floorSelectIndex != i) {
			floorSelectedIndex = i;
			floors[i].isSelected = false;
			floors[i].setFill(FloorplannerBuildingCmsPageMainView.FLOOR_SELECTOR_COLOR_DEFAULT);
		}

	}

	// Draw Floor selector layer
	this.getBuildingFloorSelectorLayer().draw();

};

// ... /DO

// ... HANDLE

FloorplannerBuildingCmsPageMainView.prototype.handleBuildingRetrieved = function(building) {

	// Draw Building
	this.drawBuilding(building);

};

FloorplannerBuildingCmsPageMainView.prototype.handleBuildingElementsRetrieved = function(elements) {

	// Draw Elements
	this.drawElements(elements);

};

FloorplannerBuildingCmsPageMainView.prototype.handleBuildingFloorsRetrieved = function(floors) {

	// Get query floor
	var floorQuery = this.getView().getController().getHash().floor;

	// Foreach floor
	var floorSelected = null, floorOrderLowest = null;
	for (floorId in floors) {
		if (!floorSelected && floors[floorId].main) {
			floorSelected = floorId;
		}
		if (floorQuery && floorQuery == floorId) {
			floorSelected = floorId;
		}
		if (floorOrderLowest == null || floors[floorId].order < floorOrderLowest) {
			floorOrderLowest = floorId;
		}
	}
	floorSelected = floorSelected ? floorSelected : floorOrderLowest;

	// Draw Floors selector
	this.drawFloorSelector(floors);

	// Select Floor
	this.doFloorSelect(floorSelected);

};

FloorplannerBuildingCmsPageMainView.prototype.handleWrapperScroll = function(event) {

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
		this.getView().getController().getEventHandler().handle(new ScaleEvent(delta > 0));
	}

};

/**
 * Handle scale event
 * 
 * @param {ScaleEvent}
 *            Scale event
 */
FloorplannerBuildingCmsPageMainView.prototype.handleScaleEvent = function(event) {

	// Do scale
	this.doScale(event.isScaleUp());

	// Send Scaled event
	this.getView().getController().getEventHandler().handle(new ScaledEvent(this.getScale()));

};

FloorplannerBuildingCmsPageMainView.prototype.handleMenu = function(menu) {

	var submenuButtons = $("#floorplanner_menu_left_wrapper [data-menu]");

	submenuButtons.removeClass("highlight");

	switch (menu) {
	case "elements":
	case "navigation":
		submenuButtons.filter("[data-menu=" + menu + "]").addClass("highlight");
		break;

	default:
		submenuButtons.filter("[data-menu=building]").addClass("highlight");
		break;
	}

};

// ... /HANDLE

/**
 * @param {Element}
 *            root
 */
FloorplannerBuildingCmsPageMainView.prototype.draw = function(root) {
	PageMainView.prototype.draw.call(this, root);
	
	// Handle hash
	var menu = this.getView().getController().getHash().menu;

	this.handleMenu(menu);

	// CANVAS

	// Initiate Kinetic Stage
	var canvasWrapper = $("#floorplanner_planner_content_canvas_wrapper");
	this.setStage(new Kinetic.Stage({
		"container" : canvasWrapper.attr("id"),
		"width" : canvasWrapper.width(),
		"height" : canvasWrapper.height()
	}));

	// Initiate building layer
	this.setBuildingLayer(new Kinetic.Layer({
		name : "building",
		draggable : true
	}));

	// Initiate building floor selector layer
	this.setBuildingFloorSelectorLayer(new Kinetic.Layer({
		name : "buildingFloorSelector"
	}));

	// add cursor styling
	this.getBuildingLayer().on("mouseover", function() {
		document.body.style.cursor = "pointer";
	});
	this.getBuildingLayer().on("mouseout", function() {
		document.body.style.cursor = "default";
	});

	// Add layer to stage
	this.getStage().add(this.getBuildingLayer());
	this.getStage().add(this.getBuildingFloorSelectorLayer());

	// /CANVAS

};

FloorplannerBuildingCmsPageMainView.prototype.drawBuilding = function(building) {

	// Draw building border
	var buildingBorder = new Kinetic.Shape({
		drawFunc : function(context) {
			context.beginPath();

			// context.lineWidth = 2;
			// context.strokeStyle = "#BD8A63";
			// context.fillStyle = "#DEDFDE";
			// context.shadowColor = "#B5B2AD";
			// context.shadowBlur = 8;
			// context.shadowOffsetX = 4;
			// context.shadowOffsetY = 4;

			// Foreach coordinates
			for (i in building.coordinates) {
				if (i == 0) {
					context.moveTo(building.coordinates[i][0], building.coordinates[i][1]);
				} else {
					context.lineTo(building.coordinates[i][0], building.coordinates[i][1]);
				}
			}

			context.closePath();
			this.fill(context);
			this.stroke(context);
		},
		fill : "#DEDFDE",
		stroke : "#BD8A63",
		strokeWidth : 2,
		shadow : {
			color : '#B5B2AD',
			blur : 8,
			offset : [ 4, 4 ]
		}
	});

	// Set building height and width
	var buildingMaxBounds = CanvasUtil.getMaxBounds(building.coordinates);
	var buildingBoundsX = buildingMaxBounds[2] - buildingMaxBounds[0], buildingBoundsY = buildingMaxBounds[3] - buildingMaxBounds[1];
	this.getBuildingLayer().height = buildingBoundsY;
	this.getBuildingLayer().width = buildingBoundsX;
	
	// Add building to building layer
	this.getBuildingLayer().add(buildingBorder);

	// Set z-order
	buildingBorder.setZIndex(1);

	// Fit building to canvas	
	var stageX = this.getStage().getWidth(), stageY = this.getStage().getHeight();
	var buildingScale = parseFloat((Math.floor(parseFloat(Math.min(stageX / buildingBoundsX, stageY / buildingBoundsY).toFixed(2)) * 20) / 20).toFixed(2));
	var buildingBoundsNewX = buildingBoundsX * buildingScale, buildingBoundsNewY = buildingBoundsY * buildingScale;
	var buildingNewX = Math.abs(stageX - buildingBoundsNewX) / 2, buildingNewY = Math.abs(stageY - buildingBoundsNewY) / 2;

	// Draw layer
	//this.getBuildingLayer().setScale(parseFloat(buildingScale));
	this.setScale(buildingScale);
	this.getBuildingLayer().setScale(this.getScale());
//	this.getBuildingLayer().setX(buildingNewX);
//	this.getBuildingLayer().setY(buildingNewY);
	CanvasUtil.centerLayer(this.getBuildingLayer());
	this.getBuildingLayer().draw();
};

FloorplannerBuildingCmsPageMainView.prototype.drawElements = function(elements) {
	var context = this;

	// Initiate elements group
	var elementsGroup = new Kinetic.Group({
		"name" : "elements"
	});
	
	// Initiate elements legend group
	var elementsLegendGroup = new Kinetic.Group({
		"name" : "elementsLegend"
	});

	// Foreach elements
	for (elementid in elements) {

		(function() {

			// Get element coordinates
			var elementIndex = i;
			var elementCoordinates = elements[elementid].coordinates;

			// Draw element
			var elementShape = new Kinetic.Shape({
				drawFunc : function(context) {
					//context.save();
					context.beginPath();
					//context.lineWidth = 1;
					//context.strokeStyle = "#EFD7B5";
					//context.fillStyle = this.color;

					// Foreach coordinations
					for ( var j = 0; j < elementCoordinates.length; j++) {
						if (j == 0) {
							context.moveTo(elementCoordinates[j][0], elementCoordinates[j][1]);
						} else {
							context.lineTo(elementCoordinates[j][0], elementCoordinates[j][1]);
						}
					}

					context.closePath();
					this.fill(context);
					this.stroke(context);
					//context.restore();
				},
				name : "element_" + elementIndex,
				stroke: "#EFD7B5",
				strokeWidth : 1,
				fill : FloorplannerBuildingCmsPageMainView.ELEMENT_COLOR_DEFAULT
			});

			// Mouse over element
			elementShape.on("mouseover", function() {
				this.setFill(FloorplannerBuildingCmsPageMainView.ELEMENT_COLOR_HIGHLIGHT);
				context.getBuildingLayer().draw();
			});

			// Mouse out element
			elementShape.on("mouseout", function() {
				this.setFill(FloorplannerBuildingCmsPageMainView.ELEMENT_COLOR_DEFAULT);
				context.getBuildingLayer().draw();
			});

			// Element bounds
			var elementBounds = CanvasUtil.getOuterBounds(elementCoordinates);

			// Find angle of first vector
			var angle = Math.atan2(elementCoordinates[1][1]
					- elementCoordinates[0][1],
					elementCoordinates[1][0]
							- elementCoordinates[0][0]);
			
			// Get element center
			var elementCenter = CanvasUtil.centerCoordinates(elementCoordinates);			

			// Create text legend
			var elementLegendText = new Kinetic.Text({
				"text" : elements[elementid].name,
				x : elementCenter[0],
				y : elementCenter[1],
				textFill: '#000',
				fontSize: 8,
				listening : false,
				rotation : angle
			});
			
			// Center text
			elementLegendText.setX(elementLegendText.getX() - (elementLegendText.getTextWidth() / 2));

			// Add element to group
			elementsGroup.add(elementShape);
			
			// Add element legend to group
			elementsLegendGroup.add(elementLegendText);
			
		})();

	}

	// Add groups to building layer
	this.getBuildingLayer().add(elementsGroup);
	this.getBuildingLayer().add(elementsLegendGroup);

	// Set z-order
	elementsGroup.setZIndex(100);
	elementsLegendGroup.setZIndex(150);

	// Draw layer
	this.getBuildingLayer().draw();

};

FloorplannerBuildingCmsPageMainView.prototype.drawFloorSelector = function(floors) {

	var context = this;

	// Clear layer
	this.getBuildingFloorSelectorLayer().clear();

	var stageWidth = this.getStage().getWidth();
	var stageHeight = this.getStage().getHeight();
	var maxHeight = (Core.countObject(floors) * 10) + 10;

	var group = new Kinetic.Group({
		name : "FloorSelector",
		x : stageWidth - 53 - 10,
		y : stageHeight - maxHeight - 30 - 15
	});

	// FLOORS

	var groupFloors = new Kinetic.Group({
		name : "floors",
		x : 0,
		y : 0
	});

	var yTemp = maxHeight;
	var zIndex = 0;
	for (floorId in floors) {
		(function() {
			var i = floorId;
			var yTemp2 = yTemp;

			var points = [ {
				x : 0,
				y : 0
			}, {
				x : 34,
				y : 0
			}, {
				x : 53,
				y : 30
			}, {
				x : 19,
				y : 30
			} ];

			var poly = new Kinetic.Polygon({
				points : points,
				fill : FloorplannerBuildingCmsPageMainView.FLOOR_SELECTOR_COLOR_DEFAULT,
				stroke : "#666666",
				strokeWidth : 2,
				x : 0,
				y : yTemp2,
				name : "floor"
			});

			poly.isSelected = false;
			poly.floor = floors[floorId];

			// Mouse over floor
			poly.on("mouseover", function() {
				if (!this.isSelected) {
					this.setFill(FloorplannerBuildingCmsPageMainView.FLOOR_SELECTOR_COLOR_HIGHLIGHT);
					context.getBuildingFloorSelectorLayer().draw();
					document.body.style.cursor = "pointer";
				}
			});

			// Mouse out floor
			poly.on("mouseout", function() {
				if (!this.isSelected) {
					this.setFill(FloorplannerBuildingCmsPageMainView.FLOOR_SELECTOR_COLOR_DEFAULT);
					context.getBuildingFloorSelectorLayer().draw();
					document.body.style.cursor = "default";
				}
			});

			// Mouse up floor
			poly.on("mouseup", function() {
				if (!this.isSelected) {
					context.getView().getController().getEventHandler().handle(new FloorFloorplannerBuildingEvent(i));
				}
			});

			groupFloors.add(poly);

			// Set floor z-index
			poly.setZIndex(zIndex++);

			yTemp -= 10;

		})();
	}

	group.add(groupFloors);

	// /FLOORS

	// LEGEND

	var groupLegend = new Kinetic.Group({
		name : "legend",
		x : 53 - 15,
		y : maxHeight + 30 - 10
	});

	var legendBox = new Kinetic.Shape({
		drawFunc : function(context) {
			CanvasUtil.roundRect(context, 0, 0, 20, 20);
			this.fill(context);
			this.stroke(context);
		},
		fill : "white",
		stroke : "#B7B7B7",
		strokeWidth : 2,
		name : "box"
	});

	var legendText = new Kinetic.Text({
		x : 0,
		y : 0,
		text : " ",
		fontSize : 10,
		fontFamily : "Verdana",
		textFill : "#434343",
		align : "center",
		verticalAlign : "bottom",
		fontStyle : "bold",
		name : "text",
		height : 20,
		width : 20
	});

	var legend = new Kinetic.Text({
		x : 0,
		y : 0,
		text : " ",
		fontSize : 10,
		fontFamily : "Verdana",
		textFill : "#434343",
		align : "center",
		verticalAlign : "bottom",
		fontStyle : "bold",
		name : "text",
		// height : 20,
		// width : 20,
		padding : 5,
		cornerRadius : 2,
		fill : "#FFF",
		stroke : "#B7B7B7",
		strokeWidth : 2,
		name : "text",
		lineHeight : "1"
	});

	// groupLegend.add(legendBox);
	// groupLegend.add(legendText);
	groupLegend.add(legend);
	group.add(groupLegend);

	// /LEGEND

	this.getBuildingFloorSelectorLayer().add(group);

	group.setZIndex(1000);

	this.getBuildingFloorSelectorLayer().draw();
};

// /FUNCTIONS
