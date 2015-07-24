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
$action = $_POST['action'];
$ad = $_POST['addr'];
$status = $_POST['status'];
$router = $_POST['router'];
include('inc/socket.php');
$r_options = get_rout_settings($router);
$socket_ip = $r_options['ip_address'];
$socket_port = $r_options['port'];
$query = "SELECT `inv` FROM `klimatiki` WHERE `addr`=".$ad." ORDER BY `inv` ASC";
$result = mysql_query($query);
confirm_query($result);
if (mysql_num_rows($result) != 0) {
    while($klimas = mysql_fetch_array($result)) {
		$invs[] = $klimas['inv'];
	}
	foreach($invs as $klima) {
        if (($klima != NULL) && ($ad != NULL)) {
            $query = "UPDATE `klimatiki` SET `prog`='".$status."' WHERE `router`='".$router."' AND `addr`='".$ad."' AND `inv`='".$klima."'";
            $result = mysql_query($query);
            confirm_query($result);
            if ($result) {
                $log_it = TRUE;
			}
		}
	}
	if ((!empty($invs)) && ($action == 'prog')) {
		$com = 'cmd';
	    $command = 'sche_addr';
		$frame = "klimas_sche_".$ad."_".$status;
        try {
            if(!($command == NULL)) {
		        $server = 'server';
	            if ($command == 'sche_addr') {
    	            $sc = new ClientSocket();
    	            $sc->open($socket_ip,$socket_port);
                    $sc->send("$server $com $command $frame\r\n");
					if ($log_it == TRUE) {
			            $obs = $router." | ".$ad." | ".$status;
				        $SYS = get_device($user_settings['user_name']);
			            insert_log($lang,$SYS,$user_settings['user_name'],'error','k140',$obs);
					}
	            }
	        }
        }
        catch (Exception $e){ echo $e->getMessage(); }
	}
}
?>