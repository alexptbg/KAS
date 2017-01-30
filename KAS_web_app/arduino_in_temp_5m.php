<?php
//error_reporting(0);
define('start', TRUE);
include('inc/db.php');
include('inc/functions.php');
include('inc/init.php');
DataBase::getInstance()->connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
include('inc/config.php');
//GET ALL ARDUINO ACTIVE DEVICES
$today = date("Y-m-d H:i:s");
$days3 = date("Y-m-d H:i:s", time() - 60 * 60 * 24 * 3);
$query = "SELECT `ar_id` FROM `arduino_in_temp` WHERE `datetime` BETWEEN '".$days3."' AND '".$today."' GROUP BY `ar_id`";
$result = mysql_query($query);
confirm_query($result);
if (mysql_num_rows($result) != 0) {
    while ($devices = mysql_fetch_array($result)) {
    	$ar_devices[] = $devices['ar_id'];
    }
}
foreach ($ar_devices as $single) {
    $query1 = "SELECT * FROM `arduino_in_temp` WHERE `ar_id`='".$single."' ORDER BY `id` DESC LIMIT 1";
    $result1 = mysql_query($query1);
    confirm_query($result1);
    if (mysql_num_rows($result1) != 0) {
        while ($dev = mysql_fetch_array($result1)) {
    	    $dbdate = $dev['timestamp'];
            if ((time() - $dbdate) < (10 * 60)) {
            	//insert in database
                $sql = "INSERT INTO `arduino_in_temp_5m` (`datetime`,`timestamp`,`temp1`,`temp2`,`ar_id`,`ip_addr`,`mac`)
                                 VALUES (
                                     '".$dev['datetime']."',
                                     '".$dev['timestamp']."',
                                     '".$dev['temp1']."',
                                     '".$dev['temp2']."',
                                     '".$dev['ar_id']."',
                                     '".$dev['ip_addr']."',
                                     '".$dev['mac']."'
                                 )";
                $result2 = mysql_query($sql);
                confirm_query($result2);
                if ($result2) {
                    echo "Inserted - ".$dev['ar_id']." - ".$dev['ip_addr']."<br/>";
                } else {
			        echo "error";
		        }
            } else {
            	//not insert in database
                echo "Not inserted, passed 10 minutes after last update: - ".$dev['ar_id']." - ".$dev['ip_addr']."<br/>";
			}
        }
    }
}
DataBase::getInstance()->disconnect();
?>