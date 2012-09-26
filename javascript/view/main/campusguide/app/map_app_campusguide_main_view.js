// CONSTRUCTOR
MapAppCampusguideMainView.prototype = new AppCampusguideMainView();

function MapAppCampusguideMainView(wrapperId) {
	AppCampusguideMainView.apply(this, arguments);
	this.map = null;
	this.geocoder = null;
	this.geolocationWatchProcess = null;
	this.markerLocation = null;
	this.mapLoaded = false;
	this.markerBuildings = {};
	this.overlayBuilding = false;
}

// /CONSTRUCTOR

// VARIABLES

MapAppCampusguideMainView.POSITION_LENGTH_MIN = 0.03; // 30 meters

// /VARIABLES

// FUNCTIONS

// ... GET

/**
 * @return {MapAppCampusguideMainController}
 */
MapAppCampusguideMainView.prototype.getController = function() {
	return AppCampusguideMainView.prototype.getController.call(this);
};

/**
 * @return {Object}
 */
MapAppCampusguideMainView.prototype.getPageWrapper = function() {
	return this.getWrapperElement().find("#page_wrapper");
};

/**
 * @return {Object}
 */
MapAppCampusguideMainView.prototype.getBuildingSliderElement = function() {
	return this.getWrapperElement().find("#building_slider_wrapper");
};

/**
 * @return {Object}
 */
MapAppCampusguideMainView.prototype.getMenuActionBar = function() {
	return this.getWrapperElement().find(".menu_wrapper .action_bar");
};

/**
 * @return {Array} [lat, lng, zoom] Null if not exit
 */
MapAppCampusguideMainView.prototype.getMapBounds = function() {
	var mapBounds = this.getController().getLocalStorageVariable("mapbounds");
	if (!mapBounds)
		return null;
	var mapBoundsArray = mapBounds.split("|");
	return [ parseFloat(mapBoundsArray[0]), parseFloat(mapBoundsArray[1]), parseInt( mapBoundsArray[2] ) ];
};

// ... /GET

// ... SET

MapAppCampusguideMainView.prototype.setMapBounds = function(lat, lng, zoom) {
	this.getController().setLocalStorageVariable("mapbounds", Core.sprintf("%s|%s|%s", lat, lng, zoom));
};

// ... /SET

// ... DO

