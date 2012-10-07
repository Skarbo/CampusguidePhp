// CONSTRUCTOR
BuildingcreatorBuildingCmsPageMainView.prototype = new PageMainView();

function BuildingcreatorBuildingCmsPageMainView(view) {
	PageMainView.apply(this, arguments);

	this.menuPresenter = new MenuBuildingcreatorCmsPresenterView(this);
	this.sidebarPresenter = new SidebarBuildingcreatorCmsPresenterView(this);
	this.toolbarPresenter = new ToolbarBuildingcreatorCmsPresenterView(this);
	this.canvasPresenter = new BuildingcreatorCmsCanvasPresenterView(this);
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
BuildingcreatorBuildingCmsPageMainView.prototype.getView = function() {
	return PageMainView.prototype.getView.call(this);
};

// ... ... OBJECTS

/**
 * @returns {Object}
 */
BuildingcreatorBuildingCmsPageMainView.prototype.getBuilding = function() {
	return this.getController().building;
};

/**
 * @returns {Object}
 */
BuildingcreatorBuildingCmsPageMainView.prototype.getFloors = function() {
	return this.getController().floors;
};

/**
 * @returns {Object}
 */
BuildingcreatorBuildingCmsPageMainView.prototype.getElements = function() {
	return this.getController().elements;
};

// ... ... /OBJECTS

// ... ... ELEMENT

/**
 * @return {Object}
 */
BuildingcreatorBuildingCmsPageMainView.prototype.getMaximizeElement = function() {
	return this.getRoot().find("#maximize");
};

/**
 * @return {Object}
 */
BuildingcreatorBuildingCmsPageMainView.prototype.getCanvasWrapperElement = function() {
	return this.getRoot().find("#buildingcreator_planner_content_canvas_wrapper");
};

/**
 * @return {Object}
 */
BuildingcreatorBuildingCmsPageMainView.prototype.getSidebarWrapperElement = function() {
	return this.getRoot().find("#buildingcreator_planner_sidebar_wrapper");
};

/**
 * @return {Object}
 */
BuildingcreatorBuildingCmsPageMainView.prototype.getToolbarWrapperElement = function() {
	return this.getRoot().find("#buildingcreator_planner_content_toolbar_wrapper");
};

/**
 * @returns {Object}
 */
BuildingcreatorBuildingCmsPageMainView.prototype.getMenuWrapperElement = function() {
	return this.getRoot().find("#buildingcreator_menu_wrapper");
};

// ... ... /ELEMENT

// ... /GET

// ... DO

BuildingcreatorBuildingCmsPageMainView.prototype.doBindEventHandler = function() {
	var context = this;

	// Maxmize
	this.getMaximizeElement().click(function() {
		if (!$(this).isDisabled())
			context.doMaximize();
	});

};

BuildingcreatorBuildingCmsPageMainView.prototype.doMaximize = function() {
	var maxmized = !this.getRoot().hasClass("maximized");

	var canvas = this.canvasPresenter.getCanvasContentElement();
	if (maxmized) {
		this.getController().setLocalStorageVariable("max", "true");

		var widthMax = Math.round($(document).width() - 75);
		var widthMaxCanvas = Math.round($(document).width() - this.getSidebarWrapperElement().width() - 75);
		var heightMax = Math.round($(document).height() - this.getRoot().position().top);

		this.getRoot().css("width", widthMax);
		canvas.parent().css("width", widthMaxCanvas).css("height", heightMax);
		this.canvasPresenter.stage.resize();

		$(window).scrollTop(this.getRoot().position().top);
	} else {
		this.getController().removeLocalStorageVariable("max");

		this.getRoot().css("width", "");
		canvas.parent().css("width", "").css("height", "");
		this.canvasPresenter.stage.resize();
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
BuildingcreatorBuildingCmsPageMainView.prototype.draw = function(root) {
	PageMainView.prototype.draw.call(this, root);
	var context = this;

	// Draw presenters
	this.menuPresenter.draw(this.getMenuWrapperElement());
	this.toolbarPresenter.draw(this.getToolbarWrapperElement());
	this.sidebarPresenter.draw(this.getSidebarWrapperElement());
	this.canvasPresenter.draw(this.getCanvasWrapperElement());

	// Maxmimize
	if (this.getController().getLocalStorageVariable("max")) {
		setTimeout(function() {
			context.getMaximizeElement().click();
		}, 200); // Because of the GUI i had to add an delay
	}
};

// ... /DRAW

// /FUNCTIONS
