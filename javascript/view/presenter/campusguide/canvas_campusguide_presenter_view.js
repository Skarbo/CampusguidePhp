// CONSTRUCTOR
CanvasCampusguidePresenterView.prototype = new PresenterView();

function CanvasCampusguidePresenterView(view) {
	PresenterView.apply(this, arguments);

	this.building = null;
	this.floors = {};
	this.elements = {};

	this.stage = null;
	this.stageScale = 1.0;
	this.stagePosition = {
		x : 0,
		y : 0
	};

	this.layers = {
		floors : {},
		elements : {}
	};
	this.groups = {
		floors : {},
		elements : {}
	};
	this.polygons = {
		floors : {},
		elements : {}
	};

	this.selected = {
		type : null,
		element : null
	};
	this.selectedCopy = this.selected;
	this.history = [];

	this.type = CanvasCampusguidePresenterView.TYPE_FLOORS;
	this.floorSelected = false;
	this.stageIsDragging = false;
	this.polygonsIsDraggable = false;
};

// VARIABLES

CanvasCampusguidePresenterView.SCALE_SIZE = 0.05;

CanvasCampusguidePresenterView.TYPE_FLOORS = "floors";
CanvasCampusguidePresenterView.TYPE_ELEMENTS = "elements";
CanvasCampusguidePresenterView.TYPE_NAVIGATION = "navigation";

// /VARIABLES

// FUNCTIONS

// ... GET

/**
 * @return {Object}
 */
CanvasCampusguidePresenterView.prototype.getCanvasContentElement = function() {
	throw new "Get canvas content element must be overwritten";
};

CanvasCampusguidePresenterView.prototype.getElementPolygon = function(elementId, floorId) {
	var elementPolygons = this.getPolygons(CanvasCampusguidePresenterView.TYPE_ELEMENTS, floorId);

	if (!elementPolygons)
		return null;

	for ( var i = 0; i < elementPolygons.children.length; i++) {
		if (elementPolygons.children[i].object.type == "element" && elementPolygons.children[i].object.element.id == elementId)
			return elementPolygons.children[i];
	}

	return null;
};

// ... ... STAGE

CanvasCampusguidePresenterView.prototype.setStageScale = function(scale) {
	this.stageScale = scale;
	this.getController().setLocalStorageVariable("scale", this.stageScale);
};

CanvasCampusguidePresenterView.prototype.setStagePosition = function(position) {
	this.stagePosition = position;
	this.getController().setLocalStorageVariable("stagePosition", position.x + "," + position.y);
};

// ... ... /STAGE

// ... ... KINETIC

/**
 * @returns {Kinetic.Layer}
 */
CanvasCampusguidePresenterView.prototype.getLayer = function(type, floorId) {
	return this.layers[type][floorId];
};

/**
 * @returns {Kinetic.Layer}
 */
CanvasCampusguidePresenterView.prototype.getLayers = function(type) {
	return this.layers[type];
};

/**
 * @returns {Kinetic.Group}
 */
CanvasCampusguidePresenterView.prototype.getGroup = function(type, floorId) {
	return this.groups[type][floorId];
};

/**
 * @returns {Kinetic.Group}
 */
CanvasCampusguidePresenterView.prototype.getGroups = function(type) {
	return this.groups[type];
};

/**
 * @returns {Kinetic.Group}
 */
CanvasCampusguidePresenterView.prototype.getPolygons = function(type, floorId) {
	return this.polygons[type][floorId];
};

// ... ... /KINETIC

// ... /GET

// ... SET

// ... ... KINETIC

CanvasCampusguidePresenterView.prototype.setLayer = function(type, floorId, layer) {
	this.layers[type][floorId] = layer;
};

CanvasCampusguidePresenterView.prototype.setGroup = function(type, floorId, group) {
	this.groups[type][floorId] = group;
};

CanvasCampusguidePresenterView.prototype.setPolygons = function(type, floorId, group) {
	this.polygons[type][floorId] = group;
};

// ... ... /KINETIC

// ... /SET

// ... DO

