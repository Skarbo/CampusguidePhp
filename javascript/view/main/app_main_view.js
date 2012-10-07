// CONSTRUCTOR
AppMainView.prototype = new MainView();

function AppMainView(wrapperId) {
	MainView.apply(this, arguments);
	this.timerOrientationDelay = null;
}

// /CONSTRUCTOR

// VARIABLES

// /VARIABLES

// FUNCTIONS

// ... GET

/**
 * @return {AppMainController}
 */
AppMainView.prototype.getController = function() {
	return MainView.prototype.getController.call(this);
};

/**
 * @return {Object}
 */
AppMainView.prototype.getSearchOverlayElement = function() {
	return this.getWrapperElement().find("#search_overlay");
};

// ... /GET

// ... DO

AppMainView.prototype.doBindEventHandler = function() {
	MainView.prototype.doBindEventHandler.call(this);
	var context = this;

	// EVENT

	// Orientation event
	this.getController().getEventHandler().registerListener(OrientationEvent.TYPE,
	/**
	 * @param {OrientationEvent}
	 *            event
	 */
	function(event) {
		context.handleOrientation();
	});

	// /EVENT

	// ORIENTATION

	var supportsOrientationChange = "onorientationchange" in window;
	var orientationEvent = supportsOrientationChange ? "orientationchange" : "resize";
	window.addEventListener(orientationEvent, function() {
		if (context.timerOrientationDelay)
			clearTimeout(context.timerOrientationDelay);
		context.timerOrientationDelay = setTimeout(function() {
			context.getEventHandler().handle(new OrientationEvent());
		}, 200);
	}, false);

	// /ORIENTATION

	// OVERLAY

	this.getController().getEventHandler().registerListener(OverlayEvent.TYPE,
	/**
	 * @param {OverlayEvent}
	 *            event
	 */
	function(event) {
		context.handleOverlay(event);
	});

	this.getController().getEventHandler().registerListener(OverlayCloseEvent.TYPE,
	/**
	 * @param {OverlayCloseEvent}
	 *            event
	 */
	function(event) {
		context.handleOverlayClose(event.getOverlayId());
	});

	// /OVERLAY

	// SEARCH

	// Register "Search" listener
	this.getController().getEventHandler().registerListener(SearchEvent.TYPE,
	/**
	 * @param {SearchEvent}
	 *            event
	 */
	function(event) {
		context.handleSearch(event.getSearch(), event.getOptions());
	});

	// Register "ResultSearch" listener
	this.getController().getEventHandler().registerListener(ResultSearchEvent.TYPE,
	/**
	 * @param {ResultSearchEvent}
	 *            event
	 */
	function(event) {
		context.handleSearchResult(event.getResults());
	});

	// Register "ResetSearch" listener
	this.getController().getEventHandler().registerListener(ResetSearchEvent.TYPE,
	/**
	 * @param {ResetSearchEvent}
	 *            event
	 */
	function(event) {
		context.handleSearchReset();
	});

	// Search input
	var searchInput = this.getSearchOverlayElement().find("#search_input");

	searchInput.keypress(function(e) {
		var code = (e.keyCode ? e.keyCode : e.which);
		if (code == 13 && searchInput.val() != "") {
			context.doMapSearch(searchInput.val());
		}
	});

	// Search reset
	this.getSearchOverlayElement().find("#search_reset").click(function(event) {
		event.preventDefault();
		searchInput.val("").focus();
		context.getController().getEventHandler().handle(new ResetSearchEvent());
	});

	// Search button
	this.getSearchOverlayElement().find("#search_button").click(function(event) {
		event.preventDefault();
		if (searchInput.val() != "") {
			context.doMapSearch(searchInput.val());
		}
	});

	// /SEARCH

};

AppMainView.prototype.doFitToParent = function() {
	var parent = null, target = null, parentSelector = null, fitparentType = null;
	$("[data-fitparent],[data-fitparent-width]").each(function(i, element) {
		target = $(element);
		fitparentType = target.attr("data-fitparent-width") ? "width" : "all";
		parentSelector = target.attr(fitparentType == "width" ? "data-fitparent-width" : "data-fitparent");
		parent = parentSelector == "true" ? null : target.parentsUntil(parentSelector).parent();
		parent = parent && parent.length > 0 ? parent : target.parent();
		if (fitparentType == "width") {
			target.width(parent.width());
		} else {
			target.width(parent.width()).height(parent.height());
		}
	});
};

AppMainView.prototype.doMapSearch = function(search) {
	if (search) {
		this.getController().getEventHandler().handle(new SearchEvent(search));
	}
};

// ... /DO

// ... HANDLE

AppMainView.prototype.handleOrientation = function() {
	var landscape = window.orientation == -90 || window.orientation == 90 ? true : false;
	if (landscape) {
		this.getWrapperElement().addClass("landscape");
		this.getWrapperElement().removeClass("portrait");
	} else {
		this.getWrapperElement().addClass("portrait");
		this.getWrapperElement().removeClass("landscape");
	}

	// Fit to parent
	this.doFitToParent();
};

/**
 * @param {OverlayEvent}
 *            event
 */
