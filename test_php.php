<?php

include '../KrisSkarboApi/src/core/core.php';

class Test
{
    public static function testing()
    {
        return "TEST";
    }
}

$test = new Test();
var_dump($test->testing(), Test::testing());

?>