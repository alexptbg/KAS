<?php
//error_reporting(0);
define('start', TRUE);
include('inc/db.php');
include('inc/functions.php');
include('inc/init.php');
DataBase::getInstance()->connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
include('inc/config.php');
$router = $_GET['router'];
$query = "SELECT `work_sche` FROM `routers` WHERE `router_name`='".$router."'";
$result = mysql_query($query);
confirm_query($result);
if (mysql_num_rows($result) != 0) {
    while($works = mysql_fetch_array($result)) {
		$work_sche = $works['work_sche'];
	}
	if ($work_sche == "Off") { $class = 'danger'; } 
	elseif ($work_sche == "On") { $class = 'success'; }
	else { $class = 'warning'; }
	echo "<span>".get_lang($lang,'k273').":&nbsp;<span class=\"label label-".$class."\">".$work_sche."</span></span>";
}
DataBase::getInstance()->disconnect();
?>