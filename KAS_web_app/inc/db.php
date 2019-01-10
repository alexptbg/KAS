<?php
defined('start') or die('Direct access not allowed.');
define("DB_SERVER", "");
define("DB_NAME", "");
define("DB_USER", "");
define("DB_PASS", "");
$connection = mysql_connect(DB_SERVER, DB_USER, DB_PASS);
if (!$connection) { die("Database connection failed" .mysql_error()); } 
mysql_query("SET NAMES 'utf8'");
//mysql_query("FLUSH HOSTS;");
$db_select = mysql_select_db(DB_NAME, $connection);
if (!$db_select) { die("Database select failed" .mysql_error()); }
?>