CanvasCampusguidePresenterView.prototype.doBindEventHandler = function() {
	PresenterView.prototype.doBindEventHandler.call(this);
	var context = this;

	// EVENTS

	// Handle save event
	this.getEventHandler().registerListener(SaveEvent.TYPE,
	/**
	 * @param {SaveEvent}
	 *            event
	 */
	function(event) {
		switch (event.getSaveType()) {
		case "building":
			context.doSave();
			break;
		}
	});

	// ... CANVAS

	// Floor select event
	this.getView().getController().getEventHandler().registerListener(FloorSelectEvent.TYPE,
	/**
	 * @param {FloorSelectEvent}
	 *            event
	 */
	function(event) {
		context.doFloorSelect(event.getFloorId());
	});

	// Select event
	this.getView().getController().getEventHandler().registerListener(SelectEvent.TYPE,
	/**
	 * @param {SelectEvent}
	 *            event
	 */
	function(event) {
		context.handleSelect(event.getSelectType(), event.getElement());
	});

	// Scale event
	this.getView().getController().getEventHandler().registerListener(ScaleEvent.TYPE,
	/**
	 * @param {ScaleEvent}
	 *            event
	 */
	function(event) {
		context.handleScale(event);
	});

	// Fit to scale event
	this.getEventHandler().registerListener(FitToScaleEvent.TYPE,
	/**
	 * @param {FitToScaleEvent}
	 *            event
	 */
	function(event) {
		context.doFitToScale();
	});

	// Polygon event
	this.getEventHandler().registerListener(PolygonEvent.TYPE,
	/**
	 * @param {PolygonEvent}
	 *            event
	 */
	function(event) {
		context.doPolygonDraw();
	});

	// Polygon line event
	this.getEventHandler().registerListener(PolygonLineEvent.TYPE,
	/**
	 * @param {PolygonLineEvent}
	 *            event
	 */
	function(event) {
		if (context.selected && context.selected.type == "polygon_anchor")
			context.doPolygonLine(context.selected.element, event.getLineType());
	});

	// Copy event
	this.getEventHandler().registerListener(CopyEvent.TYPE,
	/**
	 * @param {CopyEvent}
	 *            event
	 */
	function(event) {
		context.handleSelectedCopy();
	});

	// Delete event
	this.getView().getController().getEventHandler().registerListener(DeleteEvent.TYPE,
	/**
	 * @param {DeleteEvent}
	 *            event
	 */
	function(event) {
		context.handleSelectedDelete();
	});

	// Add history event
	this.getView().getController().getEventHandler().registerListener(AddHistoryEvent.TYPE,
	/**
	 * @param {AddHistoryEvent}
	 *            event
	 */
	function(event) {
		context.handleHistoryAdd(event.getHistory());
	});

	// Undo history event
	this.getView().getController().getEventHandler().registerListener(UndoHistoryEvent.TYPE,
	/**
	 * @param {UndoHistoryEvent}
	 *            event
	 */
	function(event) {
		context.handleHistoryUndo();
	});

	// ... /CANVAS

	// /EVENTS

	// CANVAS

	$(window).keydown(function(event) {
		// Bind ctrl
		if (event.which == 17) {
			context.doStageDraggable(true);
		}
		// Bind shift
		if (event.which == 16) {
			context.polygonsIsDraggable = true;
		}
	}).keyup(function(event) {
		// Bind ctrl
		if (event.which == 17) {
			context.doStageDraggable(false);
		}
		// Bind shift
		if (event.which == 16) {
			context.polygonsIsDraggable = false;
		}
	});

	this.getCanvasContentElement().bind("contextmenu", function(e) {
		return false;
	});

	// ... MOUSE SCROLL
console.log(this.getCanvasContentElement());
	// Get wrapper dom
	var canvasWrapper = document.getElementById(this.getCanvasContentElement().attr("id"));

	// Adding the event listerner for Mozilla
	if (window.addEventListener)
		canvasWrapper.addEventListener('DOMMouseScroll', function(event) {
			event.preventDefault();
			context.handleScroll(event);
		}, false);

	// for IE/OPERA etc
	canvasWrapper.onmousewheel = function(event) {
		event.preventDefault();
		context.handleScroll(event);
	};

	// ... /MOUSE SCROLL

	// /CANVAS

};

CanvasCampusguidePresenterView.prototype.doSave = function() {
	this.getEventHandler().handle(new EditEvent("building", this.polygons));
};

CanvasCampusguidePresenterView.prototype.doFloorSelect = function(floorId) {
	if (!floorId || !this.type)
		return false;

	// Show/hide Floors
	var floors = this.getGroups(CanvasCampusguidePresenterView.TYPE_FLOORS);
	for (id in floors) {
		if (this.type == CanvasCampusguidePresenterView.TYPE_FLOORS && id == floorId) {
			floors[id].show();
		} else {
			floors[id].hide();
		}
	}

	// Show/hide Elements
	var elements = this.getGroups(CanvasCampusguidePresenterView.TYPE_ELEMENTS);
	for (id in elements) {
		if (this.type == CanvasCampusguidePresenterView.TYPE_ELEMENTS && id == floorId) {
			elements[id].show();
		} else {
			elements[id].hide();
		}
	}

	this.floorSelected = floorId;

	// De-select
	this.getEventHandler().handle(new SelectEvent());

	// Re-draw stage
	this.stage.draw();

};

