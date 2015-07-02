<?php
//error_reporting(0);
define('start', TRUE);
include('inc/db.php');
include('inc/functions.php');
include('inc/init.php');
DataBase::getInstance()->connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
include('inc/config.php');
$cr=0;
if(isset($_GET['in'])) {
    $z = implode(",",$_GET);
    $now = date("Y-m-d H:i:s");
                $file = '_ar_in_test.txt';
                $current = file_get_contents($file);
                $current .= $now." ";
                $current .= $z;
                $current .= "\r\n";
                $current .= $_SERVER["QUERY_STRING"];
                $current .= "\r\n";
                file_put_contents($file,$current);
                echo "YES";
}
?>