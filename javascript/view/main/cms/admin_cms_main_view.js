// CONSTRUCTOR
AdminCmsMainView.prototype = new CmsMainView();

function AdminCmsMainView(wrapperId) {
	CmsMainView.apply(this, arguments);
	this.searchDelayTimer = null;

	this.facilitySelectsliderPresenter = new SelectsliderCmsPresenterView(this);
	this.buildingSelectsliderPresenter = new SelectsliderCmsPresenterView(this);
};

// /CONSTRUCTOR

// VARIABLES

AdminCmsMainView.SEARCH_DELAY = 500;

// /VARIABLES

// FUNCTIONS

// ... GET

/**
 * @return {AdminCmsMainController}
 */
AdminCmsMainView.prototype.getController = function() {
	return CmsMainView.prototype.getController.call(this);
};

AdminCmsMainView.prototype.getErrorsTableElement = function() {
	return this.getWrapperElement().find("#errors_page_wrapper table.errors");
};

AdminCmsMainView.prototype.getErrorRowsElement = function() {
	return this.getErrorsTableElement().find("tbody.error");
};

AdminCmsMainView.prototype.getErrorSearchInputElement = function() {
	return this.getWrapperElement().find("#errors_search");
};

AdminCmsMainView.prototype.getErrorResetButtonElement = function() {
	return this.getWrapperElement().find("#errors_search_reset");
};

// ... /GET

// ... DO

AdminCmsMainView.prototype.doBindEventHandler = function() {
	CmsMainView.prototype.doBindEventHandler.call(this);
	var context = this;

	// ... ERRORS

	var errorRows = this.getErrorRowsElement();
	errorRows.bind("click", {
		"errorRows" : errorRows
	}, function(event) {
		var isHighlighted = $(this).hasClass("highlight");
		if (!isHighlighted) {
			event.data.errorRows.removeClass("highlight");
			$(this).addClass("highlight");
			// $(document).scrollTop($(this).position().top);
		}
	});

	// ... ... SEARCH

	this.getErrorsTableElement().tableSearch({
		"display" : "tbody.error",
		"search" : ".message, .file, .url, .exception",
		"noresult" : "#errors_noerrors"
	});

	this.getErrorSearchInputElement().keyup(function(event) {
		context.doSearch(event.target.value, true);
	});

	this.getErrorResetButtonElement().click(function() {
		context.getController().getEventHandler().handle(new SearchEvent(""));
	});

	this.getController().getEventHandler().registerListener(SearchEvent.TYPE,
	/**
	 * @param {SearchEvent}
	 *            event
	 */
	function(event) {
		context.getErrorsTableElement().tableSearch("search", event.getSearch());
	});

	// /... ... /SEARCH

	// ... /ERRORS

	// QUEUE

	this.getEventHandler().registerListener(BuildingsRetrievedEvent.TYPE,
	/**
	 * @param {BuildingsRetrievedEvent}
	 *            event
	 */
	function(event) {
		context.handleBuildingsRetrieved(event.getBuildings());
	});

	this.getEventHandler().registerListener(FloorsBuildingRetrievedEvent.TYPE,
	/**
	 * @param {FloorsBuildingRetrievedEvent}
	 *            event
	 */
	function(event) {
		context.handleFloorsRetrieved(event.getFloors());
	});

	if (this.getController().getQuery().page == "queue" && this.getController().getQuery().action == "new") {
		var websiteSelect = this.getWrapperElement().find("select[name=select_website]");
		
		var facilityInput = this.getWrapperElement().find("input[name=select_facility]");
		facilityInput.change(function(event) {
			context.getController().doBuildingsRetrieve($(this).val());
		});

		var buildingInput = this.getWrapperElement().find("input[name=select_building]");
		buildingInput.change(function(event) {
			context.getController().doFloorsRetrieve($(this).val());
		});

		var addButton = this.getWrapperElement().find("#queue_schedule_add");
		var floorInput = this.getWrapperElement().find("select[name=select_floor]");
		floorInput.change(function(event) {
			if (!websiteSelect.val() || !facilityInput.val() || !buildingInput.val() || !$(this).val()) {
				addButton.disable();
			} else {
				addButton.enable();
			}
		});

		websiteSelect.change(function(){
			floorInput.change();
		});
		
		addButton.click(function() {
			if (!$(this).isDisabled()) {
				$(this).parents("form").submit();
			}
		});
	}

	// /QUEUE

};

AdminCmsMainView.prototype.doSearch = function(search, delay) {

	// Delay search
	if (delay != undefined && delay == true) {
		var context = this;
		clearTimeout(this.searchDelayTimer);
		this.searchDelayTimer = setTimeout(function() {
			context.doSearch(search, false);
		}, AdminCmsMainView.SEARCH_DELAY);
		return;
	}

	// Do search
	this.getController().getEventHandler().handle(new SearchEvent(search));

};

// ... /DO

AdminCmsMainView.prototype.handleBuildingsRetrieved = function(buildings) {
	this.buildingSelectsliderPresenter.doContentsRemove();
	for (buildingId in buildings) {
		this.buildingSelectsliderPresenter.doContentAdd(buildingId, buildings[buildingId].name);
	}
	this.buildingSelectsliderPresenter.doRebind();
	this.buildingSelectsliderPresenter.doSlider();
	var floorSelect = this.getWrapperElement().find("select[name=select_floor]");
	floorSelect.empty();
	floorSelect.change();
};

AdminCmsMainView.prototype.handleFloorsRetrieved = function(floors) {
	var floorSelect = this.getWrapperElement().find("select[name=select_floor]");
	floorSelect.empty();
	for (floorId in floors) {
		floorSelect.append($("<option />", {
			"value" : floorId,
			"text" : Core.sprintf("%s (%d)", floors[floorId].name, floors[floorId].order),
			"selected" : floors[floorId].main == 1
		}));
	}
	floorSelect.change();
};

AdminCmsMainView.prototype.draw = function(controller) {
	CmsMainView.prototype.draw.call(this, controller);

	$(".gui").gui();

	if (this.getController().getQuery().page == "queue" && this.getController().getQuery().action == "new") {
		this.facilitySelectsliderPresenter.draw(this.getWrapperElement().find("#select_facility"));
		this.buildingSelectsliderPresenter.draw(this.getWrapperElement().find("#select_building"));
	}
};

// /FUNCTIONS
