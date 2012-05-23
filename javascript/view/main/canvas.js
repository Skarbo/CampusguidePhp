/*
 * Canvas Main View
 */

// CONSTRUCTOR
CanvasMainView.prototype = new MainView();

/**
 * Canvas Main View
 * 
 * @param {string}
 *            wrapperId
 */
function CanvasMainView(wrapperId) {
	MainView.apply(this, arguments);
	this.wrapperId = wrapperId;
	this.stage = null;
	this.buildingLayer = null;
	this.scale = 1.0;
}

// /CONSTRUCTOR

// VARIABLES

CanvasMainView.SCALE_SIZE = 0.1;
CanvasMainView.BUILDING_SECTION_SCALE_LIMIT = 0.7;
CanvasMainView.Z_ORDER_BUILDING = 0;
CanvasMainView.Z_ORDER_BUILDING_ROOMS = 1;
CanvasMainView.Z_ORDER_BUILDING_SECTIONS = 1;
CanvasMainView.Z_ORDER_BUILDING_LEGENDS = 100;

CanvasMainView.BUILDING_SECTIONS_GROUP_NAME = "building_sections";
CanvasMainView.BUILDING_ROOMS_GROUP_NAME = "building_rooms";
CanvasMainView.BUILDING_ROOMS_LEGEND_GROUP_NAME = "building_rooms_legend";

CanvasMainView.BUILDING_COORDINATIONS = [ {
	'x' : 0,
	'y' : 164
}, {
	'x' : 127,
	'y' : 143
}, {
	'x' : 168,
	'y' : 308
}, {
	'x' : 202,
	'y' : 391
}, {
	'x' : 400,
	'y' : 239
}, {
	'x' : 370,
	'y' : 13
}, {
	'x' : 468,
	'y' : 0
}, {
	'x' : 502,
	'y' : 296
}, {
	'x' : 251,
	'y' : 496
}, {
	'x' : 305,
	'y' : 589
}, {
	'x' : 211,
	'y' : 642
}, {
	'x' : 169,
	'y' : 574
}, {
	'x' : 139,
	'y' : 556
}, {
	'x' : 51,
	'y' : 370
} ];

CanvasMainView.BUILDING_SECTIONS_COORDINATIONS = [
// A
[ {
	'x' : 1,
	'y' : 165
}, {
	'x' : 128,
	'y' : 142
}, {
	'x' : 169,
	'y' : 307
}, {
	'x' : 203,
	'y' : 392
}, {
	'x' : 111,
	'y' : 494
}, {
	'x' : 52,
	'y' : 370
} ] ];

CanvasMainView.BUILDING_SECTIONS_NAMES = {
	0 : "A-section"
};

CanvasMainView.BUILDING_ROOMS_COORDINATIONS = [
// A622
[ {
	'x' : 1,
	'y' : 165
}, {
	'x' : 50,
	'y' : 157
}, {
	'x' : 64,
	'y' : 211
}, {
	'x' : 16,
	'y' : 225
} ],
// A619
[ {
	'x' : 16,
	'y' : 225
}, {
	'x' : 64,
	'y' : 211
}, {
	'x' : 79,
	'y' : 266
}, {
	'x' : 29,
	'y' : 279
} ],
// A618
[ {
	'x' : 29,
	'y' : 279
}, {
	'x' : 79,
	'y' : 266
}, {
	'x' : 98,
	'y' : 328
}, {
	'x' : 105,
	'y' : 343
}, {
	'x' : 52,
	'y' : 370
} ],
// A617
[ {
	'x' : 52,
	'y' : 370
}, {
	'x' : 105,
	'y' : 343
}, {
	'x' : 161,
	'y' : 462
}, {
	'x' : 111,
	'y' : 494
} ],
// Stairs north
[ {
	'x' : 50,
	'y' : 157
}, {
	'x' : 76,
	'y' : 153
}, {
	'x' : 84,
	'y' : 182
}, {
	'x' : 58,
	'y' : 187
} ],
// A623
[ {
	'x' : 76,
	'y' : 153
}, {
	'x' : 126,
	'y' : 144
}, {
	'x' : 138,
	'y' : 192
}, {
	'x' : 90,
	'y' : 203
} ],
// A625
[ {
	'x' : 90,
	'y' : 203
}, {
	'x' : 138,
	'y' : 192
}, {
	'x' : 152,
	'y' : 248
}, {
	'x' : 108,
	'y' : 260
} ],
// A627
[ {
	'x' : 108,
	'y' : 260
}, {
	'x' : 152,
	'y' : 248
}, {
	'x' : 167,
	'y' : 308
}, {
	'x' : 127,
	'y' : 326
} ],
// CW
[ {
	'x' : 127,
	'y' : 326
}, {
	'x' : 167,
	'y' : 308
}, {
	'x' : 182,
	'y' : 346
}, {
	'x' : 145,
	'y' : 363
} ],
// Elevator
[ {
	'x' : 145,
	'y' : 363
}, {
	'x' : 182,
	'y' : 346
}, {
	'x' : 201,
	'y' : 391
}, {
	'x' : 165,
	'y' : 406
} ] ];

