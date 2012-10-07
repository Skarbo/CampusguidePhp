// CONSTRUCTOR
FacilitiesCmsMainController.prototype = new CmsMainController();

function FacilitiesCmsMainController(eventHandler, mode, query) {
	CmsMainController.apply(this, arguments);
	this.facilityDao = new FacilityStandardDao(mode);
	this.buildingDao = new BuildingStandardDao(mode);
};

// /CONSTRUCTOR

// VARIABLES

// /VARIABLES

// FUNCTIONS

// ... GET

/**
 * @return {FacilitiesCmsMainView}
 */
FacilitiesCmsMainController.prototype.getView = function() {
	return CmsMainController.prototype.getView.call(this);
};

/**
 * @return {FacilityStandardDao}
 */
FacilitiesCmsMainController.prototype.getFacilityDao = function() {
	return this.facilityDao;
};

/**
 * @return {BuildingStandardDao}
 */
FacilitiesCmsMainController.prototype.getBuildingDao = function() {
	return this.buildingDao;
};

// ... /GET

// ... DO

FacilitiesCmsMainController.prototype.doBindEventHandler = function() {
	CmsMainController.prototype.doBindEventHandler.call(this);
	var context = this;




};

// ... /DO

// ... RENDER

/**
 * @param {FacilitiesCmsMainView}
 *            view
 */
FacilitiesCmsMainController.prototype.render = function(view) {
	CmsMainController.prototype.render.call(this, view);
	var context = this;

	if (this.getQuery().page == "facility" && this.getQuery().action == "view") {
		var faciltyId = this.getQuery().id;
		this.getBuildingDao().getForeign(faciltyId, function(list){
			context.getEventHandler().handle(new BuildingsRetrievedEvent(list));
		}, true);
	}
};

// ... /RENDER

// /FUNCTIONS
