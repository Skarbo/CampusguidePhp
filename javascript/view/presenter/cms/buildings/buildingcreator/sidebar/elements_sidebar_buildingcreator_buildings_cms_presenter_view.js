// CONSTRUCTOR
ElementsSidebarBuildingcreatorBuildingsCmsPresenterView.prototype = new AbstractPresenterView();

function ElementsSidebarBuildingcreatorBuildingsCmsPresenterView(view) {
	AbstractPresenterView.apply(this, arguments);
	this.roomsElementsPresenter = new RoomsElementsSidebarBuildingcreatorBuildingsCmsPresenterView(this);
	this.devicesElementsPresenter = new DevicesElementsSidebarBuildingcreatorBuildingsCmsPresenterView(this);
};

// VARIABLES

// /VARIABLES

// FUNCTIONS

// ... GET

/**
 * @returns {BuildingsCmsMainController}
 */
ElementsSidebarBuildingcreatorBuildingsCmsPresenterView.prototype.getController = function() {
	return AbstractPresenterView.prototype.getController.call(this);
};

/**
 * @returns {SidebarBuildingcreatorBuildingsCmsPresenterView}
 */
ElementsSidebarBuildingcreatorBuildingsCmsPresenterView.prototype.getView = function() {
	return AbstractPresenterView.prototype.getView.call(this);
};

// ... ... ELEMENT

/**
 * @return {Object}
 */
ElementsSidebarBuildingcreatorBuildingsCmsPresenterView.prototype.getFloorsElement = function() {
	return this.getRoot().find("table.elements_table tbody[data-floor]");
};

/**
 * @return {Object}
 */
ElementsSidebarBuildingcreatorBuildingsCmsPresenterView.prototype.getElementsElement = function() {
	return this.getFloorsElement().find(".element");
};

/**
 * @return {Object}
 */
ElementsSidebarBuildingcreatorBuildingsCmsPresenterView.prototype.getElementElement = function(elementId) {
	return this.getElementsElement().filter("[data-element=" + elementId + "]");
};

/**
 * @return {Object}
 */
ElementsSidebarBuildingcreatorBuildingsCmsPresenterView.prototype.getElementGroupWrapperElement = function() {
	return this.getRoot().find(".element_group_wrapper");
};

/**
 * @return {Object}
 */
ElementsSidebarBuildingcreatorBuildingsCmsPresenterView.prototype.getRoomsElementsElement = function() {
	return this.getRoot().filter("[data-sidebar=elements_rooms]");
};

/**
 * @return {Object}
 */
ElementsSidebarBuildingcreatorBuildingsCmsPresenterView.prototype.getDevicesElementsElement = function() {
	return this.getRoot().filter("[data-sidebar=elements_devices]");
};

// ... ... /ELEMENT

// ... /GET

// ... DO

ElementsSidebarBuildingcreatorBuildingsCmsPresenterView.prototype.doBindEventHandler = function() {
	AbstractPresenterView.prototype.doBindEventHandler.call(this);
	var context = this;

	// LIST ADAPTER

	// Building Element list
	this.getController().getDaoContainer().getElementBuildingDao().getListAdapter().addNotifyOnChange(function(type, object) {
		switch (type) {
		case "add":
			context.handleElementSaved(object);
			break;
		}
	});

	// /LIST ADAPTER

	// EVENTS

	// Floor select event
	this.getEventHandler().registerListener(FloorSelectEvent.TYPE,
	/**
	 * @param {FloorSelectEvent}
	 *            event
	 */
	function(event) {
		context.handleFloorSelect(event.getFloorId());
	});

	// Select event
	this.getView().getController().getEventHandler().registerListener(SelectEvent.TYPE,
	/**
	 * @param {SelectEvent}
	 *            event
	 */
	function(event) {
		switch (event.getSelectType()) {
		case "element":
			context.handleElementSelect(event.getObject());
			break;
		}
	});

	// Select canvas event
	this.getView().getController().getEventHandler().registerListener(SelectCanvasEvent.TYPE,
	/**
	 * @param {SelectCanvasEvent}
	 *            event
	 */
	function(event) {
		context.handleElementSelectCanvas(event.getSelectType(), event.getElement());
	});

	// /EVENTS

	// ELEMENTS

	var elementsTableRows = this.getElementsElement();

	// Select Element
	elementsTableRows.click(function(event) {
		var elementId = $(this).attr("data-element");
		var target = $(event.target);
		if (elementId) {
			if (target.closest("td.infopanel").length > 0)
				context.doInfopanelElementShow(elementId);
			context.getEventHandler().handle(new SelectEvent("element", {
				id : elementId,
				type : $(this).attr("data-element-type"),
				typeGroup : $(this).attr("data-element-type-group")
			}));
		}
	});

	// Edit Element
	elementsTableRows.dblclick(function(event) {
		context.doElementEdit(true, $(this));
	});

	// Save/cancel/next Element
	elementsTableRows.unbind(".element_bind").on("keyup.element_bind", function(event) {
		// Save
		if (event.keyCode == 13) {
			context.doElementSave($(this));
			context.doElementEdit(false, $(this));
		}
		// Cancel
		if (event.keyCode == 27) {
			context.doElementEdit(false, $(this));
		}
	}).on("keydown.element_bind", function(event) {
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
	});

	// /ELEMENTS

};

