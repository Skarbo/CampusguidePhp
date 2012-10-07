// CONSTRUCTOR
SidebarBuildingcreatorCmsPresenterView.prototype = new PresenterView();

function SidebarBuildingcreatorCmsPresenterView(view) {
	PresenterView.apply(this, arguments);
};

// VARIABLES

// /VARIABLES

// FUNCTIONS

// ... GET

/**
 * @return {Object}
 */
SidebarBuildingcreatorCmsPresenterView.prototype.getSidebarElement = function() {
	return this.getRoot().find(".sidebar");
};

/**
 * @return {Object}
 */
SidebarBuildingcreatorCmsPresenterView.prototype.getSidebarHeaderElement = function() {
	return this.getSidebarElement().find(".sidebar_header_wrapper");
};

// ... ... FLOORS

/**
 * @return {Object}
 */
SidebarBuildingcreatorCmsPresenterView.prototype.getSidebarFloorsElement = function() {
	return this.getSidebarElement().filter("[data-sidebar=floors]");
};

/**
 * @return {Object}
 */
SidebarBuildingcreatorCmsPresenterView.prototype.getSidebarFloorsTableElement = function() {
	return this.getSidebarFloorsElement().find("table.floors");
};

/**
 * @return {Object}
 */
SidebarBuildingcreatorCmsPresenterView.prototype.getSidebarFloorsButtonsElement = function() {
	return this.getSidebarFloorsElement().find(".floor_buttons");
};

/**
 * @return {Object}
 */
SidebarBuildingcreatorCmsPresenterView.prototype.getSidebarFloorsFormElement = function() {
	return this.getSidebarFloorsElement().find("form#floors_form");
};

/**
 * @return {Object}
 */
SidebarBuildingcreatorCmsPresenterView.prototype.getSidebarFloorsErrorElement = function() {
	return this.getSidebarFloorsElement().find("#floors_error");
};

/**
 * @return {Object}
 */
SidebarBuildingcreatorCmsPresenterView.prototype.getSidebarFloorsErrorElement = function() {
	return this.getSidebarFloorsElement().find("#show_map");
};

// ... ... /FLOORS

// ... ... ELEMENTS

/**
 * @return {Object}
 */
SidebarBuildingcreatorCmsPresenterView.prototype.getSidebarElementsElement = function() {
	return this.getSidebarElement().filter("[data-sidebar=elements]");
};

/**
 * @return {Object}
 */
SidebarBuildingcreatorCmsPresenterView.prototype.getSidebarElementsFloorsElement = function() {
	return this.getSidebarElementsElement().find("table.elements tbody[data-floor]");
};

/**
 * @return {Object}
 */
SidebarBuildingcreatorCmsPresenterView.prototype.getSidebarElementsDeleteElement = function() {
	return this.getSidebarElementsElement().find(".element .delete.edit .delete");
};
// ... ... /ELEMENTS

// ... /GET

// ... DO

SidebarBuildingcreatorCmsPresenterView.prototype.doBindEventHandler = function() {
	var context = this;

	// EVENTS

	// Handle "SelectEvent" event
	this.getView().getController().getEventHandler().registerListener(SelectEvent.TYPE,
	/**
	 * @param {SelectEvent}
	 *            event
	 */
	function(event) {
		context.handleSelect(event.getSelectType(), event.getElement());
	});

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

	// Edited event
	this.getEventHandler().registerListener(EditedEvent.TYPE,
	/**
	 * @param {EditedEvent}
	 *            event
	 */
	function(event) {
		switch (event.getEditType()) {
		case "element":
			context.doElementSaved(event.getEdit());
			break;
		}
	});

	// Deleted event
	this.getEventHandler().registerListener(DeletedEvent.TYPE,
	/**
	 * @param {DeletedEvent}
	 *            event
	 */
	function(event) {
		context.handleDeleted(event.getDeleteType(), event.getDeleted());
	});

	// Undid history event
	this.getEventHandler().registerListener(UndidHistoryEvent.TYPE,
	/**
	 * @param {UndidHistoryEvent}
	 *            event
	 */
	function(event) {
		context.handleHistoryUndid(event.getHistory());
	});

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
	var floorsTableRow = floorsTable.find("tbody.show tr.floor");
	var floorsTableEditRow = floorsTable.find("tbody.edit tr.floor");
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
	floorsTableEditRow.find(".order_edit .up, .order_edit .down").click(function(event) {
		context.doFloorsOrder($(this).closest(".floor"), $(this).hasClass("up"));
	});

	// Select Floor
	floorsTableRow.click(function(event) {
		// Get Floor id
		var floorId = $(this).attr("data-floor");

		// Update hash
		context.getView().getController().updateHash({
			"floor" : floorId
		});
	});

	// /FLOORS

	// ELEMENTS

	var elementsTableRows = this.getSidebarElementsFloorsElement().find(".element");

	// Select element
	elementsTableRows.click(function(event) {
		// TODO Fix a way to access Canvas getElementPolygon
		if (!this.polygon)
			this.polygon = context.getView().canvasPresenter.getElementPolygon($(this).attr("data-element"), $(this).parent().attr("data-floor"));
		if (this.polygon)
			context.getEventHandler().handle(new SelectEvent("polygon", this.polygon));
	});

	// Edit element
	elementsTableRows.dblclick(function(event) {
		context.doElementEdit(true, $(this));
	});

	// Save/cancel element
	elementsTableRows.keyup(function(event) {
		// Save
		if (event.keyCode == 13) {
			context.doElementSave($(this));
			context.doElementEdit(false, $(this));
		}
		// Cancel
		if (event.keyCode == 27) {
			context.doElementEdit(false, $(this));
		}
	}).keydown(function(event) {
		// Next Element
		if (event.which == 9) {
			context.doElementSave($(this));
			context.doElementEdit(false, $(this));
			var next = $(this).next();
			if (next) {
				event.preventDefault();
				next.click();
				context.doElementEdit(true, next);
			}
		}
	}).focusout(function(event) {
		// Cancel
		context.doElementEdit(false, $(this));
	});

	// /ELEMENTS
};