MapAppCampusguideMainView.prototype.doBindEventHandler = function() {
	AppCampusguideMainView.prototype.doBindEventHandler.call(this);
	var context = this;

	// MAP

	this.getController().getEventHandler().registerListener(MapinitEvent.TYPE,
	/**
	 * @param {MapinitEvent}
	 *            event
	 */
	function(event) {
		context.handleMapInit();
	});

	this.getController().getEventHandler().registerListener(MaploadedEvent.TYPE,
	/**
	 * @param {MaploadedEvent}
	 *            event
	 */
	function(event) {
		context.handleMapLoaded();
	});

	// ... BUILDINGS

	this.getController().getEventHandler().registerListener(BuildingsRetrievedEvent.TYPE,
	/**
	 * @param {BuildingsRetrievedEvent}
	 *            event
	 */
	function(event) {
		context.handleMapBuildings(event.getBuildings());
	});

	// ... /BUILDINGS

	// ... BUILDING SLIDER

	var buildingSlider = this.getWrapperElement().find("#building_slider_wrapper");
	buildingSlider.drag(function(event, dd) {

		// Slider
		var slider = $(dd.target);

		if (slider.hasClass("finished")) {
			return false;
		}

		// Slide max
		var slideMax = parseInt(slider.attr("data-slide-max"));

		// Slide min
		var slideMin = parseFloat(slider.attr("data-slide-min"));

		// Calculate slide
		var slide = Math.max(slideMin, Math.min(slideMax, dd.deltaX));

		// Set slider padding
		slider.css("padding-left", slide);

		// Calculate slide procent
		var slideProcent = dd.deltaX / slideMax;

		if (slideProcent > 0.4) {

			// Remove drag class
			slider.removeClass("drag");

			// Add finished class
			slider.addClass("finished");

			// Set slider padding
			slider.css("padding-left", slideMax);

			// Handle building slide
			context.handleBuildingSlide();

			return false;
		}

	});

	buildingSlider.drag("start", function(event, dd) {

		// Slider
		var slider = $(dd.target);

		// Parent
		var parent = slider.parent();

		// Add drag clas
		slider.addClass("drag");

		// Set max width attr
		slider.attr("data-slide-max", parent.width() - slider.outerWidth());

		// Set slide min attr
		slider.attr("data-slide-min", slider.css("padding-left").replace("px", ""));

	});

	buildingSlider.drag("end", function(event, dd) {

		// Slider
		var slider = $(dd.target);

		// Remove drag class
		slider.removeClass("drag");

		// Slide min
		var slideMin = parseFloat(slider.attr("data-slide-min"));

		// Reset padding
		slider.css("padding-left", slideMin);

	});

	// ... /BUILDING SLIDER

	this.getController().getEventHandler().registerListener(PositionEvent.TYPE,
	/**
	 * @param {PositionEvent}
	 *            event
	 */
	function(event) {
		context.handlePosition(event.getLanLon());
	});

	// /MAP

	// MENU

	// Search
	this.getWrapperElement().find(".menu_button_search").click(function(event) {
		event.preventDefault();
		// Send overlay event
		context.getController().getEventHandler().handle(new OverlayEvent({}, "search_overlay"));

		context.getWrapperElement().find("#search_input").select();
	});

	// Location
	this.getMenuActionBar().find(".menu_button_location").click(500, function(event) {
		event.preventDefault();
		context.doActionBarMenu(event, context.getWrapperElement().find("#actionbar_menu_wrapper #actionbar_menu_locationpin"));
	}).click(function(event) {
		event.preventDefault();
		context.doGeolocationInit();
	});

	// Actionbar view control
	this.getMenuActionBar().find("#actionbar_viewcontrol_map").click(function(event) {
		event.preventDefault();
		context.doActionBarMenu(event, context.getWrapperElement().find("#actionbar_menu_wrapper .menu_item.viewcontrol"));
	});

	// Set location
	this.getWrapperElement().find("#actionbar_menu_locationpin").click(function(event) {
		event.preventDefault();

		// Do set position
		context.doPositionSet();

		// Close menu
		// context.doActionBarMenuClose();
	});

	// /MENU

	// HASH

	$(window).hashchange(function() {
		var hashObject = context.getController().getHash();

		// BUILDING OVERLAY

		if (hashObject.building) {
			context.getController().getBuildingDao().get(hashObject.building, function(building) {

				// Overlay options
				var overlayOptions = {
					cancelHandle : function() {
						context.getController().updateHash({
							building : null
						});
						context.overlayBuilding = false;
					},
					title : building.name,
					bodyHandle : function(body) {
						var takemethereElement = body.find("a.takemethere");
						takemethereElement.unbind("click");
						takemethereElement.click(function(event) {
							event.preventDefault();
							context.handleBuildingTakemethere(building, takemethereElement.attr("data-url"));
						});

						var view = body.find("a.view");
						view.attr("href", Core.sprintf(view.attr("data-url"), building.id));
						// view.unbind("click");
						// view.click(function(event) {
						// event.preventDefault();
						// context.getController().getEventHandler().handle(
						// new ViewBuildingEvent(building.id));
						// });
					}
				};

				// Send overlay event
				context.getController().getEventHandler().handle(new OverlayEvent(overlayOptions, "map_building_overlay"));

				context.overlayBuilding = true;

			});

		} else if (context.overlayBuilding) {
			context.getController().getEventHandler().handle(new OverlayCloseEvent("map_building_overlay"));
		}

		// /BUILDING OVERLAY

	});

	$(window).hashchange();

	// /HASH

};

