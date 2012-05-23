// CONSTRUCTOR
FacilitiesCmsCampusguideMainController.prototype = new CmsCampusguideMainController();

function FacilitiesCmsCampusguideMainController(eventHandler, mode, query) {
	CmsCampusguideMainController.apply(this, arguments);
	this.facilityDao = new FacilityStandardCampusguideDao(mode);
	this.buildingDao = new BuildingStandardCampusguideDao(mode);
};

// /CONSTRUCTOR

// VARIABLES

// /VARIABLES

// FUNCTIONS

// ... GET

/**
 * @return {FacilitiesCmsCampusguideMainView}
 */
FacilitiesCmsCampusguideMainController.prototype.getView = function() {
	return CmsCampusguideMainController.prototype.getView.call(this);
};

/**
 * @return {FacilityStandardCampusguideDao}
 */
FacilitiesCmsCampusguideMainController.prototype.getFacilityDao = function() {
	return this.facilityDao;
};

/**
 * @return {BuildingStandardCampusguideDao}
 */
FacilitiesCmsCampusguideMainController.prototype.getBuildingDao = function() {
	return this.buildingDao;
};

// ... /GET

// ... DO

FacilitiesCmsCampusguideMainController.prototype.doBindEventHandler = function() {
	CmsCampusguideMainController.prototype.doBindEventHandler.call(this);
	var context = this;




};

// ... /DO

// ... RENDER

/**
 * @param {FacilitiesCmsCampusguideMainView}
 *            view
 */
FacilitiesCmsCampusguideMainController.prototype.render = function(view) {
	CmsCampusguideMainController.prototype.render.call(this, view);
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
