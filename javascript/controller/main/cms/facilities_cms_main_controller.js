// CONSTRUCTOR
FacilitiesCmsMainController.prototype = new CmsMainController();

function FacilitiesCmsMainController(eventHandler, mode, query) {
	CmsMainController.apply(this, arguments);
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
		this.getDaoContainer().getBuildingDao().getForeign(faciltyId, function(list){
			context.getEventHandler().handle(new BuildingsRetrievedEvent(list));
		}, true);
	}
};

// ... /RENDER

// /FUNCTIONS
