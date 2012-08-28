<?php
?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="UTF-8">
<meta http_equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport"
    content="maximum-scale=1.0,minimum-scale=1.0,user-scalable=no,width=device-width">
<!--<script type="text/javascript" src="../KrisSkarboApi/javascript/api/jquery-1.7.1.min.js"></script> -->
<!-- <script type="text/javascript" src="javascript/api/jquery.event.drag-2.0.min.js"></script> -->
<!-- <script type="text/javascript" src="javascript/campusguide.js.php"></script>  -->
<!-- <script src="../KrisSkarboApi/javascript/api/jquery.event.drag-2.0.min.js" type="text/javascript"></script>  -->
<!--<link href="css/campusguide.css.php" type="text/css" rel="stylesheet" /> -->
<script type="text/javascript" src="../KrisSkarboApi/javascript/api/jquery-1.7.1.min.js"></script>
<!-- <script type="text/javascript" src="../KrisSkarboApi/javascript/api/QuoJS.js"></script> -->
<script type="text/javascript" src="../KrisSkarboApi/javascript/api/hammer.js"></script>
<script type="text/javascript" src="../KrisSkarboApi/javascript/api/jquery.hammer.js"></script>
<!-- <script type="text/javascript" src="../KrisSkarboApi/javascript/api/jquery.touchy.min.js"></script> -->
<style type="text/css">
#test
{
	width: 100%;
	height: 1024px;
}
</style>
<script type="text/javascript">

var logElement = null;
var content = null;

$(function() {
	console.log("Test log");
	logElement = $("#log");
	content = $("#test");
	/*
	//Touch start
	content.bind("touchstart", function(event) {
		console.log("Touch start", event);
	});

	// Touch move
	content.bind("touchmove", function(event) {
		console.log("Touch move", event);
	});

	// Touch end
	content.bind("touchend", function(event) {
		console.log("Touch end", event);
	});
*/
	/*$$("#test").touch(function(event){
		logElement.prepend("Touch", "<br />");
		console.log("Touch", event);
		});
	$$("#test").doubleTap(function(event){
		logElement.prepend("Double tap", "<br />");
		console.log("Double tap", event);
		});
	$$("#test").swipe(function(){
		logElement.prepend("Swipe", "<br />");
		console.log("Swipe", event);
		});

	$$("#test").drag(function(event){
		logElement.prepend("Drag", event, "<br />");
		console.log("Drag", event);
	    });*/

	/*var handleTouchyPinch = function (e, $target, data) {
	    logElement.prepend("Drag", data.scale, "<br />");
		console.log("Drag", data);
	};
	$('#test').bind('touchy-drag', handleTouchyPinch);
	$('#test').bind('touchy-swipe', handleTouchyPinch);*/

	var hammer = $("#test").hammer({
		prevent_default: true,
		scale_treshold: 0,
		drag_min_distance: 0
	});

	/*
	hammer.bind('transformstart', function(event) {
		logElement.prepend("Transform start", "<br />");
	});

	hammer.bind('transform', function(event) {
		logElement.prepend("Transform", event.scale, "<br />");
	});

	hammer.bind('transformend', function(event) {
		logElement.prepend("Transform end", "<br />");
	});
	*/

	hammer.bind('drag', function(event) {
		logElement.prepend("Drag", "<br />");
	});

});

function log(event)
{
	logElement.prepend(event.type, "Scale: " + parseFloat(event.scale), "<br />");
	console.log(event.type, event);
}

</script>
</head>
<body>

    <div id="test">
        <div id="log">Log</div>
    </div>

</body>
</html>