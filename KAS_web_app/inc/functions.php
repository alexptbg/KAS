<?php
//error_reporting(0);
defined('start') or die('Direct access not allowed.');
header('Content-type: text/html; charset=utf-8');
function confirm_query($query) { if (!$query) { die("Database Query failed!. Check Database Settings." . mysql_error()); } }
function mysql_prep($value) {
    $magic_quotes_active = get_magic_quotes_gpc();
    $new_enough_php = function_exists("mysql_real_escape_string");
    if ($new_enough_php) {
        if ($magic_quotes_active) { $value = stripslashes($value); }
        $value = mysql_real_escape_string($value);
    } else {
        if (!$magic_quotes_active) { $value = addslashes($value); }
    }
    return $value;
}
function get_lang($lang,$ins) {
    $translation = Translate::getInstance();
    if (!$translation->languageExist($lang))
    $lang = "en";
	if ($lang == NULL) { $lang = $settings['init_lang']; }
    $translation->setLanguage($lang);
	return $translation->getTranslation($ins);
}
function set_lang() {
	get_settings();
    $lang = isset($_GET["lang"]) ? $_GET["lang"] : $settings['init_lang'];
	return $lang;
}
function check_username($lang,$username,$password,$web_dir) {
	$u = base64_decode($username);
	$p = md5(base64_decode($password));
    $query = "SELECT * FROM `users` WHERE `user_name`='".$u."'";
    $result = mysql_query($query);
    confirm_query($result);
	$check = mysql_num_rows($result);
	if ($check==1) { check_password($lang,$u,$p,$web_dir); }
    else {
	    $error = get_lang($lang,'1010');
		$location = "error.php?lang=".$lang."&error=".$error;
		header("location:$location");
    }
}
function check_password($lang,$username,$password,$web_dir) {
    $query = "SELECT * FROM `users` WHERE `user_name`='".$username."' and `h_password`='".$password."'";
    $result = mysql_query($query);
    confirm_query($result);
	$check = mysql_num_rows($result);
	if ($check==1) { check_status($lang,$username,$password,$web_dir); }
    else {
	    $error = get_lang($lang,'1011');
		$location = "error.php?lang=".$lang."&error=".$error;
		header("location:$location");
    }
}
function check_status($lang,$username,$password,$web_dir) {
    $query = "SELECT * FROM `users` WHERE `user_name`='".$username."' and `h_password`='".$password."'";
    $result = mysql_query($query);
    confirm_query($result);
	if (mysql_num_rows($result) == 1) {
        while($row = mysql_fetch_array($result)) {
		    $status = $row['status'];
		    $user_lang = $row['init_lang'];
        }
        if ($status == 'Active') {
			session_name($web_dir);
            session_start();
			$_SESSION[$web_dir] = $web_dir;
            $_SESSION[$web_dir.'_username'] = $username;
            $_SESSION[$web_dir.'_language'] = $user_lang;
			$location = "success.php?lang=".$lang;
            header("location:$location");
        }
        elseif ($status == 'Deactivated') {
	        $error = get_lang($lang, '1012');
		    $location = "error.php?lang=".$lang."&error=".$error;
		    header("location:$location");	
        } 
        elseif ($status == 'Pending') {
	        $error = get_lang($lang, '1013');
		    $location = "error.php?lang=".$lang."&error=".$error;
		    header("location:$location");	
        }
        else {
	        $error = get_lang($lang, '1001');
		    $location = "error.php?lang=".$lang."&error=".$error;
		    header("location:$location");	
        }
	}
    else {
	    $error = get_lang($lang,'1001');
		$location = "error.php?lang=".$lang."&error=".$error;
		header("location:$location");	
    }
}
function update_login($lang,$username) {
	$updated = date('Y-m-d H:i:s');
    mysql_query("UPDATE `users` SET `last_login`='".$updated."' WHERE `user_name`='".$username."'");
    $user_lang = get_user_lang($username);
	$location = "index.php?lang=".$user_lang;
	header("location:$location");
}
function check_login($lang,$web_dir){
    if (session_status() == PHP_SESSION_NONE) {
		session_name($web_dir);
        session_start();
    }	
    function check_loggedin($web_dir) {
		if(isset($_SESSION[$web_dir]) && ($_SESSION[$web_dir] == $web_dir)) {
			return TRUE;
        } else {
			return FALSE;
		}
        //return isset($_SESSION[$web_dir.'_username']) && ($_SESSION['APP'] == $web_dir);
    }
    if (!check_loggedin($web_dir)) {
        //session_destroy();
        $_SESSION[$web_dir] = NULL;
        unset($_COOKIE['KAS']);
		$location = "login.php?lang=".$lang;
	    header("location:$location");
    }
    else {
        header('Content-Type: text/html; charset=utf-8');
	    $user_settings = get_user_settings($_SESSION[$web_dir.'_username']);
		$_SESSION[$web_dir] = $web_dir;
    }
}
function get_device($username) {
	return $_SERVER['REMOTE_ADDR'];
}
function upd_device($username) {
	if ($_COOKIE['kas_device'] != NULL) {
		mysql_query("UPDATE `users` SET `last_device`='".$_COOKIE['kas_device']."' WHERE `user_name`='".$username."'");
	} else {
		$device = $_SERVER['REMOTE_ADDR'];
		setcookie('kas_device', $device);
		mysql_query("UPDATE `users` SET `last_device`='".$device."' WHERE `user_name`='".$username."'");
	}
}
function get_user_settings($user) {
	global $user_settings;
    $query = "SELECT * FROM `users` WHERE `user_name`='".$user."'";
    $result = mysql_query($query);
    confirm_query($result);
    $user_settings = mysql_fetch_array($result);
    return $user_settings;
}
function get_user_lang($user) {
    $query = "SELECT `init_lang` FROM `users` WHERE `user_name`='".$user."'";
    $result = mysql_query($query);
    confirm_query($result);
    $user_settings = mysql_fetch_array($result);
    return $user_settings['init_lang'];
}
function get_settings() {
    global $settings;
    $query = "SELECT * FROM `settings`";
    $result = mysql_query($query);
    confirm_query($result);
    $settings = mysql_fetch_array($result);
    return $settings;
}
function get_router_settings($router,$id) {
    $query = "SELECT * FROM `routers` WHERE `router_name`='".$router."' AND `id`='".$id."'";
    $result = mysql_query($query);
    confirm_query($result);
    $router_settings = mysql_fetch_array($result);
    return $router_settings;
}
function get_rout_settings($router) {
    $query = "SELECT * FROM `routers` WHERE `router_name`='".$router."'";
    $result = mysql_query($query);
    confirm_query($result);
    $router_settings = mysql_fetch_array($result);
    return $router_settings;
}
function get_klimatik_settings($kid,$kinv) {
    $query = "SELECT * FROM `klimatiki` WHERE `id`='".$kid."' AND `inv`='".$kinv."'";
    $result = mysql_query($query);
    confirm_query($result);
    $klimatik_settings = mysql_fetch_array($result);
    return $klimatik_settings;
}
function get_router_by_addr($addr) {
    $query = "SELECT `router` FROM `klimatiki` WHERE `addr`='".$addr."'";
    $result = mysql_query($query);
    confirm_query($result);
    $num_rows = mysql_num_rows($result);
    if ($num_rows != 0) {
        while($addr = mysql_fetch_array($result)) {
    	    $router = $addr['router']; 
        }
    }
    return $router;
}
function get_klima_settings($kinv) {
    $query = "SELECT * FROM `klimatiki` WHERE `inv`='".$kinv."'";
    $result = mysql_query($query);
    confirm_query($result);
    $klima_settings = mysql_fetch_array($result);
    return $klima_settings;
}
function count_klimas($router) {
	$count = 0;
    $query = "SELECT `inv` FROM `klimatiki` WHERE `router`='".$router."'";
    $result = mysql_query($query);
    confirm_query($result);
	$count=mysql_num_rows($result);
	return $count;
}
function check_router_name($router) {
    $query = "SELECT `router_name` FROM `routers` WHERE `router_name`='".$router."'";
    $result = mysql_query($query);
    confirm_query($result);
	$c = mysql_num_rows($result);
    if ($c != NULL) { return TRUE; } else { return FALSE; }
}
function check_user_name_before_add($user) {
    $query = "SELECT `user_name` FROM `users` WHERE `user_name`='".$user."'";
    $result = mysql_query($query);
    confirm_query($result);
	$c = mysql_num_rows($result);
    if ($c != NULL) { return TRUE; } else { return FALSE; }
}
function get_usere_settings($user,$id) {
    $query = "SELECT * FROM `users` WHERE `user_name`='".$user."' AND `id`='".$id."'";
    $result = mysql_query($query);
    confirm_query($result);
    $usr_settings = mysql_fetch_array($result);
    return $usr_settings;
}
function check_router_id_and_name($id,$router) {
    $query = "SELECT `id`,`router_name` FROM `routers` WHERE `router_name`='".$router."' AND `id` NOT LIKE '".$id."'";
    $result = mysql_query($query);
    confirm_query($result);
    $c = mysql_num_rows($result);
	if ($c != NULL) { return TRUE; } else { return FALSE; }
}
function check_klimatik_before_add($inv,$rtu) {
    $query = "SELECT `inv`,`rtu` FROM `klimatiki` WHERE `inv`='".$inv."' AND `rtu`='".$rtu."'";
    $result = mysql_query($query);
    confirm_query($result);
	$c = mysql_num_rows($result);
    if ($c != NULL) { return TRUE; } else { return FALSE; }
}
function check_klimatik_id_and_inv($kid,$kinv) {
    $query = "SELECT `id`,`inv` FROM `klimatiki` WHERE `inv`='".$kinv."' AND `id` NOT LIKE '".$kid."'";
    $result = mysql_query($query);
    confirm_query($result);
    $c = mysql_num_rows($result);
	if ($c != NULL) { return TRUE; } else { return FALSE; }
}
function check_klimatik_id_and_inv_and_rtu($kid,$kinv,$rtu) {
    $query = "SELECT `id`,`inv`,`rtu` FROM `klimatiki` WHERE `inv`='".$kinv."' AND `rtu`='".$rtu."' AND `id` NOT LIKE '".$kid."'";
    $result = mysql_query($query);
    confirm_query($result);
    $c = mysql_num_rows($result);
	if ($c != NULL) { return TRUE; } else { return FALSE; }
}
function check_username_id_and_username($uid,$user_name) {
    $query = "SELECT `id`,`user_name` FROM `users` WHERE `user_name`='".$user_name."' AND `id` NOT LIKE '".$uid."'";
    $result = mysql_query($query);
    confirm_query($result);
    $c = mysql_num_rows($result);
	if ($c != NULL) { return TRUE; } else { return FALSE; }	
}
function get_klima_repair($kinv,$rid) {
    $query = "SELECT * FROM `maintenance` WHERE `inv`='".$kinv."' AND `id`='".$rid."'";
    $result = mysql_query($query);
    confirm_query($result);
    $klima_repair = mysql_fetch_array($result);
    return $klima_repair;
}
function insert_log($lang,$device,$user,$filter,$action,$obs) {
	$date = date('Y-m-d');
	$time = date('H:i:s');
	if ($obs == NULL) { $obs = ""; }
	$query = "INSERT INTO `logs` (`date`, `time`, `device`, `user`, `filter`, `action`, `obs`) 
		      VALUES ('".$date."', '".$time."', '".$device."', '".$user."', '".$filter."', '".$action."', '".$obs."')";
    $result = mysql_query($query);
    confirm_query($result);
}
function get_table_size($table) {
	$query = "SHOW TABLE STATUS LIKE '".$table."'";
	$result = mysql_query($query);
	confirm_query($result);
    $dbsize = 0;
    while($row = mysql_fetch_array($result)) {
        $dbsize += $row["Data_length"] + $row["Index_length"];
    }
	return $dbsize;
}
function decodeSize($bytes) {
    $types = array('B','KB','MB','GB','TB','PB','EB','ZB','YB');
    for($i = 0; $bytes >= 1024 && $i < (count($types)-1); $bytes /= 1024, $i++);
    return(round($bytes,2)." ".$types[$i]);
}
function redir($url,$seconds) {
    echo "
        <script type=\"text/javascript\">
            function redirect() { window.location = '".$url."'; }
            timer = setTimeout('redirect()','".($seconds*1000)."')
        </script>\n";
    return true;
}
function get_temp_from_sa() {
    $server = "192.168.17.10";
    $uid = "sa";
    $pwd = "icb99";
    $db = "SEMPirinTex";
    $connectionInfo = array("UID" => $uid, "PWD" => $pwd, "Database"=>"$db", "CharacterSet" => "UTF-8");
    $conn = sqlsrv_connect($server,$connectionInfo);
    if($conn) {
        //echo "Connection established.<br/>";
    } else {
        //echo "Connection could not be established.<br/>";
        //die( print_r( sqlsrv_errors(), true));
    }
    $sql = "SELECT TOP 1 * FROM Min5_Delta where param_code='Avg_7_S7' ORDER BY ID DESC";
    $stmt = sqlsrv_query( $conn, $sql );
    if($stmt === false) {
        die( print_r( sqlsrv_errors(), true) );
    }
    while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $temp = number_format($row['param_value'],2);
    }
    sqlsrv_free_stmt($stmt);
    sqlsrv_close( $conn);
	return $temp;
}
function curPageURL() {
    $pageURL = 'http';
    $pageURL .= "://";
    if ($_SERVER["SERVER_PORT"] != "80") {
        $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
    } else {
        $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
    }
    return $pageURL;
}
function curPageName() {
    return substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);
}
function get_domain($domain) { 
    $domain = explode('/', str_replace('www.', '', str_replace('http://', '', $domain)));
    return $domain[0];
}
function load($string,$key) {
  $result = '';
  $string = base64_decode($string);
  for($i=0; $i<strlen($string); $i++) {
    $char = substr($string, $i, 1);
    $keychar = substr($key, ($i % strlen($key))-1, 1);
    $char = chr(ord($char)-ord($keychar));
    $result.=$char;
  }
  return $result;
}
function getBrowser() {
    $u_agent = $_SERVER['HTTP_USER_AGENT'];
    $bname = 'Unknown';
    $platform = 'Unknown';
    $version= "";
    if (preg_match('/linux/i', $u_agent)) {
        $platform = 'linux';
    }
    elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
        $platform = 'mac';
    }
    elseif (preg_match('/windows|win32/i', $u_agent)) {
        $platform = 'windows';
    }
    if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent))
    {
        $bname = 'Internet Explorer';
        $ub = "MSIE";
    }
    elseif(preg_match('/Firefox/i',$u_agent))
    {
        $bname = 'Mozilla Firefox';
        $ub = "Firefox";
    }
    elseif(preg_match('/Chrome/i',$u_agent))
    {
        $bname = 'Google Chrome';
        $ub = "Chrome";
    }
    elseif(preg_match('/Safari/i',$u_agent))
    {
        $bname = 'Apple Safari';
        $ub = "Safari";
    }
    elseif(preg_match('/Opera/i',$u_agent))
    {
        $bname = 'Opera';
        $ub = "Opera";
    }
    elseif(preg_match('/Netscape/i',$u_agent))
    {
        $bname = 'Netscape';
        $ub = "Netscape";
    }
    $known = array('Version', $ub, 'other');
    $pattern = '#(?<browser>' . join('|', $known) .
    ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
    if (!preg_match_all($pattern, $u_agent, $matches)) {
    }
    $i = count($matches['browser']);
    if ($i != 1) {
        if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
            $version= $matches['version'][0];
        }
        else {
            $version= $matches['version'][1];
        }
    }
    else {
        $version= $matches['version'][0];
    }
    if ($version==null || $version=="") {$version="?";}
    return array(
        'userAgent' => $u_agent,
        'name'      => $bname,
        'version'   => $version,
        'platform'  => $platform,
        'pattern'    => $pattern
    );
}
function getOS($userAgent) {
	$oses = array (
	    'iPhone iOS 3.0' => '(iPhone OS 3.0)',
	    'iPhone iOS 3.1' => '(iPhone OS 3.1)',
	    'iPhone iOS 3.1.2' => '(iPhone OS 3.1.2)',
	    'iPhone iOS 3.1.3' => '(iPhone OS 3.1.3)',
	    'iPhone iOS 3.2' => '(iPhone OS 3.2)',
		'iPhone iOS 4.0' => '(iPhone OS 4.0)',
		'iPhone iOS 4.1' => '(iPhone OS 4.1)',
		'iPhone iOS 4.2' => '(iPhone OS 4.2)',
		'iPhone iOS 4.2.5' => '(iPhone OS 4.2.5)',
		'iPhone iOS 4.2.8' => '(iPhone OS 4.2.8)',
		'iPhone iOS 4.2.9' => '(iPhone OS 4.2.9)',
		'iPhone iOS 4.2.10' => '(iPhone OS 4.2.10)',
		'iPhone iOS 4.3' => '(iPhone OS 4.3)',
		'iPhone iOS 4.3.1' => '(iPhone OS 4.3.1)',
		'iPhone iOS 4.3.3' => '(iPhone OS 4.3.3)',
		'iPhone iOS 4.3.4' => '(iPhone OS 4.3.4)',
		'iPhone iOS 4.3.5' => '(iPhone OS 4.3.5)',
		'iPhone iOS 5.0' => '(iPhone OS 5.0)',
		'iPhone iOS 5.0.1' => '(iPhone OS 5.0.1)',
		'iPhone iOS 5.1' => '(iPhone OS 5.1)',
		'iPhone iOS 5.1.1' => '(iPhone OS 5.1.1)',
		'iPhone iOS 6.0' => '(iPhone OS 6.0)',
		'iPhone iOS 6.0.1' => '(iPhone OS 6.0.1)',
		'iPhone iOS 6.0.2' => '(iPhone OS 6.0.2)',
		'iPhone iOS 6.1' => '(iPhone OS 6.1)',
		'iPhone iOS 6.1.1' => '(iPhone OS 6.1.1)',
		'iPhone iOS 6.1.2' => '(iPhone OS 6.1.2)',
		'iPhone iOS 6.1.3' => '(iPhone OS 6.1.3)',
		'iPhone iOS 6.1.4' => '(iPhone OS 6.1.4)',
		'iPhone iOS 6.1.5' => '(iPhone OS 6.1.5)',
		'iPhone iOS 7.0' => '(iPhone OS 7.0)',
		'iPhone iOS 7.0.2' => '(iPhone OS 7.0.2)',
		'iPhone iOS 7.0.5' => '(iPhone OS 7.0.5)',
		'iPhone iOS 7.0.6' => '(iPhone OS 7.0.6)',
		'iPhone iOS 7.1' => '(iPhone OS 7.1)',
		'iPhone iOS 8.0' => '(iPhone OS 8.0)',
		'iPhone iOS 8.1' => '(iPhone OS 8.1)',
		'Android 2.0' => '(Android 2.0 Eclair)',
		'Android 2.0.1' => '(Android 2.0.1 Eclair)',
		'Android 2.1' => '(Android 2.1 Eclair)',
		'Android 2.2' => '(Android 2.2 Froyo)',
		'Android 2.2.3' => '(Android 2.2.3 Froyo)',
		'Android 2.3' => '(Android 2.3 Gingerbread)',
		'Android 2.3.2' => '(Android 2.3.2 Gingerbread)',
		'Android 2.3.3' => '(Android 2.3.3 Gingerbread)',
		'Android 2.3.4' => '(Android 2.3.4 Gingerbread)',
		'Android 2.3.5' => '(Android 2.3.5 Gingerbread)',
		'Android 2.3.6' => '(Android 2.3.6 Gingerbread)',
		'Android 2.3.7' => '(Android 2.3.7 Gingerbread)',
		'Android 3.0' => '(Android 3.0 Honeycomb)',
		'Android 3.1' => '(Android 3.1 Honeycomb)',
		'Android 3.2' => '(Android 3.2 Honeycomb)',
		'Android 3.2.1' => '(Android 3.2.1 Honeycomb)',
		'Android 3.2.2' => '(Android 3.2.2 Honeycomb)',
		'Android 3.2.4' => '(Android 3.2.4 Honeycomb)',
		'Android 3.2.5' => '(Android 3.2.5 Honeycomb)',
		'Android 4.0' => '(Android 4.0 Ice Cream Sandwich)',
		'Android 4.0.1' => '(Android 4.0.1 Ice Cream Sandwich)',
		'Android 4.0.2' => '(Android 4.0.2 Ice Cream Sandwich)',
		'Android 4.0.3' => '(Android 4.0.3 Ice Cream Sandwich)',
		'Android 4.0.4' => '(Android 4.0.4 Ice Cream Sandwich)',	
		'Android 4.1' => '(Android 4.1 Jelly Bean)',
		'Android 4.1.1' => '(Android 4.1.1 Jelly Bean)',
		'Android 4.1.2' => '(Android 4.1.2 Jelly Bean)',
		'Android 4.2' => '(Android 4.2 Jelly Bean)',
		'Android 4.2.1' => '(Android 4.2.1 Jelly Bean)',
		'Android 4.2.2' => '(Android 4.2.2 Jelly Bean)',
		'Android 4.3' => '(Android 4.3 Jelly Bean)',
		'Android 4.4' => '(Android 4.4 KitKat)',
		'Android 4.4.1' => '(Android 4.4.1 KitKat)',
		'Android 4.4.2' => '(Android 4.4.2 KitKat)',
		'Android 4.4.3' => '(Android 4.4.3 KitKat)',
		'Android 4.4.4' => '(Android 4.4.4 KitKat)',
		'Android 5.0' => '(Android 5.0 Lollipop)',
		'Windows 3.1' => 'Win16',
		'Windows 3.10' => 'Win16',
		'Windows 3.11' => 'Win16',
		'Windows 95' => '(Windows 95)|(Win95)|(Windows_95)', // Use regular expressions as value to identify operating system
		'Windows 98' => '(Windows 98)|(Win98)',
		'Windows 2000' => '(Windows NT 5.0)|(Windows 2000)',
		'Windows XP' => '(Windows NT 5.1)|(Windows XP)',
		'Windows 2003' => '(Windows NT 5.2)',
		'Windows Vista' => '(Windows NT 6.0)|(Windows Vista)',
		'Windows 7' => '(Windows NT 6.1)|(Windows 7)',
		'Windows 8' => '(Windows NT 6.2)|(Windows 8)',		
		'Windows NT 4.0' => '(Windows NT 4.0)|(WinNT4.0)|(WinNT)|(Windows NT)',
		'Windows ME' => 'Windows ME',
		'Open BSD'=>'OpenBSD',
		'Sun OS'=>'SunOS',
		'Linux'=>'(Linux)|(X11)',
		'Safari' => '(Safari)',
		'Macintosh'=>'(Mac_PowerPC)|(Macintosh)',
		'QNX'=>'QNX',
		'BeOS'=>'BeOS',
		'OS/2'=>'OS/2',
		'Search Bot'=>'(nuhk)|(Googlebot)|(Yammybot)|(Openbot)|(Slurp/cat)|(msnbot)|(ia_archiver)'
	);
	foreach($oses as $os=>$pattern){
		if(preg_match("/".$pattern."/i", $userAgent)) {
			return $os;
		}
	}
	return 'Unknown';
}
function humanTiming ($time) {
    $time = time() - $time;
    $time = ($time<1)? 1 : $time;
    $tokens = array (
        31536000 => 'year',
        2592000 => 'month',
        604800 => 'week',
        86400 => 'day',
        3600 => 'hour',
        60 => 'minute',
        1 => 'second'
    );
    foreach ($tokens as $unit => $text) {
        if ($time < $unit) continue;
        $numberOfUnits = floor($time / $unit);
        return $numberOfUnits.' '.$text.(($numberOfUnits>1)?'s':'');
    }
}
function time_elapsed_string($ptime,$lang) {
    $etime = time() - $ptime;
    if ($etime < 1) {
        return '0 seconds';
    }
    $a = array( 365 * 24 * 60 * 60  =>  'year',
                 30 * 24 * 60 * 60  =>  'month',
                      24 * 60 * 60  =>  'day',
                           60 * 60  =>  'hour',
                                60  =>  'minute',
                                 1  =>  'second'
              );
    $a_plural = array( 'year'   => 'years',
                       'month'  => 'months',
                       'day'    => 'days',
                       'hour'   => 'hours',
                       'minute' => 'minutes',
                       'second' => 'seconds'
              );
    foreach ($a as $secs => $str) {
        $d = $etime / $secs;
        if ($d >= 1) {
            $r = round($d);
            return $r . ' ' . ($r > 1 ? $a_plural[$str] : $str) . ' ago';
        }
    }
}
function crc16($values) {
	$o=0;
    $crc16 = 0xFFFF;//the CRC seed
	foreach ($values as $value) {
		$crc16 = $crc16 ^ $value;
		for($j = 0; $j < 8; $j++ ) {
		    $k = $crc16 & 1;	
			$crc16 = (($crc16 & 0xfffe) /2) & 0x7FFF;
			if ($k > 0) {
				$crc16 = $crc16 ^ 0xA001;
			}
		}
		$o++;
	}
	$lo = (int)($crc16/256);
	$mid = $lo*256;
	$hi = $crc16-$mid;
	return dechex($hi)." ".dechex($lo);
}
function array_random($arr,$num=1) {
    shuffle($arr);
    $r = array();
    for ($i = 0; $i < $num; $i++) {
        $r[] = $arr[$i];
    }
    return $num == 1 ? $r[0] : $r;
}
function get_data($url) {
	$ch = curl_init();
	$timeout = 15;
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
	$data = curl_exec($ch);
	curl_close($ch);
	return $data;
}
function decrypt($string,$key) {
  $result = '';
  $string = base64_decode($string);
  for($i=0; $i<strlen($string); $i++) {
    $char = substr($string, $i, 1);
    $keychar = substr($key, ($i % strlen($key))-1, 1);
    $char = chr(ord($char)-ord($keychar));
    $result.=$char;
  }
  return $result;
}
final class BarcodeQR {
	const API_CHART_URL = "http://chart.apis.google.com/chart";
	private $_data;
	public function bookmark($title = null, $url = null) {
		$this->_data = "MEBKM:TITLE:{$title};URL:{$url};;";
	}
	public function contact($name = null, $address = null, $phone = null, $email = null) {
		$this->_data = "MECARD:N:{$name};ADR:{$address};TEL:{$phone};EMAIL:{$email};;";
	}
	public function content($type = null, $size = null, $content = null) {
		$this->_data = "CNTS:TYPE:{$type};LNG:{$size};BODY:{$content};;";
	}
	public function draw($size = 512, $filename = null) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, self::API_CHART_URL);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, "chs={$size}x{$size}&cht=qr&chl=" . urlencode($this->_data));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		$img = curl_exec($ch);
		curl_close($ch);
		if($img) {
			if($filename) {
				if(!preg_match("#\.png$#i", $filename)) {
					$filename .= ".png";
				}
				return file_put_contents($filename, $img);
			} else {
				header("Content-type: image/png");
				print $img;
				return true;
			}
		}
		return false;
	}
	public function email($email = null, $subject = null, $message = null) {
		$this->_data = "MATMSG:TO:{$email};SUB:{$subject};BODY:{$message};;";
	}
	public function geo($lat = null, $lon = null, $height = null) {
		$this->_data = "GEO:{$lat},{$lon},{$height}";
	}
	public function phone($phone = null) {
		$this->_data = "TEL:{$phone}";
	}
	public function sms($phone = null, $text = null) {
		$this->_data = "SMSTO:{$phone}:{$text}";
	}
	public function text($text = null) {
		$this->_data = $text;
	}
	public function url($url = null) {
		$this->_data = preg_match("#^https?\:\/\/#", $url) ? $url : "http://{$url}";
	}
	public function wifi($type = null, $ssid = null, $password = null) {
		$this->_data = "WIFI:T:{$type};S{$ssid};{$password};;";
	}
}
?>