ElementsSidebarBuildingcreatorBuildingsCmsPresenterView.prototype.doElementEdit = function(isEdit, element) {
	if (!element)
		return;

	$(document).unbind(".elementedit");
	
	var nameInput = element.find("input[name=element_name]");
	var typeInput = element.find("input[name=element_type]");
	var typeGroupInput = element.find("input[name=element_type_group]");

	if (isEdit) {
		element.addClass("edit");
		nameInput.removeAttr("readonly");
		nameInput.select();

		var context = this;
		$(document).bind("click.elementedit", {
			element : element,
			context : context
		}, function(event) {
			if ($(event.target).closest("[data-element-edit]").length == 0) {
				event.data.context.doElementSave(event.data.element);
				event.data.context.doElementEdit(false, event.data.element);
				$(this).unbind(event);
			}
		});

		switch (element.attr("data-element-type-group")) {
		case "room":
			this.roomsElementsPresenter.doRoomEdit(true, element, typeInput, typeGroupInput);
			break;
		}

		// Send Fit event for this element
		var elementId = element.attr("data-element");
		if (elementId)
			this.getEventHandler().handle(new FitEvent("element", {
				id : elementId,
				type : element.attr("data-element-type"),
				typeGroup : element.attr("data-element-type-group")
			}));
	} else {
		element.removeClass("edit");
		nameInput.attr("readonly", "1").val(nameInput.attr("value"));
		this.roomsElementsPresenter.doRoomEdit(false);
	}
};

ElementsSidebarBuildingcreatorBuildingsCmsPresenterView.prototype.doElementSave = function(elementElement) {
	if (!elementElement || elementElement.length == 0)
		return console.error("RoomsElementsSidebarBuildingcreatorBuildingsCmsPresenterView.doElementSave: Element is empty", elementElement);

	var elementId = elementElement.attr("data-element");
	var nameInput = elementElement.find("input[name=element_name]");
	var typeInput = elementElement.find("input[name=element_type]");

	if (!elementId)
		return console.error("RoomsElementsSidebarBuildingcreatorBuildingsCmsPresenterView.doElementSave: Element id is null", elementId);
	if (nameInput.length == 0 || typeInput.length == 0)
		return console.error("RoomsElementsSidebarBuildingcreatorBuildingsCmsPresenterView.doElementSave: Name, type or type group is empty", nameInput, typeInput);

	if (nameInput.val() == (nameInput.attr("value") || "") && typeInput.val() == (typeInput.attr("data-value") || ""))
		return console.info("RoomsElementsSidebarBuildingcreatorBuildingsCmsPresenterView.doElementSave: Name, type and type group is not changed. Not saving.", nameInput,
				typeInput);

	this.getEventHandler().handle(new EditEvent("element", {
		id : elementId,
		name : nameInput.val(),
		type : typeInput.val()
	}));
};

