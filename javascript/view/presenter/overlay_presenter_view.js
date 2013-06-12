// CONSTRUCTOR

OverlayPresenterView.prototype = new AbstractPresenterView();

function OverlayPresenterView(view, overlayId) {
	AbstractPresenterView.apply(this, arguments);
	this.overlayId = overlayId;
	this.isHash = false;
	this.isBindClose = true;
	this.okHandle = null;
	this.cancelHandle = null;
}
// /CONSTRUCTOR

// VARIABLES

// /VARIABLES

// FUNCTIONS

// ... GET

OverlayPresenterView.prototype.getId = function() {
	return this.overlayId;
};

/**
 * @returns {CmsMainView}
 */
OverlayPresenterView.prototype.getView = function() {
	return AbstractPresenterView.prototype.getView.call(this);
};

OverlayPresenterView.prototype.getHash = function() {
	return {
		overlay : this.overlayId
	};
};

OverlayPresenterView.prototype.getBodyElement = function() {
	return this.getRoot().find(".body");
};

// ... /GET

// ... SET

OverlayPresenterView.prototype.setHash = function(isHash) {
	this.isHash = isHash;
};

OverlayPresenterView.prototype.setBindClose = function(isBindClose) {
	this.isBindClose = isBindClose;
};

OverlayPresenterView.prototype.setOkHandle = function(okHandle) {
	this.okHandle = okHandle;
};

OverlayPresenterView.prototype.setCancelHandle = function(cancelHandle) {
	this.cancelHandle = cancelHandle;
};

// ... /SET

// ... IS

OverlayPresenterView.prototype.isShown = function() {
	return !this.getRoot().is(".hide");
};

// ... /IS

// ... DO

OverlayPresenterView.prototype.doShow = function() {
	var context = this;

	// Cancel handle
	var cancelHandle = function() {
		context.doClose();
	};

	// Ok handle
	var okHandle = function() {
		if (context.handleOk())
			context.doClose();
	};

	// Fit overlay
	// this.getRoot().fitToParent();

	// Show overlay
	this.getRoot().removeClass("hide");

	// Update hash
	if (this.isHash)
		this.getView().getController().updateHash(this.getHash());

	// Ok button
	this.getRoot().find(".ok.button").unbind(".overlay").bind("click.overlay", function() {
		okHandle();
	});

	// Cancel button
	this.getRoot().find(".cancel.button").unbind(".overlay").bind("click.overlay", function() {
		cancelHandle();
	});

	// Bind close
	if (this.isBindClose) {
		setTimeout(function() {
			$("html").bind("click.overlay", function(event) {
				if ($(event.target).closest(".overlay").length == 0) {
					cancelHandle();
				}
			});
			$("html").bind("keydown.overlay", function(e) {
				if (e.keyCode == '27') {
					cancelHandle();
					return false;
				}
			});
		}, 10);
	}

	// // Fill height
	// if (!this.getRoot().is("[data-background=false]")) {
	// this.getRoot().fillHeight();
	// }

};

OverlayPresenterView.prototype.doClose = function(isOk) {
	// Hide overlay
	this.getRoot().addClass("hide");

	// Remove hash
	if (this.isHash) {
		var removeHash = Core.objectEmpty(this.getHash());
		this.getView().getController().updateHash(removeHash);
	}

	// Unbind
	if (this.isBindClose)
		$("html").unbind('.overlay');

	// Handle ok/cancel
	if (isOk)
		this.handleOk();
	else
		this.handleCancel();
};

// ... /DO

// ... HANDLE

OverlayPresenterView.prototype.handleCancel = function() {
	if (this.cancelHandle)
		this.cancelHandle();
};

/**
 * @returns {boolean} True if success
 */
OverlayPresenterView.prototype.handleOk = function() {
	if (this.okHandle)
		return this.okHandle();
	return true;
};

// ... /HANDLE

/**
 * @param {Object}
 *            root
 */
OverlayPresenterView.prototype.draw = function(root) {
	this.root = root;
	this.doBefore();
	this.doBindEventHandler();
};

// FUNCTIONS