// ... ... STAGE

CanvasCampusguidePresenterView.prototype.doFitToScale = function() {
	if (!this.floorSelected)
		return false;

	var polygons = this.getPolygons(this.type, this.floorSelected).getChildren();

	var scaleNew = 1.0;
	var positionNew = {
		x : 0,
		y : 0
	};

	if (polygons.length > 0) {

		var coordinates = [];
		for (i in polygons) {
			coordinates = coordinates.concat(polygons[i].getCoordinates());
		}

		var coordinatesMaxBounds = CanvasUtil.getMaxBounds(coordinates);
		var boundX = coordinatesMaxBounds[2] - coordinatesMaxBounds[0], boundY = coordinatesMaxBounds[3] - coordinatesMaxBounds[1];

		var stageX = this.stage.getWidth(), stageY = this.stage.getHeight();
		scaleNew = Core.roundNumber(Math.min(stageX / boundX, stageY / boundY), 4);
		var boundsNewX = boundX * scaleNew, boundsNewY = boundY * scaleNew;

		positionNew.x = ((stageX - boundsNewX) / 2) - (coordinatesMaxBounds[0] * scaleNew);
		positionNew.y = ((stageY - boundsNewY) / 2) - (coordinatesMaxBounds[1] * scaleNew);

	} else {

		// TODO Fit to scale floors map
		var layer = this.getLayer("floors_map", this.floorSelected);

		if (layer.height && layer.width) {
			var boundX = layer.width, boundY = layer.height;
			var stageX = this.stage.getWidth(), stageY = this.stage.getHeight();
			scaleNew = parseFloat((Math.floor(parseFloat(Math.min(stageX / boundX, stageY / boundY).toFixed(2)) * 20) / 20).toFixed(2));
			var boundsNewX = boundX * scaleNew, boundsNewY = boundY * scaleNew;

			positionNew.x = (stageX - boundsNewX) / 2;
			positionNew.y = (stageY - boundsNewY) / 2;
		}

	}
	this.setStageScale(scaleNew);
	this.setStagePosition(positionNew);
	this.stage.setScale(this.stageScale);
	this.stage.setX(this.stagePosition.x);
	this.stage.setY(this.stagePosition.y);
	this.stage.draw();

};

CanvasCampusguidePresenterView.prototype.doStageScale = function(scaleUp) {
	var userPosition = this.stage.getUserPosition();
	var position = this.stage.getPosition();

	// this.stage.setX(-userPosition.x * this.stage.attrs.scale.x);
	// this.stage.setY(-userPosition.y * this.stage.attrs.scale.x);

	// Set scale
	this.stageScale += CanvasCampusguidePresenterView.SCALE_SIZE * (scaleUp ? 1 : -1);
	this.setStageScale(Math.max(this.stageScale, 0));
	this.stage.setScale(this.stageScale);

	// this.stage.setPosition({ x: position.x, y : position.y });

	// Re-draw stage
	this.stage.draw();

};

CanvasCampusguidePresenterView.prototype.doStageDraggable = function(draggable) {
	this.stage.setDraggable(draggable);
	this.stageIsDragging = draggable;
	this.getCanvasContentElement().css("cursor", draggable ? "move" : "default");
};

// ... ... /STAGE

// ... ... POLYGON

CanvasCampusguidePresenterView.prototype.doPolygonDraw = function() {
	if (!this.floorSelected || !this.type)
		return;

	var polygons = this.getPolygons(this.type, this.floorSelected);
	if (!polygons)
		return;

	// Create polygon
	var polygon = new Polygon({}, this);
	polygons.add(polygon);

	// Create polygon with mouse
	polygon.createPolygon();

	polygon.getLayer().draw();
};

CanvasCampusguidePresenterView.prototype.doPolygonLine = function(polygonAnchor, type) {
	if (!polygonAnchor || !type) {
		return;
	}
	var oldType = polygonAnchor.type;

	switch (type) {
	case Polygon.LINE_TYPE_STRAIGHT:
	case Polygon.LINE_TYPE_QUAD:
	case Polygon.LINE_TYPE_BEZIER:
		polygonAnchor.type = type;
		break;
	}

	if (polygonAnchor.type != oldType) {
		polygonAnchor.select();
		polygonAnchor.getLayer().draw();
	}
};

