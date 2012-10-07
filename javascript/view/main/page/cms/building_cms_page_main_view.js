// CONSTRUCTOR
BuildingCmsPageMainView.prototype = new PageMainView();

function BuildingCmsPageMainView(view) {
	PageMainView.apply(this, arguments);
	this.map = null;
	this.geocoder = null;
	this.markers = {};
};

// /CONSTRUCTOR

// VARIABLES

// /VARIABLES

// FUNCTIONS

// ... GETTERS/SETTERS

// ... /GETTERS/SETTERS

// ... GET

/**
 * @return {BuildingsCmsMainView}
 */
BuildingCmsPageMainView.prototype.getView = function() {
	return PageMainView.prototype.getView.call(this);
};

/**
 * @return {BuildingsCmsMainView}
 */
BuildingCmsPageMainView.prototype.getMapOverlayElement = function() {
	return this.getRoot().find("#overlay_map");
};

// ... /GET

// ... DO

BuildingCmsPageMainView.prototype.doBindEventHandler = function() {
	var context = this;

	// Building page
	if (this.getView().getController().getQuery().action == "edit"
			|| this.getView().getController().getQuery().action == "new") {

		// Facilities slider
		this.doFacilitiesSlider();

		// MAP

		this.getView().getController().getEventHandler().registerListener(MaploadEvent.TYPE,
		/**
		 * @param {MaploadEvent}
		 *            event
		 */
		function(event) {
			context.doCommonMap(event.getOptions());
		});

		// /MAP

		// HISTORY

		$(window).hashchange(
				function() {
					var hash = context.getView().getController().getHash();

					// MAP OVERLAY

					if (hash.map) {
						switch (hash.map) {
						case "address":
							context.handleAddressMap();
							break;

						case "position":
							context.handlePositionMap();
							break;
						}
					} else {
						context.getView().getController().getEventHandler().handle(
								new OverlayCloseEvent("overlay_map", MapinitEvent.TYPE));
					}

					// /MAP OVERLAY

				});

		$(window).hashchange();

		// /HISTORY

	}

};

