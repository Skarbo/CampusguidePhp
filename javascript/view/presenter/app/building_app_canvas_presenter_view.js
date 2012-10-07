// CONSTRUCTOR
BuildingAppCanvasPresenterView.prototype = new CanvasPresenterView();

function BuildingAppCanvasPresenterView(view) {
	CanvasPresenterView.apply(this, arguments);

	this.layers["bound"] = null;

	this.type = CanvasPresenterView.TYPE_FLOORS;
	this.retrieved = 0;
};

// VARIABLES

// /VARIABLES

// FUNCTIONS

// ... GET

/**
 * @return {Object}
 */
BuildingAppCanvasPresenterView.prototype.getCanvasContentElement = function() {
	return this.getRoot().find("#building_canvas");
};

/**
 * @return {Object}
 */
BuildingAppCanvasPresenterView.prototype.getCanvasLoaderElement = function() {
	return this.getRoot().find("#building_loader");
};

/**
 * @return {Object}
 */
BuildingAppCanvasPresenterView.prototype.getCanvasOverlayWrapperElement = function() {
	return this.getRoot().find("#building_canvas_overlay_wrapper");
};

/**
 * @return {Object}
 */
BuildingAppCanvasPresenterView.prototype.getCanvasOverlayFloorsElement = function() {
	return this.getCanvasOverlayWrapperElement().find("#building_canvas_overlay_floors");
};

// ... /GET

// ... DO

BuildingAppCanvasPresenterView.prototype.doBindEventHandler = function() {
	CanvasPresenterView.prototype.doBindEventHandler.call(this);
	var context = this;

	// EVENTS

	// Retrieved event
	this.getView().getController().getEventHandler().registerListener(RetrievedEvent.TYPE,
	/**
	 * @param {RetrievedEvent}
	 *            event
	 */
	function(event) {
		context.handleRetrieved(event.getRetrievedType(), event.getRetrieved());
	});

	// /EVENTS

	// OVERLAY

	this.getCanvasOverlayFloorsElement().children().bind("click", function(event) {
		context.getView().getController().updateHash({
			"floor" : $(this).attr("data-floor")
		});
		// event.preventDefault();
		// console.log("Click floor");
		// context.doFloorSelect($(this).attr("data-floor"));
	});

	// /OVERLAY

};

CanvasPresenterView.prototype.doFloorSelect = function(floorId, types) {
	CanvasPresenterView.prototype.doFloorSelect.call(this, floorId, types);

	var overlayFloors = this.getCanvasOverlayFloorsElement().children();
	overlayFloors.removeClass("selected");
	overlayFloors.filter("[data-floor=" + floorId + "]").addClass("selected");
};

CanvasPresenterView.prototype.doOverlayFloorSelectToggle = function() {
	this.getCanvasOverlayFloorsElement().toggle();
};

// ... /DO

// ... HANDLE

BuildingAppCanvasPresenterView.prototype.handleRetrieved = function(type, retrieved) {
	var context = this;

	switch (type) {
	case "building":
		context.handleBuildingRetrieved(retrieved);
		this.retrieved++;
		break;

	case "building_floors":
		context.handleFloorsRetrieved(retrieved);
		this.retrieved++;
		break;

	case "building_elements":
		context.handleElementsRetrieved(retrieved);
		this.retrieved++;
		break;
	}

	if (this.retrieved == 3) {
		// Select Floor
		var selectMainFloor = function(floors) {
			var floorMain = null;
			var i = 0;
			for (floorId in floors) {
				if (floors[floorId].main || i == 0)
					floorMain = floorId;
				i++;
			}
			return floorMain;
		};

		this.doFloorSelect(this.floorSelected ? this.floorSelected : selectMainFloor(this.getView().floors), [ CanvasPresenterView.TYPE_FLOORS,
				CanvasPresenterView.TYPE_ELEMENTS ]);

		// Fit to scale
		this.doFitToScale(CanvasPresenterView.TYPE_FLOORS);

		this.getCanvasContentElement().show();
		this.getCanvasLoaderElement().hide();

		this.getCanvasOverlayWrapperElement().show();
		// this.getCanvasOverlayFloorsElement().show();

		this.getCanvasOverlayFloorsElement().offset({
			top : this.getRoot().position().top + (this.getRoot().height() / 2) - (this.getCanvasOverlayFloorsElement().height() / 2),
			left : this.getRoot().position().left + this.getRoot().width() - this.getCanvasOverlayFloorsElement().outerWidth(true)
		});
	}
};

