<?php

$temp = rand(1,95);
header("Content-type: text/json");
$x = time() * 1000;
$r = array($x,$temp);
$j = json_encode($r);
echo $j;

?>