<?php
//error_reporting(0);
define('start', TRUE);
include('inc/db.php');
include('inc/functions.php');
include('inc/init.php');
DataBase::getInstance()->connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
include('inc/config.php');
ini_set("session.gc_maxlifetime","14400");
session_name($web_dir);
session_start();
if(isset($_SESSION[$web_dir.'_username']) && ($_SESSION[$web_dir] == $web_dir)) {
    $username = $_SESSION[$web_dir.'_username'];	
	setcookie("KAS", $web_dir.".eesystems.net", time()+14400, "/".$web_dir."/", $web_dir.".eesystems.net", 0, true);
    update_login($lang,$username);
} else {
	//session_destroy();
	$_SESSION[$web_dir] = NULL;
	$location = "login.php?lang=".$lang;
	header("location:$location");
}
?>