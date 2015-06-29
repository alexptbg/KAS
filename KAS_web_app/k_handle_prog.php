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
$kinv = $_POST['kinv'];
$prog = $_POST['prog'];
$r_options = get_rout_settings($r);
$socket_ip = $r_options['ip_address'];
$socket_port = $r_options['port'];
$klima = get_klima_settings($kinv);
include('inc/socket.php');
if (($r != NULL) && ($kinv != NULL)) {
	$d = substr(chunk_split($kinv, 2, ' '), 0, -1);
	$de = explode(" ", $d);
	$delay = $de[0]*10+$de[1];
	$com = 'cmd';
	$command = 'prog';
	if ($prog != NULL) {
        $query = "UPDATE `klimatiki` SET `prog`='".$prog."' WHERE `router`='".$r."' AND `inv`='".$kinv."'";
        $result = mysql_query($query);
        confirm_query($result);
        if ($result) {
			$obs = $r." | ".$kinv." | ".$prog;
			$SYS = get_device($user_settings['user_name']);
			insert_log($lang,$SYS,$user_settings['user_name'],'warning','k139',$obs);
			$frame = "%sche_".$kinv." ".lcfirst($prog)." %prog_".$kinv."_start_w ".$klima['start_w']." %prog_".$kinv."_stop_w ".$klima['stop_w'].
			                                           " %prog_".$kinv."_start_s ".$klima['start_s']." %prog_".$kinv."_stop_s ".$klima['stop_s'].
													   " ".$kinv." ".$delay;
            try {
                if(!($command == NULL)) {
		            $server = 'server';
	                if ($command == 'prog') {
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