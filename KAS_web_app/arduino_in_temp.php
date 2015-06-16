<?php
//error_reporting(0);
define('start', TRUE);
include('inc/db.php');
include('inc/functions.php');
include('inc/init.php');
DataBase::getInstance()->connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
include('inc/config.php');
$cr=1;
if(isset($_GET['in'])) {
	if((isset($_GET['hum'])) && (isset($_GET['temp1'])) && (isset($_GET['temp2'])) && (isset($_GET['id'])) && (isset($_GET['ip'])) && (isset($_GET['mac']))) {
        $now = date("Y-m-d H:i:s");
        $stamp = time();
        $uhum = $_GET['hum'];
        $utemp1 = $_GET['temp1'];
		$utemp2 = $_GET['temp2']-$cr;
		$uid = $_GET['id'];
		$uip = $_GET['ip'];
		$umac = $_GET['mac'];
        $query = "INSERT INTO `arduino_in_temp` (`datetime`,`timestamp`,`humidity`,`temp1`,`temp2`,`ar_id`,`ip_addr`,`mac`) 
                  VALUES ('".$now."','".$stamp."','".$uhum."','".$utemp1."','".$utemp2."','".$uid."','".$uip."','".$umac."')";
        $result = mysql_query($query);
        confirm_query($result);
        if ($result) {
            //do nothing
        } else {
			//do nothing
		}
	} else {
		//do nothing
	}
	DataBase::getInstance()->disconnect();
}
?>