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
.dropdown {
	display: inline-block;
}

.dropdown .dropdown_selected {
    display: inline-block;
}

.dropdown .dropdown_value {

}

.dropdown .dropdown_contents {
    position: absolute;
    display: none;
    background-color: white;
}

.dropdown:HOVER .dropdown_contents
{
	display: block;
}

.dropdown .dropdown_contents .dropdown_content {
    cursor: pointer;
}

.dropdown .dropdown_contents .dropdown_content[data-selected] {
    font-weight: bold;
}
</style>
<script type="text/javascript">

$(function() {
	$("#dropdown_test").dropdownSelect({
	    callback : function(value){
		    console.log("Callback", value);
		    }
		});
	$("#dropdown_test").dropdownSelect();
});

</script>
</head>
<body>

    <div id="test">
        <div data-name="content" id="dropdown_test">
            <div data-value="content_1">Content 1</div>
            <div data-value="content_2">Content 2</div>
            <div data-value="content_3">Content 3</div>
        </div>
    </div>

</body>
</html>