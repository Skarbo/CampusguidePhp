// CONSTRUCTOR
FloorplannerBuildingCmsCampusguidePageMainView.prototype = new PageMainView();

function FloorplannerBuildingCmsCampusguidePageMainView(view) {
	PageMainView.apply(this, arguments);
	this.stage = null;
	this.buildingLayer = null;
	this.buildingFloorSelectorLayer = null;
	this.scale = 1.0;
};

// /CONSTRUCTOR

// VARIABLES

FloorplannerBuildingCmsCampusguidePageMainView.FLOOR_SELECTOR_COLOR_HIGHLIGHT = "#FFE599";
FloorplannerBuildingCmsCampusguidePageMainView.FLOOR_SELECTOR_COLOR_DEFAULT = "#CFE2F3";
FloorplannerBuildingCmsCampusguidePageMainView.FLOOR_SELECTOR_COLOR_SELECTED = "#EA9999";

// /VARIABLES

// FUNCTIONS

// ... GETTERS/SETTERS

/**
 * @param {Kinetic.Stage}
 *            stage
 */
FloorplannerBuildingCmsCampusguidePageMainView.prototype.setStage = function(stage) {
	this.stage = stage;
};

/**
 * @returns {Kinetic.Stage}
 */
FloorplannerBuildingCmsCampusguidePageMainView.prototype.getStage = function() {
	return this.stage;
};

/**
 * @param {Kinetic.Layer}
 *            group
 */
FloorplannerBuildingCmsCampusguidePageMainView.prototype.setBuildingLayer = function(buildingLayer) {
	this.buildingLayer = buildingLayer;
};

/**
 * @returns {Kinetic.Layer}
 */
FloorplannerBuildingCmsCampusguidePageMainView.prototype.getBuildingLayer = function() {
	return this.buildingLayer;
};

/**
 * @param {Kinetic.Layer}
 *            layer
 */
FloorplannerBuildingCmsCampusguidePageMainView.prototype.setBuildingFloorSelectorLayer = function(
		buildingFloorSelectorLayer) {
	this.buildingFloorSelectorLayer = buildingFloorSelectorLayer;
};

/**
 * @returns {Kinetic.Layer}
 */
FloorplannerBuildingCmsCampusguidePageMainView.prototype.getBuildingFloorSelectorLayer = function() {
	return this.buildingFloorSelectorLayer;
};

/**
 * @param {float}
 *            scale
 */
FloorplannerBuildingCmsCampusguidePageMainView.prototype.setScale = function(scale) {
	this.scale = scale;
};

/**
 * @returns {float}
 */
FloorplannerBuildingCmsCampusguidePageMainView.prototype.getScale = function() {
	return this.scale;
};

// ... /GETTERS/SETTERS

// ... GET

/**
 * @return {BuildingsCmsCampusguideMainView}
 */
FloorplannerBuildingCmsCampusguidePageMainView.prototype.getView = function() {
	return PageMainView.prototype.getView.call(this);
};

// ... /GET

// ... DO

FloorplannerBuildingCmsCampusguidePageMainView.prototype.doBindEventHandler = function() {

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
			context.handleWrapperScroll(event);
		}, false);

	// for IE/OPERA etc
	wrapperDom.onmousewheel = function(event) {
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
FloorplannerBuildingCmsCampusguidePageMainView.prototype.doScale = function(scaleUp) {

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

FloorplannerBuildingCmsCampusguidePageMainView.prototype.doFloorSelect = function(floorId) {
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
			floors[i].setFill(FloorplannerBuildingCmsCampusguidePageMainView.FLOOR_SELECTOR_COLOR_SELECTED);

			// Set legend text
			legendText.setText(floors[i].floor.name);
		}
		// Selected floor
		if (floors[i].isSelected && floorSelectIndex != i) {
			floorSelectedIndex = i;
			floors[i].isSelected = false;
			floors[i].setFill(FloorplannerBuildingCmsCampusguidePageMainView.FLOOR_SELECTOR_COLOR_DEFAULT);
		}
		
	}
	
	// Draw Floor selector layer
	this.getBuildingFloorSelectorLayer().draw();

};

// ... /DO

// ... HANDLE

FloorplannerBuildingCmsCampusguidePageMainView.prototype.handleBuildingRetrieved = function(building) {

	// Draw Building
	this.drawBuilding(building);

};

FloorplannerBuildingCmsCampusguidePageMainView.prototype.handleBuildingElementsRetrieved = function(elements) {

	// Draw Elements
	this.drawElements(elements);

};

