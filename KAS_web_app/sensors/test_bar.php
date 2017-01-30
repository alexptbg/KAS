<?php

$temp = rand(0,2);
header("Content-type: text/json");
$x = time() * 1000;
$r = array($x,$temp);
$j = json_encode($r);
echo $j;

?>