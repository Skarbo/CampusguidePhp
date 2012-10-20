// CONSTRUCTOR
BuildingsCmsMainView.prototype = new CmsMainView();

/**
 * @param {string}
 *            wrapperId Wrapper id
 */
function BuildingsCmsMainView(wrapperId) {
	CmsMainView.apply(this, arguments);
	this.map = null;
	this.geocoder = null;
	this.marker = null;
	this.markerResult = null;
	this.floorplannerPage = null;
	this.buildingcreatorPage = null;
	this.buildingPage = new BuildingCmsPageMainView(this);
	if (typeof FloorplannerBuildingCmsPageMainView !== "undefined")
		this.floorplannerPage = new FloorplannerBuildingCmsPageMainView(this);
	if (typeof BuildingcreatorBuildingCmsPageMainView !== "undefined")
		this.buildingcreatorPage = new BuildingcreatorBuildingCmsPageMainView(this);
};

// /CONSTRUCTOR

// VARIABLES

// /VARIABLES

// FUNCTIONS

// ... GET

/**
 * @returns {BuildingsCmsMainController}
 */
BuildingsCmsMainView.prototype.getController = function() {
	return CmsMainView.prototype.getController.call(this);
};

/**
 * @returns {FloorplannerBuildingCmsPageMainView}
 */
BuildingsCmsMainView.prototype.getFloorplannerPage = function() {
	return this.floorplannerPage;
};

/**
 * @returns {BuildingcreatorBuildingCmsPageMainView}
 */
BuildingsCmsMainView.prototype.getBuildingcreatorPage = function() {
	return this.buildingcreatorPage;
};

/**
 * @returns {BuildingCmsPageMainView}
 */
BuildingsCmsMainView.prototype.getBuildingPage = function() {
	return this.buildingPage;
};

// ... /GET

// ... DO

BuildingsCmsMainView.prototype.doBindEventHandler = function() {
	CmsMainView.prototype.doBindEventHandler.call(this);
};

// ... /DO

BuildingsCmsMainView.prototype.before = function() {
	CmsMainView.prototype.before.call(this);
};

BuildingsCmsMainView.prototype.after = function() {
	CmsMainView.prototype.after.call(this);
};

/**
 * @param {MainController}
 *            controller
 */
BuildingsCmsMainView.prototype.draw = function(controller) {
	CmsMainView.prototype.draw.call(this, controller);

	$(".gui").gui();

	// Do Floorplanner
	if (this.getController().getQuery().page == "floorplanner" && this.getController().getQuery().id) {
		this.getFloorplannerPage().draw(this.getWrapperElement().find("#floorplanner_page_wrapper"));
	}
	// Do Buildingcreator
	else if (this.getController().getQuery().page == "buildingcreator" && this.getController().getQuery().id) {
		this.getBuildingcreatorPage().draw(this.getWrapperElement().find("#buildingcreator_page_wrapper"));
	}
	// Do building
	else if (this.getController().getQuery().page == "building") {
		this.getBuildingPage().draw(this.getWrapperElement().find("#building_page_wrapper"));
	}
};

// /FUNCTIONS
