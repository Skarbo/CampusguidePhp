// CONSTRUCTOR
ToolbarBuildingcreatorCmsCampusguidePresenterView.prototype = new PresenterView();

function ToolbarBuildingcreatorCmsCampusguidePresenterView(view) {
	PresenterView.apply(this, arguments);
};

// VARIABLES

// /VARIABLES

// FUNCTIONS

// ... GET

// ... ... TOOLTIP

/**
 * @returns {Object}
 */
ToolbarBuildingcreatorCmsCampusguidePresenterView.prototype.getToolbarPolygonElement = function() {
	return this.getRoot().find("#polygon");
};

/**
 * @returns {Object}
 */
ToolbarBuildingcreatorCmsCampusguidePresenterView.prototype.getToolbarLineTypeElement = function() {
	return this.getRoot().find(".line_type");
};

/**
 * @returns {Object}
 */
ToolbarBuildingcreatorCmsCampusguidePresenterView.prototype.getToolbarCopyElement = function() {
	return this.getRoot().find("#copy");
};

/**
 * @returns {Object}
 */
ToolbarBuildingcreatorCmsCampusguidePresenterView.prototype.getToolbarDeleteElement = function() {
	return this.getRoot().find("#delete");
};

/**
 * @returns {Object}
 */
ToolbarBuildingcreatorCmsCampusguidePresenterView.prototype.getToolbarToggleMapElement = function() {
	return this.getRoot().find("#toggle_map");
};

/**
 * @returns {Object}
 */
ToolbarBuildingcreatorCmsCampusguidePresenterView.prototype.getToolbarLayerFitElement = function() {
	return this.getRoot().find("#layer_fit");
};

/**
 * @returns {Object}
 */
ToolbarBuildingcreatorCmsCampusguidePresenterView.prototype.getToolbarScaleDecElement = function() {
	return this.getRoot().find("#scale_dec");
};

/**
 * @returns {Object}
 */
ToolbarBuildingcreatorCmsCampusguidePresenterView.prototype.getToolbarScaleIncElement = function() {
	return this.getRoot().find("#scale_inc");
};

// ... ... /TOOLTIP

// ... /GET

// ... DO

ToolbarBuildingcreatorCmsCampusguidePresenterView.prototype.doBindEventHandler = function() {
	var context = this;

	// EVENT

	// Floor select event
	this.getView().getController().getEventHandler().registerListener(FloorSelectEvent.TYPE,
	/**
	 * @param {FloorSelectEvent}
	 *            event
	 */
	function(event) {
		context.handleFloorSelect(event.getFloorId());
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

	// /EVENT

	// TOOLBAR

	this.getToolbarLayerFitElement().click(function(event) {
		if (!$(this).isDisabled())
			context.getEventHandler().handle(new FitToScaleEvent());
	});

	this.getToolbarPolygonElement().click(function(event) {
		if (!$(this).isDisabled())
			context.getEventHandler().handle(new PolygonEvent());
	});

	this.getToolbarLineTypeElement().click(function(event) {
		if (!$(this).isDisabled())
			context.getEventHandler().handle(new PolygonLineEvent($(this).attr("data-line")));
	});

	this.getToolbarCopyElement().click(function(event) {
		if (!$(this).isDisabled())
			context.getEventHandler().handle(new CopyEvent());
	});

	this.getToolbarDeleteElement().click(function(event) {
		if (!$(this).isDisabled())
			context.getEventHandler().handle(new DeleteEvent());
	});

	this.getToolbarToggleMapElement().click(function(event) {
		if (!$(this).isDisabled())
			context.getEventHandler().handle(new MapFloorEvent());
	});
	
	this.getToolbarScaleIncElement().click(function(event) {
		if (!$(this).isDisabled())
			context.getEventHandler().handle(new ScaleEvent(true));
	});
	
	this.getToolbarScaleDecElement().click(function(event) {
		if (!$(this).isDisabled())
			context.getEventHandler().handle(new ScaleEvent(false));
	});

	// /TOOLBAR

};

// ... /DO

// ... HANDLE

ToolbarBuildingcreatorCmsCampusguidePresenterView.prototype.handleFloorSelect = function(floorId) {

	// Enable toolbar buttons
	this.getToolbarToggleMapElement().enable();
	this.getToolbarLayerFitElement().enable();
	this.getToolbarScaleIncElement().enable();
	this.getToolbarScaleDecElement().enable();

};

ToolbarBuildingcreatorCmsCampusguidePresenterView.prototype.handleSelect = function(type, element) {
	this.getToolbarLineTypeElement().disable();
	this.getToolbarDeleteElement().disable();
	this.getToolbarCopyElement().disable();

	if (!type || !element) {
		if (this.getView().canvasPresenter.selectedCopy.element)
			this.getToolbarCopyElement().enable();
		return;
	}

	switch (type) {
	case "polygon":
		this.getToolbarDeleteElement().enable();
		this.getToolbarCopyElement().enable();
		break;

	case "polygon_anchor":
		this.getToolbarDeleteElement().enable();
		this.getToolbarLineTypeElement().enable();
		this.getToolbarLineTypeElement().filter("[data-line=" + element.type + "]").click();
		break;
	}
};

// ... /HANDLE

ToolbarBuildingcreatorCmsCampusguidePresenterView.prototype.draw = function(root) {
	PresenterView.prototype.draw.call(this, root);
};

// /FUNCTIONS
