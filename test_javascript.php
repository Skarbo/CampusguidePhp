<?php
?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="UTF-8">
<meta http_equiv="Content-Type" content="text/html; charset=UTF-8">
<!-- <meta name="viewport" content="maximum-scale=1.0,minimum-scale=1.0,user-scalable=no,width=device-width"> -->
<script type="text/javascript"
    src="../KrisSkarboApi/javascript/api/jquery-1.9.1.min.js"></script>
    <script type="text/javascript"
    src="../KrisSkarboApi/javascript/api/kinetic-v4.3.3.js"></script>
<!-- <script type="text/javascript" src="javascript/api/jquery.event.drag-2.0.min.js"></script> -->
<script type="text/javascript" src="javascript/javascript.js.php"></script>
<script type="text/javascript" src="javascript/javascript_canvas.js.php"></script>
<!-- <script
    src="../KrisSkarboApi/javascript/api/jquery.event.drag-2.0.min.js"
    type="text/javascript"></script>-->
<!-- <link href="css/campusguide.css.php" type="text/css" rel="stylesheet" />-->
<!-- <script type="text/javascript" src="../KrisSkarboApi/javascript/api/jquery-1.7.1.min.js"></script> -->
<!-- <script type="text/javascript" src="../KrisSkarboApi/javascript/api/QuoJS.js"></script> -->
<!-- <script type="text/javascript" src="../KrisSkarboApi/javascript/api/hammer.js"></script> -->
<!-- <script type="text/javascript" src="../KrisSkarboApi/javascript/api/jquery.hammer.js"></script> -->
<!-- <script type="text/javascript" src="../KrisSkarboApi/javascript/api/jquery.touchy.min.js"></script> -->
<style type="text/css">

</style>
<script type="text/javascript">

(function() {
    MyGroup = function(config) {
        this._initTest(config);
    };
    MyGroup.prototype = {
	    _initTest: function(config) {
	        Kinetic.Group.call(this, config);
	        },
        myAdd : function(shape){
            console.log("My add", shape);
          this.add(shape);
        }
    };
    Kinetic.Global.extend(MyGroup, Kinetic.Group);

    MyCircle = function(config) {
        this._initTest(config);
    };
    MyCircle.prototype = {
	    _initTest: function(config) {
	        Kinetic.Circle.call(this, config);
	        },
        myFunc : function(){
          console.log("Test myFunc");
        }
    };
    Kinetic.Global.extend(MyCircle, Kinetic.Circle);

    MyCircle2 = function(config) {
    	MyCircle.call(this, config);
    };
    MyCircle2.prototype = {
        myFunc : function(){
          console.log("Test myFunc2");
        }
    };
    Kinetic.Global.extend(MyCircle2, MyCircle);
})();

$(function() {
    var width = $(document).width() - 2,
        height = $(document).height() - 5;
    var stage = new Kinetic.Stage({
        container: 'container',
        width: width,
        height: height
    });
    var layer = new Kinetic.Layer({
        draggable: true
    });
    var rectX = stage.getWidth() / 2 - 50;
    var rectY = stage.getHeight() / 2 - 25;
/*
    var group = new MyGroup({
        });
    var circle = new MyCircle({
        x: 100,
        y: 100,
        radius: 50,
        fill: '#00D200',
        stroke: 'black',
        strokeWidth: 2,
    });
    circle.myFunc();

    // add cursor styling
    circle.on('mouseover', function() {
        document.body.style.cursor = 'pointer';
    });
    circle.on('mouseout', function() {
        document.body.style.cursor = 'default';
    });

    var circle2 = new MyCircle2({
        x: 150,
        y: 150,
        radius: 30,
        fill: '#2D0000',
        stroke: 'black',
        strokeWidth: 1,
    });
    circle2.myFunc();*/

    var polygon = new Polygon({}, this);
    for (var i = 0; i < 10; i++) {
		anchor = new PolygonAnchor({x : i * 2, y : i * 3}, polygon);
		polygon.addAnchor(anchor);
		//anchor.fromData(dataAnchor[i]);
	}

    //group.myAdd(circle);
    //group.myAdd(circle2);
    //layer.add(group);
    layer.add(polygon);
    stage.add(layer);
});



</script>
</head>
<body>

    <div id="container"></div>

</body>
</html>