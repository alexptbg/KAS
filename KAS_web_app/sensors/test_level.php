<?php

$level = rand(0,100);
header("Content-type: text/json");
$x = time() * 1000;
$r = array($x,$level);
$j = json_encode($r);
echo $j;

?>