<?php
//error_reporting(0);
defined('start') or die('Direct access not allowed.');
session_start();  
if (isset($_GET["lang"])) {
	if(isset($_SESSION[$web_dir.'_language'])) { unset($_SESSION[$web_dir.'_language']); } 
	$lang = isset($_GET["lang"]) ? $_GET["lang"] : $initlang;
	$_SESSION[$web_dir.'_language'] = $lang;
    $translation = Translate::getInstance();
    if (!$translation->languageExist($lang)) {
		//session_start(); 
        if(isset($_SESSION[$web_dir.'_language'])) { unset($_SESSION[$web_dir.'_language']); } 
		$lang = "en";
		$_SESSION[$web_dir.'_language'] = 'en';
	}
    $translation->setLanguage($lang);
    $result = mysql_query("SELECT * FROM `languages` WHERE `short`='".$lang."'");
    $f_rows = mysql_num_rows($result);
    if ($f_rows != 0) { 
        while($format = mysql_fetch_array($result)) {
            $f = $format['format'];
		    $ln = $format['name']; 
        }
    }
} else {
    if(isset($_SESSION[$web_dir.'_language'])) {
	    $lang = $_SESSION[$web_dir.'_language'];
        $translation = Translate::getInstance();
        if (!$translation->languageExist($lang)) {
			//session_start(); 
            if(isset($_SESSION[$web_dir.'_language'])) { unset($_SESSION[$web_dir.'_language']); } 
		    $lang = "en";
		    $_SESSION[$web_dir.'_language'] = 'en';
	    }
        $translation->setLanguage($lang);
        $result = mysql_query("SELECT * FROM `languages` WHERE `short`='".$lang."'");
        $f_rows = mysql_num_rows($result);
        if ($f_rows != 0) { 
            while($format = mysql_fetch_array($result)) {
                $f = $format['format'];
		        $ln = $format['name']; 
            }
        }
    } else {
		$lang = isset($_GET["lang"]) ? $_GET["lang"] : $initlang;
		$_SESSION[$web_dir.'_language'] = $lang;
        $translation = Translate::getInstance();
        if (!$translation->languageExist($lang)) {
			//session_start(); 
            if(isset($_SESSION[$web_dir.'_language'])) { unset($_SESSION[$web_dir.'_language']); } 
		    $lang = "en";
		    $_SESSION[$web_dir.'_language'] = 'en';
	    }
        $translation->setLanguage($lang);
        $result = mysql_query("SELECT * FROM `languages` WHERE `short`='".$lang."'");
        $f_rows = mysql_num_rows($result);
        if ($f_rows != 0) { 
            while($format = mysql_fetch_array($result)) {
                $f = $format['format'];
		        $ln = $format['name']; 
            }
        }
    }
}
$cache = 1;//days
header("Content-Type: text/html; $f");
header('Expires: '.gmdate('D, d M Y H:i:s',time()+(60*60*24*$cache)).' GMT');
$date_f = date('d-m-Y');
$time_f = date('H:i:s');
$day = date('l');
$month = date('F');
@include($system);
?>