CanvasMainView.BUILDING_ROOMS_NAMES = {
	0 : "A622",
	1 : "A619",
	2 : "A618",
	3 : "A617",
	4 : "Stairs",
	5 : "A623",
	6 : "A625",
	7 : "A627",
	8 : "CW",
	9 : "Elevator"
};

// /VARIABLES

// FUNCTIONS

// ... GETTERS/SETTERS

/**
 * @param {string}
 *            wrapperId
 */
CanvasMainView.prototype.setWrapperId = function(wrapperId) {
	this.wrapperId = wrapperId;
};

/**
 * @returns {string}
 */
CanvasMainView.prototype.getWrapperId = function() {
	return this.wrapperId;
};

/**
 * @param {Kinetic.Stage}
 *            stage
 */
CanvasMainView.prototype.setStage = function(stage) {
	this.stage = stage;
};

/**
 * @returns {Kinetic.Stage}
 */
CanvasMainView.prototype.getStage = function() {
	return this.stage;
};

/**
 * @param {Kinetic.Group}
 *            group
 */
CanvasMainView.prototype.setBuildingLayer = function(group) {
	this.group = group;
};

/**
 * @returns {Kinetic.Group}
 */
CanvasMainView.prototype.getBuildingLayer = function() {
	return this.group;
};

/**
 * @param {float}
 *            scale
 */
CanvasMainView.prototype.setScale = function(scale) {
	this.scale = scale;
};

/**
 * @returns {float}
 */
CanvasMainView.prototype.getScale = function() {
	return this.scale;
};

// ... /GETTERS/SETTERS

// ... GET

/**
 * @returns {CampusguideMainController}
 */
CanvasMainView.prototype.getController = function() {
	return View.prototype.getController.call(this);
};

// ... ... ELEMENTS

/**
 * @returns {Object}
 */
CanvasMainView.prototype.getWrapperElement = function() {
	return $("#" + this.getWrapperId());
};

// ... ... /ELEMENTS

// ... /GET

// ... DO

CanvasMainView.prototype.doBindEventHandler = function() {
	MainView.prototype.doBindEventHandler.call(this);

	var context = this;

	// EVENTS

	// Handle "Scale" event
	this.getController().getEventHandler().registerListener(ScaleEvent.TYPE,
			function(event) {
				context.handleScaleEvent(event);
				context.handleBuildingDisplay();
			});

	// /EVENTS

	// MOUSE SCROLL

	// Get wrapper dom
	var wrapperDom = document.getElementById(this.getWrapperId());

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
};

/**
 * Scale stage
 * 
 * @param {boolean}
 *            scaleUp True if scale up, false if scale down
 */
CanvasMainView.prototype.doScale = function(scaleUp) {

	// Scale stage
	//var scaleOld = this.scale; 
	this.scale += CanvasMainView.SCALE_SIZE * (scaleUp ? 1 : -1);
	this.scale = Math.max(this.scale, 0);
	//var scaleDiff = this.scale - scaleOld;

	// Set stage scale
	this.getStage().setScale(this.scale);

	// Re-draw stage
	this.getBuildingLayer().draw();

};

// ... /DO

// ... DRAW

/**
 * Before
 */
CanvasMainView.prototype.before = function() {
	MainView.prototype.before.call(this);

	// Get canvas wrapper element
	var wrapperElement = this.getWrapperElement();

	// Initiate Kinetic Stage
	this.setStage(new Kinetic.Stage(wrapperElement.attr("id"), wrapperElement
			.width(), wrapperElement.height()));
};

