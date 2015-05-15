<?php
//error_reporting(0);
//device control
if (!empty($_GET['SYS'])) {
	$SYS = $_GET['SYS'];
	setcookie('kas_device', $SYS);
	upd_device($user_settings['user_name']);
} else {
	upd_device($user_settings['user_name']);
}
?>