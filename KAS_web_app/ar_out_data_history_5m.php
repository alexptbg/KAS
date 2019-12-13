<?php
//error_reporting(0);
define('start', TRUE);
include('inc/db.php');
include('inc/functions.php');
include('inc/init.php');
DataBase::getInstance()->connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
include('inc/config.php');
//weather DB
define("WDB_SERVER", "localhost");
define("WDB_NAME", "weather");
define("WDB_USER", "root");
define("WDB_PASS", "11543395");
$local = new mysqli(WDB_SERVER,WDB_USER,WDB_PASS,WDB_NAME);
$local->set_charset("utf8");
//$zones = array("Gotse Delchev","Sofia");
$color = array("#0ca8f3","#fba504","#06f406","#da29f3","#fe1b01","#0eafab");
$i=0;
//only one zone
$sql="SELECT * FROM `out_temp` ORDER BY `id` ASC";
$result=$local->query($sql);
if($result === false) {
    trigger_error('Wrong SQL: '.$sql.' Error: '.$local->error,E_USER_ERROR);
} else {
    if($result->num_rows > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            $timestamp[$i] = $row['timestamp'];
            $values[$i] = floatval($row['temp']);
            $response[$i] = array($timestamp[$i]*1000,$values[$i]);
            $i++;
        }
        $series[] = array(
            'name' => 'Gotse Delchev',
            'data' => $response,
            'color' => $color[1],
            'type' => 'spline'
            //'tooltip' => array('valueDecimals' => '2','valueSuffix' => ' °C')
       );
    }
}
//more than one zone
/*
foreach($zones as $zone) {
    $sql="SELECT * FROM `weather` WHERE `zone`='".$zone."' ORDER BY `id` ASC";
    $result=$local->query($sql);
    if($result === false) {
        trigger_error('Wrong SQL: '.$sql.' Error: '.$local->error,E_USER_ERROR);
    } else {
        if($result->num_rows > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                $timestamp[$i] = $row['timestamp'];
                $values[$i] = floatval($row['wtemp']);
                $response[$i][] = array($timestamp[$i]*1000,$values[$i]);
            }
            $series[] = array(
                'name' => $zone,
                'data' => $response[$i],
                'color' => $color[$i],
                'type' => 'spline'
                //'tooltip' => array('valueDecimals' => '2','valueSuffix' => ' °C')
           );
        }
    }
    $i++;
}
*/
DataBase::getInstance()->disconnect();
header('Content-type: application/json');
echo json_encode($series);
?>