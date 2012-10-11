// CONSTRUCTOR
AdminCmsMainController.prototype = new CmsMainController();

function AdminCmsMainController(eventHandler, mode, query) {
	CmsMainController.apply(this, arguments);
};

// /CONSTRUCTOR

// VARIABLES

// /VARIABLES

// FUNCTIONS

// ... RENDER

/**
 * @param {FacilitiesCmsMainView}
 *            view
 */
AdminCmsMainController.prototype.render = function(view) {
	CmsMainController.prototype.render.call(this, view);

	if (this.getQuery().page == "queues" && this.getQuery().action == "new") {
		var facilityInput = $("input[name=select_facility]");

		if (facilityInput.val()) {
			this.doFacilitiesRetrieve();
		}
	}
};

// ... /RENDER

AdminCmsMainController.prototype.doBuildingsRetrieve = function(facilityId) {
	if (!facilityId)
		return;
	var context = this;
	this.getDaoContainer().getBuildingDao().getForeign(facilityId, function(list) {
		context.getEventHandler().handle(new BuildingsRetrievedEvent(list));
	});
};

AdminCmsMainController.prototype.doFloorsRetrieve = function(buildingId) {
	if (!buildingId)
		return;
	var context = this;
	this.getDaoContainer().getFloorBuildingDao().getForeign(buildingId, function(list) {
		context.getEventHandler().handle(new FloorsBuildingRetrievedEvent(list));
	});
};

// /FUNCTIONS
