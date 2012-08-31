// CONSTRUCTOR
BuildingcreatorBuildingCmsCampusguidePageMainView.prototype = new PageMainView();

function BuildingcreatorBuildingCmsCampusguidePageMainView(view) {
	PageMainView.apply(this, arguments);
};

// /CONSTRUCTOR

// VARIABLES

// /VARIABLES

// FUNCTIONS

// ... GET

/**
 * @return {BuildingsCmsCampusguideMainView}
 */
BuildingcreatorBuildingCmsCampusguidePageMainView.prototype.getView = function() {
	return PageMainView.prototype.getView.call(this);
};

/**
 * @return {Object}
 */
BuildingcreatorBuildingCmsCampusguidePageMainView.prototype.getFloorsSidebar = function() {
	return this.getRoot().find(".sidebar[data-sidebar=floors]");
};

/**
 * @return {Object}
 */
BuildingcreatorBuildingCmsCampusguidePageMainView.prototype.getFloorsTable = function() {
	return this.getFloorsSidebar().find(".table.floors");
};

/**
 * @return {Object}
 */
BuildingcreatorBuildingCmsCampusguidePageMainView.prototype.getFloorsButtons = function() {
	return this.getFloorsSidebar().find(".floor_buttons");
};

/**
 * @return {Object}
 */
BuildingcreatorBuildingCmsCampusguidePageMainView.prototype.getFloorsForm = function() {
	return this.getFloorsSidebar().find("form.floors_form");
};

/**
 * @return {Object}
 */
BuildingcreatorBuildingCmsCampusguidePageMainView.prototype.getFloorsError = function() {
	return this.getFloorsSidebar().find("#floors_error");
};

// ... /GET

// ... DO

BuildingcreatorBuildingCmsCampusguidePageMainView.prototype.doBindEventHandler = function() {
	var context = this;

	// SIDEBAR

	// ... FLOORS
	
	var floorsTable = this.getFloorsTable();
	var floorsTableRow = floorsTable.find(".row.floor");
	var floorsButtons = this.getFloorsButtons();

	floorsTableRow.dblclick({
		table : floorsTable
	}, function(event) {
		context.doFloorsEdit(true);
	});

	floorsButtons.find("#floors_cancel").click(function(event) {
		if (!$(this).isDisabled()) {
			$(this).closest("form").each(function() {
				this.reset();
			});
			context.doFloorsEdit(false);
		}
	});

	floorsButtons.find("#floors_apply").click(function(event) {
		if (!$(this).isDisabled()) {
			context.doFloorsSave();
		}
	});

	floorsTableRow.find(".order_edit .up, .order_edit .down").click(function(event) {
		context.doFloorsOrder($(this).closest(".floor"), $(this).hasClass("up"));
	});
	
	// ... /FLOORS

	// /SIDEBAR

};

BuildingcreatorBuildingCmsCampusguidePageMainView.prototype.doFloorsEdit = function(edit) {
	var floorsTable = this.getFloorsTable();
	var floorsButtons = this.getFloorsButtons();

	if (edit) {
		// Set floors table
		floorsTable.addClass("edit");

		// Floors buttons
		floorsButtons.enable();
	} else {
		// Set floors table
		floorsTable.removeClass("edit");

		// Floors buttons
		floorsButtons.disable();
	}

};

BuildingcreatorBuildingCmsCampusguidePageMainView.prototype.doFloorsOrder = function(row, up) {
	// Get floor order
	var orderInput = row.find(".order_edit input");
	var order = orderInput.val(); 

	// Get move row
	varMove = up ? row.prev() : row.next();

	// Move row
	if (varMove.length > 0) {
		var orderNewInput = varMove.find(".order_edit input");
		orderInput.val(orderNewInput.val());
		orderNewInput.val(order);
		if (up) {
			row.insertBefore(varMove);
		} else {
			row.insertAfter(varMove);
		}
	}

};

BuildingcreatorBuildingCmsCampusguidePageMainView.prototype.doFloorsSave = function() {
	var floorsTable = this.getFloorsTable();
	var floorsForm = this.getFloorsForm();
	var floorsError = this.getFloorsError();
	
	// Hide floors error
	floorsError.hide();
	
	// For each floor
	var floor, floorName, floorMap, floorOrder, floorMain, error = "";
	floorsTable.find(".floor").each(function(i, element){
		floor = $(element);
		
		floorId = floor.attr("data-floor");
		floorName = floor.find(".name_edit input").inputHint("value");
		floorMap = floor.find(".map_edit input").val();
		floorOrder = floor.find(".order_edit input").val();
		floorMain = floor.find(".main_edit input").is(":checked");
		
		console.log("Floor", floorId, floorName, floorMap, floorOrder, floorMain);
		
		if (!floorName)
		{
			error = "Floor name must be given"; 
		}
		else if (floorId == "new" && !floorMap)
		{
			error = "Floor map must be given to new floor";
		}
		if (error){
			return false;
		}
	});
	
	if (error)
	{
		console.log(error);
		floorsError.show();
		floorsError.text(error);
	}
};

// ... /DO

/**
 * @param {Element}
 *            root
 */
BuildingcreatorBuildingCmsCampusguidePageMainView.prototype.draw = function(root) {
	PageMainView.prototype.draw.call(this, root);

	// Bind
	this.doBindEventHandler();

};

// /FUNCTIONS
