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

MapAppCampusguideMainView.POSITION_LENGTH_MIN = 0.01; // 10 meters

// /VARIABLES

// FUNCTIONS

// ... GET

/**
 * @return {MapAppCampusguideMainController}
 */
MapAppCampusguideMainView.prototype.getController = function() {
	return AppCampusguideMainView.prototype.getController.call(this);
};

// ... /GET

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

	this.getController().getEventHandler().registerListener(ViewBuildingEvent.TYPE,
	/**
	 * @param {ViewBuildingEvent}
	 *            event
	 */
	function(event) {
		context.handleBuildingView(event.getBuildingId());
	});

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

	// Location
	this.getWrapperElement().find("#menu_button_location").click(500, function(event) {
		event.preventDefault();
	});

	this.getWrapperElement().find("#menu_button_location").click(function(event) {
		event.preventDefault();
		context.doGeolocationInit();
	});

	// /MENU

	// HASH

	$(window).hashchange(
			function() {
				var hashObject = context.getController().getHash();

				// BUILDING OVERLAY

				if (hashObject.building) {
					context.getController().getBuildingDao().get(
							hashObject.building,
							function(building) {

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
											context.handleBuildingTakemethere(building, takemethereElement
													.attr("data-url"));
										});

										var view = body.find("a.view");
										view.unbind("click");
										view.click(function(event) {
											event.preventDefault();
											context.getController().getEventHandler().handle(
													new ViewBuildingEvent(building.id));
										});
									}
								};

								// Send overlay event
								context.getController().getEventHandler().handle(
										new OverlayEvent(overlayOptions, "map_building_overlay"));

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

MapAppCampusguideMainView.prototype.doBuildingSlider = function(buildingId) {
console.log("Building slider", buildingId);
	var buildingSlider = this.getWrapperElement().find("#building_slider_wrapper");

	if (buildingId) {
		buildingSlider.attr("data-buildingid", buildingId);
		buildingSlider.removeClass("hide");
	} else {
		buildingSlider.addClass("hide");
	}

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
		this.getWrapperElement().find("#map_canvas").height(this.getWrapperElement().find("#page_wrapper").height())
				.width(this.getWrapperElement().find("#page_wrapper").width());

		var latlng = new google.maps.LatLng(60.39126, 5.32205);
		var options = {
			zoom : 15,
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
	console.log("Handle map buildings");
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
		var building, address, locationArray;
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

			// Building location
			if (building.location) {
				locationArray = building.location.split(",");
				setMarkerAtLocation(new google.maps.LatLng(locationArray[0], locationArray[1]),
						this.markerBuildings[buildingId]);
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

	var context = this;

	if (this.mapLoaded) {

		// Set lat/lng
		var latlng = new google.maps.LatLng(position.coords.latitude.toFixed(5), position.coords.longitude.toFixed(5));

		// Set marker
		if (!this.markerLocation) {
			var image = "image/icon/location_blue_15x15.png";
			this.markerLocation = new google.maps.Marker({
				map : this.map,
				position : latlng,
				icon : image,
				draggable : true
			});

			// Marker drag
			google.maps.event.addListener(this.markerLocation, 'dragend', function(event) {

				// Handle position
				context.getController().getEventHandler().handle(new PositionEvent(event.latLng),
						BuildingMapLoadedEvent.TYPE);

				// setMarkerAtLocation(event.latLng);
			});
			// Set map center
			this.map.setCenter(latlng);

			// Set geolocation to local storage
			this.getController().setLocalStorageVariable("geolocation", "true");
		} else {
			// Set marker position
			this.markerLocation.setPosition(latlng);
		}

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
	var fromLocation = this.markerLocation ? Core.sprintf("%s,%s", this.markerLocation.position.lat().toFixed(5),
			this.markerLocation.position.lng().toFixed(5)) : "";

	// To location
	var toLocation = jQuery.isArray(building.address) ? building.address.join(", ") : building.location || "";

	// Url
	var url = Core.sprintf(dataUrl, fromLocation, toLocation);

	// Redirect
	window.location = url;

};

MapAppCampusguideMainView.prototype.handleBuildingView = function(buildingId) {

	console.log("Handle building view", buildingId);

};

MapAppCampusguideMainView.prototype.handleBuildingSlide = function() {

	console.log("Handle building slide");

	var buildingSlider = this.getWrapperElement().find("#building_slider_wrapper");
	var buildingId = buildingSlider.attr("data-buildingid");

	// Send view building event
	if (buildingId) {
		this.getController().getEventHandler().handle(new ViewBuildingEvent(parseInt(buildingId)));
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
			console.log("Distance", buildingId, distance);	
			if (distance <= MapAppCampusguideMainView.POSITION_LENGTH_MIN
					&& ((closestDistance != null && distance < closestDistance) || closestDistance == null)) {
				closest = this.markerBuildings[buildingId];
				closestDistance = distance;
			}
		}

	}
console.log("Closest", closest, closestDistance);
	if (closest != null) {
		this.doBuildingSlider(closest.buildingId);
	} else {
		this.doBuildingSlider();
	}

};

// ... /HANDLE

// /FUNCTIONS
