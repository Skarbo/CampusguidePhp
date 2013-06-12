// CONSTRUCTOR
SidebarBuildingcreatorBuildingsCmsPresenterView.prototype = new AbstractPresenterView();

function SidebarBuildingcreatorBuildingsCmsPresenterView(view) {
	AbstractPresenterView.apply(this, arguments);
	// this.roomsElementsPresenter = new
	// RoomsElementsSidebarBuildingcreatorBuildingsCmsPresenterView(this);
	// this.devicesElementsPresenter = new
	// DevicesElementsSidebarBuildingcreatorBuildingsCmsPresenterView(this);
	this.elementsPresenter = new ElementsSidebarBuildingcreatorBuildingsCmsPresenterView(this);
};

// VARIABLES

// /VARIABLES

// FUNCTIONS

// ... GET

/**
 * @return {Object}
 */
SidebarBuildingcreatorBuildingsCmsPresenterView.prototype.getSidebarsWrapperElement = function() {
	return this.getRoot().find("#sidebars");
};

/**
 * @return {Object}
 */
SidebarBuildingcreatorBuildingsCmsPresenterView.prototype.getSidebarElement = function() {
	return this.getRoot().find(".sidebar");
};

/**
 * @return {Object}
 */
SidebarBuildingcreatorBuildingsCmsPresenterView.prototype.getSidebarHeaderElement = function() {
	return this.getSidebarElement().find(".sidebar_header_wrapper");
};

// ... ... FLOORS

/**
 * @return {Object}
 */
SidebarBuildingcreatorBuildingsCmsPresenterView.prototype.getSidebarFloorsElement = function() {
	return this.getSidebarElement().filter("[data-sidebar=floors]");
};

/**
 * @return {Object}
 */
SidebarBuildingcreatorBuildingsCmsPresenterView.prototype.getSidebarFloorsTableElement = function() {
	return this.getSidebarFloorsElement().find("table.floors");
};

/**
 * @return {Object}
 */
SidebarBuildingcreatorBuildingsCmsPresenterView.prototype.getSidebarFloorsButtonsElement = function() {
	return this.getSidebarFloorsElement().find(".floor_buttons");
};

/**
 * @return {Object}
 */
SidebarBuildingcreatorBuildingsCmsPresenterView.prototype.getSidebarFloorsFormElement = function() {
	return this.getSidebarFloorsElement().find("form#floors_form");
};

/**
 * @return {Object}
 */
SidebarBuildingcreatorBuildingsCmsPresenterView.prototype.getSidebarFloorsErrorElement = function() {
	return this.getSidebarFloorsElement().find("#floors_error");
};

// ... ... /FLOORS

// ... ... ELEMENTS

// /**
// * @return {Object}
// */
// SidebarBuildingcreatorBuildingsCmsPresenterView.prototype.getRoomsElementsElement
// = function() {
// return this.getSidebarElement().filter("[data-sidebar=elements_rooms]");
// };
//
// /**
// * @return {Object}
// */
// SidebarBuildingcreatorBuildingsCmsPresenterView.prototype.getDevicesElementsElement
// = function() {
// return this.getSidebarElement().filter("[data-sidebar=elements_devices]");
// };

/**
 * @return {Object}
 */
SidebarBuildingcreatorBuildingsCmsPresenterView.prototype.getElementsSidebarGroup = function() {
	return this.getSidebarElement().filter("[data-sidebar-group=elements]");
};

// ... ... /ELEMENTS

// ... ... INFOPANEL

/**
 * @return {Object}
 */
SidebarBuildingcreatorBuildingsCmsPresenterView.prototype.getInfopanelWrapperElement = function() {
	return this.getRoot().find("#infopanel");
};

/**
 * @return {Object}
 */
SidebarBuildingcreatorBuildingsCmsPresenterView.prototype.getInfopanelHeaderWrapperElement = function() {
	return this.getInfopanelWrapperElement().find("#infopanel_header_wrapper");
};

// ... ... /INFOPANEL

// ... /GET

// ... DO

