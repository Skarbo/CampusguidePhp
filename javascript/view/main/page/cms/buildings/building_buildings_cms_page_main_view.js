// CONSTRUCTOR
BuildingBuildingsCmsPageMainView.prototype = new AbstractPageMainView();

function BuildingBuildingsCmsPageMainView(view) {
	AbstractPageMainView.apply(this, arguments);
	this.adminPage = new AdminBuildingBuildingsCmsPageMainView(this);
	this.viewPage = new ViewBuildingBuildingsCmsPageMainView(this);
};

// /CONSTRUCTOR

// VARIABLES

// /VARIABLES

// FUNCTIONS

// ... GET

/**
 * @return {BuildingsCmsMainView}
 */
BuildingBuildingsCmsPageMainView.prototype.getView = function() {
	return AbstractPageMainView.prototype.getView.call(this);
};

// ... /GET

// ... DO

BuildingBuildingsCmsPageMainView.prototype.doBindEventHandler = function() {
	AbstractPageMainView.prototype.doBindEventHandler.call(this);
};

// ... /DO

/**
 * @param {Element}
 *            root
 */
BuildingBuildingsCmsPageMainView.prototype.draw = function(root) {
	AbstractPageMainView.prototype.draw.call(this, root);

	if (this.getController().getQuery().action == "edit" || this.getController().getQuery().action == "new") {
		this.adminPage.draw(this.getRoot().find("#admin_building_page_wrapper"));
	}
	else if (this.getController().getQuery().action == "view") {
		this.viewPage.draw(this.getRoot().find("#view_building_buildings_wrapper"));
	}	
};

// /FUNCTIONS