MapAppCampusguideMainView.prototype.doGeolocationInit = function() {
	var context = this;

	if (this.geolocationWatchProcess == null) {
		this.geolocationWatchProcess = navigator.geolocation.watchPosition(function(position) {
			context.handleGeolocationQuery(position);
		}, function(error) {
			context.handleGeolocationError(error);
		});
	}
};

MapAppCampusguideMainView.prototype.doGeolocationStop = function() {
	if (this.geolocationWatchProcess != null) {
		navigator.geolocation.clearWatch(this.geolocationWatchProcess);
		this.geolocationWatchProcess == null;
	}
};

MapAppCampusguideMainView.prototype.doBuildingSlider = function(buildingId) {
	var buildingSlider = this.getWrapperElement().find("#building_slider_wrapper");

	if (buildingId) {
		buildingSlider.attr("data-buildingid", buildingId);
		buildingSlider.removeClass("hide");
	} else {
		buildingSlider.addClass("hide");
	}

};

MapAppCampusguideMainView.prototype.doPositionSet = function() {
	var context = this;

	if (this.mapLoaded) {

		// Map click
		google.maps.event.addListenerOnce(this.map, 'click', function(event) {

			// Set marker position
			context.markerLocation.setPosition(event.latLng);

			// Handle position set
			context.handlePositionSet(event.latLng);
		});

	}

};

MapAppCampusguideMainView.prototype.doFitToParent = function() {
	if (this.map)
		$("#map_page_wrapper").hide();
	AppCampusguideMainView.prototype.doFitToParent.call(this);

	// Resize map
	if (this.map) {
		$("#map_page_wrapper").show();
		google.maps.event.trigger(this.map, 'resize');
	}

};

MapAppCampusguideMainView.prototype.doActionBarMenu = function(event, menuItem) {
	var context = this;
	var button = $(event.target);
	var menu = button.parents(".menu_wrapper");
	var isTopMenu = menu.filter("#menu_top_wrapper").length > 0;
	var arrow = this.getWrapperElement().find("#actionbar_menu_wrapper .arrow");

	this.getWrapperElement().find("#actionbar_menu_wrapper").removeClass("hide");
	menuItem.removeClass("hide");
	arrow.hide();

	var arrowMargin = Core.roundNumber(((button.position().left + (button.outerWidth() / 2) - (arrow.outerWidth() / 2)) - menu.position().left)
			/ ((menu.position().left + menu.outerWidth()) - menu.position().left) * 100, 2);

	if (isTopMenu) {
		var arrowUp = arrow.filter("[data-arrow=up]");
		arrowUp.show();
		arrowUp.css("margin-left", arrowMargin + "%");

		this.getWrapperElement().find("#actionbar_menu_wrapper > *").css("vertical-align", "top");
	} else {
		var arrowDown = arrow.filter("[data-arrow=down]");
		arrowDown.show();
		arrowDown.css("margin-left", arrowMargin + "%");

		this.getWrapperElement().find("#actionbar_menu_wrapper > *").css("vertical-align", "bottom");
	}

	setTimeout(function() {
		$(document).unbind(".actionbar_menu").bind("click.actionbar_menu", function(event) {
			var close = $(event.target).parentsUntil("#actionbar_menu_wrapper #actionbar_menu").parent().filter("#actionbar_menu_wrapper #actionbar_menu").length == 0;
			if (close) {
				context.doActionBarMenuClose();
			}
		});
	}, 100);
};

MapAppCampusguideMainView.prototype.doActionBarMenuClose = function() {
	this.getWrapperElement().find("#actionbar_menu_wrapper").addClass("hide");
	this.getWrapperElement().find("#actionbar_menu_wrapper .menu_item").addClass("hide");
	$(document).unbind(".actionbar_menu");
};

