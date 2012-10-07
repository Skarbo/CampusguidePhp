// CONSTRUCTOR
CmsMainView.prototype = new MainView();

/**
 * @param {string}
 *            wrapperId Wrapper id
 */
function CmsMainView(wrapperId) {
	MainView.apply(this, arguments);
	this.wrapperId = wrapperId;
}

// /CONSTRUCTOR

// VARIABLES

// /VARIABLES

// FUNCTIONS

// ... GET

/**
 * @param {string}
 *            wrapper
 */
CmsMainView.prototype.getWrapperId = function() {
	return this.wrapperId;
};

/**
 * @retuern {Object}
 */
CmsMainView.prototype.getWrapperElement = function() {
	return $(Core.sprintf("#%s", this.getWrapperId()));
};

// ... /GET

// ... DO

CmsMainView.prototype.doBindEventHandler = function() {
	MainView.prototype.doBindEventHandler.call(this);
	var context = this;

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

	this.getController().getEventHandler().registerListener(QueueEvent.TYPE,
	/**
	 * @param {QueueEvent}
	 *            event
	 */
	function(event) {
		context.handleQueue(event.getQueueType(), event.getQueue());
	});

};

// ... /DO

// ... HANDLE

/**
 * @param {OverlayEvent}
 *            event
 */
CmsMainView.prototype.handleOverlay = function(event) {

	// Overlay element
	var overlayElement = $("#cms_wrapper #" + event.getOverlayId());

	if (overlayElement.length == 0) {
		return;
	}

	var overlayCancelElement = overlayElement.find(".cancel");
	var overlayOkElement = overlayElement.find(".ok");
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
		overlayElement.addClass("hide");

		// Close
		if (event.getOptions().close) {
			event.getOptions().close();
		}

		// Unbind
		overlayOkElement.unbind();
		overlayCancelElement.unbind();
		$(document).unbind('keydown.overlay');
	};

	// Bind ok
	overlayOkElement.click(function() {
		if (event.getOptions().ok) {
			if (event.getOptions().ok()) {
				closeHandle();
			}
		} else {
			closeHandle();
		}
	});

	// Bind cancel
	overlayCancelElement.click(function() {
		if (event.getOptions().cancel) {
			event.getOptions().cancel();
		}
		closeHandle();
	});
	overlayElement.click(function(event) {
		if ($(event.target).find(".overlay").length > 0) {
			closeHandle();
		}
	});
	$(document).bind('keydown.overlay', keydownHandle);

};

/**
 * @param {OverlayEvent}
 *            event
 */
CmsMainView.prototype.handleOverlayClose = function(overlayId) {

	// Overlay element
	var overlayElement = $("#cms_wrapper #" + overlayId);

	if (overlayElement.length == 0) {
		return;
	}

	var overlayCancelElement = overlayElement.find(".cancel");
	var overlayOkElement = overlayElement.find(".ok");

	// Hide overlay
	overlayElement.addClass("hide");

	// Unbind
	overlayOkElement.unbind();
	overlayCancelElement.unbind();
	$(document).unbind('keydown.overlay');

};

/**
 * @param {string}
 *            queueType
 * @param {Object}
 *            queue
 */
CmsMainView.prototype.handleQueue = function(queueType, queue) {

	// Create Queue view
	var queueView = new QueueCmsPageMainView(this, queue);

	// Get Queue element
	var queueElement = $("#cms_wrapper #queue_wrapper");

	// Draw queue
	queueView.draw(queueElement);

};

// ... /HANDLE

// ... DRAW

CmsMainView.prototype.draw = function(controller) {
	MainView.prototype.draw.call(this, controller);

	// DEFUALT TEXT

	$(".default_text").focus(function() {
		if ($(this).val() == $(this)[0].title) {
			$(this).removeClass("default_text_active");
			$(this).val("");
		}
	});

	$(".default_text").blur(function() {
		if ($(this).val() == "") {
			$(this).addClass("default_text_active");
			$(this).val($(this)[0].title);
		}
	});

	$(".default_text").focus().blur();

	// /DEFAULT TEXT


};

// ... /DRAW

// /FUNCTIONS
