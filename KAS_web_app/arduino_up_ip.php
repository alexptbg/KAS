<?php
//error_reporting(0);
define('start', TRUE);
include('inc/db.php');
include('inc/functions.php');
include('inc/init.php');
DataBase::getInstance()->connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
include('inc/config.php');
if(isset($_GET['ip'])) {
	if((isset($_GET['addr'])) && (isset($_GET['id']))) {
        $now = date("Y-m-d H:i:s");
        $uid = $_GET['id'];
        $uaddr = $_GET['addr'];
        $query = "SELECT `ar_id` FROM `arduino_devices` WHERE `ar_id`='".$uid."'";
        $result = mysql_query($query);
        confirm_query($result);
	    $c = mysql_num_rows($result);
        if (($c != NULL) && ($uaddr != NULL) && ($uaddr != "")){
            //update ip address
            $query = "UPDATE `arduino_devices` SET `ip_addr`='".$uaddr."' WHERE `ar_id`='".$uid."'";
            $result = mysql_query($query);
            confirm_query($result);
            if ($result) {
                //do nothing
            } else {
			    //do nothing
		    }
        } else { 
            return FALSE; 
        }
	} else {
		//do nothing
	}
	DataBase::getInstance()->disconnect();
}
?>