SidebarBuildingcreatorBuildingsCmsPresenterView.prototype.doBindEventHandler = function() {
	var context = this;

	// EVENTS

	// // Handle "SelectEvent" event
	// this.getView().getController().getEventHandler().registerListener(SelectCanvasEvent.TYPE,
	// /**
	// * @param {SelectCanvasEvent}
	// * event
	// */
	// function(event) {
	// context.handleSelect(event.getSelectType(), event.getElement());
	// });
	//
	// Handle "Menu" event
	this.getEventHandler().registerListener(MenuEvent.TYPE,
	/**
	 * @param {MenuEvent}
	 *            event
	 */
	function(event) {
		context.handleMenu(event.getMenu(), event.getSidebar());
	});

	// Handle "Floor select" event
	this.getEventHandler().registerListener(FloorSelectEvent.TYPE,
	/**
	 * @param {FloorSelectEvent}
	 *            event
	 */
	function(event) {
		context.handleFloorSelect(event.getFloorId());
	});
	//
	// // Edited event
	// this.getEventHandler().registerListener(EditedEvent.TYPE,
	// /**
	// * @param {EditedEvent}
	// * event
	// */
	// function(event) {
	// switch (event.getEditType()) {
	// case "element":
	// context.doElementSaved(event.getEdit());
	// break;
	// }
	// });
	//
	// // Deleted event
	// this.getEventHandler().registerListener(DeletedEvent.TYPE,
	// /**
	// * @param {DeletedEvent}
	// * event
	// */
	// function(event) {
	// context.handleDeleted(event.getDeleteType(), event.getDeleted());
	// });
	//
	// // Undid history event
	// this.getEventHandler().registerListener(UndidHistoryEvent.TYPE,
	// /**
	// * @param {UndidHistoryEvent}
	// * event
	// */
	// function(event) {
	// context.handleHistoryUndid(event.getHistory());
	// });

	// /EVENTS

	// Click sidebar
	this.getSidebarHeaderElement().click(function() {
		// Update hash
		context.getView().getController().updateHash({
			"sidebar" : $(this).parent().attr("data-sidebar")
		});
	});

	// FLOORS

	var floorsTable = this.getSidebarFloorsTableElement();
	var floorsTableRow = floorsTable.find("tbody");
	var floorsButtons = this.getSidebarFloorsButtonsElement();

	// Edit Floor
	floorsTableRow.dblclick({
		table : floorsTable
	}, function(event) {
		context.doFloorsEdit(true);
	});

	// Cancel Floor edit
	floorsButtons.find("#floors_cancel").click(function(event) {
		if (!$(this).isDisabled()) {
			context.doFloorsEdit(false);
		}
	});

	// Apply Floor edit
	floorsButtons.find("#floors_apply").click(function(event) {
		if (!$(this).isDisabled()) {
			context.doFloorsSave();
		}
	});

	// Order Floor
	floorsTableRow.find(".order .up, .order .down").click(function(event) {
		context.doFloorsOrder($(this).closest(".floor"), $(this).hasClass("up"));
	});

	// Select Floor
	floorsTableRow.find(".floor").click(function(event) {
		// Get Floor id
		var floorId = $(this).attr("data-floor");

		// Update hash
		context.getView().getController().updateHash({
			"floor" : floorId
		});
	});

	// /FLOORS

	// // ELEMENTS
	//
	// var elementsTableRows =
	// this.getSidebarElementsFloorsElement().find(".element");
	//
	// // Select element
	// elementsTableRows.click(function(event) {
	// // TODO Fix a way to access Canvas getElementPolygon
	// if (!this.polygon)
	// this.polygon =
	// context.getView().canvasPresenter.getElementPolygon($(this).attr("data-element"),
	// $(this).parent().attr("data-floor"));
	// if (this.polygon)
	// context.getEventHandler().handle(new SelectCanvasEvent("polygon",
	// this.polygon));
	// });
	//
	// // Edit element
	// elementsTableRows.dblclick(function(event) {
	// context.doElementEdit(true, $(this));
	// });
	//
	// // Save/cancel element
	// elementsTableRows.keyup(function(event) {
	// // Save
	// if (event.keyCode == 13) {
	// context.doElementSave($(this));
	// context.doElementEdit(false, $(this));
	// }
	// // Cancel
	// if (event.keyCode == 27) {
	// context.doElementEdit(false, $(this));
	// }
	// }).keydown(function(event) {
	// // Next Element
	// if (event.which == 9) {
	// context.doElementSave($(this));
	// context.doElementEdit(false, $(this));
	// var next = $(this).next();
	// if (next) {
	// event.preventDefault();
	// next.click();
	// context.doElementEdit(true, next);
	// }
	// }
	// });
	//
	// // /ELEMENTS
};

// ... ... FLOORS

SidebarBuildingcreatorBuildingsCmsPresenterView.prototype.doFloorsEdit = function(edit) {
	var floorsTable = this.getSidebarFloorsTableElement();
	var floorsButtons = this.getSidebarFloorsButtonsElement();
	var floorsError = this.getSidebarFloorsErrorElement();

	if (edit) {
		floorsTable.find(".edit").removeClass("hide");
		floorsTable.find(".show").addClass("hide");
		floorsButtons.enable().removeClass("hide");
	} else {
		floorsTable.find(".edit").addClass("hide");
		floorsTable.find(".show").removeClass("hide");
		floorsButtons.disable().addClass("hide");
		floorsError.hide();
	}
};

