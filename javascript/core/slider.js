/**
 * Slider
 */
function Slider() {
}

// VARIABLES

Slider.SLIDER_WRAPPER_CLASS = "slider_wrapper";
Slider.SLIDER_CONTENT_CLASS = "slider_content";
Slider.SLIDER_SCROLLER_WRAPPER_CLASS = "slider_scroller_wrapper";
Slider.SLIDER_SCROLLER_HANDLE_CLASS = "slider_scroller_handle";

// /VARIABLES

// FUNCTIONS

// /FUNCTIONS

(function($) {

	$.fn.slider = function(options) {
		return this.each(function() {

			var content = $(this);

			// Get content display
			var contentDisplay = content.css("display");

			// Hide content
			content.hide();

			// Settings
			var settings = $.extend({
				'id' : null,
				'class' : null,
				'width' : null,
				'width-parent' : null
			}, options);

			// Get wrapper id, class and width
			settings["id"] = settings["id"] || content.attr("data-id");
			settings["class"] = settings["class"] || content.attr("data-class");
			settings["width"] = settings["width"] || content.attr("data-width");
			settings["width-parent"] = settings["width-parent"] || content.attr("data-width-parent");

			// DOM-ELEMENTS

			// Create wrapper
			var wrapper = $("<div />", {
				"class" : Slider.SLIDER_WRAPPER_CLASS,
				"id" : settings["id"]
			});

			wrapper.addClass(settings["class"]);

			// Wrapper width
			if (settings["width"]) {
				wrapper.css("width", settings["width"]);
			}

			// Wrapper width from parent
			if (settings["width-parent"]) {
				var widthParentElement = $(settings["width-parent"]);
				if (widthParentElement.length > 0) {
					wrapper.css("width", widthParentElement.innerWidth());
				}
			}

			// Create scroller handle
			var scrollerHandle = $("<div />", {
				"class" : Slider.SLIDER_SCROLLER_HANDLE_CLASS,
				"html" : "&nbsp;"
			});

			// Create scroller wrapper
			var scrollerWrapper = $("<div />", {
				"class" : Slider.SLIDER_SCROLLER_WRAPPER_CLASS,
				"html" : scrollerHandle
			});

			// Add content class
			content.addClass(Slider.SLIDER_CONTENT_CLASS);

			// Wrap content
			content.wrap(wrapper);

			// Add scroller after content
			content.after(scrollerWrapper);

			// Show content
			content.css("display", contentDisplay);

			// /DOM-ELEMENTS

			// SLIDER

			// Get handle width
			var handleWidth = wrapper.innerWidth() / content.innerWidth();

			// Get handle slide max
			var handleSlideMax = Math.round(wrapper.innerWidth() - (handleWidth * wrapper.innerWidth()));

			// Get content slide max
			var contentSlideMax = Math.round(content.innerWidth() - wrapper.innerWidth());

			// Set handle properties
			scrollerHandle.attr("data-handle-slide-max", handleSlideMax);
			scrollerHandle.attr("data-content-slide-max", contentSlideMax);

			// Set handle width
			scrollerHandle.css("width", Math.round(handleWidth * 100) + "%");

			// /SLIDER

			// DRAG

			// Handle drag
			scrollerHandle.drag(function(event, dd) {

				// Get handle
				var handle = $(dd.target);

				// Get content
				var content = handle.parent().parent().find("." + Slider.SLIDER_CONTENT_CLASS);

				// Get handle properties
				var handleSlideMax = parseInt(handle.attr("data-handle-slide-max"));
				var contentSlideMax = parseInt(handle.attr("data-content-slide-max"));
				var handleMarginOriginal = parseInt(handle.attr("data-margin-original"));

				// Calculate handle margin
				var handleMargin = Math.min(Math.max(0, handleMarginOriginal + dd.deltaX), handleSlideMax);

				// Calculate slide procent
				var slideProcent = handleMargin / handleSlideMax;

				// Calculate content margin
				var contentMargin = Math.round(contentSlideMax * slideProcent) * -1;

				// Set handle margin
				handle.css({
					"margin-left" : handleMargin
				});

				// Set content margin
				content.css({
					"margin-left" : contentMargin
				});

			}, {
				"relative" : true
			});

			// Handle drag start
			scrollerHandle.drag("start", function(event, dd) {
				// Set original handle margin
				$(dd.target).attr("data-margin-original", $(dd.target).css("margin-left").replace("px", ""));
			});

			// Handle scroller wrapper click
			scrollerWrapper.click(function(event) {
				if (event.target == this) {

					// Get wrapper
					var wrapper = $(event.target);

					// Get handle
					var handle = wrapper.find("." + Slider.SLIDER_SCROLLER_HANDLE_CLASS);

					// Get content
					var content = handle.parent().parent().find("." + Slider.SLIDER_CONTENT_CLASS);

					// Get handle properties
					var handleSlideMax = parseInt(handle.attr("data-handle-slide-max"));
					var contentSlideMax = parseInt(handle.attr("data-content-slide-max"));

					// Calculate handle margin
					var handleMargin = Math.min(handleSlideMax, Math.max(0, Math.round((event.pageX - wrapper
							.position().left)
							- (handle.width() / 2))));

					// Calculate slide procent
					var slideProcent = handleMargin / handleSlideMax;

					// Calculate content margin
					var contentMargin = Math.round(contentSlideMax * slideProcent) * -1;

					// Set handle margin
					handle.css({
						"margin-left" : handleMargin
					});

					// Set content margin
					content.css({
						"margin-left" : contentMargin
					});

				}
			});

			// /DRAG

		});
	};

})(jQuery);