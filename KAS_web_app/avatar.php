<?php
//error_reporting(0);
/*
define('start', TRUE);
include('inc/db.php');
include('inc/functions.php');
include('inc/init.php');
DataBase::getInstance()->connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
include('inc/config.php');
$username = $_GET['username'];
if(!empty($username)) {
	mysql_query("SET NAMES 'utf8'");
	$query = "SELECT `img`, `type` from `avatar` WHERE `user`='$username'";
    $result = mysql_query($query);
    confirm_query($result);
	$check = mysql_num_rows($result);
	if ($check==1) {
        $rowImg = mysql_fetch_array($result);
	    mysql_free_result($result);
	    ob_clean();
	    header('Content-type: '.$rowImg[1]);
	    echo $rowImg[0];
	}
    else {*/
    
        $img = imagecreatefrompng('img/avatar.png');
        header("Content-type: image/png");
        imagepng($img);
        
        /*
    }
} else {
    $img = imagecreatefrompng('img/avatar.png');
    header("Content-type: image/png");
    imagepng($img);
}*/
?>