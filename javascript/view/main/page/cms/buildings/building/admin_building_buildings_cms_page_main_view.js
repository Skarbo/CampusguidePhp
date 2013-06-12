// CONSTRUCTOR
AdminBuildingBuildingsCmsPageMainView.prototype = new AbstractPageMainView();

function AdminBuildingBuildingsCmsPageMainView(view) {
	AbstractPageMainView.apply(this, arguments);
	this.map = null;
	this.geocoder = null;
	this.markers = {
		location : null,
		position : null
	};
	this.polygons = [];
};

// /CONSTRUCTOR

// VARIABLES

AdminBuildingBuildingsCmsPageMainView.MARKER_TYPE_LOCATION = "location";
AdminBuildingBuildingsCmsPageMainView.MARKER_TYPE_POSITION = "position";

// /VARIABLES

// FUNCTIONS

// ... GETTERS/SETTERS

// ... /GETTERS/SETTERS

// ... GET

/**
 * @return {BuildingsCmsMainView}
 */
AdminBuildingBuildingsCmsPageMainView.prototype.getView = function() {
	return AbstractPageMainView.prototype.getView.call(this);
};

// ... ... ELEMENT

AdminBuildingBuildingsCmsPageMainView.prototype.getMapOverlayElement = function() {
	return this.getRoot().find("#overlay_map");
};

AdminBuildingBuildingsCmsPageMainView.prototype.getSearchAddressButtonElement = function() {
	return this.getRoot().find("#address_search");
};

AdminBuildingBuildingsCmsPageMainView.prototype.getMapCanvasElement = function() {
	return this.getRoot().find("#map_canvas");
};

AdminBuildingBuildingsCmsPageMainView.prototype.getFormElement = function() {
	return this.getRoot().find("form#building_form");
};

AdminBuildingBuildingsCmsPageMainView.prototype.getAddressInputElements = function() {
	return this.getRoot().find("input[name*=building_address]");
};

AdminBuildingBuildingsCmsPageMainView.prototype.getLocationInputElement = function() {
	return this.getRoot().find("input[name=building_location]");
};

AdminBuildingBuildingsCmsPageMainView.prototype.getPositionInputElement = function() {
	return this.getRoot().find("input[name=building_position]");
};

AdminBuildingBuildingsCmsPageMainView.prototype.getOverlayInputElement = function() {
	return this.getRoot().find("[name=building_overlay]");
};

AdminBuildingBuildingsCmsPageMainView.prototype.getLocationPlaceButtonElement = function() {
	return this.getRoot().find("#address_place");
};

AdminBuildingBuildingsCmsPageMainView.prototype.getOverlayClearButtonElement = function() {
	return this.getRoot().find("#overlay_clear");
};

AdminBuildingBuildingsCmsPageMainView.prototype.getPositionPlaceButtonElement = function() {
	return this.getRoot().find("#position_place");
};

// ... ... /ELEMENT

/**
 * @returns Array
 */
AdminBuildingBuildingsCmsPageMainView.prototype.getAddressValue = function() {
	return this.getAddressInputElements().map(function() {
		return $(this).val();
	}).get();
};

// ... /GET

// ... DO

AdminBuildingBuildingsCmsPageMainView.prototype.doBindEventHandler = function() {
	var context = this;

	// Facilities slider
	this.doFacilitiesSlider();

	// EVENTS

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

	// /EVENTS

	// Form submit
	this.getFormElement().submit(function(event) {
		// Overlay
		if (context.map) {
			var polygonsArray = [];
			for (i in context.polygons) {
				var polygonEncode = google.maps.geometry.encoding.encodePath(context.polygons[i].getPath());
				if (polygonEncode != null && polygonEncode != "")
					polygonsArray.push(polygonEncode);
			}
			context.getOverlayInputElement().val(JSON.stringify(polygonsArray));
		}
		return true;
	});

	// Map search
	this.getSearchAddressButtonElement().click(function(event) {
		context.doAddressSearch();
	});

	// Place markers
	this.getLocationPlaceButtonElement().click(function() {
		if (context.map && context.geocoder) {
			context.handleMarkerPlace(context.markers.location, null);
			MapUtil.getAddressAtLocation(context.geocoder, context.map.getCenter(), function(result) {
				context.handleAddressSearch(result);
			});
		} else {
			console.warn("Map and Geocoder is not loaded");
		}
	});
	this.getPositionPlaceButtonElement().click(function() {
		context.handleMarkerPlace(context.markers.position, null);
	});

	// Clear overlay
	this.getOverlayClearButtonElement().click(function() {
		for ( var i in context.polygons) {
			context.polygons[i].getPath().clear();
			context.polygons[i].setVisible(false);
		}
	});

};