// ... /DO

// ... HANDLE

MapAppCampusguideMainView.prototype.handleMapInit = function() {
	var context = this;

	// Initialize geocoder
	if (!this.geocoder) {
		this.geocoder = new google.maps.Geocoder();
	}

	// Initialize map
	if (!this.map) {

		// Set canvsa width/height
		// this.getWrapperElement().find("#map_canvas").height(this.getWrapperElement().find("#page_wrapper").height()).width(this.getWrapperElement().find("#page_wrapper").width());

		var mapBounds = this.getMapBounds();
		if (!mapBounds)
			mapBounds = [60.39126, 5.32205, 15];
console.log("Map bounds", mapBounds);		
		var latlng = new google.maps.LatLng(mapBounds[0], mapBounds[1]);
		var options = {
			zoom : mapBounds[2],
			center : latlng,
			mapTypeId : google.maps.MapTypeId.ROADMAP,
			zoomControl : true,
			zoomControlOptions : {
				position : google.maps.ControlPosition.RIGHT_BOTTOM
			},
			streetViewControl : false,
			mapTypeControlOptions : {
				style : google.maps.MapTypeControlStyle.DROPDOWN_MENU,
				position : google.maps.ControlPosition.RIGHT_TOP
			}
		};

		// Set map
		this.map = new google.maps.Map(document.getElementById("map_canvas"), options);

		// POSITION MARKER

		// Set marker
		var image = "image/icon/location_blue_black_15x15.png";
		this.markerLocation = new google.maps.Marker({
			map : this.map,
			position : latlng,
			icon : image,
			draggable : true,
			visible : false
		});

		// Marker drag
		google.maps.event.addListener(this.markerLocation, 'dragend', function(event) {
			// Handle position set
			context.handlePositionSet(event.latLng);
		});

		// /POSITION MARKER

		// Map bound changed
		google.maps.event.addListener(this.map, 'bounds_changed', function() {
			var center = context.map.getBounds().getCenter();
			context.setMapBounds(center.lat(), center.lng(), context.map.getZoom());
		});

		// Listen to map idle
		context.getController().getEventHandler().handle(new MaploadedEvent());
		// google.maps.event.addListenerOnce(this.map, 'idle', function() {
		// console.log("Map idle");
		// });

	}

};

MapAppCampusguideMainView.prototype.handleMapLoaded = function() {
	this.mapLoaded = true;

	// Show map/hide loader
	this.getWrapperElement().find("#map_canvas").removeClass("hide");
	this.getWrapperElement().find("#map_loader").addClass("hide");

	// Get geolocation
	if (this.getController().getLocalStorageVariable("geolocation")) {
		this.doGeolocationInit();
	}
};

