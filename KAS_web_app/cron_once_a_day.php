<?php
//error_reporting(0);
define('start', TRUE);
include('inc/db.php');
include('inc/functions.php');
include('inc/init.php');
DataBase::getInstance()->connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
include('inc/config.php');
//start
$del_old1 = mysql_query("DELETE FROM `logs` WHERE `date` < DATE_SUB(NOW(), INTERVAL $track DAY);");
confirm_query($del_old1);
$del_old2 = mysql_query("DELETE FROM `arduino_in_temp` WHERE `datetime` < DATE_SUB(NOW(), INTERVAL $temp_track DAY);");
confirm_query($del_old2);
$del_old3 = mysql_query("DELETE FROM `arduino_in_temp_5m` WHERE `datetime` < DATE_SUB(NOW(), INTERVAL $track DAY);");
confirm_query($del_old3);
$del_old4 = mysql_query("DELETE FROM `arduino_in_temp_60m` WHERE `datetime` < DATE_SUB(NOW(), INTERVAL $track DAY);");
confirm_query($del_old4);
//end
?>