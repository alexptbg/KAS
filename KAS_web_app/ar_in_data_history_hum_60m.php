<?php
//error_reporting(0);
define('start', TRUE);
include('inc/db.php');
include('inc/functions.php');
include('inc/init.php');
DataBase::getInstance()->connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
include('inc/config.php');
$inside = array("AR_0001_2015_1.0","AR_0002_2015_1.0","AR_0003_2015_1.0","AR_0004_2015_1.0","AR_0005_2015_1.0");
$color = array("#0ca8f3","#fba504","#06f406","#da29f3","#fe1b01","#0eafab");
$i=0;
foreach($inside as $ar) {
    $query = "SELECT `place` FROM `arduino_devices` WHERE `ar_id`='".$ar."'ORDER BY `id` ASC";
    $result = mysql_query($query);
    confirm_query($result);
    $num_rows = mysql_num_rows($result);
    if ($num_rows != 0) {
        while($place = mysql_fetch_array($result)) {
		    $places[] = $place['place'];
	    }
    }
	$sql[$i] = mysql_query("SELECT `timestamp`,`humidity` FROM `arduino_in_temp_60m` WHERE `ar_id`='".$ar."' GROUP BY `timestamp` ORDER BY `timestamp` ASC");
	confirm_query($sql[$i]);
	if (mysql_num_rows($sql[$i]) != 0) {
        while($row[$i] = mysql_fetch_array($sql[$i])) {
	        $date[$i] = $row[$i]['timestamp'];
	        $datec[$i] = date("Y-m-d H:i",$date[$i]);
	        $timestamp[$i] = strtotime($datec[$i]);
            $values[$i] = floatval($row[$i]['humidity']);
            $response[$i][] = array($timestamp[$i]*1000,$values[$i]);
		}
		$series[] = array(
             'name' => $places[$i],
             'data' => $response[$i],
			 'color' => $color[$i],
		     'type' => 'spline'
             //'tooltip' => array('valueDecimals' => '2', 'valueSuffix' => ' °C')
        );
    }
	$i++;
}
DataBase::getInstance()->disconnect();
header('Content-type: application/json');
echo json_encode($series);
?>