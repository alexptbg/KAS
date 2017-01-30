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
    $query = "SELECT * FROM `arduino_out_temp` WHERE `ar_id`='".$ar_id."' ORDER BY `id` DESC LIMIT 1";
    $result = mysql_query($query);
    confirm_query($result);
    if (mysql_num_rows($result) != 0) {
        while ($row = mysql_fetch_array($result)) {
            //get values
        	$time = $row['datetime'];
        	$dbdate = $row['timestamp'];
    	    $hum = number_format($row['humidity'],0); 
    	    $temp = number_format($row['temp2'],2);
    	}
        $x = time() * 1000;
        header("Content-type: text/json");
        //if not old than 60 seconds
        if ((time() - $dbdate) < 60) {
            $ret = array($x,$temp,$hum,$time);
        } else {
            $ret = array($x,"Error","Data","","");
		}
	} else {
		$ret = array($x,"Error","ID","","");
	}
    $json = json_encode($ret);
    $json = preg_replace('/"(-?\d+\.?\d*)"/','$1',$json);
    echo $json;
    DataBase::getInstance()->disconnect();
} else {
	echo "error: ar_id not given";
}
?>