// ... ... /POLYGON

// ... /DO

// ... HANDLE

// ... ... RETRIEVED

CanvasCampusguidePresenterView.prototype.handleBuildingRetrieved = function(building) {
	this.building = building;
};

CanvasCampusguidePresenterView.prototype.handleFloorsRetrieved = function(floors) {
	this.floors = floors;

	// Draw Floors
	for (floorId in floors) {
		this.drawFloor(floors[floorId]);
	}
};

CanvasCampusguidePresenterView.prototype.handleElementsRetrieved = function(elements) {
	this.elements = elements;

	// Draw Elements
	for (elementId in elements) {
		if (!elements[elementId].deleted)
			this.drawElement(elements[elementId]);
	}
};

// ... ... /RETRIEVED

CanvasCampusguidePresenterView.prototype.handleScale = function(event) {
	this.doStageScale(event.isScaleUp());
	this.getEventHandler().handle(new ScaledEvent(this.stageScale));
};

CanvasCampusguidePresenterView.prototype.handleScroll = function(event) {
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
		this.getEventHandler().handle(new ScaleEvent(delta > 0));
	}
};

CanvasCampusguidePresenterView.prototype.handleSelect = function(type, element) {
	if (this.selected.element) {
		this.selected.element.deselect();
	}

	if (!type || !element) {
		if (this.selected.element)
			this.selected.element.getLayer().draw();
		this.selected = {};
		return;
	}

	this.selected = {};

	if (!element.isVisible())
		return;

	this.selected = {
		type : type,
		element : element
	};

	this.selected.element.select();

	switch (type) {
	case "polygon":
		this.selected.element.getLayer().draw();
		break;

	case "polygon_anchor":
		break;

	default:
		this.selected = {};
	}

};

CanvasCampusguidePresenterView.prototype.handleSelectedCopy = function() {

	// COPY

	if (this.selected.element) {
		if (this.selected.type != "polygon")
			return;
		this.selectedCopy = this.selected;
	}

	// /COPY

	// PASTE

	if (!this.selected.element) {
		if (this.selectedCopy.type != "polygon")
			return;

		var polygons = this.getPolygons(this.type, this.floorSelected);
		if (polygons) {
			var polygon = this.selectedCopy.element.copy(this);
			polygons.add(polygon);
			if (this.selectedCopy.element.getLayer()._id == polygons.getLayer()._id)
				polygon.move(20, 20);
			polygon.getLayer().draw();
		}
	}

	// /PASTE

};

CanvasCampusguidePresenterView.prototype.handleSelectedDelete = function() {
	if (!this.selected.element)
		return false;

	var selected = this.selected;
	var parent = selected.element.getParent();

	// Deselect
	this.getEventHandler().handle(new SelectEvent());

	// Delete selected
	selected.element.erase();

	// Draw layer
	parent.getLayer().draw();

	// Deleted event
	if (selected.type == "polygon" && selected.element.object.type == "element" && selected.element.object.element)
		this.getEventHandler().handle(new DeletedEvent("element", selected.element.object.element.id));

	// Add history
	this.getEventHandler().handle(new AddHistoryEvent({
		type : "selected_delete",
		element : selected,
		parent : parent
	}));
};

CanvasCampusguidePresenterView.prototype.handleTypeSelect = function(type) {
	this.type = type;

	if (this.floorSelected)
		this.getEventHandler().handle(new FloorSelectEvent(this.floorSelected));
};

// ... ... HISTORY

CanvasCampusguidePresenterView.prototype.handleHistoryAdd = function(history) {
	this.history.push(history);
};

CanvasCampusguidePresenterView.prototype.handleHistoryUndo = function() {
	if (this.history.length == 0)
		return;

	var historyObject = this.history.pop();

	switch (historyObject.type) {
	case "selected_delete":
		historyObject.element.element.undo();
		break;
	case "selected_drag":
		historyObject.element.undoMove();
		break;
	}

	this.getEventHandler().handle(new UndidHistoryEvent(historyObject));
};

// ... ... /HISTORY

// ... /HANDLE

// ... DRAW

