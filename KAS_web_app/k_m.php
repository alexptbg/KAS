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
$r_settings = get_rout_settings($r);
$klima = get_klima_settings($i);
if($klima['type'] == "1") { $class="primary"; } else { $class="success"; }
echo "
<div class=\"col-lg-12\">
    <div class=\"panel panel-".$class."\">
        <div class=\"panel-heading\">".get_lang($lang,'k280')."</div>
        <div class=\"panel-body\">";
        $query = "SELECT * FROM `maintenance` WHERE `inv`='".$i."' ORDER BY `id` DESC LIMIT 10";
        $result = mysql_query($query);
        confirm_query($result);
        if (mysql_num_rows($result) != 0) {
            echo "
			<div class=\"table-responsive\">
                <table class=\"table table-striped\" style=\"margin-bottom:0;\">
                    <thead>
                        <tr>
                            <th>".get_lang($lang,'k117')."</th>
                            <th>".get_lang($lang,'k14')."</th>
                            <th>".get_lang($lang,'k68')."</th>
                            <th>".get_lang($lang,'k297')."</th>
							<th>".get_lang($lang,'k285')."</th>
                            <th>".get_lang($lang,'k280')."&nbsp;(".get_lang($lang,'k283').")</th>
                        </tr>
                    </thead>
                    <tbody>";
		                while($repairs = mysql_fetch_array($result)) {
							//echo repairs
							if (($repairs['user'] != 'Alex') && ($repairs['user'] != 'alex')) {
								echo "<tr>";
								if (date('Y-m-d') == date('Y-m-d', strtotime($repairs['date']))) {
									echo "<td><span class=\"text-success\">".$repairs['date']."</span></td>";
								} else {
									echo "<td>".$repairs['date']."</td>";
								}		
								echo   "<td>".$repairs['router']."</td>
										<td><span class=\"text-warning\">".$repairs['inv']."</span></td>
										<td><span class=\"text-info\">".$repairs['who']."</span></td>
										<td><span class=\"text-info\">".$repairs['user']."</span></td>
										<td>".$repairs['action']." (".$repairs['obs'].")</td>
									  </tr>";
							}
						}
                echo "</tbody>
                </table>
            </div>";

        } else {
	        echo "<div class=\"alert alert-info\">".get_lang($lang,'k281')."</div>";
		}
        echo "</div>
    </div>
</div>";
DataBase::getInstance()->disconnect();