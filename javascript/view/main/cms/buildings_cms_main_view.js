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
	this.buildingPage = new BuildingBuildingsCmsPageMainView(this);
	this.buildingcreatorPage = null;
	if (typeof BuildingcreatorBuildingsCmsPageMainView !== "undefined")
		this.buildingcreatorPage = new BuildingcreatorBuildingsCmsPageMainView(this);
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
	
	// Do Building
	if (this.getController().getQuery().page == "building") {
		this.buildingPage.draw(this.getWrapperElement().find("#building_page_wrapper"));
	}
	// Do Buildingcreator
	else if (this.buildingcreatorPage && this.getController().getQuery().page == "buildingcreator")
	{
		this.buildingcreatorPage.draw(this.getWrapperElement().find("#buildingcreator_page_wrapper"));
	}
};

// /FUNCTIONS