SidebarBuildingcreatorBuildingsCmsPresenterView.prototype.doFloorsOrder = function(row, up) {
	// Get floor order
	var orderInput = row.find(".order input");
	var order = orderInput.val();

	// Get move row
	varMove = up ? row.prev() : row.next();

	// Move row
	if (varMove.length > 0) {
		var orderNewInput = varMove.find(".order input");
		orderInput.val(orderNewInput.val());
		orderNewInput.val(order);
		if (up) {
			row.insertBefore(varMove);
		} else {
			row.insertAfter(varMove);
		}
	}

};

SidebarBuildingcreatorBuildingsCmsPresenterView.prototype.doFloorsSave = function() {
	var floorsTable = this.getSidebarFloorsTableElement();
	var floorsForm = this.getSidebarFloorsFormElement();
	var floorsError = this.getSidebarFloorsErrorElement();

	// Hide floors error
	floorsError.hide();

	// For each floor
	var floor, floorName, floorMap, error = "";
	floorsTable.find(".floor").each(function(i, element) {
		floor = $(element);

		floorId = floor.attr("data-floor");
		floorName = floor.find(".name input").val();
		floorMap = floor.find(".map input").val();
		if (floorId == "new" ? (floorMap && !floorName) : !floorName) {
			error = "Floor name must be given";
		} else if (floorId == "new" ? (floorName ? !floorMap : floorMap) : false) {
			error = "Floor map must be given to new floor";
		}

		if (error) {
			return false;
		}
	});

	if (error) {
		floorsError.text(error);
		floorsError.show();
	} else {
		floorsForm.submit();
	}
};

// ... ... /FLOORS

SidebarBuildingcreatorBuildingsCmsPresenterView.prototype.doInfopanelShow = function(element) {
	if (typeof element != "object")
		return console.error("SidebarBuildingcreatorBuildingsCmsPresenterView.doInfopanelShow: Element is not object", element);
	
	this.getInfopanelWrapperElement().find("#infopanel_header_wrapper .infopanel_header_name").html(element.name || $("<italic />", { text : "Element" }));
	this.getInfopanelWrapperElement().find(".info_panel_content_wrapper").removeClass("selected").hide();

	this.getSidebarsWrapperElement().slideUp();
	this.getInfopanelWrapperElement().slideDown();
	
	var infoPanelContents = this.getInfopanelWrapperElement().find(".info_panel_content_wrapper");

	infoPanelContents.find(".info_panel_content_content_wrapper").hide();
	infoPanelContents.filter("[data-infopanel=element_name]").show();	

	// ELEMENT NAME

	infoPanelContents.filter("[data-infopanel=element_name]").find(".element_name_wrapper input[name=element_id]").val(element.id);
	
	// Element name
	infoPanelContents.filter("[data-infopanel=element_name]").find(".info_panel_content_header_value").html("<h3>" + element.name + "</h3>");

	var elementNameTable = infoPanelContents.filter("[data-infopanel=element_name]").find(".element_name_wrapper .element_name_table");
	var elementNameInputWrapperTemplate = infoPanelContents.filter("[data-infopanel=element_name]").find(".element_name_wrapper .element_name_input_wrapper.template");
	var elementNameInputWrappers = infoPanelContents.filter("[data-infopanel=element_name]").find(".element_name_wrapper .element_name_input_wrapper:NOT(.template)");
	elementNameInputWrappers.remove();

	var elementNameInputWrapper = elementNameInputWrapperTemplate.clone().removeClass("template");
	elementNameTable.append(elementNameInputWrapper);
	elementNameInputWrapper.find("input[name=element_name]").val(element.name);
	if (element.data) {
		for ( var i in element.data.names) {
			elementNameInputWrapper = elementNameInputWrapperTemplate.clone().removeClass("template");
			elementNameTable.append(elementNameInputWrapper);
			elementNameInputWrapper.find("input[name=element_name]").val(element.data.names[i]);
		}
	}

	var bindRoomNameRemoveButton = function() {
		elementNameTable.unbind("click").click(function(event) {
			event.preventDefault();
			if (elementNameTable.find(".element_name_input_wrapper").length > 2) {
				$(event.target).closest(".element_name_input_wrapper").remove();
			} else {
				$(event.target).closest(".element_name_input_wrapper").find("input[name=element_name]").val("").focus();
			}
		});
	};
	bindRoomNameRemoveButton();

	infoPanelContents.filter("[data-infopanel=element_name]").find(".element_name_wrapper a.element_name_add").unbind("click").click(function(event) {
		event.preventDefault();
		var elementNameRow = elementNameInputWrapperTemplate.clone().removeClass("template");
		elementNameTable.append(elementNameRow);
		elementNameRow.find("input[name=element_name]").focus();
		bindRoomNameRemoveButton();
	});

	// /ELEMENT NAME
	
};

