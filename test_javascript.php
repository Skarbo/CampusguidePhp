<?php
?>
<html>
<head>
<!--<script type="text/javascript" src="../KrisSkarboApi/javascript/api/jquery-1.7.1.min.js"></script> -->
<!-- <script type="text/javascript" src="javascript/api/jquery.event.drag-2.0.min.js"></script> -->
<!-- <script type="text/javascript" src="javascript/campusguide.js.php"></script>  -->
<!-- <script src="../KrisSkarboApi/javascript/api/jquery.event.drag-2.0.min.js" type="text/javascript"></script>  -->
<!--<link href="css/campusguide.css.php" type="text/css" rel="stylesheet" /> -->
<style type="text/css">
.dropdownselect {
	display: inline-block;
}

.dropdownselect .selected {

}

.dropdownselect .items {
	display: none;
	position: absolute;
}

.dropdownselect .items {
	display: block;
}

.dropdownselect .items .wrapper {
	border: 1px solid black;
	/*height: 200px;
	overflow-y: hidden;*/
}

.dropdownselect  .scroller {
	background-color: gray;
}

.dropdownselect .scroller .handle {
	background-color: black;
	height: 20px;
	width: 10px;
}

.dropdownselect .items .item {
	background-color: white;
	border-top: 1px solid black;
	padding: 0.5em;
}

.dropdownselect .items .item:FIRST-CHILD {
	border: 0;
}

#testButton {
	border: 1px solid black;
	display: inline;
	cursor: pointer;
}

</style>
<!--
<script type="text/javascript">
/*
$(function() {



});

Gui.DROPDOWNSELECT_CLASS = "class";
Gui.DROPDOWNSELECT_ITEMS_CLASS = "items";

(function($) {

	var dropDownSelectMethods = {
			init : function(options) {

				return this.each(function() {

					var $this = $(this), data = $this.data(TableSearch.DATA);

					if (!data) {

						$(this).data(TableSearch.DATA, {
							target : $this,
							options : options
						});

					}

				});
			}
	};

	$.fn.dropDownSelect = function() {
		return this.each(function() {

			var $this = $(this);

		    // Add class
		    $this.addClass(Gui.DROPDOWNSELECT_CLASS);

		    // Find items
		    var itemsElement = $this.find("." +Gui.DROPDOWNSELECT_ITEMS_CLASS);

		});
	};

	//////// SLIDER /////////

	function Slider() {
	}

	Slider.DATA = "data";
	Slider.SLIDER_WRAPPER_CLASS = "slider_wrapper";
	Slider.SLIDER_SWIPE_CLASS = "swipe";
	Slider.SLIDER_CONTENT_CLASS = "slider_content";
	Slider.SLIDER_SCROLLER_WRAPPER_CLASS = "slider_scroller_wrapper";
	Slider.SLIDER_SCROLLER_HANDLE_CLASS = "slider_scroller_handle";
	Slider.SLIDER_SCROLLER_HANDLE_DRAG_CLASS = "drag";

	var sliderMethods = {
			init : function(options) {

				return this.each(function() {

					var $this = $(this), data = $this.data(Slider.DATA);

					// Options
					options = $.extend({
						'id' : content.attr("data-id"),
						'class' : content.attr("data-class"),
						'width' : content.attr("data-width"),
						'width-parent' : content.attr("data-width-parent")
					}, options);

					// Initiate data
					if (!data) {
						$(this).data(TableSearch.DATA, {
							target : $this,
							options : options
						});
					}

				});
			},
			destroy : function() {

				return this.each(function() {

					var $this = $(this), data = $this.data(Slider.DATA);
					$this.removeData(Slider.DATA);

				});

			}
		};

		$.fn.slider = function(method) {

			if (sliderMethods[method]) {
				return sliderMethods[method].apply(this, Array.prototype.slice.call(arguments, 1));
			} else if (typeof method === 'object' || !method) {
				return sliderMethods.init.apply(this, arguments);
			} else {
				$.error('Method ' + method + ' does not exist on jQuery.sliderMethods');
			}

		};


})(jQuery);*/

</script>
-->
<script type="text/javascript">

(function($) {


	var button = $("#testButton");

    console.log("Ready", button);
	button.click(function(){ console.log("Click") });
	//button.bind("click.test", function() { console.log("Click test"); });
	//button.bind("click.test", function() { console.log("Click test 2"); });


});

</script>
</head>
<body>
<!--
    <div id="test">

        <div style="display: inline;">Before</div>

        <div class="dropdownselect">
            <div class="selected">Selected</div>
            <div class="items">
                <div class="wrapper table">
                    <div>

                        <div class="item" data-type="noneselected">None
                            selected</div>
                        <div class="item">Menu sub</div>
                        <div class="item">Menu sub</div>
                        <div class="item">Menu sub</div>
                        <div class="item">Menu sub</div>
                        <div class="item">Menu sub</div>
                        <div class="item">Menu sub</div>
                        <div class="item">Menu sub</div>
                        <div class="item">Menu sub</div>
                        <div class="item">Menu sub</div>

                    </div>
                    <div>

                        <div class="scroller">
                            <div class="handle">&nbsp;</div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div id="test2">
            <div>Under</div>
        </div>

    </div>
 -->

<div id="testButton">Test</div>

</body>
</html>