// CONSTRUCTOR
BuildingsCmsCampusguideMainView.prototype = new CmsCampusguideMainView();

/**
 * @param {string}
 *            wrapperId Wrapper id
 */
function BuildingsCmsCampusguideMainView(wrapperId) {
	CmsCampusguideMainView.apply(this, arguments);
	this.map = null;
	this.geocoder = null;
	this.marker = null;
	this.markerResult = null;
	this.floorplannerPage = new FloorplannerBuildingCmsCampusguidePageMainView(this);
};

// /CONSTRUCTOR

// VARIABLES

// /VARIABLES

// FUNCTIONS

// ... GET

/**
 * @returns {BuildingsCmsCampusguideMainController}
 */
BuildingsCmsCampusguideMainView.prototype.getController = function() {
	return CmsCampusguideMainView.prototype.getController.call(this);
};

/**
 * @returns {FloorplannerBuildingCmsCampusguidePageMainView}
 */
BuildingsCmsCampusguideMainView.prototype.getFloorplannerPage = function() {
	return this.floorplannerPage;
};

// ... /GET

// ... DO

BuildingsCmsCampusguideMainView.prototype.doBindEventHandler = function() {
	CmsCampusguideMainView.prototype.doBindEventHandler.call(this);
	var context = this;

	// Building page
	if (this.getController().getQuery().page == "building"
			&& (this.getController().getQuery().action == "edit" || this.getController().getQuery().action == "new")) {
		// Facilities slider
		this.doFacilitiesSlider();

		// Bind address map
		this.getWrapperElement().find("#address_map").click(function() {
			context.handleAddressMap();
		});

		// Bind location map
		this.getWrapperElement().find("#location_map").click(function() {
			context.handleLocationMap();
		});
	}
};

BuildingsCmsCampusguideMainView.prototype.doFacilitiesSlider = function() {

	// Create slider
	$(".facilities_content").slider();

	// Get Building Facility input
	var input = $("input#facility_id");

	// Get selected wrapper
	var selectedFacilityElement = $("#facility_selected");

	// Get none facility element
	var noneFacilityElement = $("#facility_none");

	// Bind Facilities
	$("#facilities_slider_wrapper .facility_wrapper").click(function(event) {
		var target = $(event.delegateTarget);
		var facilityId = parseInt(target.attr("id").replace("facility_", ""));
		$(".facility_wrapper").removeClass("selected");
		target.addClass("selected");
		input.val(facilityId);

		selectedFacilityElement.css("display", "table-cell");
		selectedFacilityElement.empty();
		selectedFacilityElement.append(target.clone());

		noneFacilityElement.hide();
	});

	// Select Facility
	if (input.val()) {
		var facilityId = input.val();
		var facilityWrapperId = Core.sprintf("facility_%s", facilityId);
		var facilitySelectedElement = $(Core.sprintf(".facility_wrapper#%s", facilityWrapperId));

		if (facilitySelectedElement.length > 0) {
			facilitySelectedElement.addClass("selected");

			selectedFacilityElement.css("display", "table-cell");
			selectedFacilityElement.empty();
			selectedFacilityElement.append(facilitySelectedElement.clone());

			noneFacilityElement.hide();
		}
	}

};

BuildingsCmsCampusguideMainView.prototype.doCommonMap = function(initAddress, initLatLng) {

	var context = this;

	var mapSearchInput = $("#map_search");
	var mapSearchButton = $("#map_search_button");

	var mapSearchAddressElement = $("#map_search_address");
	var mapSearchLocationElement = $("#map_search_location");

	// Set location at address function
	var setLocationAtAddress = function(address) {
		context.geocoder.geocode({
			'address' : address
		}, function(results, status) {
			if (status == google.maps.GeocoderStatus.OK) {
				if (results[0]) {
					context.markerResult = results[0];
					context.map.setCenter(results[0].geometry.location);
					context.marker.setPosition(results[0].geometry.location);
					context.marker.setVisible(true);
					mapSearchAddressElement.text(results[0].formatted_address);
					mapSearchLocationElement.text(Core.sprintf("%s, %s", results[0].geometry.location.lat().toFixed(5),
							results[0].geometry.location.lng().toFixed(5)));
				}
			} else {
				console.error("Geocode was not successful for the following reason:", status);
			}
		});
	};

	// Set address at location function
	var setAddressAtLocation = function(latLng, setSearch) {
		context.geocoder.geocode({
			'latLng' : latLng
		}, function(results, status) {
			if (status == google.maps.GeocoderStatus.OK) {
				if (results[0]) {
					context.markerResult = results[0];
					mapSearchAddressElement.text(results[0].formatted_address);
					if (setSearch) {
						mapSearchInput.val(results[0].formatted_address);
					}
				}
			} else {
				console.error("Geocoder failed due to:", status);
			}
		});
	};

	// Set marker at location
	var setMarkerAtLocation = function(latLng, setSearch) {
		context.marker.setPosition(latLng);
		context.marker.setVisible(true);
		mapSearchLocationElement.text(Core.sprintf("%s, %s", latLng.lat().toFixed(5), latLng.lng().toFixed(5)));

		// Set address at location
		setAddressAtLocation(latLng, setSearch);
	};

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

		// Set marker
		this.marker = new google.maps.Marker({
			map : this.map,
			position : latlng,
			visible : false,
			draggable : true,
			clickable : false
		});

		// Map click
		google.maps.event.addListener(this.map, 'click', function(event) {
			setMarkerAtLocation(event.latLng);
		});

		// Marker drag
		google.maps.event.addListener(this.marker, 'dragend', function(event) {
			setMarkerAtLocation(event.latLng);
		});

		// Search click
		mapSearchButton.click(function() {
			if (mapSearchInput.val() != "") {
				setLocationAtAddress(mapSearchInput.val());
			}
		});

		// Search input enter press
		mapSearchInput.keypress(function(e) {
			if (e.which == 13) {
				mapSearchButton.click();
				e.preventDefault();
			}
		});

	}

	// Mark address
	if (initAddress && initAddress.length > 0) {
		setLocationAtAddress(initAddress);

		// Set search address
		mapSearchInput.val(initAddress);
	}

	// Mark lat&lng
	if (initLatLng && initLatLng.length > 0) {
		var latLngArray = initLatLng.split(",");
		var latlng = new google.maps.LatLng(latLngArray[0], latLngArray[1]);
		setMarkerAtLocation(latlng, true);
		// Set location as center
		this.map.setCenter(latlng);
	}

	// Focus map search
	mapSearchInput.focus();

};

