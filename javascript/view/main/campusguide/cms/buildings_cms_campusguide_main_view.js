// CONSTRUCTOR
BuildingsCmsCampusguideMainView.prototype = new CmsCampusguideMainView();

/**
 * @param {string}
 *            wrapperId Wrapper id
 */
function BuildingsCmsCampusguideMainView(wrapperId) {
	CmsCampusguideMainView.apply(this, arguments);
	this.map = null;
	this.geocoder = null;
	this.marker = null;
	this.markerResult = null;
	this.floorplannerPage = new FloorplannerBuildingCmsCampusguidePageMainView(this);
	this.buildingPage = new BuildingCmsCampusguidePageMainView(this);
};

// /CONSTRUCTOR

// VARIABLES

// /VARIABLES

// FUNCTIONS

// ... GET

/**
 * @returns {BuildingsCmsCampusguideMainController}
 */
BuildingsCmsCampusguideMainView.prototype.getController = function() {
	return CmsCampusguideMainView.prototype.getController.call(this);
};

/**
 * @returns {FloorplannerBuildingCmsCampusguidePageMainView}
 */
BuildingsCmsCampusguideMainView.prototype.getFloorplannerPage = function() {
	return this.floorplannerPage;
};

/**
 * @returns {BuildingCmsCampusguidePageMainView}
 */
BuildingsCmsCampusguideMainView.prototype.getBuildingPage = function() {
	return this.buildingPage;
};

// ... /GET

// ... DO

BuildingsCmsCampusguideMainView.prototype.doBindEventHandler = function() {
	CmsCampusguideMainView.prototype.doBindEventHandler.call(this);
};

// ... /DO

BuildingsCmsCampusguideMainView.prototype.before = function() {
	CmsCampusguideMainView.prototype.before.call(this);
};

BuildingsCmsCampusguideMainView.prototype.after = function() {
	CmsCampusguideMainView.prototype.after.call(this);
};

/**
 * @param {CampusguideMainController}
 *            controller
 */
BuildingsCmsCampusguideMainView.prototype.draw = function(controller) {
	CmsCampusguideMainView.prototype.draw.call(this, controller);

	// Do Floorplanner
	if (this.getController().getQuery().page == "floorplanner" && this.getController().getQuery().id) {
		this.getFloorplannerPage().draw(this.getWrapperElement().find("#floorplanner_page_wrapper"));
	}
	// Do building
	else if (this.getController().getQuery().page == "building") {
		this.getBuildingPage().draw(this.getWrapperElement().find("#building_page_wrapper"));
	}

	$(".gui").gui();
};

// /FUNCTIONS
