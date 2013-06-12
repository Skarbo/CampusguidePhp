// CONSTRUCTOR
MainView.prototype = new AbstractMainView();

function MainView() {
	AbstractMainView.apply(this, arguments);
	this.toastOverlay = new OverlayPresenterView(this, "overlay_toast");
	this.timerResizeDelay = null;
}

// /CONSTRUCTOR

// VARIABLES

// /VARIABLES

// FUNCTIONS

// ... GET

/**
 * @return {MainController}
 */
MainView.prototype.getController = function() {
	return AbstractMainView.prototype.getController.call(this);
};

/**
 * @retuern {Object}
 */
MainView.prototype.getToastOverlayElement = function() {
	return $(".overlay_wrapper#overlay_toast");
};

// ... /GET

// ... DO

MainView.prototype.doBindEventHandler = function() {
	AbstractMainView.prototype.doBindEventHandler.call(this);
	var context = this;

	// Toast event
	this.getEventHandler().registerListener(ToastEvent.TYPE,
	/**
	 * @param {ToastEvent}
	 *            event
	 */
	function(event) {
		context.handleToast(event.getMessage(), event.getLength());
	});

	// RESIZE

	var supportsOrientationChange = "onorientationchange" in window;
	var orientationEvent = supportsOrientationChange ? "orientationchange" : "resize";
	window.addEventListener(orientationEvent, function() {
		if (context.timerResizeDelay)
			clearTimeout(context.timerResizeDelay);
		context.timerResizeDelay = setTimeout(function() {
			context.getEventHandler().handle(new ResizeEvent());
		}, 200);
	}, false);

	// /RESIZE

};

// ... /DO

// ... HANDLE

MainView.prototype.handleToast = function(message, length) {
	var context = this;
	this.toastOverlay.getBodyElement().text(message);
	this.toastOverlay.doShow();

	if (this.toastTimeout)
		clearTimeout(this.toastTimeout);
	this.toastTimeout = setTimeout(function() {
		context.toastOverlay.doClose();
		context.toastTimeout = null;
	}, length == ToastEvent.LENGTH_LONG ? 6000 : 3000);
};

// ... /HANDLE

// /FUNCTIONS
