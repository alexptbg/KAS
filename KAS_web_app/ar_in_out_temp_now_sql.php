<?php
//error_reporting(0);
define('start', TRUE);
include('inc/db.php');
include('inc/functions.php');
include('inc/init.php');
DataBase::getInstance()->connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
include('inc/config.php');
//mySQL weather
define("WDB_SERVER", "localhost");
define("WDB_NAME", "weather");
define("WDB_USER", "root");
define("WDB_PASS", "11543395");
//mySQL CLOCKS
define("MDB_SERVER", "localhost");
define("MDB_NAME", "raspi");
define("MDB_USER", "root");
define("MDB_PASS", "11543395");
//VARS
$now = date("Y-m-d H:i:s");
$data = array();
//init
//GET OUT TEMP
$local1 = new mysqli(WDB_SERVER,WDB_USER,WDB_PASS,WDB_NAME);
$sql1 = "SELECT * FROM `out_temp` ORDER BY `id` DESC LIMIT 1";
$result1=$local1->query($sql1);
if($result1 === false) {
    trigger_error('Wrong SQL: '.$sql1.' Error: '.$local1->error,E_USER_ERROR);
} else {
    if($result1->num_rows === 1) {
        $data1 = mysqli_fetch_assoc($result1);
        if ((time() - $data1['timestamp']) < 620) {
            $temp_out = number_format($data1['temp'],1);
        } else {
            $temp_out = "error";
        }
    }
}
//GET IN TEMP HALE1 FLOOR1
$local2 = new mysqli(MDB_SERVER,MDB_USER,MDB_PASS,MDB_NAME);
$sql2 = "SELECT * FROM `status` WHERE `inv`='11029' ORDER BY `id` DESC LIMIT 1";
$result2=$local2->query($sql2);
if($result2 === false) {
    trigger_error('Wrong SQL: '.$sql2.' Error: '.$local2->error,E_USER_ERROR);
} else {
    if($result2->num_rows === 1) {
        $data2 = mysqli_fetch_assoc($result2);
        if ((time() - $data2['timestamp']) < 130) {
            $temp_h1f1 = $data2['tempin'];
        } else {
            $temp_h1f1 = "error";
        }
    }
}
//GET IN TEMP HALE1 FLOOR2
$sql3 = "SELECT * FROM `status` WHERE `inv`='12028' ORDER BY `id` DESC LIMIT 1";
$result3=$local2->query($sql3);
if($result3 === false) {
    trigger_error('Wrong SQL: '.$sql3.' Error: '.$local2->error,E_USER_ERROR);
} else {
    if($result3->num_rows === 1) {
        $data3 = mysqli_fetch_assoc($result3);
        if ((time() - $data3['timestamp']) < 130) {
            $temp_h1f2 = $data3['tempin'];
        } else {
            $temp_h1f2 = "error";
        }
    }
}
//GET IN TEMP HALE2 FLOOR1
$sql4 = "SELECT * FROM `status` WHERE `inv`='21020' ORDER BY `id` DESC LIMIT 1";
$result4=$local2->query($sql4);
if($result4 === false) {
    trigger_error('Wrong SQL: '.$sql4.' Error: '.$local2->error,E_USER_ERROR);
} else {
    if($result4->num_rows === 1) {
        $data4 = mysqli_fetch_assoc($result4);
        if ((time() - $data4['timestamp']) < 130) {
            $temp_h2f1 = $data4['tempin'];
        } else {
            $temp_h2f1 = "error";
        }
    }
}
//GET IN TEMP HALE2 FLOOR2
$sql5 = "SELECT * FROM `status` WHERE `inv`='22005' ORDER BY `id` DESC LIMIT 1";
$result5=$local2->query($sql5);
if($result5 === false) {
    trigger_error('Wrong SQL: '.$sql5.' Error: '.$local2->error,E_USER_ERROR);
} else {
    if($result5->num_rows === 1) {
        $data5 = mysqli_fetch_assoc($result5);
        if ((time() - $data5['timestamp']) < 130) {
            $temp_h2f2 = $data5['tempin']+2;
        } else {
            $temp_h2f2 = "error";
        }
    }
}
//generate data
$data = array($now,$temp_out,$temp_h1f1,$temp_h1f2,$temp_h2f1,$temp_h2f2);
header('Content-Type: application/json; charset=utf-8');
echo json_encode($data);
DataBase::getInstance()->disconnect();
?>