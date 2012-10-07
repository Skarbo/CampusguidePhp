// CONSTRUCTOR
FacilitiesCmsMainView.prototype = new CmsMainView();

/**
 * @param {string}
 *            wrapperId Wrapper id
 */
function FacilitiesCmsMainView(wrapperId) {
	CmsMainView.apply(this, arguments);
	this.map = null;
	this.geocoder = null;
	this.markers = {};
	this.buildingsRetrieved = false;
	this.searchDelayTimer = null;
};

// /CONSTRUCTOR

// VARIABLES

FacilitiesCmsMainView.SEARCH_DELAY = 500;

// /VARIABLES

// FUNCTIONS

// ... GET

/**
 * @returns {FacilitiesCmsMainController}
 */
FacilitiesCmsMainView.prototype.getController = function() {
	return CmsMainView.prototype.getController.call(this);
};

/**
 * @returns {Object}
 */
FacilitiesCmsMainView.prototype.getSearchInputElement = function() {
	return this.getWrapperElement().find("#facilities_search");
};

/**
 * @returns {Object}
 */
FacilitiesCmsMainView.prototype.getSearchResetButtonElement = function() {
	return this.getWrapperElement().find("#facilities_search_reset");
	this.searchDelayTimer = null;
};

/**
 * @returns {Object}
 */
FacilitiesCmsMainView.prototype.getFacilitiesTableElement = function() {
	return this.getWrapperElement().find("#facilities_table");
};

// ... /GET

// ... DO

FacilitiesCmsMainView.prototype.doBindEventHandler = function() {
	CmsMainView.prototype.doBindEventHandler.call(this);
	var context = this;

	// Overview page
	if (this.getController().getQuery().page == "overview" || !this.getController().getQuery().page) {

		// FACILITIES CHECK

		this.getController().getEventHandler().registerListener(CheckboxEvent.TYPE,
		/**
		 * @param {CheckboxEvent}
		 *            event
		 */
		function(event) {
			context.handleFacilitiesCheck(event.getCheckboxes());
		});

		$("input#facilities_check[type=checkbox]").click(function() {
			console.log("Facilities checkbox changed", this);
		});

		// Facility check
		$("input[type=checkbox][name=facility_check]").click(
				function(event) {
					context.getController().getEventHandler().handle(
							new CheckboxEvent(event.currentTarget, $("input[type=checkbox][name=facility_check]")));
				});

		// Facilities delete
		var deleteUrl = $("#delete_facility").attr("data-url");

		$("#delete_facility").click(
				function(event) {
					var checkedCheckboxes = $("input[type=checkbox][name=facility_check]:checked");
					var deleteIds = jQuery.map(checkedCheckboxes, function(element, i) {
						return $(element).val();
					}) || [];

					if (deleteIds.length > 0) {
						context.getController().getEventHandler().handle(
								new OverlayEvent({
									"title" : Core.sprintf("Deleting %s %s", deleteIds.length,
											deleteIds.length == 1 ? "Facility" : "Facilities"),
									"body" : Core.sprintf("Are you sure you want to delete %s %s?", deleteIds.length,
											deleteIds.length == 1 ? "Facility" : "Facilities"),
									"ok" : function() {
										Core.postToUrl(Core.sprintf(deleteUrl, deleteIds.join("_")));
									}
								}));
					}
				});

		// /FACILITIES CHECK

		// FACILITY HIGHLIGHT

		$(".facilities_table_body > tr > td").click(function(event) {
			if (event.target == this) {
				// Handle highlight
				var facilitiesBody = $(event.currentTarget).parentsUntil(".facilities_table_body").parent();
				context.handleFacilityHighlight(facilitiesBody);
			}
		});

		// /FACILITY HIGHLIGHT

		// FACILITY SEARCH

		// Initiate Facility table search
		this.getFacilitiesTableElement().tableSearch({
			"display" : ".facilities_table_body",
			"search" : ".facility .name, .facility_buildings .facility_buildings_building_content",
			"noresult" : "#facilities_none_table"
		});

		// Bind search key up
		this.getSearchInputElement().keyup(function(event) {
			context.doSearch(event.target.value, true);
		});

		// Handle search reset button
		this.getSearchResetButtonElement().click(function() {
			context.getController().getEventHandler().handle(new SearchEvent(""));
		});

		// Search event
		this.getController().getEventHandler().registerListener(SearchEvent.TYPE,
		/**
		 * @param {SearchEvent}
		 *            event
		 */
		function(event) {
			context.getFacilitiesTableElement().tableSearch("search", event.getSearch());
		});

		// /FACILITY SEARCH

	}
	// Facility page
	else if (this.getController().getQuery().page == "facility") {

		// View action
		if (this.getController().getQuery().action == "view") {

			// Click Building row
			this.getWrapperElement().find(
					"#buildings_map_wrapper #buildings_wrapper .buildings_table_body .buildings_row_building > td")
					.click(function(event) {
						if (event.target == this) {
							var buildingId = parseInt($(event.target).parent().attr("id").replace("building_", ""));
							context.getController().getEventHandler().handle(new HighlightEvent(buildingId));
						}
					});

			// Highlight Building
			this.getController().getEventHandler().registerListener(HighlightEvent.TYPE,
			/**
			 * @param {HighlightEvent}
			 *            event
			 */
			function(event) {
				context.handleBuildingHighlight(event.getId());
			});

			// Init map
			this.getController().getEventHandler().registerListener(MapinitEvent.TYPE,
			/**
			 * @param {MapinitEvent}
			 *            event
			 */
			function(event) {
				// Do map
				context.doMap();
			});

			// RETRIEVE BUILDINGS

			this.getController().getEventHandler().registerListener(BuildingsRetrievedEvent.TYPE,
			/**
			 * @param {BuildingsRetrievedEvent}
			 *            event
			 */
			function(event) {
				context.handleMapBuildings(event.getBuildings());
			});

			// /RETRIEVE BUILDINGS

		}

	}

};

