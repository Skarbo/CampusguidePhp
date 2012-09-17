// CONSTRUCTOR
BuildingcreatorBuildingCmsCampusguidePageMainView.prototype = new PageMainView();

function BuildingcreatorBuildingCmsCampusguidePageMainView(view) {
	PageMainView.apply(this, arguments);
	this.stage = null;
	this.layers = {
		floors : {},
		floors_map : {},
		elements : {}
	};
	this.groups = {
		floors : {},
		floors_map : {},
		elements : {}
	};
	this.polygons = {
		floors : {},
		elements : {}
	};
	this.building = null;
	this.elements = {};
	this.floors = null;
	this.floorSelected = false;
	this.floorMapShow = true;
	this.stageIsDragging = false;
	this.polygonsIsDraggable = false;
	this.selected = {
		type : null,
		element : null
	};
	this.selectedCopy = this.selected;
	this.scale = 1.0;
	this.stagePosition = {
		x : 0,
		y : 0
	};
	this.menu = BuildingcreatorBuildingCmsCampusguidePageMainView.MENU_FLOORS;
	this.toolbar = null;
	this.retrieved = 0;

	this.menuPresenter = new MenuBuildingcreatorCmsCampusguidePresenterView(this);
	this.sidebarPresenter = new SidebarBuildingcreatorCmsCampusguidePresenterView(this);
	this.toolbarPresenter = new ToolbarBuildingcreatorCmsCampusguidePresenterView(this);
	this.canvasPresenter = new BuildingcreatorCmsCanvasCampusguidePresenterView(this);
};

// /CONSTRUCTOR

// VARIABLES

// /VARIABLES

// CLASS

// /CLASS

// FUNCTIONS

// ... GET

/**
 * @return {BuildingsCmsCampusguideMainView}
 */
BuildingcreatorBuildingCmsCampusguidePageMainView.prototype.getView = function() {
	return PageMainView.prototype.getView.call(this);
};

// ... ... OBJECTS

/**
 * @returns {Object}
 */
BuildingcreatorBuildingCmsCampusguidePageMainView.prototype.getBuilding = function() {
	return this.getController().building;
};

/**
 * @returns {Object}
 */
BuildingcreatorBuildingCmsCampusguidePageMainView.prototype.getFloors = function() {
	return this.getController().floors;
};

/**
 * @returns {Object}
 */
BuildingcreatorBuildingCmsCampusguidePageMainView.prototype.getElements = function() {
	return this.getController().elements;
};

// ... ... /OBJECTS

// ... ... ELEMENT

/**
 * @return {Object}
 */
BuildingcreatorBuildingCmsCampusguidePageMainView.prototype.getMaximizeElement = function() {
	return this.getRoot().find("#maximize");
};

/**
 * @return {Object}
 */
BuildingcreatorBuildingCmsCampusguidePageMainView.prototype.getCanvasWrapperElement = function() {
	return this.getRoot().find("#buildingcreator_planner_content_canvas_wrapper");
};

/**
 * @return {Object}
 */
BuildingcreatorBuildingCmsCampusguidePageMainView.prototype.getSidebarWrapperElement = function() {
	return this.getRoot().find("#buildingcreator_planner_sidebar_wrapper");
};

/**
 * @return {Object}
 */
BuildingcreatorBuildingCmsCampusguidePageMainView.prototype.getToolbarWrapperElement = function() {
	return this.getRoot().find("#buildingcreator_planner_content_toolbar_wrapper");
};

/**
 * @returns {Object}
 */
BuildingcreatorBuildingCmsCampusguidePageMainView.prototype.getMenuWrapperElement = function() {
	return this.getRoot().find("#buildingcreator_menu_wrapper");
};

// ... ... /ELEMENT

// ... /GET

// ... DO

BuildingcreatorBuildingCmsCampusguidePageMainView.prototype.doBindEventHandler = function() {
	var context = this;

	// Maxmize
	this.getMaximizeElement().click(function() {
		if (!$(this).isDisabled())
			context.doMaximize();
	});

};

BuildingcreatorBuildingCmsCampusguidePageMainView.prototype.doMaximize = function() {
	var maxmized = !this.getRoot().hasClass("maximized");

	var canvas = this.getCanvasContentElement();
	if (maxmized) {
		this.getController().setLocalStorageVariable("maximized", "true");

		var widthMax = Math.round($(document).width() - 75);
		var widthMaxCanvas = Math.round($(document).width() - this.getSidebarWrapperElement().width() - 75);
		var heightMax = Math.round($(document).height() - this.getRoot().position().top);

		this.getRoot().css("width", widthMax);
		canvas.parent().css("width", widthMaxCanvas).css("height", heightMax);
		this.stage.resize();

		$(window).scrollTop(this.getRoot().position().top);
	} else {
		this.getController().removeLocalStorageVariable("scale");

		this.getRoot().css("width", "");
		canvas.parent().css("width", "").css("height", "");
		this.stage.resize();
	}

	if (maxmized)
		this.getRoot().addClass("maximized");
	else
		this.getRoot().removeClass("maximized");
};

// ... /DO

// ... DRAW

/**
 * @param {Element}
 *            root
 */
BuildingcreatorBuildingCmsCampusguidePageMainView.prototype.draw = function(root) {
	PageMainView.prototype.draw.call(this, root);
	var context = this;

	// Bind
	this.doBindEventHandler();

	// Draw presenters
	this.menuPresenter.draw(this.getMenuWrapperElement());
	this.toolbarPresenter.draw(this.getToolbarWrapperElement());
	this.sidebarPresenter.draw(this.getSidebarWrapperElement());
	this.canvasPresenter.draw(this.getCanvasWrapperElement());

	// Maxmimize
	if (this.getController().getLocalStorageVariable("maxmized")) {
		setTimeout(function() {
			context.getMaximizeElement().click();
		}, 200); // Because of the GUI i had to add an delay
	}
};

// ... /DRAW

// /FUNCTIONS