/**
 * After
 */
CanvasMainView.prototype.after = function() {
	MainView.prototype.after.call(this);

	// Handle building display
	this.handleBuildingDisplay();

};

/**
 * @param {CampusguideMainController}
 *            controller
 */
CanvasMainView.prototype.draw = function(controller) {
	MainView.prototype.draw.call(this, controller);

	var str = "";
	for (i in CanvasMainView.BUILDING_SECTIONS_COORDINATIONS) {
		for (j in CanvasMainView.BUILDING_SECTIONS_COORDINATIONS[i]) {
		str += CanvasMainView.BUILDING_SECTIONS_COORDINATIONS[i][j].x + ","
				+ CanvasMainView.BUILDING_SECTIONS_COORDINATIONS[i][j].y + "|";
		}
	}

	for (i in CanvasMainView.BUILDING_ROOMS_COORDINATIONS) {
		var str = "";
		for (j in CanvasMainView.BUILDING_ROOMS_COORDINATIONS[i]) {
			str += CanvasMainView.BUILDING_ROOMS_COORDINATIONS[i][j].x + ","
					+ CanvasMainView.BUILDING_ROOMS_COORDINATIONS[i][j].y + "|";
		}	
	}

	// Initiate building layer
	this.setBuildingLayer(new Kinetic.Layer("building"));

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

	// Draw building
	this.drawBuilding();

	// Draw building rooms
	this.drawBuildingRooms();

	// Draw building sections
	this.drawBuildingSections();
	
	// Produce data url	
	this.getStage().toDataURL(function(dataUrl) {
		$("body").append($("<textarea />", {
			"html" : dataUrl
		}));
    });

};

/**
 * Draw Building
 */
CanvasMainView.prototype.drawBuilding = function() {

	// Draw building border
	var buildingBorder = new Kinetic.Shape(function() {
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
		for (i in CanvasMainView.BUILDING_COORDINATIONS) {
			if (i == 0) {
				context.moveTo(CanvasMainView.BUILDING_COORDINATIONS[i].x,
						CanvasMainView.BUILDING_COORDINATIONS[i].y);
			} else {
				context.lineTo(CanvasMainView.BUILDING_COORDINATIONS[i].x,
						CanvasMainView.BUILDING_COORDINATIONS[i].y);
			}
		}

		context.closePath();
		context.stroke();
		context.fill();
	});

	// Add building to building layer
	this.getBuildingLayer().add(buildingBorder);

	// Set z-order
	buildingBorder.setZIndex(CanvasMainView.Z_ORDER_BUILDING);

	// Draw layer
	this.getBuildingLayer().draw();

};

/**
 * Draw Building Sections
 */
CanvasMainView.prototype.drawBuildingSections = function() {

	// Initiate sections group
	var sectionsGroup = new Kinetic.Group(
			CanvasMainView.BUILDING_SECTIONS_GROUP_NAME);

	// Foreach sections
	for ( var i = 0; i < CanvasMainView.BUILDING_SECTIONS_COORDINATIONS.length; i++) {

		(function() {

			// Get section coordinates
			var sectionIndex = i;
			var sectionCoordinates = CanvasMainView.BUILDING_SECTIONS_COORDINATIONS[i];

			// Draw section
			var sectionShape = new Kinetic.Shape(
					function() {
						var context = this.getContext();
						context.beginPath();
						context.lineWidth = 1;
						context.strokeStyle = "black";
						context.fillStyle = "red";

						// Foreach coordinations
						for ( var j = 0; j < sectionCoordinates.length; j++) {
							if (j == 0) {
								context.moveTo(sectionCoordinates[j].x,
										sectionCoordinates[j].y);
							} else {
								context.lineTo(sectionCoordinates[j].x,
										sectionCoordinates[j].y);
							}
						}

						context.closePath();
						context.fill();
						context.stroke();

						// TEXT

						// Get shape width height
						var widthHeight = Util
								.getCoordinateWidthHeight(sectionCoordinates);

						// Find center point in shape
						var con = new Contour(sectionCoordinates);
						center = con.centroid();

						// Find angle of first vector
						var angle = Math.atan2(sectionCoordinates[1].y
								- sectionCoordinates[0].y,
								sectionCoordinates[1].x
										- sectionCoordinates[0].x);

						// Text
						context.save();
						context.translate(center.x, center.y);
						context.rotate(angle);
						context.font = "20px Arial";
						var text = CanvasMainView.BUILDING_SECTIONS_NAMES[sectionIndex] ? CanvasMainView.BUILDING_SECTIONS_NAMES[sectionIndex]
								: "Section " + sectionIndex;
						var metrics = context.measureText(text);
						if (metrics.width > widthHeight.x) {
							context.font = "6px Arial";
						}
						context.textAlign = "center";
						context.fillStyle = "black";
						context.fillText(text, 0, 0);
						context.restore();

						// /TEXT

					}, "section_" + sectionIndex);

			// Add section to group
			sectionsGroup.add(sectionShape);

		})();

	}

	// Hide as default
	sectionsGroup.hide();

	// Add sections group to building layer
	this.getBuildingLayer().add(sectionsGroup);

	// Set z-order
	sectionsGroup.setZIndex(CanvasMainView.Z_ORDER_BUILDING_SECTIONS);

	// Draw layer
	this.getBuildingLayer().draw();

};

