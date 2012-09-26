<?php

include '../KrisSkarboApi/src/core/core.php';

$string = '<svg
   xmlns:dc="http://purl.org/dc/elements/1.1/"
   xmlns:cc="http://creativecommons.org/ns#"
   xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
   xmlns:svg="http://www.w3.org/2000/svg"
   xmlns="http://www.w3.org/2000/svg"
   version="1.1"
   width="860"
   height="980"
   id="svg2">';
$pattern = '/<svg(.*?)width="(\d+)"(.*?)>/s';
$replacement = '${1}width="new"${3}';
echo preg_replace($pattern, $replacement, $string);

?>