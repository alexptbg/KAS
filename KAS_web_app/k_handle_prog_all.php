<?php
//error_reporting(0);
define('start', TRUE);
include('inc/db.php');
include('inc/functions.php');
include('inc/init.php');
DataBase::getInstance()->connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
include('inc/config.php');
check_login($lang,$web_dir);
//change program schedule on%off
$r = $_POST['r'];
$pg = $_POST['pg'];
$status = $_POST['status'];
$r_options = get_rout_settings($r);
$socket_ip = $r_options['ip_address'];
$socket_port = $r_options['port'];
include('inc/socket.php');
if (($r != NULL) && ($pg == 'all')) {
	$com = 'cmd';
	$command = 'sche';
	if ($status == "On") {
        $query = "UPDATE `routers` SET `work_sche`='".$status."' WHERE `router_name`='".$r."'";
        $result = mysql_query($query);
        confirm_query($result);
        if ($result) {
			$obs = $r." | ".$status;
			$SYS = get_device($user_settings['user_name']);
			insert_log($lang,$SYS,$user_settings['user_name'],'error','k140',$obs);
			$frame = "init_prog ".$status;
            try {
                if(!($command == NULL)) {
		            $server = 'server';
	                if ($command == 'sche') {
    	                $sc = new ClientSocket();
    	                $sc->open($socket_ip,$socket_port);
    	                $sc->send("$server $com $command $frame\r\n");
		            }
	            }
            }
            catch (Exception $e){ echo $e->getMessage(); }
		}
	} elseif ($status == "Off") {
        $query = "UPDATE `routers` SET `work_sche`='".$status."' WHERE `router_name`='".$r."'";
        $result = mysql_query($query);
        confirm_query($result);
        if ($result) {
			$obs = $r." | ".$status;
			$SYS = get_device($user_settings['user_name']);
			insert_log($lang,$SYS,$user_settings['user_name'],'error','k140',$obs);
			$frame = "init_prog ".$status;
            try {
                if(!($command == NULL)) {
		            $server = 'server';
	                if ($command == 'sche') {
    	                $sc = new ClientSocket();
    	                $sc->open($socket_ip,$socket_port);
    	                $sc->send("$server $com $command $frame\r\n");
		            }
	            }
            }
            catch (Exception $e){ echo $e->getMessage(); }
		}
	} 
}
?>