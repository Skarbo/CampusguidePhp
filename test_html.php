<!DOCTYPE HTML>
<html>
<head>
<meta charset="UTF-8">
<script type="text/javascript" src="../KrisSkarboApi/javascript/api/jquery-1.7.1.min.js"></script>
<style type="text/css">
input[type=file]
{

}
</style>
<script type="text/javascript">

$(function() {

    $("[data-click]").click(function(event){
        var id = $(this).attr("data-click");
        $("#" + id).click();
    });

    $("#file_test1").change(function(event){
        console.log($(this).val());
    });

});

</script>
</head>
<body>

<?php

function getNormalizedFILES()
{
    $newfiles = array();
    foreach($_FILES as $fieldname => $fieldvalue)
        foreach($fieldvalue as $paramname => $paramvalue)
        foreach((array)$paramvalue as $index => $value)
        $newfiles[$fieldname][$index][$paramname] = $value;
    return $newfiles;
}

    var_dump($_POST);
    var_dump(getNormalizedFILES());

?>

    <div id="test">
        <form method="post" action="?" enctype="multipart/form-data">
            File 1: <input name="file_name[]" /><button type="button" data-click="file_test1">File1</button><input id="file_test1" name="file_path[]" type="file" /><br />
            File 2: <input name="file_name[]" /><button type="button" data-click="file_test2">File2</button><input id="file_test2" name="file_path[]" type="file" /><br />
            <input type="submit" />
        </form>
    </div>

</body>
</html>