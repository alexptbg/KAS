<?php
//error_reporting(0);
define('start', TRUE);
include('inc/db.php');
include('inc/functions.php');
include('inc/init.php');
DataBase::getInstance()->connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
include('inc/config.php');
$cr=5;
$fi=3;//minus
if(isset($_GET['out'])) {
	if((isset($_GET['hum'])) && (isset($_GET['temp1'])) && (isset($_GET['temp2'])) && (isset($_GET['id'])) && (isset($_GET['ip'])) && (isset($_GET['mac']))) {
        $now = date("Y-m-d H:i:s");
        $fix = date("H");
        $stamp = time();
        if ($fix > 12) {
			$cr = 4;
		}
		$utemp1 = $_GET['temp1']-$cr;
		$utemp2 = $_GET['temp2']-$cr-$fi;
		$uid = $_GET['id'];
		$uip = $_GET['ip'];
		$umac = $_GET['mac'];
        $query = "INSERT INTO `arduino_out_temp` (`datetime`,`timestamp`,`temp1`,`temp2`,`ar_id`,`ip_addr`,`mac`) 
                  VALUES ('".$now."','".$stamp."','".$utemp1."','".$utemp2."','".$uid."','".$uip."','".$umac."')";
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
}
DataBase::getInstance()->disconnect();
?>