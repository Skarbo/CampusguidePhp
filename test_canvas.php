<?php
?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="UTF-8">
<script type="text/javascript"
    src="../KrisSkarboApi/javascript/api/jquery-1.7.1.min.js"></script>
<script type="text/javascript"
    src="../KrisSkarboApi/javascript/api/kinetic-v4.0.0.js"></script>
<style type="text/css">
#test #canvas {
	width: 700px;
	height: 500px;
	background-color: #EEE;
	border: 1px solid #9C9898;
}
</style>
<script type="text/javascript">

var lineToolbarButton;
var canvas;
var stage;
var drawLayer;
var drawLineLayer;
var drawLineTempLayer;
var lines = [];
var linesTemp = null;

$(function() {

    canvas = $("#canvas");
    lineToolbarButton = $("#toolbar #line");

	// Create stage
	stage = new Kinetic.Stage({
        container: "canvas",
        height : canvas.height(),
        width : canvas.width(),
        draggable : true
    });

    // Create layer
	drawLineLayer = new Kinetic.Layer({
	    name : "lineLayer"
	});
	drawLineTempLayer = new Kinetic.Layer({
	    name : "lineTempLayer"
	});

    // Add layer to stage
    stage.add(drawLineLayer);
    stage.add(drawLineTempLayer);

    // Layer before draw
    drawLineLayer.beforeDraw(function() {
    	drawLines();
    });
    drawLineTempLayer.beforeDraw(function() {
    	drawLineTemp();
    });

    // Build line group
    lines.push(buildLineGroup(drawLineLayer, [50, 50], [150, 150], lines.length));
    lines.push(buildLineGroup(drawLineLayer, [50, 100], [150, 200], lines.length));
    drawLineLayer.draw();

	// Bind toolbar
	lineToolbarButton.click(drawLineStart);
});

/**
 * @return Kinetic.Group
 */
function buildAnchor(layer, x, y, id, start) {
	// Create group
	var name = "anchor_" + (start ? "start" : "end");
    var group = new Kinetic.Group({
        name : name,
        id : id,
        x : x,
        y : y,
        draggable : true
    });

    // Create link container
    group.link = {};

    // Create circle
    var circle = new Kinetic.Circle({
        x: 0,
        y: 0,
        radius: 8,
        stroke: "#666",
        fill: "#ddd",
        strokeWidth: 1,
        name : "anchorCircle"
    });

    // Create text
    var text = new Kinetic.Text({
        name : "anchorText",
        x: -3,
        y: -4,
        text: " ",
        textStroke : "#000",
        textStrokeWidth : 0.8,
        fontSize : 8,
        fontFamily : "Arial",
        listening : false
    });

    // Add circle hover styling
    circle.on("mouseover", function() {
    	canvas.css("cursor", "pointer");
        this.setStrokeWidth(2);
        layer.getLayer().draw();
    });
    circle.on("mouseout", function() {
    	canvas.css("cursor", "default");
        this.setStrokeWidth(1);
        layer.getLayer().draw();
    });

    group.on("dragstart", function(event){
        this.getParent().moveToTop();
    });
    group.on("dragmove", function(event){
        console.log(event);
        if (!jQuery.isEmptyObject(this.link)) {
            var anchorTemp;
            for(i in this.link)
            {
            	anchorTemp = this.link[i];
            	anchorTemp.setX(this.getX());
            	anchorTemp.setY(this.getY());
            }
        }
    });
    group.on("dragend", function(event){
    	handleAnchorDrag(this, event);
    });
    group.on("dblclick", function(event){
    	if (!jQuery.isEmptyObject(this.link)) {
            var anchorTemp;
            var j = 0;
            for(i in this.link)
            {
            	anchorTemp = this.link[i];
            	anchorTemp.move(5, ++j);
            	delete anchorTemp.link[this.getId()];
            }
            this.link = {};
        }
    });

    group.add(circle);
    group.add(text);
    layer.add(group);

    return group;
}

function buildLine(layer, start, end, id)
{
	var line = new Kinetic.Line({
        name: "line",
        id : id,
        stroke: "black",
        strokeWidth: 3,
        lineCap: "round",
        points : [ start[0], start[1], end[0], end[1] ]
    });

    layer.add(line);
    return line;
}

function buildLineGroup(layer, start, end, id)
{
	// Create line group
    var group = new Kinetic.Group({
	    name : "line",
	    id : id
    });

    // Build line
	buildLine(group, start, end, id);

	// Build anchor on position
	buildAnchor(group, start[0], start[1], id, true);
	buildAnchor(group, end[0], end[1], id, false);

	// Add group to layer
	layer.add(group);

	return group;
}

