<?php
//error_reporting(0);
define('start', TRUE);
include('inc/db.php');
include('inc/functions.php');
include('inc/init.php');
DataBase::getInstance()->connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
include('inc/config.php');
check_login($lang,$web_dir);
//mode//regime changer
$router = mysql_prep($_POST['router']);
$kinv = mysql_prep($_POST['kinv']);
$command = $_POST['action'];
$status = $_POST['status'];
$mode = $_POST['mode'];
if ($mode < 10) { $mode = "0".$mode; }
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
if ($status == 'on') {
	if ($mode == '00') { $md = '09'; }
	elseif ($mode == '01') { $md = '09'; }
	elseif ($mode == '02') { $md = '10'; }
	elseif ($mode == '03') { $md = '11'; }
	elseif ($mode == '04') { $md = '12'; }
	else { }
}
elseif ($status == 'off') {
	if ($mode == '08') { $md = '01'; }
	elseif ($mode == '09') { $md = '01'; }
	elseif ($mode == '10') { $md = '02'; }
	elseif ($mode == '11') { $md = '03'; }
	elseif ($mode == '12') { $md = '04'; }
	else { }
}
else { }
if ($command == "MD") {//mode
	if ($klima == "01") {
	    $cc = array("$addr","16","00","02","00","01","02","00","$md");
	}
	elseif ($klima == "02") {
	    $cc = array("$addr","16","00","07","00","01","02","00","$md");
	}
	elseif ($klima == "03") {
	    $cc = array("$addr","16","00","12","00","01","02","00","$md");
	}
	elseif ($klima == "04") {
	    $cc = array("$addr","16","00","17","00","01","02","00","$md");
	}
	elseif ($klima == "05") {
	    $cc = array("$addr","16","00","22","00","01","02","00","$md");
	}
	elseif ($klima == "06") {
	    $cc = array("$addr","16","00","27","00","01","02","00","$md");
	}
	elseif ($klima == "07") {
	    $cc = array("$addr","16","00","32","00","01","02","00","$md");
	}
	elseif ($klima == "08") {
	    $cc = array("$addr","16","00","37","00","01","02","00","$md");
	}
	elseif ($klima == "09") {
	    $cc = array("$addr","16","00","42","00","01","02","00","$md");
	}
	elseif ($klima == "10") {
	    $cc = array("$addr","16","00","47","00","01","02","00","$md");
	}
	elseif ($klima == "11") {
	    $cc = array("$addr","16","00","52","00","01","02","00","$md");
	}
	elseif ($klima == "12") {
	    $cc = array("$addr","16","00","57","00","01","02","00","$md");
	}
	elseif ($klima == "13") {
	    $cc = array("$addr","16","00","62","00","01","02","00","$md");
	}
	elseif ($klima == "14") {
	    $cc = array("$addr","16","00","67","00","01","02","00","$md");
	}
	elseif ($klima == "15") {
	    $cc = array("$addr","16","00","72","00","01","02","00","$md");
	}
	elseif ($klima == "16") {
	    $cc = array("$addr","16","00","77","00","01","02","00","$md");
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
	    if ($command == 'MD') {
    	    $sc = new ClientSocket();
    	    $sc->open($socket_ip,$socket_port);
    	    $sc->send("$server $command $rtu $frame\r\n");
			$obs = $router." | ".$kinv." | ".$md;
			$SYS = get_device($user_settings['user_name']);
			insert_log($lang,$SYS,$user_settings['user_name'],'error','k84',$obs);
		}
	}
}
catch (Exception $e){ echo $e->getMessage(); }
?>