/**
 * Draw Building Rooms
 */
CanvasMainView.prototype.drawBuildingRooms = function() {

	var contextMain = this;

	// Initiate rooms group
	var roomsGroup = new Kinetic.Group(CanvasMainView.BUILDING_ROOMS_GROUP_NAME);
	var roomsLegendGroup = new Kinetic.Group(
			CanvasMainView.BUILDING_ROOMS_LEGEND_GROUP_NAME);

	// Room color's
	var roomColorDefault = "rgba(255,255,222,1)";// "rgba(0,0,0,0.1)";
	var roomColorHighlight = "#CCCCFF";

	// Foreach rooms
	for ( var i = 0; i < CanvasMainView.BUILDING_ROOMS_COORDINATIONS.length; i++) {

		(function() {

			// Get room coordinates
			var roomIndex = i;
			var roomCoordinates = CanvasMainView.BUILDING_ROOMS_COORDINATIONS[i];

			// Draw room
			var roomShape = new Kinetic.Shape(function() {
				var context = this.getContext();

				context.save();
				context.beginPath();
				context.lineWidth = 1;
				context.strokeStyle = "#EFD7B5";
				context.fillStyle = this.color;

				// Foreach coordinations
				for ( var j = 0; j < roomCoordinates.length; j++) {
					if (j == 0) {
						context.moveTo(roomCoordinates[j].x,
								roomCoordinates[j].y);
					} else {
						context.lineTo(roomCoordinates[j].x,
								roomCoordinates[j].y);
					}
				}

				context.closePath();
				context.fill();
				context.stroke();
				context.restore();

			}, "room_" + roomIndex);

			// Room legend
			var roomLegend = new Kinetic.Shape(
					function() {
						var context = this.getContext();

						// Get shape width height
						var widthHeight = Util
								.getCoordinateWidthHeight(roomCoordinates);

						// Find center point in shape
						var con = new Contour(roomCoordinates);
						center = con.centroid();

						// Find angle of first vector
						var angle = Math.atan2(roomCoordinates[1].y
								- roomCoordinates[0].y, roomCoordinates[1].x
								- roomCoordinates[0].x);

						// Text
						context.translate(center.x, center.y);
						context.rotate(angle);
						context.font = "12px Arial";
						var text = CanvasMainView.BUILDING_ROOMS_NAMES[roomIndex] ? CanvasMainView.BUILDING_ROOMS_NAMES[roomIndex]
								: "Room " + roomIndex;
						var metrics = context.measureText(text);
						if (metrics.width > widthHeight.x) {
							context.font = "6px Arial";
						}
						context.textAlign = "center";
						context.fillStyle = "#6B5500";
						context.fillText(text, 0, 0);

						contextMain.drawTest(context);

					}, "room_legend_" + roomIndex);

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
			roomsLegendGroup.add(roomLegend);

		})();

	}

	// Add legend group to rooms group
	roomsGroup.add(roomsLegendGroup);

	// Add rooms group to building layer
	this.getBuildingLayer().add(roomsGroup);

	// Set z-order
	roomsGroup.setZIndex(CanvasMainView.Z_ORDER_BUILDING_ROOMS);
	roomsLegendGroup.setZIndex(CanvasMainView.Z_ORDER_BUILDING_LEGENDS);

	// Draw layer
	this.getBuildingLayer().draw();

};

