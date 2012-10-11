<?php
?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="UTF-8">
<meta http_equiv="Content-Type" content="text/html; charset=UTF-8">
<!-- <meta name="viewport" content="maximum-scale=1.0,minimum-scale=1.0,user-scalable=no,width=device-width"> -->
<script type="text/javascript"
    src="../KrisSkarboApi/javascript/api/jquery-1.8.0.min.js"></script>
<!-- <script type="text/javascript" src="javascript/api/jquery.event.drag-2.0.min.js"></script> -->
<script type="text/javascript" src="javascript/javascript.js.php"></script>
<script
    src="../KrisSkarboApi/javascript/api/jquery.event.drag-2.0.min.js"
    type="text/javascript"></script>
<link href="css/campusguide.css.php" type="text/css" rel="stylesheet" />
<!-- <script type="text/javascript" src="../KrisSkarboApi/javascript/api/jquery-1.7.1.min.js"></script> -->
<!-- <script type="text/javascript" src="../KrisSkarboApi/javascript/api/QuoJS.js"></script> -->
<!-- <script type="text/javascript" src="../KrisSkarboApi/javascript/api/hammer.js"></script> -->
<!-- <script type="text/javascript" src="../KrisSkarboApi/javascript/api/jquery.hammer.js"></script> -->
<!-- <script type="text/javascript" src="../KrisSkarboApi/javascript/api/jquery.touchy.min.js"></script> -->
<style type="text/css">
#test {
	width: 100px;
}

#contents {
	display: table;
}

#contents>* {
	display: table-cell;
	white-space: nowrap;
}
</style>
<script type="text/javascript">

$(document).ready(function() {
	$("#contents").slider();

	$("#button").click(function(){
		$("#test").css("width", 150);
		$("#contents > *:nth-child(1)").remove();
		$("#contents").slider();
		});
});

</script>
</head>
<body>

    <div id="test">
        <div>
            <div id="contents" data-width-parent="#test">
                <div>Content 1</div>
                <div>Content 2</div>
                <div>Content 3</div>
                <div>Content 4</div>
                <div>Content 5</div>
                <div>Content 6</div>
            </div>
        </div>
        <button id="button">Click</button>
    </div>

</body>
</html>