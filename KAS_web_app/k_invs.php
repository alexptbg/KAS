<?php
//error_reporting(0);
define('start', TRUE);
include('inc/db.php');
include('inc/functions.php');
include('inc/init.php');
DataBase::getInstance()->connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
include('inc/config.php');
if(isset($_POST['router'])) {
    $router = $_POST['router'];
	$query = "SELECT `inv` FROM `klimatiki` WHERE `router`='".$router."' GROUP BY `inv` ORDER BY `inv` ASC";
    $result = mysql_query($query);
    confirm_query($result);
    $num_rows = mysql_num_rows($result);
    if ($num_rows != 0) {
    	echo "<option></option>";
        while ($invs = mysql_fetch_array($result)) {
			echo "<option value=\"".$invs['inv']."\">".$invs['inv']."</option>";
	    }
	}
}
DataBase::getInstance()->disconnect();
?>