CanvasMainView.prototype.drawTest = function(context) {
	if (!context)
		return;

	context.save();
	context.scale(0.06, 0.06);
	context.translate(-175.0 - (175.0 / 2), -80.0);

	// Blackboard
	context.save();
	context.translate(175.0, 100.0);
	context.lineWidth = 3;
	context.fillStyle = "rgba(255,255,255,1)";
	context.strokeStyle = "rgba(102,102,102,1)";
	context.fillRect(-100.5, -3.75, 350.5, 203.75);
	context.strokeRect(-100.5, -3.75, 350.5, 203.75);
	context.restore();

	// Border top
	context.save();
	context.translate(64.5, 72.0);
	context.lineWidth = 1;
	context.fillStyle = "rgba(0,0,0,1)";
	context.fillRect(-3.0, 20.25, 378.0, 4.75);
	context.restore();

	// Border bottom
	context.save();
	context.translate(61.0, 277.0);
	context.lineWidth = 1;
	context.fillStyle = "rgba(0,0,0,1)";
	context.fillRect(-3.0, 20.25, 378.0, 4.75);
	context.restore();

	// Stick
	context.save();
	context.translate(130, 90);
	context.rotate(45.0);
	context.lineWidth = 1;
	context.fillStyle = "rgba(102,102,102,1)";
	context.fillRect(60.98795987733972, 0.5, 172.51204012266027,
			4.272970773009202);
	context.restore();

	// Head
	context.save();
	context.beginPath();
	context.translate(312.5, 139.0);
	context.fillStyle = "rgba(102,102,102,1)";
	context.arc(25.0, 25.0, 125.0 / 2, 2 * Math.PI, false);
	context.fill();
	context.restore();

	// Torso
	context.save();
	context.translate(325.0, 225.0);
	context.fillStyle = "rgba(102,102,102,1)";
	context.fillRect(0.0, 0.0, 25.0, 100.0);
	context.restore();

	// Arm right
	context.save();
	context.translate(336.0, 227.0);
	context.rotate(-45.0);
	context.fillStyle = "rgba(102,102,102,1)";
	context.fillRect(0.0, 0.0, 25.0, 100.0);
	context.restore();

	// Arm left
	context.save();
	context.translate(318.5, 209.0);
	context.rotate(45);
	context.fillStyle = "rgba(102,102,102,1)";
	context.fillRect(0.0, 0.0, 25.0, 100.0);
	context.restore();

	context.restore();

};

// ... /DRAW

// ... HANDLE

CanvasMainView.prototype.handleWrapperScroll = function(event) {

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
		this.getController().getEventHandler()
				.handle(new ScaleEvent(delta > 0));
	}

};

/**
 * Handle scale event
 * 
 * @param {ScaleEvent}
 *            Scale event
 */
CanvasMainView.prototype.handleScaleEvent = function(event) {

	// Do scale
	this.doScale(event.isScaleUp());

	// Send Scaled event
	this.getController().getEventHandler().handle(
			new ScaledEvent(this.getScale()));

};

/**
 * Handle building display. Hides or shows the building children according to
 * scale.
 */
CanvasMainView.prototype.handleBuildingDisplay = function() {

	// Get building sections group
	var buildingSectionsGroup = this.getBuildingLayer().getChild(
			CanvasMainView.BUILDING_SECTIONS_GROUP_NAME);

	// Get building rooms group
	var buildingRoomsGroup = this.getBuildingLayer().getChild(
			CanvasMainView.BUILDING_ROOMS_GROUP_NAME);

	if (!buildingSectionsGroup || !buildingRoomsGroup) {
		console.error("Handle building display error",
				"Building section group or room group variable is undefined");
		return;
	}

	// Hide/show building sections
	if (buildingSectionsGroup
			&& this.getScale() < CanvasMainView.BUILDING_SECTION_SCALE_LIMIT) {
		buildingSectionsGroup.show();
		buildingRoomsGroup.hide();
	} else if (buildingSectionsGroup) {
		buildingSectionsGroup.hide();
		buildingRoomsGroup.show();
	}

	// Re-draw layer
	this.getBuildingLayer().draw();

};

// ... /HANDLE

// /FUNCTIONS
