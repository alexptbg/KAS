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
$r_settings = get_rout_settings($r);
$klima = get_klima_settings($i);
if($klima['type'] == "1") { $class="primary"; } else { $class="success"; }
echo "
<div class=\"col-lg-12\">
    <div class=\"panel panel-".$class."\">
        <div class=\"panel-heading\">".get_lang($lang,'k175')."</div>
        <div class=\"panel-body\">";
        $query = "SELECT * FROM `logs` WHERE `obs` LIKE '%".$i."%' ORDER BY `id` DESC LIMIT 30";
        $result = mysql_query($query);
        confirm_query($result);
        if (mysql_num_rows($result) != 0) {
            echo "
			<div class=\"table-responsive\">
                <table class=\"table table-striped\">
                    <thead>
                        <tr>
                            <th class=\"h\">".get_lang($lang, 'k117')." / ".get_lang($lang, 'k118')."</th>
                            <th>".get_lang($lang, 'k05')." / ".get_lang($lang, 'k119')."</th>
                        </tr>
                    </thead>
                    <tbody>";
                while($logs = mysql_fetch_array($result)) {
                    echo "<tr>";
                        if (date('Y-m-d') == date('Y-m-d', strtotime($logs['date']))) {
						    echo "<td><span class=\"l-success\">".$logs['date']." ".$logs['time']."</span></td>";
					    } else {
						    echo "<td>".$logs['date']." ".$logs['time']."</td>";
						}
						echo "<td><span class=\"l-info\">
						         ".$logs['user']."&nbsp;</span><span class=\"l-".$logs['filter']."\">".get_lang($lang,$logs['action'])." (".$logs['obs'].")</span></td>
							</tr>";
                }
                echo "</tbody>
                </table>
            </div>";
        } else {
	        echo "<div class=\"alert alert-info\">".get_lang($lang,'k176')."</div>";
		}
        echo "</div>
    </div>
</div>";
DataBase::getInstance()->disconnect();