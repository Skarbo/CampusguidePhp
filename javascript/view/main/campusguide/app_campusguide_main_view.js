// CONSTRUCTOR
AppCampusguideMainView.prototype = new CampusguideMainView();

function AppCampusguideMainView(wrapperId) {
	CampusguideMainView.apply(this, arguments);
}

// /CONSTRUCTOR

// VARIABLES

// /VARIABLES

// FUNCTIONS

// ... GET

/**
 * @return {AppCampusguideMainController}
 */
AppCampusguideMainView.prototype.getController = function() {
	return CampusguideMainView.prototype.getController.call(this);
};

// ... /GET

// ... DO

AppCampusguideMainView.prototype.doBindEventHandler = function() {
	CampusguideMainView.prototype.doBindEventHandler.call(this);
	var context = this;
	
	// ORIENTATION

	var supportsOrientationChange = "onorientationchange" in window;
	var orientationEvent = supportsOrientationChange ? "orientationchange" : "resize";

	// window.addEventListener(orientationEvent, this.handleOrientation, false);

	// /ORIENTATION

	// FIT TO PARENT

	var parent = null, target = null, parentSelector = null;
	$("[data-fitparent]").each(function(i, element) {
		target = $(element);
		parentSelector = target.attr("data-fitparent");
		parent = parentSelector == "true" ? null : target.parentsUntil(parentSelector).parent();
		parent = parent && parent.length > 0 ? parent : target.parent();
		target.width(parent.width()).height(parent.height());
	});

	// /FIT TO PARENT

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

};

// ... /DO

// ... HANDLE

AppCampusguideMainView.prototype.handleOrientation = function() {

	var landscape = window.orientation == -90 || window.orientation == 90 ? true : false;
	if (landscape) {
		$("body").addClass("landscape");
	} else {
		$("body").removeClass("landscape");
	}

};

/**
 * @param {OverlayEvent}
 *            event
 */
AppCampusguideMainView.prototype.handleOverlay = function(event) {

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
	
	if ("bodyHandle" in event.getOptions())
	{
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
AppCampusguideMainView.prototype.handleOverlayClose = function(overlayId) {

	// Overlay element
	var overlayElement = $("#app_wrapper #" + overlayId);

	if (overlayElement.length == 0) {
		return;
	}

	// Add hide class
	overlayElement.addClass("hide");

};

// ... /HANDLE

// ... DRAW

AppCampusguideMainView.prototype.draw = function(controller) {
	CampusguideMainView.prototype.draw.call(this, controller);

	// Handle orientation
	// this.handleOrientation();

	// $("body").addClass("landscape");

};

// ... /DRAW

// /FUNCTIONS
