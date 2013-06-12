// CONSTRUCTOR
RoomsElementsSidebarBuildingcreatorBuildingsCmsPresenterView.prototype = new AbstractPresenterView();

function RoomsElementsSidebarBuildingcreatorBuildingsCmsPresenterView(view) {
	AbstractPresenterView.apply(this, arguments);
	this.typeSelecter = null;
};

// VARIABLES

// /VARIABLES

// FUNCTIONS

// ... GET

/**
 * @returns {BuildingsCmsMainController}
 */
RoomsElementsSidebarBuildingcreatorBuildingsCmsPresenterView.prototype.getController = function() {
	return AbstractPresenterView.prototype.getController.call(this);
};

/**
 * @returns {ElementsSidebarBuildingcreatorBuildingsCmsPresenterView}
 */
RoomsElementsSidebarBuildingcreatorBuildingsCmsPresenterView.prototype.getView = function() {
	return AbstractPresenterView.prototype.getView.call(this);
};

// ... ... ELEMENTS

/**
 * @return {Object}
 */
RoomsElementsSidebarBuildingcreatorBuildingsCmsPresenterView.prototype.getElementsElement = function() {
	return this.getView().getElementsElement().filter("[data-element-type-group=room]");
};

/**
 * @return {Object}
 */
RoomsElementsSidebarBuildingcreatorBuildingsCmsPresenterView.prototype.getTypeSelecterElement = function() {
	return this.getRoot().find("#element_type_selecter");
};

// ... ... /ELEMENTS

// ... /GET

// ... DO

RoomsElementsSidebarBuildingcreatorBuildingsCmsPresenterView.prototype.doBindEventHandler = function() {
	AbstractPresenterView.prototype.doBindEventHandler.call(this);
	var context = this;

	// TYPE SELECTER

	this.typeSelecter = this.getTypeSelecterElement();

	this.typeSelecter.showSelecter = function(element, typeInput) {
		if (!element || element.length == 0 || !typeInput || typeInput.length == 0)
			return console.warn("DevicesElementsSidebarBuildingcreatorBuildingsCmsPresenterView.typeSelecter: Illegal arguments", element);

		this.show();
		this.setType(element, typeInput.val());
		var position = {
			left : element.position().left + element.width() + 5,
			top : element.position().top - this.find(".type_group_header_wrapper").height()
		};
		this.offset(position);

		this.unbind(".typeselecter").on("click.typeselecter", {
			element : element,
			typeInput : typeInput,
			typeSelecter : this
		}, function(event) {
			var typeWrapper = $(event.target).closest(".type_wrapper");
			if (typeWrapper.length > 0) {
				var type = typeWrapper.attr("data-type");
				event.data.typeInput.val(type);
				event.data.typeSelecter.setType(event.data.element, type);
			}
		});
	};
	this.typeSelecter.closeSelecter = function() {
		this.hide();
	};
	this.typeSelecter.setType = function(element, type) {
		var typeWrapper = this.find(".type_wrapper").removeClass("selected").filter("[data-type=" + type + "]").addClass("selected");
		element.find("input[name=element_name]").focus();
		return typeWrapper.length > 0 ? typeWrapper : this;
	};

	// /TYPE SELECTER
};

// ... ... INFOPANEL

RoomsElementsSidebarBuildingcreatorBuildingsCmsPresenterView.prototype.doInfopanelRoom = function(room) {
	var context = this;
	if (typeof room != "object")
		return console.error("RoomsElementsSidebarBuildingcreatorBuildingsCmsPresenterView.doInfopanelRoom: Room is empty", room);

	var infoPanelContents = this.getView().getView().getInfopanelWrapperElement().find(".info_panel_content_wrapper");

	infoPanelContents.filter("[data-infopanel=room_type]").show();

	// ROOM TYPE

	// Header value
	var roomTypeImageSource = BuildingsCmsMainView.ELEMENT_TYPE_ROOMS[room.type];
	var roomTypeImage = "&nbsp;";
	if (roomTypeImageSource)
		roomTypeImage = $("<img />", {
			src : roomTypeImageSource.source,
			alt : roomTypeImageSource.name
		});
	infoPanelContents.filter("[data-infopanel=room_type]").find(".info_panel_content_header_value").html(roomTypeImage);
	infoPanelContents.filter("[data-infopanel=room_type]").find(".info_panel_content_content_wrapper .room_type_wrapper .room_type_content").removeClass("selected").filter(
			"[data-room-type=" + room.type + "]").addClass("selected");
	var roomTypeInput = infoPanelContents.filter("[data-infopanel=room_type]").find(".info_panel_content_content_wrapper .room_type_wrapper input[name=room_type]").val(room.type);

	infoPanelContents.filter("[data-infopanel=room_type]").find(".info_panel_content_content_wrapper .room_type_content").click(function(event) {
		$(event.target).closest(".room_type_wrapper").find(".room_type_content").removeClass("selected");
		var roomTypeContent = $(event.target).closest(".room_type_content").addClass("selected");
		roomTypeInput.val(roomTypeContent.attr("data-room-type"));
	});

	// /ROOM TYPE

	// SAVE

	this.getView().getView().getInfopanelHeaderWrapperElement().find("#infopanel_header_buttons_save").button().unbind("click").click(function(event) {
		event.preventDefault();
		context.doRoomSave();
	});

	// /SAVE

};

// ... ... /INFOPANEL

RoomsElementsSidebarBuildingcreatorBuildingsCmsPresenterView.prototype.doRoomEdit = function(isEdit, element, typeInput, typeGroupInput) {
	if (isEdit) {
		this.typeSelecter.showSelecter(element, typeInput, typeGroupInput);
	} else {
		this.typeSelecter.closeSelecter();
	}
};

RoomsElementsSidebarBuildingcreatorBuildingsCmsPresenterView.prototype.doRoomSave = function() {
	var infoPanelContents = this.getView().getInfopanelWrapperElement().find(".info_panel_content_wrapper");

	var roomElement = {
		id : null,
		name : null,
		data : {
			names : []
		},
		type : null,
		typeGroup : "room"
	};

	var elementIdElement = infoPanelContents.find("input[name=element_id]");
	var elementNameElements = infoPanelContents.find(".element_name_input_wrapper:NOT(.template) input[name=element_name]");
	var roomTypeElement = infoPanelContents.find("input[name=room_type]");

	roomElement["id"] = elementIdElement.val();
	roomElement["type"] = roomTypeElement.val();

	var names = [];
	elementNameElements.each(function() {
		names.push($(this).val());
	});

	if (names.length > 0) {
		roomElement.name = names[0];
		roomElement.data.names = names.splice(1);
	}

	if (!roomElement["id"])
		return console.error("RoomsElementsSidebarBuildingcreatorBuildingsCmsPresenterView.doRoomSave: Room id not given");

	this.getEventHandler().handle(new EditEvent("element", roomElement));

	this.getView().getView().doSidebarsShow();
};

RoomsElementsSidebarBuildingcreatorBuildingsCmsPresenterView.prototype.doUpdateHeaderCounter = function() {
	var elementsVisible = this.getElementsElement().filter(":visible"); 
	this.getRoot().find(".sidebar_header_wrapper span").text(elementsVisible.length);
};

// ... /DO

// ... HANDLE

// ... /HANDLE

RoomsElementsSidebarBuildingcreatorBuildingsCmsPresenterView.prototype.draw = function(root) {
	AbstractPresenterView.prototype.draw.call(this, root);
	var context = this;

};

// /FUNCTIONS
