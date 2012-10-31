<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<script type="text/javascript" src="javascript/api/jquery-1.7.1.min.js"></script>
<!-- <script type="text/javascript" src="../KrisSkarboApi/javascript/gui/gui.js"></script> -->
<!-- <script type="text/javascript" src="javascript/gui/gui.js"></script> -->
<link href="css/campusguide.css.php" type="text/css" rel="stylesheet" />
<script type="text/javascript">

$(document).ready(function() {


} );

</script>
<style type="text/css">

.dropdown_wrapper
{

}

.dropdown_value
{
    display: block;
}

.dropdown_contents
{
	display: none;
    position: absolute;
	list-style: none;
	padding: 0;
	margin: 0;
}

.dropdown_wrapper:HOVER .dropdown_contents
{
	display: block;
}

.dropdown_content
{
    padding: 0;
	margin: 0;
}

</style>
</head>
<body>

    <div id="test">

        <div>Value above</div>
        <div class="dropdown_wrapper">
            <div class="dropdown_value">Dropdown value</div>
            <ul class="dropdown_contents">
                <li class="dropdown_content">Test 1</li>
                <li class="dropdown_content">Test 2</li>
                <li class="dropdown_content">Test 3</li>
            </ul>
        </div>
        <div>Value below</div>

    </div>

</body>
</html>