// CONSTRUCTOR
ViewBuildingBuildingsCmsCanvasPresenterView.prototype = new BuildingCanvasPresenterView();

function ViewBuildingBuildingsCmsCanvasPresenterView(view) {
	BuildingCanvasPresenterView.apply(this, arguments);
	
	this.levelAnimate = true;
};

// VARIABLES

// /VARIABLES

// FUNCTIONS

// ... GET

/**
 * @return {BuildingsCmsMainController}
 */
ViewBuildingBuildingsCmsCanvasPresenterView.prototype.getController = function()
{
	return BuildingCanvasPresenterView.prototype.getController.call(this);
};

/**
 * @return {DaoContainer}
 */
ViewBuildingBuildingsCmsCanvasPresenterView.prototype.getDaoContainer = function()
{
	return this.getController().getDaoContainer();
};

// ... ... LIST ADAPTER

/**
 * @returns {ListAdapter}
 */
ViewBuildingBuildingsCmsCanvasPresenterView.prototype.getBuildingList = function()
{
	return this.getDaoContainer().getBuildingDao().getListAdapter();
};

/**
 * @returns {ListAdapter}
 */
ViewBuildingBuildingsCmsCanvasPresenterView.prototype.getBuildingFloorList = function()
{
	return this.getDaoContainer().getFloorBuildingDao().getListAdapter();
};

/**
 * @returns {ListAdapter}
 */
ViewBuildingBuildingsCmsCanvasPresenterView.prototype.getBuildingElementList = function()
{
	return this.getDaoContainer().getElementBuildingDao().getListAdapter();
};

/**
 * @returns {ListAdapter}
 */
ViewBuildingBuildingsCmsCanvasPresenterView.prototype.getBuildingNavigationList = function()
{
	return this.getDaoContainer().getNavigationBuildingDao().getListAdapter();
};

// ... ... /LIST ADAPTER

// ... ... CANVAS

/**
 * @return {Object}
 */
ViewBuildingBuildingsCmsCanvasPresenterView.prototype.getCanvasContentElement = function() {
    return this.getRoot().find("#canvas_content_wrapper");
};

/**
 * @return {Object}
 */
ViewBuildingBuildingsCmsCanvasPresenterView.prototype.getCanvasLoaderElement = function() {
    return this.getRoot().find("#canvas_loader_wrapper");
};

// ... ... /CANVAS

// ... /GET

// ... DO

ViewBuildingBuildingsCmsCanvasPresenterView.prototype.doBindEventHandler = function() {
	BuildingCanvasPresenterView.prototype.doBindEventHandler.call(this);
    var context = this;
};

// ... /DO

// ... DRAW

ViewBuildingBuildingsCmsCanvasPresenterView.prototype.draw = function(root) {
	BuildingCanvasPresenterView.prototype.draw.call(this, root);
    var context = this;
};

// ... /DRAW

// /FUNCTIONS