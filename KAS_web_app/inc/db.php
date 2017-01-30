<?php
defined('start') or die('Direct access not allowed.');
define("DB_SERVER", "localhost");
define("DB_NAME", "kas");
define("DB_USER", "");
define("DB_PASS", "");
$connection = mysql_connect(DB_SERVER, DB_USER, DB_PASS);
if (!$connection) { die("Database connection failed" .mysql_error()); } 
mysql_query("SET NAMES 'utf8'");
$db_select = mysql_select_db(DB_NAME, $connection);
if (!$db_select) { die("Database select failed" .mysql_error()); }
?>