<?php
//error_reporting(0);
define('start', TRUE);
include('inc/db.php');
include('inc/functions.php');
include('inc/init.php');
DataBase::getInstance()->connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
include('inc/config.php');
check_login($lang,$web_dir);
$resp = "";
if ($user_settings['level'] > 20) {
    $r = $_GET['r'];
    $i = $_GET['i'];
    $d = $_GET['d'];
    mysql_query("SET NAMES utf8");
    $query = "UPDATE `klimatiki` SET `last_cleaned`='".$d."' WHERE `inv`='".$i."' AND `router`='".$r."'";
    $result = mysql_query($query);
    confirm_query($result);
    if ($result) {
        $resp = "OK";
    } else {
        $resp = "NOOK";
    }
} else {
    $resp = "ERROR";
}
header('Content-Type: application/json; charset=utf-8');
echo json_encode($resp);
DataBase::getInstance()->disconnect();
?>