// ... /DO

// ... HANDLE

BuildingsCmsCampusguideMainView.prototype.handleAddressMap = function() {

	var context = this;

	// Initiate address element
	var addressElement = $("input[name*=address]");

	// Retrieve address
	var address = [];
	addressElement.each(function(index, element) {
		element = $(element);
		if (element.attr("title") != element.val()) {
			address.push(element.val());
		}
	});

	$("#overlay_map_title_address").show();
	$("#overlay_map_title_location").hide();
	$("#overlay_map_body_address").show();
	$("#overlay_map_body_location").hide();

	// Do common map
	this.doCommonMap(address.join(", "));

	// Address function
	var addressFunction = function(address) {
		var addressNumber = "";
		var addressName = "";
		var addressCity = "";
		var addressPostal = "";
		var addressCountry = "";

		for ( var i = 0; i < address.length; i++) {
			// Street number
			if (jQuery.inArray("street_number", address[i].types) > -1) {
				addressNumber = address[i].long_name;
			}
			// Route
			if (jQuery.inArray("route", address[i].types) > -1) {
				addressName = address[i].long_name;
			}
			// City
			if (jQuery.inArray("locality", address[i].types) > -1) {
				addressCity = address[i].long_name;
			}
			// Postal code
			if (jQuery.inArray("postal_code", address[i].types) > -1) {
				addressPostal = address[i].long_name;
			}
			// Country
			if (jQuery.inArray("country", address[i].types) > -1) {
				addressCountry = address[i].long_name;
			}
		}

		if (addressNumber || addressName) {
			$(addressElement[0]).val(addressName + " " + addressNumber);
			$(addressElement[0]).removeClass("default_text_active");
		} else {
			$(addressElement[0]).val("");
			$(addressElement[0]).blur();
		}

		if (addressCity) {
			$(addressElement[1]).val(addressCity);
			$(addressElement[1]).removeClass("default_text_active");
		} else {
			$(addressElement[1]).val("");
			$(addressElement[1]).blur();
		}

		if (addressPostal) {
			$(addressElement[2]).val(addressPostal);
			$(addressElement[2]).removeClass("default_text_active");
		} else {
			$(addressElement[2]).val("");
			$(addressElement[2]).blur();
		}

		if (addressCountry) {
			$(addressElement[3]).val(addressCountry);
			$(addressElement[3]).removeClass("default_text_active");
		} else {
			$(addressElement[3]).val("");
			$(addressElement[3]).blur();
		}

	};

	// OK handle
	var okHandle = function() {
		if (context.marker.getVisible() && context.markerResult) {
			addressFunction(context.markerResult.address_components);
		}
		return true;
	};

	// Call overlay event
	this.getController().getEventHandler().handle(new OverlayEvent({
		"ok" : okHandle
	}, "overlay_map"));

};

BuildingsCmsCampusguideMainView.prototype.handleLocationMap = function() {

	var context = this;

	// Initiate location element
	var locationElement = $("input#building_location");

	$("#overlay_map_title_address").hide();
	$("#overlay_map_title_location").show();
	$("#overlay_map_body_address").hide();
	$("#overlay_map_body_location").show();

	// Do common map
	this.doCommonMap(null, locationElement.val());

	// OK handle
	var okHandle = function() {
		if (context.marker.getVisible() && context.marker) {
			locationElement.val(Core.sprintf("%s,%s", context.marker.position.lat().toFixed(5), context.marker.position
					.lng().toFixed(5)));
		}
		return true;
	};

	// Call overlay event
	this.getController().getEventHandler().handle(new OverlayEvent({
		"ok" : okHandle
	}, "overlay_map"));

};

// ... /HANDLE

BuildingsCmsCampusguideMainView.prototype.before = function() {
	CmsCampusguideMainView.prototype.before.call(this);
};

BuildingsCmsCampusguideMainView.prototype.after = function() {
	CmsCampusguideMainView.prototype.after.call(this);
};

/**
 * @param {CampusguideMainController}
 *            controller
 */
BuildingsCmsCampusguideMainView.prototype.draw = function(controller) {
	CmsCampusguideMainView.prototype.draw.call(this, controller);

	// Do Floorplanner
	if (this.getController().getQuery().page == "floorplanner" && this.getController().getQuery().id) {
		this.getFloorplannerPage().draw(this.getWrapperElement().find("#floorplanner_page_wrapper"));
	}

	$(".gui").gui();
};

// /FUNCTIONS
