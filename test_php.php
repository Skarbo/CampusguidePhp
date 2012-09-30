<?php

include '../KrisSkarboApi/src/core/core.php';

class Test
{

    public static function testFunc($arg1, $arg2)
    {
        return $arg1 . $arg2;
    }

    public function testParse($func)
    {
        return $func("Test", "Testing");
    }

}

$test = new Test();
$test->testParse(Test::testParse);


?>