function drawLineStart()
{
	canvas.css("cursor", "crosshair");
	canvas.unbind(".draw");
	canvas.bind("mouseup.draw", drawLineClick);
}

function drawLineClick(event)
{
	var position = stage.getUserPosition();

	if (position) {

		// Create id
		var id = lines.length;

	    // Build line group
	    var lineGroup = buildLineGroup(drawLineTempLayer, [position.x, position.y], [position.x, position.y], id);

		// Re-draw layer
		drawLineTempLayer.draw();

	    linesTemp = lineGroup;

        canvas.unbind(".draw");
        canvas.bind("mousemove.draw", drawLineMove);
        canvas.bind("mouseup.draw", drawLineEnd);
	}
}

function drawLineMove(event)
{
	var position = stage.getUserPosition();

	if (position && linesTemp) {
		var anchorEnd = linesTemp.get(".anchor_end");

		if (anchorEnd && anchorEnd.length > 0) {
			anchorEnd = anchorEnd[0];

    		// Set end position
			anchorEnd.setX(position.x - stage.getX());
			anchorEnd.setY(position.y - stage.getY());

    		// Re-draw layer
    		drawLineTempLayer.draw();
		}
	}
}

function drawLineEnd(event)
{
	canvas.unbind(".draw");
	canvas.css("cursor", "default");

	addLine(linesTemp, drawLineLayer);
	linesTemp = null;
}

function drawLineTemp()
{
	if (linesTemp) {
		var line = linesTemp.get(".line");
		var anchorStart = linesTemp.get(".anchor_start");
		var anchorEnd = linesTemp.get(".anchor_end");

		if (line && line.length > 0 && anchorStart && anchorStart.length > 0 && anchorEnd && anchorEnd.length > 0) {
			line = line[0];
			anchorStart = anchorStart[0];
			anchorEnd = anchorEnd[0];
		    line.setPoints([anchorStart.attrs.x, anchorStart.attrs.y, anchorEnd.attrs.x, anchorEnd.attrs.y]);
		}
	}
}

function drawLines()
{
	for(i in lines)
	{
		var line = lines[i].get(".line");
		var anchorStart = lines[i].get(".anchor_start");
		var anchorEnd = lines[i].get(".anchor_end");

		if (line && line.length > 0 && anchorStart && anchorStart.length > 0 && anchorEnd && anchorEnd.length > 0) {
			line = line[0];
			anchorStart = anchorStart[0];
			anchorEnd = anchorEnd[0];
		    line.setPoints([anchorStart.attrs.x, anchorStart.attrs.y, anchorEnd.attrs.x, anchorEnd.attrs.y]);
		}
	}
}

function addLine(line, layer)
{
	var layerOld = line.getLayer();
	lines.push(line);
    line.moveTo(layer);

	layerOld.draw();
    layer.draw();
}

function handleAnchorDrag(anchor, event)
{
	var line = anchor.getParent();
	var id = line.getId();
	var lineTemp, anchorStart, anchorEnd;
	for(i in lines)
	{
		lineTemp = lines[i];
		if (lineTemp && lineTemp.getId() != id)
		{
			anchorStart = lineTemp.get(".anchor_start");
			anchorEnd = lineTemp.get(".anchor_end");
			if (anchorStart && anchorStart.length > 0 && anchorEnd && anchorEnd.length > 0){
				anchorStart = anchorStart[0];
				anchorEnd = anchorEnd[0];
    			if (isNearAnchor(anchor, anchorStart))
    			{
    				handleAnchorSnap(anchor, anchorStart);
    			}
    			else if (isNearAnchor(anchor, anchorEnd))
    			{
    				handleAnchorSnap(anchor, anchorEnd);
    			}
			}
		}
	}
}

function isNearAnchor(anchor, anchorSecond) {
	var closeTo = 10;
    var a = anchor;
    var o = anchorSecond;
    if(a.attrs.x > o.attrs.x - closeTo && a.attrs.x < o.attrs.x + closeTo && a.attrs.y > o.attrs.y - closeTo && a.attrs.y < o.attrs.y + closeTo) {
        return true;
    }
    else {
        return false;
    }
}

function handleAnchorSnap(anchorFirst, anchorSecond)
{
	anchorFirst.setX(anchorSecond.getX());
	anchorFirst.setY(anchorSecond.getY());

	anchorFirst.link[anchorSecond.getId()] = anchorSecond;
	anchorSecond.link[anchorFirst.getId()] = anchorFirst;

	anchorFirst.getLayer().draw();
}

</script>
</head>
<body>

    <div id="test">
        <div id="toolbar">
            <button id="line">Line</button>
        </div>
        <div id="canvas"></div>
    </div>

</body>
</html>