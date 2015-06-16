<?php
//error_reporting(0);
defined('start') or die('Direct access not allowed.');
$today = date('d-m-Y');
$today_e = date('Y-m-d');
//init
$settings = get_settings();
$initlang = $settings['init_lang'];
$engine = $settings['status'];
$system_name = $settings['system_name'];
$slogan = $settings['slogan'];
$version = $settings['version'];
$web_base = $settings['base'];
$web_dir = $settings['sub_dir'];
$desc = $settings['desc'];
$track = $settings['track'];
$temp_track = $settings['temp_track'];
$core = load($settings['core'],$settings['salt']);
$system = load($settings['system'],$settings['salt']);
//required files
require_once "inc/lang/DataBase.php";
require_once "inc/lang/Language.php";
require_once "inc/lang/Result.php";
require_once "inc/lang/Translation.php";
require_once "inc/lang/Translate.php";
//web settings
$web_path = $web_base . "/" . $web_dir;
$index_path = "http://".$web_dir.".".$web_base;
$apk = "http://".$web_base."/".$web_dir."/android/".strtoupper($web_dir).".apk";
$real_path = "http://".$web_base."/".$web_dir;
$self_path = $_SERVER['PHP_SELF'];
define('HOST',$web_dir.".".$web_base,TRUE);
$path = curPageURL();
$installed = strtotime($settings['installed']);
//engine control
if($engine != 'Online'){ echo "Engine is offline.<br/><br/>Please, contact the server administrator."; die; }
?>