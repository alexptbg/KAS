<?php
error_reporting(0);
define('start', TRUE);
include('inc/db.php');
include('inc/functions.php');
include('inc/init.php');
DataBase::getInstance()->connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
include('inc/config.php');
check_login($lang,$web_dir);
$u = $_GET['user'];
$r = $_GET['router'];
$query = "SELECT `klimas` FROM `users` WHERE `user_name`='$u'";
$result = mysql_query($query);
confirm_query($result);
if (mysql_num_rows($result) != 0) {
    while($klimas_u = mysql_fetch_array($result)) {
		$klimas_list = $klimas_u['klimas'];
	}
	$klimas = explode(", ",$klimas_list);
}
if (!empty($klimas)) {
	$r_settings = get_rout_settings($r);
    $datafile = "data/{$r_settings['data_file']}";
    if (file_exists($datafile)) { include_once("$datafile"); } else { echo "file error"; exit; }
	if (filesize($datafile)<500) {
		echo "
            <div class=\"col-lg-12\">
                <div class=\"panel panel-danger\">
                    <div class=\"panel-heading\">".get_lang($lang, 'Error')."</div>
                    <div class=\"panel-body\">
					    <div class=\"alert alert-warning\">
                            ".get_lang($lang,'k124')."
						</div>
                    </div>
                </div>
		    </div>";
		exit; 
	}
    $exclude = $r_settings['ex_table'];
    $ex = explode(',', $exclude);
	foreach ($klimas as $klima) {
		$i++;
		if(!(${'dev'.$klima} == NULL)) {
		    ${'d'.$klima} = explode(" ", ${'dev'.$klima}); 
			p(${'d'.$klima},$r_settings['router_name'],$lang,$u,$ex);
		}
	}
}
echo "<div class=\"clearboth\"></div>";
DataBase::getInstance()->disconnect();
function p($d,$r,$lang,$u,$ex) {
	$d0 = $d[0];//inv
	$d1 = $d[1];//time
	$d2 = $d[2];//set_point_1
	$d3 = $d[3];//set_point_2
	$d4 = $d[4];//mode1
	$d5 = $d[5];//mode2
	$d6 = $d[6];//vent1
	$d7 = $d[7];//vent2
	$d8 = $d[8];//temp_in_1
	$d9 = $d[9];//temp_in_2	
	$mode = $d4*256+$d5;
	$vent = $d6*256+$d7;
	$set_point = ($d2*256+$d3)/10;
	$in_temp = ($d8*256+$d9)/10;
    //mode
	if ($mode == "1") { $mode_name = get_lang($lang, 'k69')." \ ".get_lang($lang, 'off'); } 
	elseif ($mode == "9") { $mode_name = get_lang($lang, 'k69')." \ ".get_lang($lang, 'on'); }
	elseif ($mode == "2") { $mode_name = get_lang($lang, 'k70')." \ ".get_lang($lang, 'off'); }
	elseif ($mode == "10") { $mode_name = get_lang($lang, 'k70')." \ ".get_lang($lang, 'on'); }
	elseif ($mode == "3") { $mode_name = get_lang($lang, 'k71')." \ ".get_lang($lang, 'off'); }
	elseif ($mode == "11") { $mode_name = get_lang($lang, 'k71')." \ ".get_lang($lang, 'on'); }
	elseif ($mode == "4") { $mode_name = get_lang($lang, 'k72')." \ ".get_lang($lang, 'off'); }
	elseif ($mode == "12") { $mode_name = get_lang($lang, 'k72')." \ ".get_lang($lang, 'on'); }
	elseif ($mode == "0") { $mode_name = get_lang($lang, 'k73'); }
	else { $mode_name = $mode; }
	//step
	if ($vent == "1"){ $vent_name = get_lang($lang, 'k74').": ".get_lang($lang, 'k75'); }
	elseif ($vent == "2") { $vent_name = get_lang($lang, 'k74').": ".get_lang($lang, 'k76'); }
	elseif ($vent == "3") { $vent_name = get_lang($lang, 'k74').": ".get_lang($lang, 'k77'); }
	elseif ($vent == "0") { $vent_name = ""; }
	else { $vent_name = $vent; }	
	//led
	if (($mode < 8) && ($mode > 0)) { $led = 'off'; $checked = ""; $data_off = "danger"; } 
	elseif (($mode < 13) && ($mode > 8)) { $led = 'on'; $checked = "checked "; $data_off = "danger"; }
	else { $led = 'err'; $checked = ""; $data_off = "danger"; }
	$klima = get_klima_settings($d0);
	$user = get_user_settings($u);
    if ($klima['prog'] == 'On') { $p_class = "success"; } elseif ( $klima['prog'] == "Off") { $p_class = "danger"; }
	if ($klima['type'] == "1") { $class="primary"; } else { $class="success"; }
	if (!in_array($d0, $ex)) {
	echo "
                    <div class=\"col-lg-4\">
                        <div class=\"panel panel-".$class."\">
                            <div class=\"panel-heading\">
                                ".$d0."&nbsp;[<small>".$d1."</small>]
								<span class=\"deg fr\">".$in_temp."</span>
                            </div>
                            <div class=\"panel-body control\">
                                    <table class=\"table ".$d0."\" id=\"control\">
                                        <tbody>
                                            <tr class=\"head\">
                                                <td class=\"tal\" colspan=\"3\"><span>".$klima['group']."&nbsp;\&nbsp;
                                                    ".$klima['zona']."&nbsp;\&nbsp;
                                                    ".$klima['place']."</span>
												<span class=\"lamp fr\"><span class=\"".$led."\"></span></span></td>
                                            </tr>
                                            <tr class=\"ext\">
                                                <td colspan=\"3\"><span>".get_lang($lang,'k43').": ".$klima['building']."
												                  &nbsp;\&nbsp;".get_lang($lang,'k44').": ".$klima['floor']."</span>
                                                                  <span class=\"fr\">VRF: ".$klima['vrf']."</span></td>
                                            </tr>
                                            <tr class=\"status\">
                                                <td colspan=\"3\"><span>".$mode_name."</span>
                                                                  <span class=\"fr\">".$vent_name."</span></td>
                                            </tr>
                                            <tr class=\"gradus\">
											    <td>&nbsp;</td>
												<td><h1 id=\"output-".$d0."\">".number_format($set_point,1)."</h1></td>
                                                <td>&nbsp;</td>
                                            </tr>
                                        </tbody>
                                    </table>
                            </div>
                            <div class=\"panel-footer control\">
							    <div class=\"end\">
							    <span class=\"p\">".get_lang($lang,'k132').": <span class=\"uppercase fw400 label label-".$p_class."\">".$klima['prog']."</span></span><br/>
								    <span class=\"t\">".$klima['start_w']." - ".$klima['stop_w']." | ".$klima['start_s']." - ".$klima['stop_s']."</span></div>
								         <button type=\"button\" class=\"btn btn-danger fr\" onClick=\"document.location.href = 'klima_i.php?lang=".$lang."&user=".$u."&klima=".$d0."&r=".$r."'; return false;\"><i class=\"fa fa-cog\"></i>&nbsp;".get_lang($lang,'Settings')."</button>
                            </div>
                        </div>
                    </div>";
	}
}
?>