ElementsSidebarBuildingcreatorBuildingsCmsPresenterView.prototype.doInfopanelElementShow = function(elementId) {
	var element = this.getController().getDaoContainer().getElementBuildingDao().getListAdapter().getItem(elementId);
	if (!element)
		return console.error("ElementsSidebarBuildingcreatorBuildingsCmsPresenterView.doInfopanelElementShow: Element is null", element);

	this.getView().doInfopanelShow(element);

	switch (element.typeGroup) {
	case "room":
		this.roomsElementsPresenter.doInfopanelRoom(element);
		break;
	case "device":
		this.devicesElementsPresenter.doInfopanelDevice(element);
		break;
	}
};

// ... /DO

// ... HANDLE

ElementsSidebarBuildingcreatorBuildingsCmsPresenterView.prototype.handleFloorSelect = function(floorId) {
	if (!floorId)
		return console.error("ElementsSidebarBuildingcreatorBuildingsCmsPresenterView.handleFloorSelect: Floor id is empty", floorId);

	var elementsVisible = this.getFloorsElement().addClass("hide").filter("[data-floor=" + floorId + "]").removeClass("hide");

	this.getElementGroupWrapperElement().addClass("hide");
	elementsVisible.find("tr[data-element]").closest(".element_group_wrapper").removeClass("hide");

	this.roomsElementsPresenter.doUpdateHeaderCounter();
	this.devicesElementsPresenter.doUpdateHeaderCounter();
};

ElementsSidebarBuildingcreatorBuildingsCmsPresenterView.prototype.handleElementSaved = function(element) {
	if (!element)
		return console.error("ElementsSidebarBuildingcreatorBuildingsCmsPresenterView.handleElementSaved: Element is empty", element);

	var elementElement = this.getElementElement(element.id);
	if (elementElement.length == 0)
		return console.error("DevicesElementsSidebarBuildingcreatorBuildingsCmsPresenterView.handleElementSaved: Element element is empty", element);

	elementElement.find("input[name=element_name]").val(element.name).attr("data-value", element.name);
	elementElement.find("input[name=element_type]").val(element.type).attr("data-value", element.type);
	elementElement.find("input[name=element_type_group]").val(element.typeGroup).attr("data-value", element.typeGroup);
};

// ElementsSidebarBuildingcreatorBuildingsCmsPresenterView.prototype.handleDeleted
// = function(type, deleted) {
// switch (type) {
// case "element":
// this.getFloorsElement().find(".element[data-element=" + deleted +
// "]").addClass("deleted");
// break;
// }
// };
//
// ElementsSidebarBuildingcreatorBuildingsCmsPresenterView.prototype.handleHistoryUndid
// = function(history) {
// switch (history.type) {
// case "selected_delete":
// if (history.element.type == "polygon" && history.element.element.object.type
// == "element") {
// this.getFloorsElement().find(".element[data-element=" +
// history.element.element.object.element.id + "]").removeClass("deleted");
// }
// break;
// }
// };

// ... ... SELECT

ElementsSidebarBuildingcreatorBuildingsCmsPresenterView.prototype.handleElementSelect = function(element) {
	this.getElementsElement().removeClass("selected");
	if (!element)
		return;
	if (typeof element != "object")
		return console.error("ElementsSidebarBuildingcreatorBuildingsCmsPresenterView.handleElementSelect: Element is not object", element);
	this.getElementElement(element.id).addClass("selected");
};

ElementsSidebarBuildingcreatorBuildingsCmsPresenterView.prototype.handleElementSelectCanvas = function(type, element) {
	if (!element)
		this.handleElementSelect(null);

	switch (type) {
	case "polygon":
		if (element.type == "building_element_polygon" && element.element)
			this.handleElementSelect({
				id : element.element.id
			});
		break;
	}
};

// ... ... /SELECT

// ... /HANDLE

ElementsSidebarBuildingcreatorBuildingsCmsPresenterView.prototype.draw = function(root) {
	AbstractPresenterView.prototype.draw.call(this, root);

	this.roomsElementsPresenter.draw(this.getRoomsElementsElement());
	this.devicesElementsPresenter.draw(this.getDevicesElementsElement());
};

// /FUNCTIONS
