<?php
//error_reporting(0);
define('start', TRUE);
include('inc/db.php');
include('inc/functions.php');
include('inc/init.php');
DataBase::getInstance()->connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
include('inc/config.php');
check_login($lang,$web_dir);
//send command to socket server
$action = $_POST['action'];
$command = $_POST['command'];
$r = $_POST['r'];
$r_options = get_rout_settings($r);
$socket_ip = $r_options['ip_address'];
$socket_port = $r_options['port'];
include('inc/socket.php');
if (($r != NULL) && ($action == 'COM')) {
	$com = 'cmd';
	if ($command == "reset") {
		$frame = "Klima_reset";
        try {
            if(!($command == NULL)) {
		        $server = 'server';
    	        $sc = new ClientSocket();
    	        $sc->open($socket_ip,$socket_port);
    	        $sc->send("$server $com $command $frame\r\n");
			    $obs = $r;
			    $SYS = get_device($user_settings['user_name']);
			    insert_log($lang,$SYS,$user_settings['user_name'],'error','k163',$obs);
	        }
        }
        catch (Exception $e){ echo $e->getMessage(); }
	}
}
?>