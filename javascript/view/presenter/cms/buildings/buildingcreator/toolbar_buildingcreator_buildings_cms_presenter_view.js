// CONSTRUCTOR
ToolbarBuildingcreatorBuildingsCmsPresenterView.prototype = new AbstractPresenterView();

function ToolbarBuildingcreatorBuildingsCmsPresenterView(view) {
	AbstractPresenterView.apply(this, arguments);
};

// VARIABLES

// /VARIABLES

// FUNCTIONS

// ... GET

// ... ... TOOLTIP
	
/**
 * @returns {Object}
 */
ToolbarBuildingcreatorBuildingsCmsPresenterView.prototype.getToolbarPolygonElement = function() {
	return this.getRoot().find("#polygon");
};

/**
 * @returns {Object}
 */
ToolbarBuildingcreatorBuildingsCmsPresenterView.prototype.getDeviceRouterElement = function() {
	return this.getRoot().find("#element_device_router");
};

///**
// * @returns {Object}
// */
//ToolbarBuildingcreatorBuildingsCmsPresenterView.prototype.getToolbarLineTypeElement = function() {
//	return this.getRoot().find(".line_type");
//};

/**
 * @returns {Object}
 */
ToolbarBuildingcreatorBuildingsCmsPresenterView.prototype.getToolbarCopyElement = function() {
	return this.getRoot().find("#copy");
};

/**
 * @returns {Object}
 */
ToolbarBuildingcreatorBuildingsCmsPresenterView.prototype.getToolbarDeleteElement = function() {
	return this.getRoot().find("#delete");
};

/**
 * @returns {Object}
 */
ToolbarBuildingcreatorBuildingsCmsPresenterView.prototype.getToolbarToggleMapElement = function() {
	return this.getRoot().find("#toggle_map");
};

/**
 * @returns {Object}
 */
ToolbarBuildingcreatorBuildingsCmsPresenterView.prototype.getToolbarLayerFitElement = function() {
	return this.getRoot().find("#layer_fit");
};

/**
 * @returns {Object}
 */
ToolbarBuildingcreatorBuildingsCmsPresenterView.prototype.getToolbarScaleDecElement = function() {
	return this.getRoot().find("#scale_dec");
};

/**
 * @returns {Object}
 */
ToolbarBuildingcreatorBuildingsCmsPresenterView.prototype.getToolbarScaleIncElement = function() {
	return this.getRoot().find("#scale_inc");
};

/**
 * @returns {Object}
 */
ToolbarBuildingcreatorBuildingsCmsPresenterView.prototype.getToolbarUndoElement = function() {
	return this.getRoot().find("#undo");
};

// ... ... /TOOLTIP

// ... /GET

// ... DO

ToolbarBuildingcreatorBuildingsCmsPresenterView.prototype.doBindEventHandler = function() {
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

	// Select canvas event
	this.getView().getController().getEventHandler().registerListener(SelectCanvasEvent.TYPE,
	/**
	 * @param {SelectCanvasEvent}
	 *            event
	 */
	function(event) {
		context.handleSelectCanvas(event.getSelectType(), event.getElement());
	});
	
	// Menu event
	this.getEventHandler().registerListener(MenuEvent.TYPE,
	/**
	 * @param {MenuEvent}
	 *            event
	 */
	function(event) {
		context.handleMenuSelect(event.getMenu());
	});


	// Add history event
	this.getView().getController().getEventHandler().registerListener(AddHistoryEvent.TYPE,
	/**
	 * @param {AddHistoryEvent}
	 *            event
	 */
	function(event) {
		context.handleHistory();
	});

	// Undo history event
	this.getView().getController().getEventHandler().registerListener(UndoHistoryEvent.TYPE,
	/**
	 * @param {UndoHistoryEvent}
	 *            event
	 */
	function(event) {
		context.handleHistory();
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

//	this.getToolbarLineTypeElement().click(function(event) {
//		if (!$(this).isDisabled())
//			context.getEventHandler().handle(new PolygonLineEvent($(this).attr("data-line")));
//	});

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

	this.getToolbarUndoElement().click(function(event) {
		if (!$(this).isDisabled())
			context.getEventHandler().handle(new UndoHistoryEvent());
	});

	// /TOOLBAR

};

// ... /DO

// ... HANDLE

ToolbarBuildingcreatorBuildingsCmsPresenterView.prototype.handleFloorSelect = function(floorId) {
	this.getToolbarToggleMapElement().enable();
	this.getToolbarLayerFitElement().enable();
	this.getToolbarScaleIncElement().enable();
	this.getToolbarScaleDecElement().enable();
};

ToolbarBuildingcreatorBuildingsCmsPresenterView.prototype.handleMenuSelect = function(menu) {

};

ToolbarBuildingcreatorBuildingsCmsPresenterView.prototype.handleSelectCanvas = function(type, element) {
//	this.getToolbarLineTypeElement().disable();
	this.getToolbarDeleteElement().disable();
	this.getToolbarCopyElement().disable();

	if (!type || !element) {
		if (this.getView().selectedCopy.element)
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
//		this.getToolbarLineTypeElement().enable();
		//this.getToolbarLineTypeElement().filter("[data-line=" + element.type + "]").click();
//		this.getToolbarLineTypeElement().filter("[data-line=" + element.type + "]").trigger("select");
		break;
		
	case "device_shape":
		this.getToolbarDeleteElement().enable();
		break;
	}
};

ToolbarBuildingcreatorBuildingsCmsPresenterView.prototype.handleHistory = function() {
	var context = this;
	setTimeout(function() {
		if (context.getView().history.length == 0)
			context.getToolbarUndoElement().disable();
		else
			context.getToolbarUndoElement().enable();
	}, 10);
};

// ... /HANDLE

ToolbarBuildingcreatorBuildingsCmsPresenterView.prototype.draw = function(root) {
	AbstractPresenterView.prototype.draw.call(this, root);
	var context = this;
	
	// Device Router
	this.getDeviceRouterElement().button({
		icons : {
			primary : "device_router"
		},
		text : false
	}).click(function() {
		context.getEventHandler().handle(new DeviceElementBuildingCanvasEvent("router"));
	});
};

// /FUNCTIONS
