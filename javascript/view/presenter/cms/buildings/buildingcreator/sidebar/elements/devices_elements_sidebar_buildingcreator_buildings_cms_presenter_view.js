// CONSTRUCTOR
DevicesElementsSidebarBuildingcreatorBuildingsCmsPresenterView.prototype = new AbstractPresenterView();

function DevicesElementsSidebarBuildingcreatorBuildingsCmsPresenterView(view) {
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
DevicesElementsSidebarBuildingcreatorBuildingsCmsPresenterView.prototype.getController = function() {
	return AbstractPresenterView.prototype.getController.call(this);
};

/**
 * @returns {ElementsSidebarBuildingcreatorBuildingsCmsPresenterView}
 */
DevicesElementsSidebarBuildingcreatorBuildingsCmsPresenterView.prototype.getView = function() {
	return AbstractPresenterView.prototype.getView.call(this);
};

// ... ... ELEMENT

/**
 * @return {Object}
 */
DevicesElementsSidebarBuildingcreatorBuildingsCmsPresenterView.prototype.getElementsElement = function() {
	return this.getView().getElementsElement().filter("[data-element-type-group=device]");
};

// ... ... /ELEMENT

// ... /GET

// ... DO

DevicesElementsSidebarBuildingcreatorBuildingsCmsPresenterView.prototype.doBindEventHandler = function() {
	AbstractPresenterView.prototype.doBindEventHandler.call(this);
	var context = this;

};

// ... ... INFOPANEL

DevicesElementsSidebarBuildingcreatorBuildingsCmsPresenterView.prototype.doInfopanelDevice = function(device) {
	var context = this;
	if (typeof device != "object")
		return console.error("DevicesElementsSidebarBuildingcreatorBuildingsCmsPresenterView.doInfopanelDevice: Device is empty", device);

	var infoPanelContents = this.getView().getView().getInfopanelWrapperElement().find(".info_panel_content_wrapper");

	infoPanelContents.filter("[data-infopanel=device_router_mac]").show();

	// DEVICE ROUTER MAC

	// Router mac value
	var routerMacValuesDiv = $("<div />", {});
	var macs = device.data ? device.data.macs || [] : [];
	for ( var i in macs) {
		routerMacValuesDiv.append($("<div />", {
			text : macs[i]
		}));
	}
	if (macs.length == 0)
		routerMacValuesDiv.append($("<div />", {
			html : "<i>None</i>"
		}));
	infoPanelContents.filter("[data-infopanel=device_router_mac]").find(".info_panel_content_header_value").html(routerMacValuesDiv);

	var deviceRouterMacTable = infoPanelContents.find(".device_router_mac_wrapper .device_router_mac_table");
	var deviceRouterMacInputWrapperTemplate = infoPanelContents.find(".device_router_mac_wrapper .device_router_mac_row_wrapper.template");
	var deviceRouterMacInputWrappers = infoPanelContents.find(".device_router_mac_wrapper .device_router_mac_row_wrapper:NOT(.template)");
	deviceRouterMacInputWrappers.remove();

	var deviceRouterMacInputWrapper = deviceRouterMacInputWrapperTemplate.clone().removeClass("template");
	deviceRouterMacTable.append(deviceRouterMacInputWrapper);
	deviceRouterMacInputWrapper.find("input[name=device_router_mac]").val(macs[0] || "");
	macs = macs.splice(1);
	for ( var i in macs) {
		deviceRouterMacInputWrapper = deviceRouterMacInputWrapperTemplate.clone().removeClass("template");
		deviceRouterMacTable.append(deviceRouterMacInputWrapper);
		deviceRouterMacInputWrapper.find("input[name=device_router_mac]").val(macs[i]);
	}

	var bindRoomNameRemoveButton = function() {
		deviceRouterMacTable.find(".device_router_mac_remove").unbind("click").click(function(event) {
			event.preventDefault();
			if (deviceRouterMacTable.find(".device_router_mac_row_wrapper").length > 2) {
				$(event.target).closest(".device_router_mac_row_wrapper").remove();
			} else {
				$(event.target).closest(".device_router_mac_row_wrapper").find("input[name=device_router_mac]").val("").focus();
			}
		});
	};
	bindRoomNameRemoveButton();

	infoPanelContents.find(".device_router_mac_wrapper a.device_router_mac_add").unbind("click").click(function(event) {
		event.preventDefault();
		var deviceRouterMacRow = deviceRouterMacInputWrapperTemplate.clone().removeClass("template");
		deviceRouterMacTable.append(deviceRouterMacRow);
		deviceRouterMacRow.find("input[name=device_router_mac]").focus();
		bindRoomNameRemoveButton();
	});

	// /DEVICE ROUTER MAC

	// SAVE

	this.getView().getView().getInfopanelHeaderWrapperElement().find("#infopanel_header_buttons_save").button().unbind("click").click(function(event) {
		event.preventDefault();
		context.doDeviceSave();
	});

	// /SAVE

};

// ... ... /INFOPANEL

DevicesElementsSidebarBuildingcreatorBuildingsCmsPresenterView.prototype.doDeviceSave = function() {
	var infoPanelContents = this.getView().getView().getInfopanelWrapperElement().find(".info_panel_content_wrapper");

	var deviceElement = {
		id : null,
		name : null,
		data : {
			names : [],
			macs : []
		}
	};

	var elementIdElement = infoPanelContents.find("input[name=element_id]");
	var elementNameElements = infoPanelContents.find(".element_name_input_wrapper:NOT(.template) input[name=element_name]");
	var deviceRouterMacElements = infoPanelContents.find(".device_router_mac_row_wrapper:NOT(.template) input[name=device_router_mac]");

	deviceElement["id"] = elementIdElement.val();

	var names = [];
	elementNameElements.each(function() {
		names.push($(this).val());
	});

	deviceRouterMacElements.each(function() {
		deviceElement.data.macs.push($(this).val());
	});

	if (names.length > 0) {
		deviceElement.name = names[0];
		deviceElement.data.names = names.splice(1);
	}

	if (!deviceElement["id"])
		return console.error("DevicesElementsSidebarBuildingcreatorBuildingsCmsPresenterView.doDeviceSave: Device id not given");

	this.getEventHandler().handle(new EditEvent("element", deviceElement));

	this.getView().getView().doSidebarsShow();
};

DevicesElementsSidebarBuildingcreatorBuildingsCmsPresenterView.prototype.doUpdateHeaderCounter = function() {
	var elementsVisible = this.getElementsElement().filter(":visible");
	this.getRoot().find(".sidebar_header_wrapper span").text(elementsVisible.length);
};

// ... /DO

// ... HANDLE

// ... /HANDLE

DevicesElementsSidebarBuildingcreatorBuildingsCmsPresenterView.prototype.draw = function(root) {
	AbstractPresenterView.prototype.draw.call(this, root);
	var context = this;

};

// /FUNCTIONS
