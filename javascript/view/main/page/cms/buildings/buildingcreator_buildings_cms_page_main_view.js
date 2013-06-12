// CONSTRUCTOR
BuildingcreatorBuildingsCmsPageMainView.prototype = new AbstractPageMainView();

function BuildingcreatorBuildingsCmsPageMainView(view) {
	AbstractPageMainView.apply(this, arguments);

	this.menuPresenter = new MenuBuildingcreatorBuildingsCmsPresenterView(this);
	this.sidebarPresenter = new SidebarBuildingcreatorBuildingsCmsPresenterView(this);
	this.toolbarPresenter = new ToolbarBuildingcreatorBuildingsCmsPresenterView(this);
	this.canvasPresenter = new BuildingcreatorBuildingsCmsCanvasPresenterView(this);

	this.selected = {
		type : null,
		element : null
	};
	this.selectedCopy = this.selected;
	this.history = [];
};

// /CONSTRUCTOR

// VARIABLES

// /VARIABLES

// CLASS

// /CLASS

// FUNCTIONS

// ... GET

/**
 * @return {BuildingsCmsMainView}
 */
BuildingcreatorBuildingsCmsPageMainView.prototype.getView = function() {
	return AbstractPageMainView.prototype.getView.call(this);
};

// ... ... OBJECTS

/**
 * @returns {Object}
 */
BuildingcreatorBuildingsCmsPageMainView.prototype.getBuilding = function() {
	return this.getController().building;
};

/**
 * @returns {Object}
 */
BuildingcreatorBuildingsCmsPageMainView.prototype.getFloors = function() {
	return this.getController().floors;
};

/**
 * @returns {Object}
 */
BuildingcreatorBuildingsCmsPageMainView.prototype.getElements = function() {
	return this.getController().elements;
};

// ... ... /OBJECTS

// ... ... ELEMENT

/**
 * @return {Object}
 */
BuildingcreatorBuildingsCmsPageMainView.prototype.getMaximizeElement = function() {
	return this.getRoot().find("#page_maximize");
};

/**
 * @return {Object}
 */
BuildingcreatorBuildingsCmsPageMainView.prototype.getCanvasWrapperElement = function() {
	return this.getRoot().find("#buildingcreator_planner_content_canvas_wrapper");
};

/**
 * @return {Object}
 */
BuildingcreatorBuildingsCmsPageMainView.prototype.getSidebarWrapperElement = function() {
	return this.getRoot().find("#buildingcreator_planner_sidebar_wrapper");
};

/**
 * @return {Object}
 */
BuildingcreatorBuildingsCmsPageMainView.prototype.getToolbarWrapperElement = function() {
	return this.getRoot().find("#buildingcreator_planner_content_toolbar_wrapper");
};

/**
 * @returns {Object}
 */
BuildingcreatorBuildingsCmsPageMainView.prototype.getMenuWrapperElement = function() {
	return this.getRoot().find("#buildingcreator_menu_wrapper");
};

// ... ... /ELEMENT

// ... /GET

// ... DO

BuildingcreatorBuildingsCmsPageMainView.prototype.doBindEventHandler = function() {
	var context = this;

	// EVENTS

	// Add history event
	this.getView().getController().getEventHandler().registerListener(AddHistoryEvent.TYPE,
	/**
	 * @param {AddHistoryEvent}
	 *            event
	 */
	function(event) {
		context.handleHistory(event.getHistory());
	});

	// Maximized event
	this.getView().getController().getEventHandler().registerListener(MaximizedEvent.TYPE,
	/**
	 * @param {MaximizedEvent}
	 *            event
	 */
	function(event) {
		context.handleResize(!event.isMaximized());
	});

	// Resize event
	this.getView().getController().getEventHandler().registerListener(ResizeEvent.TYPE,
	/**
	 * @param {ResizeEvent}
	 *            event
	 */
	function(event) {
		context.handleResize();
	});

	// /EVENTS

	// Maxmize
	// this.getMaximizeElement().click(function() {
	// // if (!$(this).isDisabled())
	// // context.doMaximize();
	// context.getEventHandler().handle(new MaximizeEvent());
	// });

	this.getRoot().find(".test_ui").button().click(function(event) {
		event.preventDefault();
	});

};

BuildingcreatorBuildingsCmsPageMainView.prototype.handleResize = function(minimized) {
	var isMaximized = this.getView().isMaximized;
	var canvasWrapper = this.getCanvasWrapperElement();
	if (isMaximized) {
		var canvasHeight = $(window).height() - this.getCanvasWrapperElement().position().top - 10;
		canvasWrapper.css("height", canvasHeight);
		// var widthMax = this.getCanvasWrapperElement().width();
		// var widthMaxCanvas = Math.round($(document).width() -
		// this.getSidebarWrapperElement().width() - 75);
		// var heightMax = Math.round($(document).height() -
		// this.getRoot().position().top);
		//
		// // this.getRoot().css("width", widthMax);
		// canvas.parent().css("width", widthMaxCanvas).css("height",
		// heightMax);
		this.canvasPresenter.stage.resize();
		//
		// $(window).scrollTop(this.getRoot().position().top);
		// } else {
		// this.getController().removeLocalStorageVariable("max");
		//
		// this.getRoot().css("width", "");
		// canvas.parent().css("width", "").css("height", "");
		// this.canvasPresenter.stage.resize();
		this.getMaximizeElement().jqueryUiActive();
		// this.getMaximizeElement().prop("checked", true);
	} else if (minimized) {
		canvasWrapper.removeAttr("style");
		this.canvasPresenter.stage.resize();
		// canvasWrapper.show();
	}
};

// ... /DO

// ... HANDLE

BuildingcreatorBuildingsCmsPageMainView.prototype.handleHistory = function(history) {
	this.history.push(history);
};

// ... /HANDLE

// ... DRAW

/**
 * @param {Element}
 *            root
 */
BuildingcreatorBuildingsCmsPageMainView.prototype.draw = function(root) {
	AbstractPageMainView.prototype.draw.call(this, root);
	var context = this;

	// Draw presenters
	this.menuPresenter.draw(this.getMenuWrapperElement());
	this.toolbarPresenter.draw(this.getToolbarWrapperElement());
	this.sidebarPresenter.draw(this.getSidebarWrapperElement());
	this.canvasPresenter.draw(this.getCanvasWrapperElement());

	// Maxmimize
	this.getMaximizeElement().button({
		icons : {
			primary : "maximize"
		},
		text : false
	}).click(function() {
		context.getEventHandler().handle(new MaximizeEvent());
	});

	// Maximized
	if (this.getView().isMaximized) {
		this.handleResize();
	}
};

// ... /DRAW

// /FUNCTIONS
