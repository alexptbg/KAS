<?php
error_reporting(0);
define('start', TRUE);
include('inc/db.php');
include('inc/functions.php');
include('inc/init.php');
DataBase::getInstance()->connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
include('inc/config.php');
check_login($lang,$web_dir);
$r = $_GET['router'];
$u = $user_settings['user_name'];
$r_settings = get_rout_settings($r);
$datafile = "data/{$r_settings['data_file']}";
if (file_exists($datafile)) { include("$datafile"); } 
else { echo "<div class=\"alert alert-warning\">".get_lang($lang,'k164')."</div>"; exit; }
$exclude = $r_settings['ex_table'];
$ex = explode(',', $exclude);
//echo "<div class=\"list-group\">";

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
            echo "<div class=\"divc\">
               <h5>ADDR&nbsp;".$addr."</h5>";
	        echo "<div class=\"list-group\">";
	        foreach ($klimas as $klima) {
		        if(!(${'dev'.$klima} == NULL)) {
		            ${'d'.$klima} = explode(" ", ${'dev'.$klima}); 
			        p(${'d'.$klima},$r,$lang,$u,$ex);
		        }	
	        }
	        echo "</div>";
	        echo "<div class=\"clearboth\"></div>";
	        echo "</div>";
        }
	}
}
//echo "</div>";
function p($d,$r,$lang,$u,$ex) {
	$d0 = $d[0];//inv
	$d1 = $d[1];//time
	$d2 = $d[2];//set_point_1
	$d3 = $d[3];//set_point_2
	$d4 = $d[4];//mode1
	$d5 = $d[5];//mode2
	$d6 = $d[6];//vent1
	$d7 = $d[7];//vent2
	$d8 = $d[8];//temp_in_1
	$d9 = $d[9];//temp_in_2	
	$mode = $d4*256+$d5;
	$vent = $d6*256+$d7;
	$set_point = ($d2*256+$d3)/10;
	$in_temp = ($d8*256+$d9)/10;
    //mode
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
	//step
	//led
	if (($mode < 8) && ($mode > 0)) { $led = 'off'; $checked = ""; $data_off = "danger"; } 
	elseif (($mode < 13) && ($mode > 8)) { $led = 'on'; $checked = "checked "; $data_off = "danger"; }
	else { $led = 'err'; $checked = ""; $data_off = "danger"; }
	$klima = get_klima_settings($d0);
	$user = get_user_settings($u);
	$prog_status = r($d0,$r);
	if ($prog_status == "Off") { $regime = "M"; }
	if ($prog_status == "On") { $regime = "A"; }
	if (!in_array($d0,$ex)) {
	echo "
        <div class=\"col-xs-6 col-sm-3 status_".$prog_status."\">
            <a href=\"klima_i.php?lang=".$lang."&user=".$u."&klima=".$d0."&r=".$r."\" class=\"list-group-item\">
                <i class=\"fa fa-square fa-fw\"></i>&nbsp;".$d0."
                <span>&nbsp;&nbsp;&nbsp;".$set_point."<i class=\"icon ka-celcius ka-status-lg\"></i></span>
                <span>&nbsp;&nbsp;".$mode_name."</span>
                <span>&nbsp;&nbsp;&nbsp;<i class=\"icon ka-cooler ka-status\"></i>&nbsp;".$vent."</span>
                <span>&nbsp;&nbsp;".$regime."</span>
                <span class=\"pull-right\" style=\"margin-top:4px;vertical-align:middle;\">
				    <span class=\"lamp fr\"><span class=\"".$led."\"></span></span>
				</span>
            </a>
	    </div>";
	}
}
DataBase::getInstance()->disconnect();
function r($d,$r) {
	$query = "SELECT `prog` FROM `klimatiki` WHERE `router`='".$r."' AND `inv`='".$d."'";
    $result = mysql_query($query);
    confirm_query($result);
    if (mysql_num_rows($result) != 0) {
        while($status = mysql_fetch_array($result)) {
		    $prog_status = $status['prog'];
	    }
    }
    return $prog_status;
}
?>