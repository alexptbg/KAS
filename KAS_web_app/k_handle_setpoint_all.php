<?php
//error_reporting(0);
define('start', TRUE);
include('inc/db.php');
include('inc/functions.php');
include('inc/init.php');
DataBase::getInstance()->connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
include('inc/config.php');
check_login($lang,$web_dir);
//manual url
/*
https://eesystems.net/kas/k_handle_setpoint_all.php?router=Boss&action=FIX&spoint=28
https://eesystems.net/kas/k_handle_setpoint_all.php?router=Strellson/Joop&action=FIX&spoint=28
*/
//temperature sender
//router=Boss&kinv=1601&action=SP&first=1&second=24
/*
degrees algorithm
25C = first=0&second=250
26C = first=1&second=4
27C = first=1&second=14
28C = first=1&second=24
29C = first=1&second=34
30C = first=1&second=44
*/
$action = $_GET['action'];
$router = mysql_prep($_GET['router']);
$spoint = mysql_prep($_GET['spoint']);
if($spoint=="25") {
	$first = "0"; $second = "250";
} elseif ($spoint=="26") {
    $first = "1"; $second = "4";
} elseif ($spoint=="27") {
    $first = "1"; $second = "14";
} elseif ($spoint=="28") {
    $first = "1"; $second = "24";
} elseif ($spoint=="29") {
    $first = "1"; $second = "34";
} elseif ($spoint=="30") {
    $first = "1"; $second = "44";
} else {
	$first = "1"; $second = "24";
}
if (($router != NULL) && ($action == 'FIX')) {
	$klimas = array();
	$query = "SELECT `inv` FROM `klimatiki` WHERE `router`='".$router."' ORDER BY `inv` ASC";
	$result = mysql_query($query);
	confirm_query($result);
	if (mysql_num_rows($result) != 0 ) {
		while($k = mysql_fetch_array($result)) {
			$klimas[] = $k['inv'];
		}
	}
    if(!empty($klimas)) {
		$k=1;
		echo "<script type=\"text/javascript\" src=\"js/jquery-1.10.2.js\"></script>";
		echo "<script type=\"text/javascript\">\r\n";
		foreach($klimas as $klima) {
			$timed = ($k*1600);
			
			echo "
			var x".$k." = setTimeout(function(){ 
				//var k".$k." = '".$klima."';\r\n

				$.ajax({
					url: 'k_handle_setpoint_fix2.php?router=".$router."&kinv=".$klima."&action=SP&first=".$first."&second=".$second."',
					//dataType: 'json',
					type: 'GET',
					contentType: 'application/json',
					success: function(data,textStatus,jQxhr){
					  console.log(data);
					  
					},
					error: function(jqXhr,textStatus,errorThrown){
					  console.log(errorThrown);
					},
					timeout: 3000
				  });

			}, ".$timed.");
			";
			$k++;
		}
		echo "</script>";
	}
}
?>