<?php
error_reporting(0);
define('start', TRUE);
include('inc/db.php');
include('inc/functions.php');
include('inc/init.php');
DataBase::getInstance()->connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
include('inc/config.php');
$ad = $_GET['addr'];
$r = get_router_by_addr($ad);
$query = "SELECT `inv` FROM `klimatiki` WHERE `addr`=".$ad." ORDER BY `inv` ASC";
$result = mysql_query($query);
confirm_query($result);
if (mysql_num_rows($result) != 0) {
    while($klimas = mysql_fetch_array($result)) {
		$invs[] = $klimas['inv'];
	}
    $r_settings = get_rout_settings($r);
    $datafile = "data/{$r_settings['data_file']}";
	if (file_exists($datafile)) { include_once("$datafile"); } else { echo "file error"; exit; }
	foreach($invs as $klima) {
		if(!(${'dev'.$klima} == NULL)) {
		    $d = explode(" ", ${'dev'.$klima});
	        $d2 = $d[2];
	        $d3 = $d[3];
			$d4 = $d[4];
	        $d5 = $d[5];
	        $d6 = $d[6];
	        $d7 = $d[7];
			$set_p = ($d2*256+$d3)/10;
			$mode = $d4*256+$d5;
			$vent = $d6*256+$d7;
	        if ($mode == "1") { $mode_n = get_lang($lang, 'k69'); } 
	        elseif ($mode == "9") { $mode_n = get_lang($lang, 'k69'); }
	        elseif ($mode == "2") { $mode_n = get_lang($lang, 'k70'); }
	        elseif ($mode == "10") { $mode_n = get_lang($lang, 'k70'); }
	        elseif ($mode == "3") { $mode_n = get_lang($lang, 'k71'); }
	        elseif ($mode == "11") { $mode_n = get_lang($lang, 'k71'); }
	        elseif ($mode == "4") { $mode_n = get_lang($lang, 'k72'); }
	        elseif ($mode == "12") { $mode_n = get_lang($lang, 'k72'); }
	        elseif ($mode == "0") { $mode_n = get_lang($lang, 'k73'); }
	        else { $mode_n = $mode; }
	        if (($mode < 8) && ($mode > 0)) { $class = 'danger'; $md = get_lang($lang, 'off'); } 
	        elseif (($mode < 13) && ($mode > 8)) { $class = 'success'; $md = get_lang($lang, 'on'); }
	        else { $class = 'warning'; $md = 'err'; }
			echo "<h3><span class=\"label label-default\">".$klima."</span>&nbsp;
			          <span class=\"label label-info\">".$mode_n."</span>&nbsp;
					  <span class=\"label label-".$class."\">".$md."</span>&nbsp;
					  <span class=\"label label-info\">".$vent."</span>&nbsp;
					  <span class=\"label label-info\">".$set_p."&ordm;</span></h3>";
		}
	}
}
DataBase::getInstance()->disconnect();
?>