BuildingCmsPageMainView.prototype.doFacilitiesSlider = function() {

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

BuildingCmsPageMainView.prototype.doCommonMap = function(options) {
	var context = this, type = options.type, init = options.init;

	this.getMapOverlayElement().attr("data-maptype", type);

	var mapSearchInput = this.getMapOverlayElement().find("#map_search");
	var mapSearchButton = this.getMapOverlayElement().find("#map_search_button");

	var locationAddressElement = this.getMapOverlayElement().find("#map_search_address");
	var locationLocationElement = this.getMapOverlayElement().find("#map_search_location");

	var positionCenter = this.getMapOverlayElement().find("#map_position_center");
	var positionCenterButton = this.getMapOverlayElement().find("#map_position_center_button");
	var positionTopleft = this.getMapOverlayElement().find("#map_position_topleft");
	var positionTopleftButton = this.getMapOverlayElement().find("#map_position_topleft_button");
	var positionTopright = this.getMapOverlayElement().find("#map_position_topright");
	var positionToprightButton = this.getMapOverlayElement().find("#map_position_topright_button");
	var positionBottomright = this.getMapOverlayElement().find("#map_position_bottomright");
	var positionBottomrightButton = this.getMapOverlayElement().find("#map_position_bottomright_button");

	// // Set location at address function
	// var setLocationAtAddress = function(address) {
	// context.geocoder.geocode({
	// 'address' : address
	// }, function(results, status) {
	// if (status == google.maps.GeocoderStatus.OK) {
	// if (results[0]) {
	// context.markerResult = results[0];
	// context.map.setCenter(results[0].geometry.location);
	// context.marker.setPosition(results[0].geometry.location);
	// context.marker.setVisible(true);
	// mapSearchAddressElement.text(results[0].formatted_address);
	// mapSearchLocationElement.text(Core.sprintf("%s, %s",
	// results[0].geometry.location.lat().toFixed(5),
	// results[0].geometry.location.lng().toFixed(5)));
	// }
	// } else {
	// console.error("Geocode was not successful for the following reason:",
	// status);
	// }
	// });
	// };

	// // Set address at location function
	// var setAddressAtLocation = function(latLng, setSearch) {
	// context.geocoder.geocode({
	// 'latLng' : latLng
	// }, function(results, status) {
	// if (status == google.maps.GeocoderStatus.OK) {
	// if (results[0]) {
	// context.markerResult = results[0];
	// mapSearchAddressElement.text(results[0].formatted_address);
	// if (setSearch) {
	// mapSearchInput.val(results[0].formatted_address);
	// }
	// }
	// } else {
	// console.error("Geocoder failed due to:", status);
	// }
	// });
	// };

	// // Set marker at location
	// var setMarkerAtLocation = function(latLng, setSearch) {
	// context.marker.setPosition(latLng);
	// context.marker.setVisible(true);
	// mapSearchLocationElement.text(Core.sprintf("%s, %s",
	// latLng.lat().toFixed(5), latLng.lng().toFixed(5)));
	//
	// // Set address at location
	// setAddressAtLocation(latLng, setSearch);
	// };

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

		// FUNCTIONS

		// Set location
		var locationHandler = function(result) {
			context.markers.location.address = result;
			context.markers.location.setVisible(true);
			context.markers.location.setPosition(result.geometry.location);
			context.markers.location.placed = true;
			locationLocationHandler(result.geometry.location);
			locationAddressHandler(result);
		};

		// Set location location
		var locationLocationHandler = function(latLng) {
			locationLocationElement.text(Core.sprintf("%s, %s", latLng.lat().toFixed(5), latLng.lng().toFixed(5)));
		};

		// Set location address
		var locationAddressHandler = function(result) {
			locationAddressElement.text(result.formatted_address);
		};

		// Set position location
		var positionHandler = function(markerName, latLng) {
			latLng = latLng || context.map.getCenter();
			context.markers[markerName].setPosition(latLng);
			context.markers[markerName].setVisible(true);
			context.markers[markerName].placed = true;
			positionLegend(markerName, latLng);
		};

		// /FUNCTIONS

		// MARKERS

		// Update position legend
		var positionLegend = function(markerName, latLng) {
			var positionElement = null;
			switch (markerName) {
			case "center":
				positionElement = positionCenter;
				break;
			case "topleft":
				positionElement = positionTopleft;
				break;
			case "topright":
				positionElement = positionTopright;
				break;
			case "bottomright":
				positionElement = positionBottomright;
				break;
			}

			if (positionElement != null) {
				positionElement.text(Core.sprintf("%s, %s", latLng.lat().toFixed(5), latLng.lng().toFixed(5)));
			}
		};

		// Initiate markers
		var markersTemp = [];
		markersTemp.push({
			name : "center",
			icon : "http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=C|FF6666|000000"
		});
		markersTemp.push({
			name : "topleft",
			icon : "http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=L|80B3FF|000000"
		});
		markersTemp.push({
			name : "topright",
			icon : "http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=R|99FF99|000000"
		});
		markersTemp.push({
			name : "bottomright",
			icon : "http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=B|FFE680|000000"
		});

		for (i in markersTemp) {
			// Init marker
			this.markers[markersTemp[i].name] = new google.maps.Marker({
				map : this.map,
				position : latlng,
				visible : false,
				draggable : true,
				clickable : false,
				icon : markersTemp[i].icon,
				name : markersTemp[i].name,
				placed : false
			});

			// Marker drag
			google.maps.event.addListener(this.markers[markersTemp[i].name], 'dragend', function(event) {
				positionLegend(this.name, event.latLng);
			});
		}

		// Init marker
		this.markers.location = new google.maps.Marker({
			map : this.map,
			position : latlng,
			visible : false,
			draggable : true,
			clickable : false,
			name : "location",
			placed : false,
			address : null
		});

		// Marker drag
		google.maps.event.addListener(this.markers.location, 'dragend', function(event) {
			MapUtil.getAddressAtLocation(context.geocoder, event.latLng, locationHandler);
		});

		positionCenterButton.click(function(event) {
			event.preventDefault();
			positionHandler("center");
		});
		positionTopleftButton.click(function(event) {
			event.preventDefault();
			positionHandler("topleft");
		});
		positionToprightButton.click(function(event) {
			event.preventDefault();
			positionHandler("topright");
		});
		positionBottomrightButton.click(function(event) {
			event.preventDefault();
			positionHandler("bottomright");
		});

		// Map click
		google.maps.event.addListener(this.map, 'click', function(event) {
			var type = context.getMapOverlayElement().attr("data-maptype");
			if (type == "address") {
				MapUtil.getAddressAtLocation(context.geocoder, event.latLng, locationHandler);
			}
		});

		// /MARKERS

		// Search click
		mapSearchButton.click(function(event) {
			event.preventDefault();
			if (mapSearchInput.val() != "") {
				MapUtil.setLocationAtAddress(context.geocoder, mapSearchInput.val(), function(result) {
					context.map.setCenter(result.geometry.location);

					var type = context.getMapOverlayElement().attr("data-maptype");
					if (type == "address") {
						locationHandler(result);
					}
				});
			}
		});

		// Search input enter press
		mapSearchInput.keypress(function(e) {
			if (e.which == 13) {
				e.preventDefault();
				mapSearchButton.click();
			}
		});

		// // Set marker
		// this.marker = new google.maps.Marker({
		// map : this.map,
		// position : latlng,
		// visible : false,
		// draggable : true,
		// clickable : false
		// });

		// // Map click
		// google.maps.event.addListener(this.map, 'click', function(event) {
		// setMarkerAtLocation(event.latLng);
		// });

		// // Search click
		// mapSearchButton.click(function() {
		// if (mapSearchInput.val() != "") {
		// setLocationAtAddress(mapSearchInput.val());
		// }
		// });

		// // Search input enter press
		// mapSearchInput.keypress(function(e) {
		// if (e.which == 13) {
		// mapSearchButton.click();
		// e.preventDefault();
		// }
		// });

		// Call map loaded callback
		// mapLoadedCallback();

		// INIT VIEWPORT

		// Address element
		var addressElement = this.getView().getWrapperElement().find("input[name*=building_address]");

		// Location element
		var locationElement = this.getView().getWrapperElement().find("input#building_location");

		// Position element
		var positionElement = this.getView().getWrapperElement().find("input[name*=building_position]");

		// Address
		if (type == "address") {
			var address = addressElement.val();
			var location = locationElement.val();
			if (address.join("") != "") {
				mapSearchInput.val(address.join(", "));
				MapUtil.setLocationAtAddress(this.geocoder, address.join(", "), function(result) {
					context.map.setCenter(result.geometry.location);
					locationHandler(result);
				});
			} else if (location != "") {
				console.log("From location");
				var latlng = new google.maps.LatLng(parseFloat(location[0]), parseFloat(location[1]));
				MapUtil.getAddressAtLocation(this.geocoder, latlng, locationHandler);
			}
		}
		// Position
		else if (type == "position") {
			var position = positionElement.val();
			var positions = new google.maps.LatLngBounds();
			var positionArray = [], latLng = null, count = 0;
			for (i in position) {
				positionArray = position[i].split(",");
				if (positionArray.length == 2) {
					latLng = new google.maps.LatLng(parseFloat(positionArray[0]), parseFloat(positionArray[1]));
					switch (i) {
					case "0":
						positionHandler("center", latLng);
						break;
					case "1":
						positionHandler("topleft", latLng);
						break;
					case "2":
						positionHandler("topright", latLng);
						break;
					case "3":
						positionHandler("bottomright", latLng);
						break;
					}
					positions.extend(latLng);
					count++;
				}
			}
			if (!positions.isEmpty()) {
				console.log(positions);
				context.map.fitBounds(positions);
			}
		}

		// /INIT VIEWPORT

	}

	// // Mark address
	// if (initAddress && initAddress.length > 0) {
	// setLocationAtAddress(initAddress);
	//
	// // Set search address
	// mapSearchInput.val(initAddress);
	// }
	//
	// // Mark lat&lng
	// if (initLatLng && initLatLng.length > 0) {
	// var latLngArray = initLatLng.split(",");
	// var latlng = new google.maps.LatLng(latLngArray[0], latLngArray[1]);
	// setMarkerAtLocation(latlng, true);
	// // Set location as center
	// this.map.setCenter(latlng);
	// }

	// Focus map search
	mapSearchInput.focus();

	// Hide/show markers
	for (i in this.markers) {
		switch (this.markers[i].name) {
		case "location":
			this.markers[i].setVisible(type == "address" && this.markers[i].placed);
			break;

		default:
			this.markers[i].setVisible(type == "position" && this.markers[i].placed);
			break;
		}
	}

};

