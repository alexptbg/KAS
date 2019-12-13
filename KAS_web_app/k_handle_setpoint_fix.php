<?php
//error_reporting(0);
define('start', TRUE);
include('inc/db.php');
include('inc/functions.php');
include('inc/init.php');
DataBase::getInstance()->connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
include('inc/config.php');
check_login($lang,$web_dir);
//temperature sender
//router=Boss&kinv=1601&action=SP&first=1&second=24
$action = $_POST['action'];
$router = mysql_prep($_POST['router']);
$kinv = mysql_prep($_POST['kinv']);
$first = $_POST['first'];
$second = $_POST['second'];
include('inc/socket.php');
$r_options = get_rout_settings($router);
$socket_ip = $r_options['ip_address'];
$socket_port = $r_options['port'];
$k_options = get_klima_settings($kinv);
$rtu = $k_options['rtu'];
$addr = $k_options['addr'];
$device = substr(chunk_split($kinv, 2, ' '), 0, -1);
$klimatik = explode(" ", $device);
$klima = $klimatik[1];//end na klimatik id
if ($action == 'SP') { $command = 'SP'; } else { return false; }
if ($first < 10) { $ft = "0".$first; } else { $ft = $first; }
if ($second < 10) { $sc = "0".$second; } else { $sc = $second; }
if ($command == "SP") {//mode
	if ($klima == "01") {
	    $cc = array("$addr","16","00","01","00","01","02","$ft","$sc");
	}
	elseif ($klima == "02") {
	    $cc = array("$addr","16","00","06","00","01","02","$ft","$sc");
	}
	elseif ($klima == "03") {
	    $cc = array("$addr","16","00","11","00","01","02","$ft","$sc");
	}
	elseif ($klima == "04") {
	    $cc = array("$addr","16","00","16","00","01","02","$ft","$sc");
	}
	elseif ($klima == "05") {
	    $cc = array("$addr","16","00","21","00","01","02","$ft","$sc");
	}
	elseif ($klima == "06") {
	    $cc = array("$addr","16","00","26","00","01","02","$ft","$sc");
	}
	elseif ($klima == "07") {
	    $cc = array("$addr","16","00","31","00","01","02","$ft","$sc");
	}	
	elseif ($klima == "08") {
	    $cc = array("$addr","16","00","36","00","01","02","$ft","$sc");
	}	
	elseif ($klima == "09") {
	    $cc = array("$addr","16","00","41","00","01","02","$ft","$sc");
	}	
	elseif ($klima == "10") {
	    $cc = array("$addr","16","00","46","00","01","02","$ft","$sc");
	}	
	elseif ($klima == "11") {
	    $cc = array("$addr","16","00","51","00","01","02","$ft","$sc");
	}	
	elseif ($klima == "12") {
	    $cc = array("$addr","16","00","56","00","01","02","$ft","$sc");
	}	
	elseif ($klima == "13") {
	    $cc = array("$addr","16","00","61","00","01","02","$ft","$sc");
	}	
	elseif ($klima == "14") {
	    $cc = array("$addr","16","00","66","00","01","02","$ft","$sc");
	}	
	elseif ($klima == "15") {
	    $cc = array("$addr","16","00","71","00","01","02","$ft","$sc");
	}	
	elseif ($klima == "16") {
	    $cc = array("$addr","16","00","76","00","01","02","$ft","$sc");
	}
}
foreach ($cc as $e) {//dehex frame
	if($e < 16) { $e = "0".dechex($e); } else { $e = dechex($e); }
	$ee[] = strtoupper($e);
}
$xx = strtoupper(crc16($cc));//hex soma
$xx = explode(" ", $xx); 
foreach ($xx as $h) {
	if ($h == "0") { $h = "00"; }
	if ($h == "1") { $h = "01"; }
	if ($h == "2") { $h = "02"; }
	if ($h == "3") { $h = "03"; }
	if ($h == "4") { $h = "04"; }
	if ($h == "5") { $h = "05"; }
	if ($h == "6") { $h = "06"; }
	if ($h == "7") { $h = "07"; }
	if ($h == "8") { $h = "08"; }
	if ($h == "9") { $h = "09"; }
	if ($h == "A") { $h = "0A"; }
	if ($h == "B") { $h = "0B"; }
	if ($h == "C") { $h = "0C"; }
	if ($h == "D") { $h = "0D"; }
	if ($h == "E") { $h = "0E"; }
	if ($h == "F") { $h = "0F"; }
	$hh[] = $h;
}
$frame = implode(" ",$ee)." ".implode(" ",$hh);
try {
    if(!($command == NULL)) {
		$server = 'r';
	    if ($command == 'SP') {
    	    $sc = new ClientSocket();
    	    $sc->open($socket_ip,$socket_port);
    	    $sc->send("$server $command $rtu $frame\r\n");
			$temp = (($first*256)+$second)/10;
			$obs = $router." | ".$kinv." | ".$temp;
			$SYS = get_device($user_settings['user_name']);
			insert_log($lang,$SYS,$user_settings['user_name'],'warning','k83',$obs);
		}
	}
}
catch (Exception $e){ echo $e->getMessage(); }
?>