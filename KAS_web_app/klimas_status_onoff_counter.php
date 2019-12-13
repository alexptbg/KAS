<?php
error_reporting(0);
define('start', TRUE);
include('inc/db.php');
include('inc/functions.php');
include('inc/init.php');
DataBase::getInstance()->connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
include('inc/config.php');
//start
$r = $_GET['router'];
$r_settings = get_rout_settings($r);
$datafile = "data/{$r_settings['data_file']}";
if (file_exists($datafile)) { include("$datafile"); } 
else { echo "error-1"; exit; }
$exclude = $r_settings['ex_table'];
$ex = explode(',', $exclude);
//get ADDRs
$query = "SELECT `addr` FROM `klimatiki` WHERE `router`='".$r."' GROUP BY `addr` ORDER BY `addr` ASC";
$result = mysql_query($query);
confirm_query($result);
if (mysql_num_rows($result) != 0) {
    while($addr_u = mysql_fetch_array($result)) {
		$addrs[] = $addr_u['addr'];
	}
}
if (!empty($addrs)) {
	foreach ($addrs as $addr) {
        $klimas = array();
        $query = "SELECT `inv` FROM `klimatiki` WHERE `router`='".$r."' AND `addr`=".$addr." ORDER BY `inv` ASC";
        $result = mysql_query($query);
        confirm_query($result);
        if (mysql_num_rows($result) != 0) {
            while($klimas_u = mysql_fetch_array($result)) {
		        $klimas[] = $klimas_u['inv'];
	        }
        }
        if (!empty($klimas)) {
            echo "<h5>ADDR&nbsp;".$addr."</h5>";
	        foreach ($klimas as $klima) {
		        if(!(${'dev'.$klima} == NULL)) {
		            ${'d'.$klima} = explode(" ", ${'dev'.$klima}); 
			        p(${'d'.$klima},$r,$addr,$ex);
		        }	
	        }
        }
	}
}
//functions
function p($d,$r,$addr,$ex) {
	$d0 = $d[0];//inv
	$d1 = $d[1];//time
	//$d2 = $d[2];//set_point_1
	//$d3 = $d[3];//set_point_2
	$d4 = $d[4];//mode1
	$d5 = $d[5];//mode2
	//$d6 = $d[6];//vent1
	//$d7 = $d[7];//vent2
	//$d8 = $d[8];//temp_in_1
	//$d9 = $d[9];//temp_in_2	
	$mode = $d4*256+$d5;
	//$vent = $d6*256+$d7;
	//$set_point = ($d2*256+$d3)/10;
	//$in_temp = ($d8*256+$d9)/10;
	//mode
	/*
    if ($mode == "1") {      $mode_name = substr(get_lang($lang,'k69'),0,6).'.'; } 
    elseif ($mode == "9") {  $mode_name = substr(get_lang($lang,'k69'),0,6).'.'; }
    elseif ($mode == "2") {  $mode_name = substr(get_lang($lang,'k70'),0,6).'.'; }
    elseif ($mode == "10") { $mode_name = substr(get_lang($lang,'k70'),0,6).'.'; }
    elseif ($mode == "3") {  $mode_name = substr(get_lang($lang,'k71'),0,6).'.'; }
    elseif ($mode == "11") { $mode_name = substr(get_lang($lang,'k71'),0,6).'.'; }
    elseif ($mode == "4") {  $mode_name = substr(get_lang($lang,'k72'),0,6).'.'; }
    elseif ($mode == "12") { $mode_name = substr(get_lang($lang,'k72'),0,6).'.'; }
    elseif ($mode == "0") {  $mode_name = substr(get_lang($lang,'k73'),0,6).'.'; }
	else { $mode_name = $mode; }
	*/
	//step
	//led
	if (($mode < 8) && ($mode > 0)) { $status = 0; }
	elseif (($mode < 13) && ($mode > 8)) { $status = 1; }
	else { $status = 2; }
	if (!in_array($d0,$ex)) {
		$klima_time = strtotime($d1);
		//$klima_time_format = date('Y-m-d H:i:s',$klima_time);
		$startTime = '06:45';
		$endTime = '23:59';
		$time = new DateTime($startTime);
		$time1 = date_format($time,'H:i'); 
		$time = new DateTime($endTime);
		$time2 = date_format($time,'H:i');
		$current = date("H:i");
		echo $d0." ".$status."<br/>";
		if (($status === 1) && ((time() - $klima_time) < (5 * 60)) && ($current > $time1 && $current < $time2)) {
            $day = date("Y-m-d");
			$datetime = date("Y-m-d H:i:s");
			$stamp = time();
			$query = "INSERT INTO `tempo` (`timestamp`, `day`, `datetime`, `router`, `addr`, `inv`, `status`) VALUES ('".$stamp."', '".$day."', '".$datetime."', '".$r."', '".$addr."', '".$d0."', '".$status."')";
			$result = mysql_query($query);
			confirm_query($result);
			/*
			if ($result) {

			} else {

			}
			*/
		}
	}
}
//close connection
DataBase::getInstance()->disconnect();
?>