// ... /DO

// ... HANDLE

BuildingCmsPageMainView.prototype.handleAddressMap = function() {
	var context = this;

	var maploadedCallback = function() {

	};

	// Hide/show elements
	this.getMapOverlayElement().find("#overlay_map_title_address").show();
	this.getMapOverlayElement().find("#overlay_map_title_position").hide();
	this.getMapOverlayElement().find("#overlay_map_body_address").show();
	this.getMapOverlayElement().find("#overlay_map_body_position").hide();
	this.getMapOverlayElement().find("#map_position").hide();
	this.getMapOverlayElement().find("#map_address").show();

	// Send Map load event
	this.getView().getController().getEventHandler().handle(new MaploadEvent({
		type : "address",
		loaded : maploadedCallback
	}), MapinitEvent.TYPE);

	// Do common map
	// this.doCommonMap(address.join(", "));

	// Address element
	var addressElement = this.getView().getWrapperElement().find("input[name*=building_address]");
	
	// Location element
	var locationElement = this.getView().getWrapperElement().find("input#building_location");

	// Address function
	var addressFunction = function(location) {
		var addressNumber = addressName = addressCity = addressPostal = addressCountry = "";
		var address = location.address.address_components;

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

//		$(addressElement[0]).inputHint("value",
//				addressNumber || addressName ? Core.sprintf("%s %s", addressName, addressNumber) : "");
//		$(addressElement[1]).inputHint("value", addressCity ? addressCity : "");
//		$(addressElement[2]).inputHint("value", addressPostal ? addressPostal : "");
//		$(addressElement[3]).inputHint("value", addressCountry ? addressCountry : "");
//		
//		locationElement.inputHint("value", location.getVisible() ? Core.sprintf("%s,%s", location.position.lat().toFixed(5), location.position.lng().toFixed(5)) : "");

	};

	// OK handle
	var okHandle = function() {
		if (context.markers.location.getVisible() && context.markers.location.address) {
			addressFunction(context.markers.location);
		}
		return true;
	};

	// Close handle
	var closeHandle = function() {
		context.getView().getController().updateHash({
			"map" : null
		});
	};

	// Call overlay event
	this.getView().getController().getEventHandler().handle(new OverlayEvent({
		"ok" : okHandle,
		"close" : closeHandle
	}, "overlay_map"));

};

