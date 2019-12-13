<?php
//error_reporting(0);
define('start', TRUE);
include('inc/db.php');
include('inc/functions.php');
include('inc/init.php');
DataBase::getInstance()->connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
include('inc/config.php');
//init
$colors = array("#0ca8f3","#fba504","#06f406","#da29f3","#fe1b01","#0eafab");
$places = array("Strellson/Joop 1","Strellson/Joop 2","Boss 1","Boss 2");
$invs = array("11029","12028","21020","22005");
$i=0;
foreach($invs as $inv) {
    $query = "SELECT * FROM `raspi_in_temps_60m` WHERE `inv`='".$inv."' ORDER BY `id` ASC";
    $result = mysql_query($query);
    confirm_query($result);
    $num_rows = mysql_num_rows($result);
    if ($num_rows > 0) {
            while($row = mysql_fetch_assoc($result)) {
                $timestamp[$i] = $row['timestamp'];
                $values[$i] = floatval($row['temp']);
                $response[$i][] = array($timestamp[$i]*1000,$values[$i]);
            }
            $series[] = array(
                'name' => $places[$i],
                'data' => $response[$i],
                'color' => $colors[$i],
                'type' => 'spline'
                //'tooltip' => array('valueDecimals' => '2','valueSuffix' => ' °C')
           );
    }
	$i++;
}
DataBase::getInstance()->disconnect();
header('Content-type: application/json');
echo json_encode($series);
?>