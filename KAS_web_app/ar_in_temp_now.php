<?php
error_reporting(0);
define('start', TRUE);
include('inc/db.php');
include('inc/functions.php');
include('inc/init.php');
DataBase::getInstance()->connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
include('inc/config.php');
if(isset($_GET['ar_id'])) {
    $ar_id = $_GET['ar_id'];
    $query = "SELECT `place` FROM `arduino_devices` WHERE `ar_id`='".$ar_id."'";
    $result = mysql_query($query);
    confirm_query($result);
    if (mysql_num_rows($result) != 0) {
        while ($row = mysql_fetch_array($result)) {
        	$where = $row['place'];
        }
    }
    if ($where != NULL) {
        $query = "SELECT `datetime`,`timestamp`,`temp2` FROM `arduino_in_temp` WHERE `ar_id`='".$ar_id."' ORDER BY `id` DESC LIMIT 1";
        $result = mysql_query($query);
        confirm_query($result);
        if (mysql_num_rows($result) != 0) {
            while ($row = mysql_fetch_array($result)) {
        	    $time = $row['datetime'];
        	    $dbdate = $row['timestamp'];
    	        $temp = number_format($row['temp2'],1);
            }
        }
        $x = time() * 1000;
        header("Content-type: text/json");
        //if not old than 60 seconds
        if ((time() - $dbdate) < 60) {
            $ret = array($x,$where,$temp,$time);
        } else {
            $ret = array($x,"Error","Data","","");
		}
	} else {
		$ret = array($x,"Error","ID","","");
	}
    $json = json_encode($ret);
    $json = preg_replace('/"(-?\d+\.?\d*)"/','$1',$json);
    echo $json;
} else {
	echo "error: ar_id";
}
DataBase::getInstance()->disconnect();
?>