BuildingCmsPageMainView.prototype.handlePositionMap = function() {
	var context = this;

	var maploadedCallback = function() {

	};

	this.getView().getController().getEventHandler().handle(new MaploadEvent({
		type : "position",
		loaded : maploadedCallback
	}), MapinitEvent.TYPE);

	// // Initiate location element
	// var locationElement = $("input#building_location");

	this.getMapOverlayElement().find("#overlay_map_title_address").hide();
	this.getMapOverlayElement().find("#overlay_map_title_position").show();
	this.getMapOverlayElement().find("#overlay_map_body_address").hide();
	this.getMapOverlayElement().find("#overlay_map_body_position").show();
	this.getMapOverlayElement().find("#map_position").show();
	this.getMapOverlayElement().find("#map_address").hide();

	// // Do common map
	// this.doCommonMap(null, locationElement.val());

	// Position element
	var positionElement = this.getView().getWrapperElement().find("input[name*=building_position]");

	// Position handle
	var positionHandle = function(markerName) {
		if (context.markers[markerName].getVisible()) {
			var index = -1;
			switch (markerName) {
			case "center":
				index = 0;
				break;
			case "topleft":
				index = 1;
				break;
			case "topright":
				index = 2;
				break;
			case "bottomright":
				index = 3;
				break;
			}
			if (index != -1 && positionElement[index] != null) {
				$(positionElement[index]).inputHint(
						"value",
						Core.sprintf("%s,%s", context.markers[markerName].position.lat().toFixed(5),
								context.markers[markerName].position.lng().toFixed(5)));
			}
		}
	};

	// OK handle
	var okHandle = function() {
		positionHandle("center");
		positionHandle("topleft");
		positionHandle("topright");
		positionHandle("bottomright");
		return true;
	};

	// Close handle
	var closeHandle = function() {
		context.getView().getController().updateHash({
			"map" : null
		});
	};

	// Call overlay event
	this.getView().getController().getEventHandler().handle(new OverlayEvent({
		"ok" : okHandle,
		"close" : closeHandle
	}, "overlay_map"));

};

// ... /HANDLE

/**
 * @param {Element}
 *            root
 */
BuildingCmsPageMainView.prototype.draw = function(root) {
	PageMainView.prototype.draw.call(this, root);
};

// /FUNCTIONS
