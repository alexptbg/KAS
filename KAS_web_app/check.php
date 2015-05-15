<?php
//error_reporting(0);
define('start', TRUE);
include('inc/db.php');
include('inc/functions.php');
include('inc/init.php');
DataBase::getInstance()->connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
include('inc/config.php');
$myusername=base64_encode(mysql_prep($_POST['username']));
$mypassword=base64_encode(mysql_prep($_POST['password']));
ob_start();
check_username($lang,$myusername,$mypassword,$web_dir);
?>