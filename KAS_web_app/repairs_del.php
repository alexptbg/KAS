<?php
//error_reporting(0);
define('start', TRUE);
include('inc/db.php');
include('inc/functions.php');
include('inc/init.php');
DataBase::getInstance()->connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
include('inc/config.php');
check_login($lang,$web_dir);
$rid = $_GET['rid'];
$kinv = $_GET['kinv'];
if ($user_settings['level']>20) {
    $query = "DELETE FROM `maintenance` WHERE `id`='".$rid."' AND `inv`='".$kinv."'";
    $result = mysql_query($query);
    confirm_query($result);
} else {
	exit;
}
DataBase::getInstance()->disconnect();
?>