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
$query = "SELECT `klimas` FROM `users` WHERE `user_name`='".$u."'";
$result = mysql_query($query);
confirm_query($result);
if (mysql_num_rows($result) != 0) {
    while($klimas_u = mysql_fetch_array($result)) {
		$klimas_list = $klimas_u['klimas'];
	}
	$klimas = explode(", ",$klimas_list);
}
if (!empty($klimas)) {
	$r_settings = get_rout_settings($r);
    $datafile = "data/{$r_settings['data_file']}";
    if (file_exists($datafile)) { include_once("$datafile"); } else { echo "file error"; exit; }
	if (filesize($datafile)<500) {
		echo "
            <div class=\"col-lg-12\">
                <div class=\"panel panel-danger\">
                    <div class=\"panel-heading\">".get_lang($lang,'Error')."</div>
                    <div class=\"panel-body\">
					    <div class=\"alert alert-warning\">
                            ".get_lang($lang,'k124')."
						</div>
                    </div>
                </div>
		    </div>";
		exit; 
	}
    $exclude = $r_settings['ex_table'];
    $ex = explode(',', $exclude);
    if (!empty($klimas)) {
    	echo "<div class=\"list-group\">";
	    foreach ($klimas as $klima) {
		    $i++;
		    if(!(${'dev'.$klima} == NULL)) {
		        ${'d'.$klima} = explode(" ", ${'dev'.$klima}); 
			    p(${'d'.$klima},$r_settings['router_name'],$lang,$u,$ex);
		    }
	    }
	    echo "</div>";
	}
}
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
	if (!in_array($d0, $ex)) {
	echo "
        <div class=\"col-xs-6 col-sm-3\">
            <a href=\"klima_i.php?lang=".$lang."&user=".$u."&klima=".$d0."&r=".$r."\" class=\"list-group-item\">
                <i class=\"fa fa-square fa-fw\"></i>&nbsp;".$d0."
                <span>&nbsp;&nbsp;&nbsp;&nbsp;".$set_point."<i class=\"icon ka-celcius ka-status-lg\"></i></span>
                <span>&nbsp;&nbsp;&nbsp;&nbsp;".$mode_name."</span>
                <span>&nbsp;&nbsp;&nbsp;&nbsp;<i class=\"icon ka-cooler ka-status\"></i>&nbsp;".$vent."</span>
                <span class=\"pull-right\" style=\"margin-top:4px;vertical-align:middle;\">
				    <span class=\"lamp fr\"><span class=\"".$led."\"></span></span>
				</span>
            </a>
	    </div>";
	}
}
DataBase::getInstance()->disconnect();
?>