MapAppCampusguideMainView.prototype.handleMapBuildings = function(buildings) {
	var context = this;

	if (this.mapLoaded) {

		// Map buildings loaded function
		var buildingsLoaded = 0;
		var mapBuildingsLoaded = function() {
			if (++buildingsLoaded == Core.countObject(buildings)) {
				context.getController().getEventHandler().handle(new BuildingMapLoadedEvent());
			}
		};

		// Set location at address function
		var setMarkerAtAddress = function(address, marker) {
			context.geocoder.geocode({
				'address' : address
			}, function(results, status) {
				if (status == google.maps.GeocoderStatus.OK) {
					if (results[0]) {
						marker.setPosition(results[0].geometry.location);
						marker.setVisible(true);
						mapBuildingsLoaded();
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
			mapBuildingsLoaded();
		};

		// Foreach Buildings
		var building, address;
		for (buildingId in buildings) {
			building = buildings[buildingId];
			address = jQuery.isArray(building.address) ? building.address.join(", ") : "";

			// Add marker
			this.markerBuildings[buildingId] = new google.maps.Marker({
				map : this.map,
				visible : false,
				buildingId : buildingId,
				clickable : true
			});

			// Building position
			if (jQuery.isArray(building.position) && building.position.length == 4) {
				setMarkerAtLocation(new google.maps.LatLng(building.position[0][0], building.position[0][1]), this.markerBuildings[buildingId]);
			}
			// Building location
			else if (jQuery.isArray(building.location) && building.location.length == 2) {
				setMarkerAtLocation(new google.maps.LatLng(building.location[0], building.location[1]), this.markerBuildings[buildingId]);
			}
			// Building address
			else if (address) {
				setMarkerAtAddress(address, this.markerBuildings[buildingId]);
			}

			// Building click
			google.maps.event.addListener(this.markerBuildings[buildingId], 'click', function(event) {
				context.getController().updateHash({
					"building" : this.buildingId
				});
			});
			/*
			 * // Building coordinates var positions =
			 * buildings[buildingId].position; var coordinates =
			 * buildings[buildingId].coordinates; console.log("Outer bounds",
			 * CanvasUtil.getOuterBounds(coordinates));
			 * 
			 * if (positions && positions.length == 4) { var outerBounds =
			 * CanvasUtil.getOuterBounds(coordinates); var corLeft =
			 * outerBounds[0], corTop = outerBounds[1], corRight =
			 * outerBounds[2], corBottom = outerBounds[3]; var corOrigo = [0,
			 * 0]; var corCenter = [Math.round((corLeft[0] + corTop[0] +
			 * corRight[0]) / 3), Math.round((corLeft[1] + corTop[1] +
			 * corRight[1]) / 3)]; var gpsLeft = positions[1], gpsTop =
			 * positions[2], gpsRight = positions[3]; var gpsOrigo =
			 * [gpsLeft[0], gpsTop[1]]; var gpsCenter = [parseFloat(((gpsLeft[0] +
			 * gpsTop[0] + gpsRight[0]) / 3).toFixed(5)),
			 * parseFloat(((gpsLeft[1] + gpsTop[1] + gpsRight[1]) /
			 * 3).toFixed(5))]; var gpsMesaruement = [gpsCenter[0] -
			 * gpsOrigo[0], gpsCenter[1] - gpsOrigo[1]]; var measurementX =
			 * Math.abs(gpsTop[0] - gpsLeft[0]) / Math.abs(corTop[0] -
			 * corLeft[0]), measurementY = Math.abs(gpsTop[1] - gpsLeft[1]) /
			 * Math.abs(corTop[1] - corLeft[1]); console.log(corOrigo,
			 * corCenter, gpsOrigo, gpsCenter, gpsMesaruement);
			 * 
			 * var latLngs = [], lat, lng, coordinate; for (i in coordinates) {
			 * coordinate = [coordinates[i][0], coordinates[i][1]]; lat =
			 * ((gpsMesaruement[0] * coordinate[0]) + gpsOrigo[0]).toFixed(5);
			 * lng = ((gpsMesaruement[1] * coordinate[1]) +
			 * gpsOrigo[1]).toFixed(5); console.log(coordinate, lat, lng);
			 * latLngs.push(new google.maps.LatLng(lat, lng)); }
			 * 
			 * new google.maps.Polygon({ paths: latLngs, strokeColor: "#FF0000",
			 * strokeOpacity: 0.8, strokeWeight: 2, fillColor: "#FF0000",
			 * fillOpacity: 0.35, map : this.map }); return;
			 * //console.log("Test", test); }
			 */
		}

	}

};

MapAppCampusguideMainView.prototype.handleGeolocationError = function(error) {
	switch (error.code) {
	case error.PERMISSION_DENIED:
		alert("user did not share geolocation data");
		break;

	case error.POSITION_UNAVAILABLE:
		alert("could not detect current position");
		break;

	case error.TIMEOUT:
		alert("retrieving position timed out");
		break;

	default:
		alert("unknown error");
		break;
	}
};

MapAppCampusguideMainView.prototype.handleGeolocationQuery = function(position) {

	if (this.mapLoaded) {

		// Set lat/lng
		var latlng = new google.maps.LatLng(position.coords.latitude.toFixed(5), position.coords.longitude.toFixed(5));

		// Is set as automatic
		if (!this.markerLocation.automatic) {

			// Set geolocation to local storage
			this.getController().setLocalStorageVariable("geolocation", "true");

			// Set marker icon
			var image = "image/icon/location_blue_15x15.png";
			this.markerLocation.setIcon(image);

			// Set marker as visible
			this.markerLocation.setVisible(true);

			// Set map center
			this.map.setCenter(latlng);

			// Set automatic
			this.markerLocation.automatic = true;

		}

		// Set marker position
		this.markerLocation.setPosition(latlng);

		// Handle position
		this.getController().getEventHandler().handle(new PositionEvent(latlng), BuildingMapLoadedEvent.TYPE);

	} else {
		console.error("Handle Geolocation Query", "Map not initlized");
	}

};

/**
 * @param {Object}
 *            building
 * @param {string}
 *            dataUrl
 */
MapAppCampusguideMainView.prototype.handleBuildingTakemethere = function(building, dataUrl) {

	// From location
	var fromLocation = this.markerLocation ? Core.sprintf("%s,%s", this.markerLocation.position.lat().toFixed(5), this.markerLocation.position.lng().toFixed(5)) : "";

	// To location
	var toLocation = jQuery.isArray(building.address) ? building.address.join(", ") : building.location || "";

	// Url
	var url = Core.sprintf(dataUrl, fromLocation, toLocation);

	// Redirect
	window.location = url;

};

MapAppCampusguideMainView.prototype.handleBuildingSlide = function() {

	var buildingSlider = this.getBuildingSliderElement();
	var buildingUrl = buildingSlider.attr("data-url");
	var buildingId = buildingSlider.attr("data-buildingid");

	// Redirect to view building
	if (buildingId) {
		window.location = Core.sprintf(buildingUrl, buildingId);
	}
};

/**
 * @param {google.maps.LatLng}
 *            latlng
 */
MapAppCampusguideMainView.prototype.handlePosition = function(latlng) {
	console.log("Handle position", latlng);
	var position = null, distance = null, closest = null, closestDistance = null;
	for (buildingId in this.markerBuildings) {
		position = this.markerBuildings[buildingId].getPosition();
		if (position) {
			distance = MapUtil.distance(latlng.lat(), latlng.lng(), position.lat(), position.lng());

			if (distance <= MapAppCampusguideMainView.POSITION_LENGTH_MIN && ((closestDistance != null && distance < closestDistance) || closestDistance == null)) {
				closest = this.markerBuildings[buildingId];
				closestDistance = distance;
			}
		}

	}

	if (closest != null) {
		this.doBuildingSlider(closest.buildingId);
	} else {
		this.doBuildingSlider();
	}
};

MapAppCampusguideMainView.prototype.handlePositionSet = function(latlng) {

	// Stop geolocation watch
	this.doGeolocationStop();

	// Update marker
	if (this.mapLoaded) {

		// Is set as automatic
		if (this.markerLocation.automatic == null || this.markerLocation.automatic == true) {

			// Remove geolocation to local storage
			this.getController().removeLocalStorageVariable("geolocation");

			// Set marker icon
			var image = "image/icon/location_blue_black_15x15.png";
			this.markerLocation.setIcon(image);

			// Set marker as visible
			this.markerLocation.setVisible(true);

			// Set map center
			this.map.setCenter(latlng);

			// Set automatic
			this.markerLocation.automatic = false;

		}

		// Handle position
		this.getController().getEventHandler().handle(new PositionEvent(latlng), BuildingMapLoadedEvent.TYPE);

	}

};

// ... /HANDLE

// /FUNCTIONS