AdminBuildingBuildingsCmsPageMainView.prototype.doFacilitiesSlider = function() {

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

AdminBuildingBuildingsCmsPageMainView.prototype.doMap = function() {
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
		google.maps.visualRefresh = true;
		this.map = new google.maps.Map(this.getMapCanvasElement()[0], options);

		// DRAWING MANAGER

		var drawingManager = new google.maps.drawing.DrawingManager({
			drawingMode : null,
			drawingControl : true,
			drawingControlOptions : {
				position : google.maps.ControlPosition.TOP_CENTER,
				drawingModes : [ google.maps.drawing.OverlayType.POLYGON ]
			},
			polygonOptions : {
				editable : true,
				fillColor : "#134F5C",
				fillOpacity : 0.6,
				strokeWeight : 0
			}
		});
		drawingManager.setMap(this.map);

		google.maps.event.addListener(drawingManager, 'polygoncomplete', function(polygon) {
			context.polygons.push(polygon);

			polygon.addListener("rightclick", function(event) {
				if (event.vertex != undefined) {
					context.doPolygonVertexRemove(this, event.vertex);
				}
			});
		});

		// /DRAWING MANAGER

		// MARKERS

		// Location
		var location = this.getLocationInputElement().val().split(",");
		var locationLatLng = location.length >= 2 ? new google.maps.LatLng(parseFloat(location[0]), parseFloat(location[1])) : latlng;
		this.markers.location = new google.maps.Marker({
			map : this.map,
			position : locationLatLng,
			visible : location.length >= 2,
			draggable : true,
			clickable : false,
			icon : "http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=A|FF6666|000000",
			name : "Address",
			title : "Address",
			placed : false,
			type : AdminBuildingBuildingsCmsPageMainView.MARKER_TYPE_LOCATION
		});

		google.maps.event.addListener(this.markers.location, 'dragend', function(event) {
			MapUtil.getAddressAtLocation(context.geocoder, event.latLng, function(result) {
				context.handleAddressSearch(result);
			});
		});

		// Position
		var position = this.getPositionInputElement().val().split(",");
		var positionLatLng = position.length >= 2 ? new google.maps.LatLng(parseFloat(position[0]), parseFloat(position[1])) : latlng;
		this.markers.position = new google.maps.Marker({
			map : this.map,
			position : positionLatLng,
			visible : position.length >= 2,
			draggable : true,
			clickable : false,
			icon : "https://chart.googleapis.com/chart?chst=d_map_pin_letter&chld=P|80B3FF|000000",
			name : "Position",
			title : "Position",
			placed : false,
			type : AdminBuildingBuildingsCmsPageMainView.MARKER_TYPE_POSITION
		});

		google.maps.event.addListener(this.markers.position, 'dragend', function(event) {
			context.handleMarkerPlace(this, event.latLng);
		});

		// /MARKERS

		// OVERLAY
		var overlay = this.getOverlayInputElement().val();
		if (overlay != "") {
			var overlays = JSON.parse(overlay);
			for ( var i in overlays) {
				if (overlays[i] != "") {
					var paths = google.maps.geometry.encoding.decodePath(overlays[i]);

					var polygon = new google.maps.Polygon({
						paths : paths,
						editable : true,
						fillColor : "#134F5C",
						fillOpacity : 0.6,
						strokeWeight : 0
					});
					polygon.setMap(this.map);

					polygon.addListener("rightclick", function(event) {
						if (event.vertex != undefined) {
							context.doPolygonVertexRemove(this, event.vertex);
						}
					});

					this.polygons.push(polygon);
				}
			}
		}

		// /OVERLAY

		// VIEWPORT

		var viewportBounds = new google.maps.LatLngBounds();

		var address = this.getAddressValue();
		var location = this.getLocationInputElement().val().split(",");
		var position = this.getPositionInputElement().val().split(",");

		// Location
		if (location.length >= 2) {
			viewportBounds.extend(new google.maps.LatLng(parseFloat(location[0]), parseFloat(location[1])));
		}
		// // Address
		// else if (address.join("") != "") {
		// console.log("Viewport from address: " + address);
		// this.doAddressSearch();
		// }
		// Position
		if (position.length >= 2) {
			viewportBounds.extend(new google.maps.LatLng(parseFloat(position[0]), parseFloat(position[1])));
		}
		// Overlay
		if (this.polygons.length > 0) {
			for ( var i in this.polygons) {
				var path = this.polygons[i].getPath();
				path.forEach(function(element, index) {
					viewportBounds.extend(element);
				});
			}
		}

		// Fit map to viewport
		if (!viewportBounds.isEmpty())
			this.map.fitBounds(viewportBounds);
		// this.map.panToBounds(viewportBounds);

		// /VIEWPORT

	}

};

