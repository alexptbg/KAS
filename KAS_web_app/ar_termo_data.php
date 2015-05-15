<?php
//error_reporting(0);
define('start', TRUE);
include('inc/db.php');
include('inc/functions.php');
include('inc/init.php');
DataBase::getInstance()->connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
include('inc/config.php');
$ar_id = $_GET['ar_id'];

$color = array("#20ff00","#fe01bf","#7d0000","#64004b","#0600ff","#ef9601");


    $places = array('temperature','hindex');
	$i=0;
    foreach ($places as $place) {
		$sql[$i] = mysql_query("SELECT `timestamp`,".$place." FROM `arduino_5_min` WHERE `ar_id`='".$ar_id."'");
	    confirm_query($sql[$i]);
		if (mysql_num_rows($sql[$i]) != 0) {
            while($row[$i] = mysql_fetch_array($sql[$i])) {
	            $date[$i] = $row[$i]['timestamp']*1000;
                $values[$i] = floatval($row[$i][$place]);
                $response[$i][] = array($date[$i], $values[$i]);
			}
			$series[] = array(
                 'name' => $place,
                 'data' => $response[$i],
				 'color' => $color[$i],
			     'type' => 'spline',
                 'tooltip' => array('valueDecimals' => '1', 'valueSuffix' => ' °C')
           );
        }
		$i++;
	}
	header('Content-type: application/json');
    echo json_encode($series);
?>