FacilitiesCmsMainView.prototype.doMap = function() {

	var context = this;

	// Initialize geocoder
	if (!this.geocoder) {
		this.geocoder = new google.maps.Geocoder();
	}

	// Initialize map
	if (!this.map) {
		var latlng = new google.maps.LatLng(60.39126, 5.32205);
		var options = {
			zoom : 15,
			center : latlng,
			mapTypeId : google.maps.MapTypeId.ROADMAP,
			zoomControl : true,
			streetViewControl : false,
			mapTypeControlOptions : {
				style : google.maps.MapTypeControlStyle.DROPDOWN_MENU
			}
		};

		// Set map
		this.map = new google.maps.Map(document.getElementById("map_canvas"), options);

	}

	// Draw buildings if retrieved
	if (this.buildingsRetrieved) {
		this.getController().getBuildingDao().getForeign(this.getController().getQuery().id, function(buildings) {
			context.handleMapBuildings(buildings);
		});
	}

};

FacilitiesCmsMainView.prototype.doSearch = function(search, delay) {

	// Delay search
	if (delay != undefined && delay == true) {
		var context = this;
		clearTimeout(this.searchDelayTimer);
		this.searchDelayTimer = setTimeout(function() {
			context.doSearch(search, false);
		}, FacilitiesCmsMainView.SEARCH_DELAY);
		return;
	}

	// Do search
	this.getController().getEventHandler().handle(new SearchEvent(search));

};

// ... /DO

// ... HANDLE

FacilitiesCmsMainView.prototype.handleFacilitiesCheck = function(checkboxes) {

	var checkedCheckboxes = $(checkboxes).filter(":checked");

	var deleteUrl = $("#delete_facility").attr("data-url");
	var editUrl = $("#edit_facility").attr("data-url");
	var deleteIds = jQuery.map(checkedCheckboxes, function(val, i) {
		return $(val).val();
	}) || [];

	// None checked
	if (checkedCheckboxes.length == 0) {
		$("#edit_facility").disable();
		$("#delete_facility").disable();
	} else {
		$("#delete_facility").enable();

		// One checked
		if (checkedCheckboxes.length == 1) {
			$("#edit_facility").enable();
			$("#edit_facility").attr("href", Core.sprintf(editUrl, checkedCheckboxes.val()));
		} else {
			$("#edit_facility").disable();
		}
	}

};

