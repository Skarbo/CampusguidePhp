<?php

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Canvas Test</title>
<script type="text/javascript"
    src="../KrisSkarboApi/javascript/api/jquery-1.7.1.min.js" type="text/javascript"></script>
<script type="text/javascript"
    src="../KrisSkarboApi/javascript/api/kinetic-v3.7.3.min.js">
    </script>
<script type="text/javascript" src="javascript/campusguide.js.php"></script>
<script type="text/javascript">

var controller;
    $(document).ready(function() {
    	var eventHandler = new EventHandler();
    	var view = new CampusguideMainView("wrapper");
    	controller = new CampusguideMainController(eventHandler, 2);
    	controller.render(view);
    	} );

    </script>
<style type="text/css">
body {
	padding: 0;
	margin: 0;
}

#wrapper {
	display: table;
	width: 100%;
}

#wrapper>div {
	display: table-cell;
	vertical-align: top;
}

#wrapper #left {
	width: 100px;
}

#canvas_wrapper {
	border: 1px solid grey;
	height: 600px;
	width: 800px;
}

</style>
</head>
<body>

    <div id="wrapper">

        <div id="left">
            Left
            <div>
                <strong>Zoom:</strong> <span id="zoom">100</span>%
            </div>
        </div>

        <div id="right">

            <div id="canvas_wrapper">
            </div>

        </div>

    </div>

</body>

</html>