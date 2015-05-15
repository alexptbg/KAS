<?php
//error_reporting(0);
define('start', TRUE);
include('inc/db.php');
include('inc/functions.php');
include('inc/init.php');
DataBase::getInstance()->connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
include('inc/config.php');
$ar_id = $_GET['ar_id'];


$query = "SELECT `timestamp`,`pressure` FROM `arduino` WHERE `ar_id`='".$ar_id."' ORDER BY `id` DESC LIMIT 5000";
$result = mysql_query($query);
confirm_query($result);
if (mysql_num_rows($result) != 0) {
    while ($row = mysql_fetch_array($result)) {
    	$temp = number_format($row['pressure'],1);
        $timestamp = $row['timestamp'];
        $return_data[] = array($timestamp*1000,$temp);
    }
}
$data_return = array_reverse($return_data);

header('Content-type: application/json');
$json = json_encode($data_return);
$json = preg_replace('/"(-?\d+\.?\d*)"/', '$1', $json);
echo $json;
?>