FacilitiesCmsMainView.prototype.handleMapBuildings = function(buildings) {

	var context = this;
	this.buildingsRetrieved = true;

	// Add Buildings to map
	if (this.map) {

		var bounds = new google.maps.LatLngBounds();

		// Set location at address function
		var setMarkerAtAddress = function(address, marker) {
			context.geocoder.geocode({
				'address' : address
			}, function(results, status) {
				if (status == google.maps.GeocoderStatus.OK) {
					if (results[0]) {
						marker.setPosition(results[0].geometry.location);
						marker.setVisible(true);
						updatedBounds(results[0].geometry.location);
					}
				} else {
					console.error("Geocode was not successful for the following reason:", status);
				}
			});
		};

		// Set marker at location
		var setMarkerAtLocation = function(latLng, marker) {
			marker.setPosition(latLng);
			marker.setVisible(true);
			updatedBounds(latLng);
		};

		// Update bounds and map viewport
		var updatedBounds = function(latLng) {
			bounds.extend(latLng);
			context.map.fitBounds(bounds);
		};

		// Foreach Buildings
		var building, address;
		for (buildingId in buildings) {
			building = buildings[buildingId];
			address = jQuery.isArray(building.address) ? building.address.join(", ") : "";

			// Add marker
			this.markers[buildingId] = new google.maps.Marker({
				map : this.map,
				visible : false,
				buildingId : buildingId
			});

			// Building location
			if (building.location && jQuery.isArray(building.location)) {
				setMarkerAtLocation(new google.maps.LatLng(building.location[0], building.location[1]), this.markers[buildingId]);
			}
			// Building address
			else if (address) {
				setMarkerAtAddress(address, this.markers[buildingId]);
			}
			
			// Marker click
			google.maps.event.addListener(this.markers[buildingId], 'click', function(event) {
				
				console.log(this);
				context.handleBuildingHighlight(this.buildingId);
			});
						
		}

	}
};

FacilitiesCmsMainView.prototype.handleFacilityHighlight = function(facilityBodyElement) {

	// Is already highlighted
	if (facilityBodyElement.hasClass("highlight")) {
		// Remove highlight
		$(".facilities_table_body").removeClass("highlight");
		return;
	}

	// Remove highlights
	$(".facilities_table_body").removeClass("highlight");

	// Highlight body
	facilityBodyElement.addClass("highlight");

	// Initiate slider
	if ($(facilityBodyElement).find(".facility_buildings .slider_wrapper").length == 0) {
		$(facilityBodyElement).find(".facility_buildings .facility_buildings_table").slider();
	}

};

FacilitiesCmsMainView.prototype.handleBuildingHighlight = function(buildingId) {

	// HIGHLIGHT BUILDING ROW

	// Get Building rows
	var buildingRows = this.getWrapperElement().find(
			"#buildings_map_wrapper #buildings_wrapper .buildings_table_body .buildings_row_building");

	// Remove highlight class
	buildingRows.removeClass("highlight");

	// Add highlight class
	buildingRows.filter(Core.sprintf("#building_%s", buildingId)).addClass("highlight");

	// /HIGHLIGHT BUILDING ROW

};

// ... /HANDLE

FacilitiesCmsMainView.prototype.after = function() {
	CmsMainView.prototype.after.call(this);

	// Handle checkboxes
	this.handleFacilitiesCheck($("input[type=checkbox][name=facility_check]"));
};

/**
 * @param {MainController}
 *            controller
 */
FacilitiesCmsMainView.prototype.draw = function(controller) {
	CmsMainView.prototype.draw.call(this, controller);

	$(".gui").gui();

};

// /FUNCTIONS
