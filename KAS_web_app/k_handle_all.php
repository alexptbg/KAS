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
$status = $_POST['status'];
include('inc/socket.php');
$router = 'Strellson/Joop';
$r_options = get_rout_settings($router);
$socket_ip = $r_options['ip_address'];
$socket_port = $r_options['port'];
if ($addr == "all") {
	$command = "ALL";
    $frame = "klimas_turn_".$status."_".$addr."_safe";
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
			$SYS = get_device($user_settings['user_name']);
			insert_log($lang,$SYS,$user_settings['user_name'],'error','k127',$obs);
		}
	}
}
catch (Exception $e){ echo $e->getMessage(); }
?>