SidebarBuildingcreatorBuildingsCmsPresenterView.prototype.doSidebarsShow = function() {
	this.getSidebarsWrapperElement().slideDown();
	this.getInfopanelWrapperElement().slideUp();
};

// ... /DO

// ... HANDLE

SidebarBuildingcreatorBuildingsCmsPresenterView.prototype.handleSelect = function(type, element) {
	// De-select Element
	this.getSidebarElementsFloorsElement().find(".selected[data-element]").removeClass("selected");

	if (!type || !element) {
		return;
	}

	switch (type) {
	case "polygon":
		if (element.object.type == "element" && element.object.element) {
			this.getSidebarElementsFloorsElement().find("[data-element=" + element.object.element.id + "]").addClass("selected");
		}
		break;
	}

};

SidebarBuildingcreatorBuildingsCmsPresenterView.prototype.handleFloorSelect = function(floorId) {
	if (!floorId)
		return false;

	// Select Floor
	var floorRows = this.getSidebarFloorsTableElement().find("tbody tr");
	floorRows.removeClass("selected");
	floorRows.filter("[data-floor=" + floorId + "]").addClass("selected");
};

SidebarBuildingcreatorBuildingsCmsPresenterView.prototype.handleMenu = function(menu, sidebar) {
	sidebar = sidebar || null;
	menu = menu || "floors";
	var sidebarElements = this.getSidebarElement();
	sidebarElements.hide();

	var sidebarMenuElements = sidebarElements.filter("[data-sidebar-group~=" + menu + "]");
	sidebarMenuElements.show();
	// sidebarMenuElements.find(".sidebar_header_wrapper.collapse").addClass("collapsed");
	// sidebarMenuElements.filter(":NOT([data-sidebar=" + sidebar +
	// "])").find(".sidebar_content:visible").slideUp();

	var sidebarElement = sidebarMenuElements.filter("[data-sidebar=" + sidebar + "]");
	if (sidebarElement.length == 0)
		sidebarElement = sidebarMenuElements.filter("[data-sidebar]:first-child");
	if (sidebarElement.length > 0)
		sidebarElement.find(".sidebar_content").slideDown();

	sidebarMenuElements.filter(":NOT([data-sidebar=" + sidebarElement.attr("data-sidebar") + "])").find(".sidebar_content:visible").slideUp();
};

SidebarBuildingcreatorBuildingsCmsPresenterView.prototype.handleDeleted = function(type, deleted) {
	switch (type) {
	case "element":
		this.getSidebarElementsFloorsElement().find(".element[data-element=" + deleted + "]").addClass("deleted");
		break;
	}
};

SidebarBuildingcreatorBuildingsCmsPresenterView.prototype.handleHistoryUndid = function(history) {
	switch (history.type) {
	case "selected_delete":
		if (history.element.type == "polygon" && history.element.element.object.type == "element") {
			this.getSidebarElementsFloorsElement().find(".element[data-element=" + history.element.element.object.element.id + "]").removeClass("deleted");
		}
		break;
	}
};

// ... /HANDLE

SidebarBuildingcreatorBuildingsCmsPresenterView.prototype.draw = function(root) {
	AbstractPresenterView.prototype.draw.call(this, root);
	var context = this;

	if (!this.getController().getHash().menu)
		this.handleMenu();
	// this.getRoot().find(".element_type_dropdown").dropdownSelect();

	// this.roomsElementsPresenter.draw(this.getRoomsElementsElement());
	// this.devicesElementsPresenter.draw(this.getDevicesElementsElement());
	this.elementsPresenter.draw(this.getElementsSidebarGroup());

	// INFO PANEL

	this.getInfopanelHeaderWrapperElement().find("#infopanel_header_buttons_cancel").button().click(function(event) {
		event.preventDefault();
		context.doSidebarsShow();
	});
	this.getInfopanelHeaderWrapperElement().find("#infopanel_header_buttons_save").button();
	this.getInfopanelHeaderWrapperElement().find("#infopanel_header_buttons_save_next").button({
		text : false,
		icons : {
			primary : "ui-icon-triangle-1-e"
		}
	});

	this.getInfopanelWrapperElement().find(".info_panel_content_header_wrapper").click(function(event) {
		$(event.target).closest(".info_panel_content_wrapper").toggleClass("selected").find(".info_panel_content_content_wrapper").slideToggle();
	});

	// /INFO PANEL

};

// /FUNCTIONS
