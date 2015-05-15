<?php
//error_reporting(0);
define('start', TRUE);
include('inc/db.php');
include('inc/functions.php');
include('inc/init.php');
DataBase::getInstance()->connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
include('inc/config.php');
if (!empty($_GET['SYS'])) {
	$SYS = $_GET['SYS'];
} else {
	$SYS = "";
}
if (!empty($_GET['USR'])) {
	$USR = $_GET['USR'];
}
//session_start();
//session_destroy();
$_SESSION[$web_dir] = NULL;
unset($_COOKIE['KAS']);
$location = "login.php?lang=".$lang."&SYS=".$SYS."&USR=".$USR;
header("location:$location");
?>