// ... ... FLOORS

SidebarBuildingcreatorCmsPresenterView.prototype.doFloorsEdit = function(edit) {
	var floorsTable = this.getSidebarFloorsTableElement();
	var floorsButtons = this.getSidebarFloorsButtonsElement();
	var floorsError = this.getSidebarFloorsErrorElement();

	if (edit) {
		floorsTable.addClass("edit");
		floorsButtons.enable();
	} else {
		floorsTable.removeClass("edit");
		floorsButtons.disable();
		floorsError.hide();
	}
};

SidebarBuildingcreatorCmsPresenterView.prototype.doFloorsOrder = function(row, up) {
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

SidebarBuildingcreatorCmsPresenterView.prototype.doFloorsSave = function() {
	var floorsTable = this.getSidebarFloorsTableElement();
	var floorsForm = this.getSidebarFloorsFormElement();
	var floorsError = this.getSidebarFloorsErrorElement();

	// Hide floors error
	floorsError.hide();

	// For each floor
	var floor, floorName, floorMap, floorOrder, floorMain, error = "";
	floorsTable.find(".floor.edit, .floor.new").each(function(i, element) {
		floor = $(element);

		floorId = floor.attr("data-floor");
		floorName = floor.find(".name_edit input").val();
		floorMap = floor.find(".map_edit input").val();
		floorOrder = floor.find(".order_edit input").val();
		floorMain = floor.find(".main_edit input").is(":checked");

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

// ... ... ELEMENTS

SidebarBuildingcreatorCmsPresenterView.prototype.doElementEdit = function(edit, element) {
	if (!element)
		return;

	if (edit) {
		element.find(".show").addClass("hide");
		element.find(".edit").removeClass("hide").find("input").select();
	} else {
		element.find(".show").removeClass("hide");
		element.find(".edit").addClass("hide");
		var input = element.find(".edit input");
		if (input)
			input.val(input.attr("data-value") || "");
	}
};

SidebarBuildingcreatorCmsPresenterView.prototype.doElementSave = function(elementElement) {
	var elementId = elementElement.attr("data-element");
	var input = elementElement.find(".edit input");

	if (!input)
		return;

	if (input.val() == (input.attr("data-value") || ""))
		return;

	this.getEventHandler().handle(new EditEvent("element", {
		id : elementId,
		name : input.val()
	}));
};

SidebarBuildingcreatorCmsPresenterView.prototype.doElementSaved = function(element) {
	if (!element)
		return;

	var elementElement = this.getSidebarElementsFloorsElement().find(".element[data-element=" + element.id + "]");
	elementElement.find(".name.show").text(element.name);
	elementElement.find(".name.edit input").attr("data-name", element.name).val(element.name);
};

// ... ... /ELEMENTS

// ... /DO

// ... HANDLE

SidebarBuildingcreatorCmsPresenterView.prototype.handleSelect = function(type, element) {
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

SidebarBuildingcreatorCmsPresenterView.prototype.handleFloorSelect = function(floorId) {
	if (!floorId)
		return false;

	// Select Floor
	var floorRows = this.getSidebarFloorsTableElement().find("tbody.show tr");
	floorRows.removeClass("selected");
	floorRows.filter("[data-floor=" + floorId + "]").addClass("selected");

	// Select Element
	this.getSidebarElementsFloorsElement().addClass("hide");
	var elementsVisible = this.getSidebarElementsFloorsElement().filter("[data-floor=" + floorId + "]").removeClass("hide");

	// Update Elements counter
	this.getSidebarElementsElement().find(".sidebar_header_wrapper span").text(elementsVisible.children().length);
};

SidebarBuildingcreatorCmsPresenterView.prototype.handleMenu = function(menu, sidebar) {
	sidebar = sidebar || null;
	var sidebarElements = this.getSidebarElement();
	sidebarElements.hide();

	var sidebarMenuElements = sidebarElements.filter("[data-sidebar-group~=" + menu + "]");
	sidebarMenuElements.show();
	sidebarMenuElements.find(".sidebar_header_wrapper.collapse").addClass("collapsed");

	var sidebarElement = sidebarMenuElements.filter("[data-sidebar=" + sidebar + "]");
	if (sidebarElement.length == 0)
		sidebarElement = sidebarMenuElements.filter("[data-sidebar]:first-child");
	if (sidebarElement.length > 0)
		sidebarElement.find(".sidebar_header_wrapper.collapse").removeClass("collapsed");
};

SidebarBuildingcreatorCmsPresenterView.prototype.handleDeleted = function(type, deleted) {
	switch (type) {
	case "element":
		this.getSidebarElementsFloorsElement().find(".element[data-element=" + deleted + "]").addClass("deleted");
		break;
	}
};

SidebarBuildingcreatorCmsPresenterView.prototype.handleHistoryUndid = function(history) {
	switch (history.type) {
	case "selected_delete":
		if (history.element.type == "polygon" && history.element.element.object.type == "element") {
			this.getSidebarElementsFloorsElement().find(".element[data-element=" + history.element.element.object.element.id + "]").removeClass("deleted");
		}
		break;
	}
};

// ... /HANDLE

SidebarBuildingcreatorCmsPresenterView.prototype.draw = function(root) {
	PresenterView.prototype.draw.call(this, root);

	this.handleMenu(this.getController().getHash().menu);
};

// /FUNCTIONS
