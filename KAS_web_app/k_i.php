<?php
error_reporting(0);
define('start', TRUE);
include('inc/db.php');
include('inc/functions.php');
include('inc/init.php');
DataBase::getInstance()->connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
include('inc/config.php');
check_login($lang,$web_dir);
$r = $_GET['r'];
$b = $_GET['b'];
$f = $_GET['f'];
$i = $_GET['i'];
$u = $_GET['u'];
$ar_id = "AR_0007_2015_1.0";
$r_settings = get_rout_settings($r);
$datafile = "data/{$r_settings['data_file']}";
if (file_exists($datafile)) { include("$datafile"); clear_cronk(); } 
else { 
	echo "
        <div class=\"col-lg-12\">
            <div class=\"panel panel-danger\">
                <div class=\"panel-heading\">".get_lang($lang, 'Error')."</div>
                <div class=\"panel-body\">
				    <div class=\"alert alert-warning\">".get_lang($lang, 'k164')."</div>
                </div>
            </div>
		</div>";
    exit; 
}
if (filesize($datafile)<500) {
	echo "
        <div class=\"col-lg-12\">
            <div class=\"panel panel-danger\">
                <div class=\"panel-heading\">".get_lang($lang, 'Error')."</div>
                <div class=\"panel-body\">
				    <div class=\"alert alert-warning\">".get_lang($lang, 'k124')."</div>
                </div>
            </div>
	    </div>";
	exit; 
}
$dev = ${'dev' . $i};
$d = explode(" ", $dev);
//init
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
$m_class1 = "btn-default"; $m_class2 = "btn-default"; $m_class3 = "btn-default"; $m_class4 = "btn-default"; 
if ($mode == "1") { $mode_name = get_lang($lang, 'k69')." \ ".get_lang($lang, 'off'); $m_class1 = "btn-primary"; } 
elseif ($mode == "9") { $mode_name = get_lang($lang, 'k69')." \ ".get_lang($lang, 'on'); $m_class1 = "btn-primary"; }
elseif ($mode == "2") { $mode_name = get_lang($lang, 'k70')." \ ".get_lang($lang, 'off'); $m_class2 = "btn-primary"; }
elseif ($mode == "10") { $mode_name = get_lang($lang, 'k70')." \ ".get_lang($lang, 'on'); $m_class2 = "btn-primary"; }
elseif ($mode == "3") { $mode_name = get_lang($lang, 'k71')." \ ".get_lang($lang, 'off'); $m_class3 = "btn-primary"; }
elseif ($mode == "11") { $mode_name = get_lang($lang, 'k71')." \ ".get_lang($lang, 'on'); $m_class3 = "btn-primary"; }
elseif ($mode == "4") { $mode_name = get_lang($lang, 'k72')." \ ".get_lang($lang, 'off'); $m_class4 = "btn-primary"; }
elseif ($mode == "12") { $mode_name = get_lang($lang, 'k72')." \ ".get_lang($lang, 'on'); $m_class4 = "btn-primary"; }
elseif ($mode == "0") { $mode_name = get_lang($lang, 'k73'); }
else { $mode_name = $mode; }
//step
$v_class1 = "btn-default"; $v_class2 = "btn-default"; $v_class3 = "btn-default";
if ($vent == "1"){ $vent_name = get_lang($lang, 'k74').": ".get_lang($lang, 'k75'); $v_class1 = "btn-primary"; }
elseif ($vent == "2") { $vent_name = get_lang($lang, 'k74').": ".get_lang($lang, 'k76'); $v_class2 = "btn-primary"; }
elseif ($vent == "3") { $vent_name = get_lang($lang, 'k74').": ".get_lang($lang, 'k77'); $v_class3 = "btn-primary"; }
elseif ($vent == "0") { $vent_name = ""; }
else { $vent_name = $vent; }	
//led
if (($mode < 8) && ($mode > 0)) { $led = 'off'; $checked = ""; $data_off = "danger"; $md = 'off';} 
elseif (($mode < 13) && ($mode > 8)) { $led = 'on'; $checked = "checked "; $data_off = "danger"; $md = 'on'; }
else { $led = 'err'; $checked = ""; $data_off = "danger"; $md = 'off'; }
$klima = get_klima_settings($d0);
$router = $klima['router'];
if($klima['type'] == "1") { $class="primary"; } else { $class="success"; }
//prog
if($klima['prog'] == "On") { $p_class1 = "success"; $p_class2 = "default"; $dis1 = "disabled=\"disabled\""; $dis2 = ""; }
elseif($klima['prog'] == "Off") { $p_class1 = "default"; $p_class2 = "danger"; $dis1 = ""; $dis2 = "disabled=\"disabled\""; }
if($in_temp < $set_point) { $f_class = "orange"; } else { $f_class = "emerald"; }
//get values from database/arduino
$query = "SELECT * FROM `arduino_out_temp` WHERE `ar_id`='".$ar_id."' ORDER BY `id` DESC LIMIT 1";
$result = mysql_query($query);
confirm_query($result);
if (mysql_num_rows($result) != 0) {
    while ($row = mysql_fetch_array($result)) {
        //get values
        $last_time = $row['datetime'];
        $out_temp = number_format($row['temp2'],1);
   	}
} else {
	$last_time = "error";
	$out_temp = "error";
}
if($out_temp > $in_temp+1) { $s_class = "orange"; } else { $s_class = "emerald"; }
//if ($mode > "0") {
	echo "
    <script type=\"text/javascript\"> $(function() {
		$(\"#c\").bootstrapSwitch('size', 'large');";
		if ($vent == "1") { echo "$(\"#vent-1\").attr(\"disabled\", true);"; }
		if ($vent == "2") { echo "$(\"#vent-2\").attr(\"disabled\", true);"; }
		if ($vent == "3") { echo "$(\"#vent-3\").attr(\"disabled\", true);"; }
		if (($mode == "1") || ($mode == "9")) { echo "$(\"#md-1\").attr(\"disabled\", true);"; }
		if (($mode == "2") || ($mode == "10")) { echo "$(\"#md-2\").attr(\"disabled\", true);"; }
		if (($mode == "3") || ($mode == "11")) { echo "$(\"#md-3\").attr(\"disabled\", true);"; }
		if (($mode == "4") || ($mode == "12")) { echo "$(\"#md-4\").attr(\"disabled\", true);"; }		
	echo "
		var val = $(this).find(\"#output\").html();
		if (val < 17) { $(\"#minus\").attr(\"disabled\", true); }
		if (val > 29) { $(\"#plus\").attr(\"disabled\", true); }	
	}); </script>
                    <div class=\"col-lg-6\">
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
											    <td>";
												if (($user_settings['access'] == 1) && ($user_settings['level'] > 2)) {
													echo "
													<button type=\"button\" id=\"minus\" class=\"btn btn-warning btn-circle btn-lg\">
													    <i class=\"fa fa-minus\"></i></button>";
												} else { 
													echo "
													<button type=\"button\" id=\"minus\" class=\"btn btn-default btn-circle btn-lg\" disabled=\"disabled\">
													    <i class=\"fa fa-minus\"></i></button>";
												}
                                                echo "
												</td>
												<td><h1 id=\"output\">".number_format($set_point,1)."</h1></td>
                                                <td>";
												if (($user_settings['access'] == 1) && ($user_settings['level'] > 2)) {
													echo "
													<button type=\"button\" id=\"plus\" class=\"btn btn-warning btn-circle btn-lg\">
													    <i class=\"fa fa-plus\"></i></button>";
												} else { 
													echo "
													<button type=\"button\" id=\"plus\" class=\"btn btn-default btn-circle btn-lg\" disabled=\"disabled\">
													    <i class=\"fa fa-plus\"></i></button>";
												}
												echo "
												</td>
                                            </tr>
                                        </tbody>
                                    </table>
                            </div>
                            <div class=\"panel-footer control l\">";
	                            if (($user_settings['access'] == 1) && ($user_settings['level'] > 2)) {
										echo "
                                                    <div class=\"switch fr\">
                                                        <input type=\"checkbox\" ".$checked." id=\"c\" data-on-color=\"success\" data-off-color=\"".$data_off."\" data-on-text=\"".get_lang($lang,'on')."\" data-off-text=\"".get_lang($lang,'off')."\" />
                                                    </div>";
								} else {
									echo "									
                                                    <div class=\"switch fr\">
                                                        <input type=\"checkbox\" ".$checked."disabled=\"disabled\" id=\"c\" data-on-color=\"success\" data-off-color=\"".$data_off."\" data-on-text=\"".get_lang($lang,'on')."\" data-off-text=\"".get_lang($lang,'off')."\" />
                                                    </div>";
								}
							    echo "
                            </div>
                        </div>
                    </div>
                    <div class=\"col-lg-6\">
                        <div class=\"panel panel-".$class."\">
                            <div class=\"panel-heading\">".get_lang($lang,'k78')."</div>
                            <div class=\"panel-body control\">
                                    <table class=\"table ".$d0."\" id=\"control\">
                                        <tbody>
										    <tr class=\"adv\">
												<td colspan=\"2\">".get_lang($lang,'k79')."</td>
											</tr>
											<tr class=\"controls\">
												<td colspan=\"2\">";
											if (($user_settings['access'] == 1) && ($user_settings['level'] > 4)) {
												echo "
<div class=\"btn-group btn-group-lg\" id=\"vent\">
   <button type=\"button\" class=\"btn ".$v_class1."\" id=\"vent-1\">".get_lang($lang,'k75')."</button>
   <button type=\"button\" class=\"btn ".$v_class2."\" id=\"vent-2\">".get_lang($lang,'k76')."</button>
   <button type=\"button\" class=\"btn ".$v_class3."\" id=\"vent-3\">".get_lang($lang,'k77')."</button>
</div>";
                                            } else {
										  echo "
<div class=\"btn-group btn-group-lg\" id=\"vent\">
   <button type=\"button\" class=\"btn ".$v_class1."\" id=\"vent-1\" disabled=\"disabled\">".get_lang($lang,'k75')."</button>
   <button type=\"button\" class=\"btn ".$v_class2."\" id=\"vent-2\" disabled=\"disabled\">".get_lang($lang,'k76')."</button>
   <button type=\"button\" class=\"btn ".$v_class3."\" id=\"vent-3\" disabled=\"disabled\">".get_lang($lang,'k77')."</button>
</div>";
											}
										  echo "</td>
											</tr>
										    <tr class=\"adv\">
												<td colspan=\"2\">".get_lang($lang,'k80')."</td>
											</tr>
											<tr class=\"controls\">
												<td colspan=\"2\">";
												if (($user_settings['access'] == 1) && ($user_settings['level'] > 5)) {
													echo "
<div class=\"btn-group btn-group-lg\" id=\"mode\">
   <button type=\"button\" class=\"btn ".$m_class1."\" id=\"md-1\">".get_lang($lang,'k69')."</button>
   <button type=\"button\" class=\"btn ".$m_class2."\" id=\"md-2\" disabled=\"disabled\">".get_lang($lang,'k70')."</button>
</div>
<div class=\"btn-group btn-group-lg\" id=\"mode\">
   <button type=\"button\" class=\"btn ".$m_class3."\" id=\"md-3\">".get_lang($lang,'k71')."</button>
   <button type=\"button\" class=\"btn ".$m_class4."\" id=\"md-4\" disabled=\"disabled\">".get_lang($lang,'k72')."</button>
</div>";
                                                } else {
													echo "
<div class=\"btn-group btn-group-lg\" id=\"mode\">
   <button type=\"button\" class=\"btn ".$m_class1."\" id=\"md-1\" disabled=\"disabled\">".get_lang($lang,'k69')."</button>
   <button type=\"button\" class=\"btn ".$m_class2."\" id=\"md-2\" disabled=\"disabled\">".get_lang($lang,'k70')."</button>
</div>
<div class=\"btn-group btn-group-lg\" id=\"mode\">
   <button type=\"button\" class=\"btn ".$m_class3."\" id=\"md-3\" disabled=\"disabled\">".get_lang($lang,'k71')."</button>
   <button type=\"button\" class=\"btn ".$m_class4."\" id=\"md-4\" disabled=\"disabled\">".get_lang($lang,'k72')."</button>
</div>";			
												}
										  echo "</td>
											</tr>
										</tbody>
									</table>
							</div>
							<div class=\"panel-footer control r\">
							    <span class=\"s\"><i class=\"fa fa-long-arrow-right\">&nbsp;</i><span id=\"crons\"></span></span><br/>
							    <span class=\"r\"><i class=\"fa fa-long-arrow-left\"></i>&nbsp;<span id=\"cronr\"></span></span>
							</div>
						</div>
					</div>
					<div class=\"clearboth\"></div>
                    <div class=\"col-lg-6\">
                        <div class=\"panel panel-".$class."\">
                            <div class=\"panel-heading\">".get_lang($lang,'k132')."</div>
                            <div class=\"panel-body\">
                                <table class=\"table\" id=\"sche\">
									<thead>
										<tr>
											<th colspan=\"4\">".get_lang($lang,'k137')."</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>".get_lang($lang,'k133').":</td>
											<td>".$klima['start_w']."</td>
											<td>".get_lang($lang,'k134').":</td>
											<td>".$klima['stop_w']."</td>
										</tr>
									</tbody>
								</table>
                                <table class=\"table\" id=\"sche\">
									<thead>
										<tr>
											<th colspan=\"4\">".get_lang($lang,'k138')."</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>".get_lang($lang,'k133').":</td>
											<td>".$klima['start_s']."</td>
											<td>".get_lang($lang,'k134').":</td>
											<td>".$klima['stop_s']."</td>
										</tr>
									</tbody>
								</table>
                            </div>
                            <div class=\"panel-footer\">
                                ".get_lang($lang,'k90').":&nbsp;&nbsp;
                                <div class=\"btn-group btn-group-lg\" id=\"prog\">";
                            if (($user_settings['access'] == 1) && ($user_settings['level'] > 5)) {
								echo "
                                    <button type=\"button\" class=\"btn btn-".$p_class1."\" id=\"pg-1\" $dis1 >".get_lang($lang,'on')."</button>
                                    <button type=\"button\" class=\"btn btn-".$p_class2."\" id=\"pg-2\" $dis2 >".get_lang($lang,'off')."</button>
								</div>
								<button type=\"button\" class=\"btn btn-warning btn-lg fr\" onClick=\"document.location.href = 'klimatiki_sche_edit.php?lang=".$lang."&user=".$u."&klima=".$d0."&r=".$router."'; return false;\">
											<i class=\"fa fa-edit\"></i> ".get_lang($lang,'k22')."</button>";
                            } else {
								echo "
                                    <button type=\"button\" class=\"btn btn-".$p_class1."\" id=\"pg-1\" disabled=\"disabled\">".get_lang($lang,'on')."</button>
                                    <button type=\"button\" class=\"btn btn-".$p_class2."\" id=\"pg-2\" disabled=\"disabled\">".get_lang($lang,'off')."</button>
								</div>
								<button type=\"button\" class=\"btn btn-default btn-lg fr\" disabled=\"disabled\">
								              <i class=\"fa fa-edit\"></i> ".get_lang($lang,'k22')."</button>";
							}
                           echo "
                            </div>
                        </div>
                    </div>
                    <div class=\"col-lg-6\">
                        <div class=\"panel panel-".$class."\">
                            <div class=\"panel-heading\">".get_lang($lang,'k177')."</div>
                            <div class=\"panel-body control z\">
                                <div class=\"col-xs-6 col-md-6\">
                                    <div class=\"panel panel-primary text-center panel-eyecandy\">
                                        <div class=\"panel-body ".$f_class."\" style=\"height:127px;\">
                                            <h1>".$in_temp."º</h1>
                                            <span>".date('Y-m-d')." ".$d1."</span>
                                        </div>
                                        <div class=\"panel-footer\">
                                            <span class=\"panel-eyecandy-title\">".get_lang($lang,'k178')."</span>
                                        </div>
                                    </div>
                                </div>
                                <div class=\"col-xs-6 col-md-6\">
                                    <div class=\"panel panel-primary text-center panel-eyecandy\">
                                        <div class=\"panel-body ".$s_class."\" style=\"height:127px;\">
                                            <h1>".$out_temp."º</h1>
                                            <span>".$last_time."</span>
                                        </div>
                                        <div class=\"panel-footer\">
                                            <span class=\"panel-eyecandy-title\">".get_lang($lang,'k179')."</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
    <script type=\"text/javascript\">
	var timer = null;
	var router = \"".$router."\";
	var inv = \"".$d0."\";
	var status = \"".$md."\";
    $(function() {
        $(\"#minus\").click(function() {
            $(\"#output\").html(function(i, val) {
				if (val < 18) {
			        $(\"#minus\").attr(\"disabled\", true);
					$(\"#plus\").removeAttr(\"disabled\");
					val = 16;
				} else {
					$(\"#minus\").removeAttr(\"disabled\");
					$(\"#plus\").removeAttr(\"disabled\");
					val = +val-1;
				}
				t = val.toFixed(1);
				return t;
			});
			setPause();
            reset();
            timer = setTimeout(function () {
			    $(\"#minus\").attr(\"disabled\", true);
			    $(\"#plus\").attr(\"disabled\", true);
			    temp(router,inv,t);
            },3000);
        });
        $(\"#plus\").click(function() {
            $(\"#output\").html(function(i, val) { 
				if (val > 28) {
			        $(\"#plus\").attr(\"disabled\", true);
					$(\"#minus\").removeAttr(\"disabled\");
					val = 30;
				} else {
					$(\"#minus\").removeAttr(\"disabled\");
					val = +val+1;
				}
				t = val.toFixed(1);
				return t;
			});
			setPause();
            reset();
            timer = setTimeout(function () {
			    $(\"#minus\").attr(\"disabled\", true);
			    $(\"#plus\").attr(\"disabled\", true);
                temp(router,inv,t);
            }, 4000);
        });
        $('#switch').on('click', function(e, data) {
            $(\"#c\").bootstrapSwitch('toggleState');
        });
        $(\"#c\").on('switchChange', function (e, data) {
			setPause();
            value = data.value;
			var mode = '".$mode."';
			if (value == false) { var action = 'off'; }
			else if (value == true) { var action = 'on'; }
			else { alert('Error ".$d0."'); }
			$(\"#vent-1\").attr(\"disabled\", true);
			$(\"#vent-2\").attr(\"disabled\", true);
			$(\"#vent-3\").attr(\"disabled\", true);
			$(\"#md-1\").attr(\"disabled\", true);
			$(\"#md-2\").attr(\"disabled\", true);
			$(\"#md-3\").attr(\"disabled\", true);
			$(\"#minus\").attr(\"disabled\", true);
			$(\"#plus\").attr(\"disabled\", true);
			$(\"#c\").bootstrapSwitch(\"readonly\", true);
			onoff(router,inv,action,mode);
        });";
		if /*(($mode > "0") && */($user_settings['level'] > 4)/*)*/ {
			echo "
        $(\"#vent-1\").on(\"click\", function (e) {
			setPause();
			$(\"#vent-2\").removeClass(\"btn-primary\");
			$(\"#vent-3\").removeClass(\"btn-primary\");
			$(\"#vent-2\").addClass(\"btn-default\");
			$(\"#vent-3\").addClass(\"btn-default\");
			$(\"#vent-1\").addClass(\"btn-primary\");
			$(\"#vent-1\").attr(\"disabled\", true);
			$(\"#vent-2\").removeAttr(\"disabled\");
			$(\"#vent-3\").removeAttr(\"disabled\");
			var v = \"1\";
			step(router,inv,v);
        });
        $(\"#vent-2\").on(\"click\", function (e) {
			setPause();
			$(\"#vent-1\").removeClass(\"btn-primary\");
			$(\"#vent-3\").removeClass(\"btn-primary\");
			$(\"#vent-1\").addClass(\"btn-default\");
			$(\"#vent-3\").addClass(\"btn-default\");
			$(\"#vent-2\").addClass(\"btn-primary\");
			$(\"#vent-2\").attr(\"disabled\", true);
			$(\"#vent-1\").removeAttr(\"disabled\");
			$(\"#vent-3\").removeAttr(\"disabled\");
			var v = \"2\";
            step(router,inv,v);
        });
        $(\"#vent-3\").on(\"click\", function (e) {
			setPause();
			$(\"#vent-1\").removeClass(\"btn-primary\");
			$(\"#vent-2\").removeClass(\"btn-primary\");
			$(\"#vent-1\").addClass(\"btn-default\");
			$(\"#vent-2\").addClass(\"btn-default\");
			$(\"#vent-3\").addClass(\"btn-primary\");
			$(\"#vent-3\").attr(\"disabled\", true);		
			$(\"#vent-1\").removeAttr(\"disabled\");
			$(\"#vent-2\").removeAttr(\"disabled\");
			var v = \"3\";
            step(router,inv,v);
        });"; }
		if /*(($mode > "0") && */($user_settings['level'] > 5)/*)*/ {
			echo "
        $(\"#md-1\").on(\"click\", function (e) {
			setPause();
			$(\"#md-2\").removeClass(\"btn-primary\");
			$(\"#md-3\").removeClass(\"btn-primary\");
			$(\"#md-2\").addClass(\"btn-default\");
			$(\"#md-3\").addClass(\"btn-default\");
			$(\"#md-1\").addClass(\"btn-primary\");
			$(\"#md-1\").attr(\"disabled\", true);
			$(\"#md-2\").removeAttr(\"disabled\");
			$(\"#md-3\").removeAttr(\"disabled\");
			var md = \"1\";
			mode(router,inv,status,md);
        });
        $(\"#md-2\").on(\"click\", function (e) {
			setPause();
			$(\"#md-1\").removeClass(\"btn-primary\");
			$(\"#md-3\").removeClass(\"btn-primary\");
			$(\"#md-1\").addClass(\"btn-default\");
			$(\"#md-3\").addClass(\"btn-default\");
			$(\"#md-2\").addClass(\"btn-primary\");
			$(\"#md-2\").attr(\"disabled\", true);
			$(\"#md-1\").removeAttr(\"disabled\");
			$(\"#md-3\").removeAttr(\"disabled\");
			var md = \"2\";
			mode(router,inv,status,md);
        });
        $(\"#md-3\").on(\"click\", function (e) {
			setPause();
			$(\"#md-1\").removeClass(\"btn-primary\");
			$(\"#md-2\").removeClass(\"btn-primary\");
			$(\"#md-1\").addClass(\"btn-default\");
			$(\"#md-2\").addClass(\"btn-default\");
			$(\"#md-3\").addClass(\"btn-primary\");
			$(\"#md-3\").attr(\"disabled\", true);		
			$(\"#md-1\").removeAttr(\"disabled\");
			$(\"#md-2\").removeAttr(\"disabled\");
			var md = \"3\";
			mode(router,inv,status,md);
        });
        $(\"#pg-1\").on(\"click\", function (e) {
			setPause();
			$(\"#pg-1\").removeClass(\"btn-default\");
			$(\"#pg-1\").addClass(\"btn-success\");
            $(\"#pg-2\").removeClass(\"btn-danger\");
			$(\"#pg-2\").addClass(\"btn-default\");
			var pg = \"On\";
			prog(router,inv,pg);
        });
        $(\"#pg-2\").on(\"click\", function (e) {
			setPause();
			$(\"#pg-2\").removeClass(\"btn-default\");
			$(\"#pg-2\").addClass(\"btn-danger\");
            $(\"#pg-1\").removeClass(\"btn-success\");
			$(\"#pg-1\").addClass(\"btn-default\");
			var pg = \"Off\";
			prog(router,inv,pg);
        });
		"; 
		}
		echo "
	});
	</script>";
//}
function clear_cronk() {
	$fh = fopen('data/crons.php', 'w');
    fclose($fh);
	$fh2 = fopen('data/cronr.php', 'w');
    fclose($fh2);	
}
DataBase::getInstance()->disconnect();
?>
<script type="text/javascript">
var ispaused=false;
function setPause(){ ispaused=!ispaused; }
function reset(){ clearTimeout(timer); }
refreshCrons = null;
refreshCronr = null;
function get_crons_live() {
    refreshCrons = setInterval(function () {
		$.ajax({
			url: 'data/crons.php', 
			success: function(point) {
		    $('span#crons').text(point);
		},
			cache: false
		});
    }, 1000);
}
function get_cronr_live() {
    refreshCronr = setInterval(function () {
		$.ajax({
			url: 'data/cronr.php', 
			success: function(point) {
		    $('span#cronr').text(point);
		},
			cache: false
		});
    }, 1000);
}
function clear_crons() {
	clearInterval(refreshCrons);
	clearInterval(refreshCronr);
}
function onoff(r,i,a,m) {
    var postData = { 'router' : r, 'kinv' : i, 'action' : a, 'mode' : m }; 
    $.ajax({
        url: 'k_handle_status.php',
        type: 'post',
        data: postData,
        success: function(result) {
			get_crons_live();
			get_cronr_live(); 
            setTimeout( function(){ 
				$("#c").bootstrapSwitch("readonly", false);
				clear_crons();
				setPause();
			},12000);
		},
        error: function(xhr, status, error) {
		    console.log('error with onoff');
        }
    });
}
function temp(r,i,t) {
    var td = t*10;
	var f = parseInt(td/256);//first frame
	var s = td-(f*256);//second frame
    var postData = { 'router' : r, 'kinv' : i, 'action' : 'SP', 'first' : f , 'second' : s };
	$("#vent-1").attr("disabled", true);
	$("#vent-2").attr("disabled", true);
	$("#vent-3").attr("disabled", true);
	$("#md-1").attr("disabled", true);
	$("#md-2").attr("disabled", true);
	$("#md-3").attr("disabled", true);	
	$("#minus").attr("disabled", true);
	$("#plus").attr("disabled", true);
	$("#c").bootstrapSwitch("readonly", true);
    $.ajax({
        url: 'k_handle_setpoint.php',
        type: 'post',
        data: postData,
        success: function(result) {
			get_crons_live();
			get_cronr_live(); 
            setTimeout(function(){ 
				if (t > 16) { $("#minus").removeAttr("disabled"); }
				if (t < 30) { $("#plus").removeAttr("disabled"); }
				clear_crons();
				setPause();
			},12000);
		},
        error: function(xhr, status, error) {
            //var err = eval(\"(\" + xhr.responseText + \")\");
            //alert(err.Message);
		    console.log('error with temp');
        }
    });
}
function step(r,i,v) {
    var postData = { 'router' : r, 'kinv' : i, 'action' : 'ST', 'v' : v };
	$("#vent-1").attr("disabled", true);
	$("#vent-2").attr("disabled", true);
	$("#vent-3").attr("disabled", true);
	$("#md-1").attr("disabled", true);
	$("#md-2").attr("disabled", true);
	$("#md-3").attr("disabled", true);	
	$("#minus").attr("disabled", true);
	$("#plus").attr("disabled", true);
	$("#c").bootstrapSwitch("readonly", true);
    $.ajax({
        url: 'k_handle_step.php',
        type: 'post',
        data: postData,
        success: function(result) {
			get_crons_live();
			get_cronr_live(); 
            setTimeout(function(){ 
			    clear_crons();
				setPause();
			},12000);
		},
        error: function(xhr, status, error) {
		    console.log('error setting mode');
        }
    });
}
function mode(r,i,s,m) {
	$("#vent-1").attr("disabled", true);
	$("#vent-2").attr("disabled", true);
	$("#vent-3").attr("disabled", true);
	$("#md-1").attr("disabled", true);
	$("#md-2").attr("disabled", true);
	$("#md-3").attr("disabled", true);	
	$("#minus").attr("disabled", true);
	$("#plus").attr("disabled", true);
	$("#c").bootstrapSwitch("readonly", true);
    var postData = { 'router' : r, 'kinv' : i, 'action' : 'MD', 'status' : s, 'mode' : m }; 
    $.ajax({
        url: 'k_handle_mode.php',
        type: 'post',
        data: postData,
        success: function(result) {
			get_crons_live();
			get_cronr_live(); 
            setTimeout( function(){ 
				$("#c").bootstrapSwitch("readonly", false);
				clear_crons();
				setPause();
			},12000);
		},
        error: function(xhr, status, error) {
		    console.log('error with mode changing');
        }
    });
}
function prog(r,inv,prog) {
    var postData = { 'r': r, 'kinv' : inv, 'prog' : prog }; 
    $.ajax({
        url: 'k_handle_prog.php',
        type: 'post',
        data: postData,
        success: function(result) {
			$("#pg-1").attr("disabled", true);
			$("#pg-2").attr("disabled", true); 
            setTimeout( function(){
				setPause();
			},2000);
		},
        error: function(xhr, status, error) {
		    console.log('error with onoff');
        }
    });
}
</script>