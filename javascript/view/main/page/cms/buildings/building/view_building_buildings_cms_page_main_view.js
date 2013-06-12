// CONSTRUCTOR
ViewBuildingBuildingsCmsPageMainView.prototype = new AbstractPageMainView();

function ViewBuildingBuildingsCmsPageMainView(view) {
	AbstractPageMainView.apply(this, arguments);
	this.canvasPresenter = null;

	this.selected = {
		type : null,
		element : null
	};
	this.selectedCopy = this.selected;
	this.history = [];

	if (typeof ViewBuildingBuildingsCmsCanvasPresenterView !== "undefined")
		this.canvasPresenter = new ViewBuildingBuildingsCmsCanvasPresenterView(this);
};

// /CONSTRUCTOR

// VARIABLES

// /VARIABLES

// FUNCTIONS

// ... GET

/**
 * @return {BuildingBuildingsCmsPageMainView}
 */
ViewBuildingBuildingsCmsPageMainView.prototype.getView = function() {
	return AbstractPageMainView.prototype.getView.call(this);
};

/**
 * @return {Object}
 */
ViewBuildingBuildingsCmsPageMainView.prototype.getCanvasWrapperElement = function() {
	return this.getRoot().find("#canvas_wrapper");
};

/**
 * @return {Object}
 */
ViewBuildingBuildingsCmsPageMainView.prototype.getToolbarWrapperElement = function() {
	return this.getRoot().find("#toolbar_wrapper");
};

/**
 * @return {Object}
 */
ViewBuildingBuildingsCmsPageMainView.prototype.getFloorPickerWrapperElement = function() {
	return this.getCanvasWrapperElement().find("#floor_picker_wrapper");
};

// ... /GET

// ... DO

ViewBuildingBuildingsCmsPageMainView.prototype.doBindEventHandler = function() {
	AbstractPageMainView.prototype.doBindEventHandler.call(this);
	var context = this;

	// BUILDING CANVAS

	// Floor select event
	this.getView().getController().getEventHandler().registerListener(FloorSelectEvent.TYPE,
	/**
	 * @param {FloorSelectEvent}
	 *            event
	 */
	function(event) {
		context.getToolbarWrapperElement().find("#scale_dec").enable();
		context.getToolbarWrapperElement().find("#scale_inc").enable();
		context.getToolbarWrapperElement().find("#layer_fit").enable();

		context.doFloorPickerSelect(event.getFloorId());
	});

	// /BUILDING CANVAS

	// TOOLBAR

	this.getToolbarWrapperElement().find("#scale_dec").bind("click", function() {
		if (!$(this).isDisabled())
			context.getEventHandler().handle(new ScaleEvent(false));
	});

	this.getToolbarWrapperElement().find("#scale_inc").bind("click", function() {
		if (!$(this).isDisabled())
			context.getEventHandler().handle(new ScaleEvent(true));
	});

	this.getToolbarWrapperElement().find("#layer_fit").click(function(event) {
		if (!$(this).isDisabled())
			context.getEventHandler().handle(new FitToScaleEvent());
	});

	// /TOOLBAR

	// FLOOR PICKER

	this.getFloorPickerWrapperElement().children().click(function(event) {
		var floorId = $(event.target).attr("data-floor");
		if (floorId) {
			// context.getEventHandler().handle(new FloorSelectEvent(floorId));
			context.getController().updateHash({
				'floor' : floorId
			});
		}
	});

	// /FLOOR PICKER

};

ViewBuildingBuildingsCmsPageMainView.prototype.doFloorPickerSelect = function(floorId) {
	this.getFloorPickerWrapperElement().find(".floor_pick_wrapper").removeClass("selected").filter("[data-floor=" + floorId + "]").addClass("selected");
};

// ... /DO

/**
 * @param {Element}
 *            root
 */
ViewBuildingBuildingsCmsPageMainView.prototype.draw = function(root) {
	AbstractPageMainView.prototype.draw.call(this, root);

	this.canvasPresenter.draw(this.getCanvasWrapperElement());

	this.getFloorPickerWrapperElement().offset(
			{
				top : this.getCanvasWrapperElement().position().top + (this.getCanvasWrapperElement().height() / 2)
						- (this.getFloorPickerWrapperElement().find(":first-child").height() / 2),
				left : this.getCanvasWrapperElement().position().left
			});
};

// /FUNCTIONS