CanvasCampusguidePresenterView.prototype.draw = function(root) {
	PresenterView.prototype.draw.call(this, root);
	var context = this;

	// Set variables from local storage
	var scale = this.getController().getLocalStorageVariable("scale");
	if (scale)
		this.stageScale = parseFloat(scale);
	var stagePosition = this.getController().getLocalStorageVariable("stagePosition");
	if (stagePosition) {
		stagePosition = stagePosition.split(",");
		this.stagePosition = {
			x : parseFloat(stagePosition[0]),
			y : parseFloat(stagePosition[1])
		};
	}

	// Initiate Kinetic Stage
	var canvas = this.getCanvasContentElement();
	this.stage = new Kinetic.Stage({
		"container" : canvas.attr("id"),
		"width" : canvas.parent().width(),
		"height" : canvas.parent().height(),
		clearBeforeDraw : true,
		scale : this.stageScale
	});
	this.stage.setX(this.stagePosition.x);
	this.stage.setY(this.stagePosition.y);
	this.stage.resize = function() {
		this.setSize(canvas.parent().width(), canvas.parent().height());
		this.draw();
	};

	this.stage.on("click", function(event) {
		if (event.which == 3)
			context.getEventHandler().handle(new SelectEvent(null));
	});

	this.stage.on("dragend", function(event) {
		context.setStagePosition(this.getPosition());
	});
};

CanvasCampusguidePresenterView.prototype.drawFloor = function(floor, width, height) {
	width = width || 0;
	height = height || 0;

	// Initiate layer
	var layer = new Kinetic.Layer({
		name : "floor_layer",
		id : floor.id
	});

	// Initiate group
	var group = new Kinetic.Group({
		name : "floor_group",
		id : floor.id,
		visible : false
	});

	// Create fill
	var fill = new Kinetic.Rect({
		name : "floor_fill",
		x : 0,
		y : 0,
		width : width,
		height : height,
		stroke : "#CCC",
		strokeWidth : 2
	});
	group.add(fill);
	fill.setZIndex(5);

	// Create polygon group
	var polygons = new Kinetic.Group({
		name : "floor_polygons"
	});
	group.add(polygons);
	polygons.setZIndex(10);
	this.setPolygons(CanvasCampusguidePresenterView.TYPE_FLOORS, floor.id, polygons);

	// Create Floor polygon
	if (floor.coordinates) {
		var coordinates = floor.coordinates.split("$");
		for (i in coordinates) {
			var polygon = new Polygon({}, this);
			polygon.fromData(coordinates[i]);
			polygons.add(polygon);
		}
	}

	// Set Floor layer
	this.setLayer(CanvasCampusguidePresenterView.TYPE_FLOORS, floor.id, layer);

	// Set floor group
	this.setGroup(CanvasCampusguidePresenterView.TYPE_FLOORS, floor.id, group);

	// Add group to layer
	layer.add(group);

	// Add layer to stage
	this.stage.add(layer);

	// Draw Floor Element
	this.drawFloorElement(floor, width, height);

};

CanvasCampusguidePresenterView.prototype.drawFloorElement = function(floor, width, height) {

	// Initiate layer
	var layer = new Kinetic.Layer({
		name : "element_layer",
		id : floor.id
	});

	this.setLayer(CanvasCampusguidePresenterView.TYPE_ELEMENTS, floor.id, layer);
	this.stage.add(layer);

	// Initiate group
	var group = new Kinetic.Group({
		name : "element_group",
		id : floor.id,
		visible : false
	});

	this.setGroup(CanvasCampusguidePresenterView.TYPE_ELEMENTS, floor.id, group);
	layer.add(group);

	// Create fill
	var fill = new Kinetic.Rect({
		name : "floor_fill",
		x : 0,
		y : 0,
		width : width,
		height : height,
		stroke : "#CCC",
		strokeWidth : 2
	});
	group.add(fill);
	fill.setZIndex(5);

	// Initiate polygons
	var polygons = new Kinetic.Group({
		name : "element_polygons",
		id : floor.id
	});

	this.setPolygons(CanvasCampusguidePresenterView.TYPE_ELEMENTS, floor.id, polygons);
	group.add(polygons);
	polygons.setZIndex(10);

};

CanvasCampusguidePresenterView.prototype.drawElement = function(element) {
	var polygons = this.getPolygons(CanvasCampusguidePresenterView.TYPE_ELEMENTS, element.floorId);

	// TODO Add these elements to an unnamed floor?
	if (!polygons)
		return;

	// Create polygon
	if (element.coordinates) {
		var coordinates = element.coordinates.split("$");
		for (i in coordinates) {
			var polygon = new Polygon({}, this);
			polygon.object = {
				type : "element",
				element : element
			};
			polygons.add(polygon);
			polygon.fromData(coordinates[i]);
		}
	}

};

// ... /DRAW

// /FUNCTIONS