AppMainView.prototype.handleOverlay = function(event) {

	var context = this;

	// Overlay element
	var overlayElement = $("#app_wrapper #" + event.getOverlayId());

	if (overlayElement.length == 0) {
		return;
	}

	var titleElement = overlayElement.find(".title");
	var bodyElement = overlayElement.find(".body");

	// Title
	if (event.getOptions().title) {
		titleElement.html(event.getOptions().title);
	}

	// Body
	if (event.getOptions().body) {
		bodyElement.html(event.getOptions().body);
	}

	if ("bodyHandle" in event.getOptions()) {
		event.getOptions().bodyHandle(bodyElement);
	}

	// Keydown handle
	var keydownHandle = function(e) {
		if (e.keyCode == '27') {
			closeHandle();
			return false;
		}
	};

	// Remove hide class
	overlayElement.removeClass("hide");

	// Cancel overlay handle
	var closeHandle = function() {
		// Send close overlay event
		context.getController().getEventHandler().handle(new OverlayCloseEvent(event.getOverlayId()));

		// Unbind
		$(document).unbind('keydown', keydownHandle);

		// Cancel handle
		if (event.getOptions().cancelHandle) {
			event.getOptions().cancelHandle();
		}
	};

	overlayElement.click(function(event) {
		if ($(event.target).find(".overlay").length > 0) {
			closeHandle();
		}
	});
	$(document).bind('keydown', keydownHandle);

};

/**
 * @param {string}
 *            Overlay id
 */
AppMainView.prototype.handleOverlayClose = function(overlayId) {

	// Overlay element
	var overlayElement = $("#app_wrapper #" + overlayId);

	if (overlayElement.length == 0) {
		return;
	}

	// Add hide class
	overlayElement.addClass("hide");

};

// ... ... SEARCH

/**
 * @param {String}
 *            search
 * @param {Object}
 *            options
 */
AppMainView.prototype.handleSearch = function(search, options) {

	// Show search spinner
	this.getSearchOverlayElement().find("#search_spinner").removeClass("hide");

};

/**
 * @param {Object}
 *            results
 */
AppMainView.prototype.handleSearchResult = function(results) {
	var context = this;

	// Hide search spinner
	this.getSearchOverlayElement().find("#search_spinner").addClass("hide");

	// Search result table
	var searchResultTable = this.getSearchOverlayElement().find("#search_result_table");

	// Search result template
	var searchResultBuildingTemplate = searchResultTable.find(".search_result_body#search_result_template_building");
	var searchResultElementTemplate = searchResultTable.find(".search_result_body#search_result_template_element");

	// Clear result table
	this.handleSearchReset();

	// BUILDINGS

	var buildings = results.buildings;

	var searchResultBody = null, building, address;
	for (i in buildings) {
		searchResultBody = searchResultBuildingTemplate.clone();
		building = buildings[i];

		searchResultBody.attr("id", null);
		searchResultBody.removeClass("template");

		// Set building id
		searchResultBody.attr("data-buildingid", building.id);

		// Remove hide
		searchResultBody.removeClass("hide");

		// Building name
		searchResultBody.find(".search_result_title").text(building.name);

		// Building address
		address = jQuery.isArray(building.address) ? building.address.join(", ") : "";
		searchResultBody.find(".search_result_description").text(address);

		if (searchResultBody.find(".search_result_description").text() == "") {
			searchResultBody.find(".search_result_description").html("&nbsp;");
		}

		// Bind body
		searchResultBody.click(function(event) {
			context.handleSearchSelect("building", $(this).attr("data-buildingid"));
		});

		// Touchable
		searchResultBody.touchActive();

		// Add row to table
		searchResultTable.append(searchResultBody);
	}

	// /BUILDINGS

	// ELEMENTS

	var elements = results.elements;

	var searchResultBody = null;
	for (i in elements) {
		searchResultBody = searchResultElementTemplate.clone();
		element = elements[i];

		searchResultBody.attr("id", null);
		searchResultBody.removeClass("template");

		// Set building id
		searchResultBody.attr("data-element", element.id);

		// Remove hide
		searchResultBody.removeClass("hide");

		// Building name
		searchResultBody.find(".search_result_title").text(element.name);

		// Building address
		searchResultBody.find(".search_result_description").html("&nbsp;");

		// Bind body
		searchResultBody.click(function(event) {
			context.handleSearchSelect("element", $(this).attr("data-element"));
		});

		// Touchable
		searchResultBody.touchActive();

		// Add row to table
		searchResultTable.append(searchResultBody);
	}

	// /ELEMENTS
	console.log(buildings, elements);
	if (jQuery.isEmptyObject(buildings) && jQuery.isEmptyObject(elements)) {
		searchResultTable.find("#search_result_noresult").removeClass("hide");
	} else {
		searchResultTable.find("#search_result_noresult").addClass("hide");
	}

};

AppMainView.prototype.handleSearchReset = function() {

	// Search result table
	var searchResultTable = this.getSearchOverlayElement().find("#search_result_table");

	// Clear result table
	searchResultTable.find(".search_result_body:NOT(.template)").remove();

	// Show no result body
	searchResultTable.find("#search_result_noresult").removeClass("hide");

};

AppMainView.prototype.handleSearchSelect = function(type, id) {

	console.log("Handle search select", type, id);
	switch (type) {
	case "building":
		break;
	case "element":
		break;
	}

};

// ... ... /SEARCH

// ... /HANDLE

// ... DRAW

AppMainView.prototype.draw = function(controller) {
	MainView.prototype.draw.call(this, controller);

	// Handle orientation
	this.handleOrientation();
	// this.getWrapperElement().addClass("portrait");
	// this.doFitToParent();
	// this.getWrapperElement().addClass("landscape");

	// HOVER

	this.getWrapperElement().find(".hover").bind("touchstart.hovering touchend.hovering touchend.hovering touchcancel.hovering", function(event) {
		if (event.type == "touchstart") {
			$(this).addClass("hovering");
		} else {
			$(this).removeClass("hovering");
		}
	});

	// /HOVER

};

// ... /DRAW

// /FUNCTIONS