AdminBuildingBuildingsCmsPageMainView.prototype.doCommonMap = function(options) {
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

		// Location
		this.markers.location = new google.maps.Marker({
			map : this.map,
			position : latlng,
			visible : false,
			draggable : true,
			clickable : false,
			icon : "http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=A|FF6666|000000",
			name : "Address",
			placed : false,
			markerType : AdminBuildingBuildingsCmsPageMainView.MARKER_TYPE_LOCATION
		});

		google.maps.event.addListener(this.markers.location, 'dragend', function(event) {
			context.handleMarkerPlace(this.markerType, event.latLng);
		});

		// Position
		this.markers.position = new google.maps.Marker({
			map : this.map,
			position : latlng,
			visible : false,
			draggable : true,
			clickable : false,
			icon : "https://chart.googleapis.com/chart?chst=d_map_pin_letter&chld=P|80B3FF|000000",
			name : "Position",
			placed : false,
			markerType : AdminBuildingBuildingsCmsPageMainView.MARKER_TYPE_LOCATION
		});

		google.maps.event.addListener(this.markers.position, 'dragend', function(event) {
			context.handleMarkerPlace(this.markerType, event.latLng);
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
		var addressElement = this.getView().getWrapperElement().find("input[name='building_address\\[\\]']");

		// Location element
		var locationElement = this.getView().getWrapperElement().find("input#building_location");

		// Position element
		var positionElement = this.getView().getWrapperElement().find("input[name*=building_position]");

		// Address
		if (type == "address") {
			var address = addressElement.map(function() {
				return $(this).val();
			}).get();
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
				// console.log("Positions", positions);
				// context.map.fitBounds(positions);
			}
		}

		// /INIT VIEWPORT

		// DRAWING MANAGER

		var drawingManager = new google.maps.drawing.DrawingManager({
			drawingMode : null,
			drawingControl : true,
			drawingControlOptions : {
				position : google.maps.ControlPosition.TOP_CENTER,
				drawingModes : [ google.maps.drawing.OverlayType.POLYGON ]
			},
			polygonOptions : {
				editable : true
			}
		});
		drawingManager.setMap(this.map);

		google.maps.event.addListener(drawingManager, 'polygoncomplete', function(polygon) {
			context.polygons.push(polygon);

			polygon.addListener("rightclick", function(event) {
				if (event.vertex != undefined) {
					this.getPath().removeAt(event.vertex);
					if (this.getPath().length <= 2) {
						this.getPath().clear();
					}
				}
			});
		});

		// /DRAWING MANAGER

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

	// Hide/show markers/polygons
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
	for (i in this.polygons) {
		this.polygons[i].setVisible(true);
	}

};

AdminBuildingBuildingsCmsPageMainView.prototype.doAddressSearch = function() {
	var context = this;

	if (this.map && this.geocoder) {
		var address = this.getAddressValue();
		if (address.join("") != "") {
			MapUtil.setLocationAtAddress(context.geocoder, address.join(", "), function(result) {
				context.handleAddressSearch(result);
			});
		}
	} else {
		console.warn("Map and Geocoder is not loaded");
	}
};

AdminBuildingBuildingsCmsPageMainView.prototype.doPolygonVertexRemove = function(polygon, vertex) {
	polygon.getPath().removeAt(vertex);
	if (polygon.getPath().length <= 2) {
		polygon.getPath().clear();
	}
};

// ... /DO

// ... HANDLE

AdminBuildingBuildingsCmsPageMainView.prototype.handleAddressSearch = function(result) {
	this.map.setCenter(result.geometry.location);
	this.markers.location.address = result;
	this.handleMarkerPlace(this.markers.location, result.geometry.location);
};

AdminBuildingBuildingsCmsPageMainView.prototype.handleMarkerPlace = function(marker, latLng) {
	if (!this.map)
		return console.warn("Map is not loaded");

	latLng = latLng || this.map.getCenter();
	var coordinate = Core.sprintf("%s,%s", latLng.lat().toFixed(5), latLng.lng().toFixed(5));

	marker.setPosition(latLng);
	marker.setVisible(true);
	marker.placed = true;

	switch (marker.type) {
	case AdminBuildingBuildingsCmsPageMainView.MARKER_TYPE_LOCATION:
		this.getLocationInputElement().val(coordinate);
		this.handleAddressPlace();
		break;

	case AdminBuildingBuildingsCmsPageMainView.MARKER_TYPE_POSITION:
		this.getPositionInputElement().val(coordinate);
		break;
	}
};

AdminBuildingBuildingsCmsPageMainView.prototype.handleAddressPlace = function() {
	if (!this.markers.location.address)
		return;

	var addressNumber = addressName = addressCity = addressPostal = addressCountry = "";
	var address = this.markers.location.address.address_components;

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

	var addressElement = this.getAddressInputElements();
	$(addressElement[0]).val(addressNumber || addressName ? Core.sprintf("%s %s", addressName, addressNumber) : "");
	$(addressElement[1]).val(addressCity ? addressCity : "");
	$(addressElement[2]).val(addressPostal ? addressPostal : "");
	$(addressElement[3]).val(addressCountry ? addressCountry : "");
};

AdminBuildingBuildingsCmsPageMainView.prototype.handleAddressMap = function() {
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
	var overlayElement = this.getView().getWrapperElement().find("input[name=building_overlay]");
	var overlayImgElement = this.getView().getWrapperElement().find("img#overlay_map_image");

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

		$(addressElement[0]).val(addressNumber || addressName ? Core.sprintf("%s %s", addressName, addressNumber) : "");
		$(addressElement[1]).val(addressCity ? addressCity : "");
		$(addressElement[2]).val(addressPostal ? addressPostal : "");
		$(addressElement[3]).val(addressCountry ? addressCountry : "");

		locationElement.val(location.getVisible() ? Core.sprintf("%s,%s", location.position.lat().toFixed(5), location.position.lng().toFixed(5)) : "");
	};

	// OK handle
	var okHandle = function() {
		if (context.markers.location.getVisible() && context.markers.location.address) {
			addressFunction(context.markers.location);
		}

		// Polygons
		var polygonsArray = [];
		for (i in context.polygons) {
			var polygonEncode = google.maps.geometry.encoding.encodePath(context.polygons[i].getPath());
			if (polygonEncode != null)
				polygonsArray.push(polygonEncode);
		}

		var overlaySrc = overlayImgElement.attr("data-src");
		var overlayUrl = "";
		var match = overlaySrc.match(/&path=.+/);
		if (match != null) {
			var pathSrc = match[0];
			overlayUrl = overlaySrc.replace(pathSrc, "");
			for (i in polygonsArray) {
				overlayUrl += Core.sprintf(pathSrc, polygonsArray[i]);
			}
			overlayImgElement.attr("src", overlayUrl);
		}

		overlayElement.val(JSON.stringify(polygonsArray));

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

AdminBuildingBuildingsCmsPageMainView.prototype.handlePositionMap = function() {
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
				// $(positionElement[index]).inputHint("value",
				// Core.sprintf("%s,%s",
				// context.markers[markerName].position.lat().toFixed(5),
				// context.markers[markerName].position.lng().toFixed(5)));
				$(positionElement[index]).val(Core.sprintf("%s,%s", context.markers[markerName].position.lat().toFixed(5), context.markers[markerName].position.lng().toFixed(5)));
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
AdminBuildingBuildingsCmsPageMainView.prototype.draw = function(root) {
	AbstractPageMainView.prototype.draw.call(this, root);
};

// /FUNCTIONS
