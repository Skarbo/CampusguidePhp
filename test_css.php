<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<script type="text/javascript" src="javascript/api/jquery-1.7.1.min.js"></script>
<script type="text/javascript"
    src="../KrisSkarboApi/javascript/gui/gui.js"></script>
<script type="text/javascript" src="javascript/gui/gui.js"></script>
<link href="css/campusguide.css.php" type="text/css" rel="stylesheet" />
<script type="text/javascript">

$(document).ready(function() {


} );

</script>
<style type="text/css">
body {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 100%;
	color: #333333;
}

input {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	padding: 0;
	margin: 0;
}

a {
	outline: medium none;
	-webkit-tap-highlight-color: RGBA(0, 0, 0, 0);
}

.menu
{
display: inline-block;
}

.menu .title
{

}

.menu .sub
{
	display: none;
	position: absolute;
}

.menu:HOVER .sub
{
	display: block;
}

.menu .sub .item
{
    background-color: white;
	border: 1px solid black;
}

</style>
</head>
<body>

    <div id="test">

        <div style="display: inline;">Test menu: </div>

        <div class="menu">
            <div class="title">Menu title</div>
            <div class="sub">
                <div class="item">Menu sub</div>
                <div class="item">Menu sub</div>
            </div>
        </div>
        <div>Test second line</div>

    </div>

</body>
</html>