FloorplannerBuildingCmsCampusguidePageMainView.prototype.handleBuildingFloorsRetrieved = function(floors) {

	// Get query floor
	var floorQuery = this.getView().getController().getHash().floor;

	// Foreach floor
	var floorSelected = null, floorOrderLowest = null;
	for (floorId in floors) {
		if (!floorSelected && floors[floorId].main) {
			floorSelected = floorId;
		}
		if (floorQuery && floorQuery == floorId)
		{
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

FloorplannerBuildingCmsCampusguidePageMainView.prototype.handleWrapperScroll = function(event) {

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
FloorplannerBuildingCmsCampusguidePageMainView.prototype.handleScaleEvent = function(event) {

	// Do scale
	this.doScale(event.isScaleUp());

	// Send Scaled event
	this.getView().getController().getEventHandler().handle(new ScaledEvent(this.getScale()));

};

FloorplannerBuildingCmsCampusguidePageMainView.prototype.handleMenu = function(menu) {

	var submenuButtons = $("#floorplanner_menu_left_wrapper [data-menu]");

	submenuButtons.removeClass("highlight");

	switch (menu) {
	case "elements":
	case "navigation":
		submenuButtons.filter("#[data-menu=" + menu + "]").addClass("highlight");
		break;

	default:
		submenuButtons.filter("#[data-menu=building]").addClass("highlight");
		break;
	}

};

// ... /HANDLE

/**
 * @param {Element}
 *            root
 */
FloorplannerBuildingCmsCampusguidePageMainView.prototype.draw = function(root) {
	PageMainView.prototype.draw.call(this, root);

	// Bind
	this.doBindEventHandler();

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
		name : "building"
	}));

	// Initiate building floor selector layer
	this.setBuildingFloorSelectorLayer(new Kinetic.Layer({
		name : "buildingFloorSelector"
	}));

	// Layer draggable
	this.getBuildingLayer().draggable(true);

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

FloorplannerBuildingCmsCampusguidePageMainView.prototype.drawBuilding = function(building) {

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

	// Set z-order
	buildingBorder.setZIndex(1);

	// Draw layer
	this.getBuildingLayer().draw();

};

FloorplannerBuildingCmsCampusguidePageMainView.prototype.drawElements = function(elements) {

	var contextMain = this;

	// Initiate rooms group
	var roomsGroup = new Kinetic.Group({
		"name" : "elements"
	});

	// Room color's
	var roomColorDefault = "rgba(255,255,222,1)";// "rgba(0,0,0,0.1)";
	var roomColorHighlight = "#CCCCFF";

	// Foreach rooms
	for (elementid in elements) {

		(function() {

			// Get room coordinates
			var roomIndex = i;
			var roomCoordinates = elements[elementid].coordinates;

			// Draw room
			var roomShape = new Kinetic.Shape({
				drawFunc : function() {
					var context = this.getContext();

					context.save();
					context.beginPath();
					context.lineWidth = 1;
					context.strokeStyle = "#EFD7B5";
					context.fillStyle = this.color;

					// Foreach coordinations
					for ( var j = 0; j < roomCoordinates.length; j++) {
						if (j == 0) {
							context.moveTo(roomCoordinates[j][0], roomCoordinates[j][1]);
						} else {
							context.lineTo(roomCoordinates[j][0], roomCoordinates[j][1]);
						}
					}

					context.closePath();
					context.fill();
					context.stroke();
					context.restore();

				},
				"name" : "room_" + roomIndex
			});

			// Set room color
			roomShape.color = roomColorDefault;

			// Mouse over room
			roomShape.on("mouseover", function() {
				this.color = roomColorHighlight;
				contextMain.getBuildingLayer().draw();
			});

			// Mouse out room
			roomShape.on("mouseout", function() {
				this.color = roomColorDefault;
				contextMain.getBuildingLayer().draw();
			});

			// Add room to group
			roomsGroup.add(roomShape);

		})();

	}

	// Add rooms group to building layer
	this.getBuildingLayer().add(roomsGroup);

	// Set z-order
	roomsGroup.setZIndex(100);

	// Draw layer
	this.getBuildingLayer().draw();

};

FloorplannerBuildingCmsCampusguidePageMainView.prototype.drawFloorSelector = function(floors) {

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
				fill : FloorplannerBuildingCmsCampusguidePageMainView.FLOOR_SELECTOR_COLOR_DEFAULT,
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
					this.setFill(FloorplannerBuildingCmsCampusguidePageMainView.FLOOR_SELECTOR_COLOR_HIGHLIGHT);
					context.getBuildingFloorSelectorLayer().draw();
					document.body.style.cursor = "pointer";
				}
			});

			// Mouse out floor
			poly.on("mouseout", function() {
				if (!this.isSelected) {
					this.setFill(FloorplannerBuildingCmsCampusguidePageMainView.FLOOR_SELECTOR_COLOR_DEFAULT);
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
		drawFunc : function() {
			var context = this.getContext();
			CanvasUtil.roundRect(context, 0, 0, 20, 20);
			this.fillStroke();
		},
		fill : "white",
		stroke : "#B7B7B7",
		strokeWidth : 2,
		name : "box"
	});

	var legendText = new Kinetic.Text({
		x : 10,
		y : 10,
		text : " ",
		fontSize : 10,
		fontFamily : "Verdana",
		textFill : "#434343",
		align : "center",
		verticalAlign : "middle",
		fontStyle : "bold",
		name : "text"
	});

	groupLegend.add(legendBox);
	groupLegend.add(legendText);
	group.add(groupLegend);

	// /LEGEND

	this.getBuildingFloorSelectorLayer().add(group);

	group.setZIndex(1000);

	this.getBuildingFloorSelectorLayer().draw();
};

// /FUNCTIONS
