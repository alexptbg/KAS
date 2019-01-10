<?php
//error_reporting(0);
define('start', TRUE);
include('inc/db.php');
include('inc/functions.php');
include('inc/init.php');
DataBase::getInstance()->connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
include('inc/config.php');
//check_login($lang,$web_dir);
//turn off klimas by addr
$router = 'Strellson/Joop';
$command = 'ADDR';
$addr = 'all';
$status = 'off';
include('inc/socket.php');
$r_options = get_rout_settings($router);
$socket_ip = $r_options['ip_address'];
$socket_port = $r_options['port'];
if ($addr == "all") {
	$command = "ALL";
    $frame = "klimas_turn_".$status."_".$addr."_safe_14h30m";
} else {
	exit;
}
try {
    if(!($command == NULL)) {
		$server = 'server';
		$com = 'cmd';
	    if ($command == 'ALL') {
    	    $sc = new ClientSocket();
    	    $sc->open($socket_ip,$socket_port);
    	    $sc->send("$server $com $command $frame\r\n");
			$obs = $router." | ".$addr." | ".$status;
			$SYS = "SYSTEM";
			insert_log($lang,$SYS,"SYSTEM",'error','k127',$obs);
			echo "OKOK";
		}
	}
}
catch (Exception $e){ echo $e->getMessage(); }
?>