BuildingAppCanvasPresenterView.prototype.handleElementsRetrieved = function(elements) {
	CanvasPresenterView.prototype.handleElementsRetrieved.call(this, elements);
	var context = this;

	// ELEMENTS POLYGON CLICK

	var polygons = this.polygons[CanvasPresenterView.TYPE_ELEMENTS], elementPolygon = null;
	for (floorId in polygons) {
		for (i in polygons[floorId].children) {
			elementPolygon = polygons[floorId].children[i];

			elementPolygon.on("click", function(event) {
				event.cancelBubble = true;
				if (event.which == 1)
					context.getEventHandler().handle(new SelectEvent("polygon", this));
			});

			elementPolygon.on("mouseover", function(event) {
				this.shape.fillDefault = this.shape.attrs.fill;
				this.shape.setFill("#C9DAF8");
				this.getLayer().draw();
			});
			elementPolygon.on("mouseout", function(event) {
				if (this.shape.fillDefault)
					this.shape.setFill(this.shape.fillDefault);
				this.getLayer().draw();
			});
		}
	}

	// /ELEMENTS POLYGON CLICK
};

// ... /HANDLE

// ... DRAW

BuildingAppCanvasPresenterView.prototype.draw = function(root) {
	CanvasPresenterView.prototype.draw.call(this, root);
	var context = this;

	// Stage click
	this.stage.on("click", function(event) {
		if (event.which == 1)
			context.doOverlayFloorSelectToggle();
	});

	// Set stage draggable
	this.stage.setDraggable(true);
};

CanvasPresenterView.prototype.drawFloor = function(floor, width, height) {
	CanvasPresenterView.prototype.drawFloor.call(this, floor, width, height);
	var context = this;

	var polygons = this.getPolygons(CanvasPresenterView.TYPE_FLOORS, floor.id);
	if (!polygons)
		return;

	// DRAW BOUND RECT

	var outerBoundsMax = {
		x : 0,
		y : 0
	}, outerBounds = null;
	for (i in polygons.children) {
		outerBounds = CanvasUtil.getOuterBounds(polygons.children[i].getCoordinates());
		if (outerBounds[2][0] > outerBoundsMax.x)
			outerBoundsMax.x = outerBounds[2][0];
		if (outerBounds[3][1] > outerBoundsMax.y)
			outerBoundsMax.y = outerBounds[3][1];
	}

	if (!outerBoundsMax)
		return;

	if (!this.layers.bound) {
		this.layers.bound = new Kinetic.Layer({
			name : "bound"
		});

		this.layers.bound.add(new Kinetic.Rect({
			x : 0,
			y : 0,
			height : 0,
			width : 0
		}));

		this.stage.add(this.layers.bound);
		this.layers.bound.setZIndex(-10);
	}
	var boundRect = this.layers.bound.children[0];
	if (!boundRect)
		return;

	if (boundRect.getWidth() < outerBoundsMax.x)
		boundRect.setWidth(outerBoundsMax.x);
	if (boundRect.getHeight() < outerBoundsMax.y)
		boundRect.setHeight(outerBoundsMax.y);

	// /DRAW BOUND RECT

	// BIND CLICK

	var polygon = null;
	for (i in polygons.children) {
		polygon = polygons.children[i];

		polygon.on("click", function(event) {
			if (event.which == 1)
				context.getEventHandler().handle(new SelectEvent());
		});
	}

	// /BIND CLICK

};

// ... /DRAW

// /FUNCTIONS
