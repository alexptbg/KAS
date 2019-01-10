<?php
//error_reporting(E_ALL);
/*
define('start', TRUE);
include('inc/db.php');
include('inc/functions.php');
include('inc/init.php');
DataBase::getInstance()->connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
include('inc/config.php');
$cr=0;
$arduino_temp = arduino();
$darksky_temp = darksky();
$hour = date("H");
if($hour >= 0 && $hour <= 9) {
	$cr = 0;
} elseif ($hour >= 10 && $hour <=12) {
	$cr=1;
} elseif ($hour >= 13 && $hour <=15) {
	$cr=2;
} elseif ($hour >= 16 && $hour <=18) {
	$cr=3;
} elseif ($hour >= 19 && $hour <=21) {
	$cr=2;
} elseif ($hour >= 22) {
	$cr=1;
}
$curTemp = (($arduino_temp+$darksky_temp)/2)+$cr;
//echo $arduino_temp;
if(isset($_GET['out'])) {
	if((isset($_GET['hum'])) && (isset($_GET['temp1'])) && (isset($_GET['temp2'])) && (isset($_GET['id'])) && (isset($_GET['ip'])) && (isset($_GET['mac']))) {
        $now = date("Y-m-d H:i:s");
        $stamp = time();
		//$utemp1 = ($_GET['temp1']-$cr);
		//$utemp2 = ($_GET['temp2']-$cr);
		$utemp1 = number_format($curTemp,2);
		$utemp2 = number_format($curTemp,2);
		$uid = $_GET['id'];
		$uip = $_GET['ip'];
		$umac = $_GET['mac'];
        $query = "INSERT INTO `arduino_out_temp` (`datetime`,`timestamp`,`temp1`,`temp2`,`ar_id`,`ip_addr`,`mac`) 
                  VALUES ('".$now."','".$stamp."','".$utemp1."','".$utemp2."','".$uid."','".$uip."','".$umac."')";
        $result = mysql_query($query);
        confirm_query($result);
        if ($result) {
            echo "inserted<br/>";
        } else {
			//do nothing
		}
	} else {
		//do nothing
	}
}
DataBase::getInstance()->disconnect();
function arduino() {
    $servername = "localhost";
    $username = "root";
    $password = "11543395";
    $dbname = "weather";
    //Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    //Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT * FROM `weather` WHERE `zone`='Gotse Delchev' ORDER BY `id` DESC LIMIT 1";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        //output data of each row
        while($row = $result->fetch_assoc()) {
            $data = $row;
        }
        return $data['wmax'];
    }
    $conn->close();
}
function darksky() {
    $servername = "localhost";
    $username = "root";
    $password = "11543395";
    $dbname = "weather";
    //Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    //Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT * FROM `darksky` ORDER BY `id` DESC LIMIT 1";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        //output data of each row
        while($row = $result->fetch_assoc()) {
            $data = $row;
        }
        return $data['curTemp'];
    }
    $conn->close();
}
*/
?>