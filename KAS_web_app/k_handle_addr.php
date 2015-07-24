<?php
//error_reporting(0);
define('start', TRUE);
include('inc/db.php');
include('inc/functions.php');
include('inc/init.php');
DataBase::getInstance()->connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
include('inc/config.php');
check_login($lang,$web_dir);
//turn off klimas by addr
$command = $_POST['action'];
$addr = $_POST['addr'];
$router = $_POST['router'];
$status = $_POST['status'];
include('inc/socket.php');
$r_options = get_rout_settings($router);
$socket_ip = $r_options['ip_address'];
$socket_port = $r_options['port'];
if ($command == "ADDR") {
    $frame = "klimas_turn_".$status."_".$addr;
} else {
	exit;
}
if ($addr == '01') { $timer = '11'; }
elseif ($addr == '02') { $timer = '10'; }
elseif ($addr == '03') { $timer = '7'; }
elseif ($addr == '04') { $timer = '10'; }
elseif ($addr == '05') { $timer = '7'; }
elseif ($addr == '06') { $timer = '7'; }
elseif ($addr == '07') { $timer = '10'; }
elseif ($addr == '08') { $timer = '7'; }
elseif ($addr == '09') { $timer = '12'; }
elseif ($addr == '10') { $timer = '6'; }
elseif ($addr == '11') { $timer = '9'; }
elseif ($addr == '12') { $timer = '8'; }
elseif ($addr == '13') { $timer = '10'; }
elseif ($addr == '14') { $timer = '9'; }
elseif ($addr == '15') { $timer = '6'; }
elseif ($addr == '16') { $timer = '16'; }
elseif ($addr == '17') { $timer = '16'; }
elseif ($addr == '18') { $timer = '16'; }
elseif ($addr == '19') { $timer = '16'; }
else { $timer = '12'; }
try {
    if(!($command == NULL)) {
		$server = 'server';
		$com = 'cmd';
	    if ($command == 'ADDR') {
    	    $sc = new ClientSocket();
    	    $sc->open($socket_ip,$socket_port);
    	    $sc->send("$server $com $command $timer $frame\r\n");
			$obs = $router." | ".$addr." | ".$status." ALL";
			$SYS = get_device($user_settings['user_name']);
			insert_log($lang,$SYS,$user_settings['user_name'],'error','k127',$obs);
		}
	}
}
catch (Exception $e){ echo $e->getMessage(); }
?>