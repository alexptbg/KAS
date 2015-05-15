<?php
error_reporting(0);
define('start', TRUE);
include('inc/db.php');
include('inc/functions.php');
include('inc/init.php');
DataBase::getInstance()->connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
include('inc/config.php');
$ad = $_GET['addr'];
$query = "SELECT `inv` FROM `klimatiki` WHERE `addr`=".$ad." ORDER BY `inv` ASC";
$result = mysql_query($query);
confirm_query($result);
if (mysql_num_rows($result) != 0) {
    while($klimas = mysql_fetch_array($result)) {
		$invs[] = $klimas['inv'];
	}
	$r = 'Strellson/Joop';
	foreach($invs as $klima) {
        $k_settings = get_klima_settings($klima);
		if ($k_settings['prog'] == 'On') { $p_class = "emerald"; } elseif ( $k_settings['prog'] == "Off") { $p_class = "alizarin"; }
	    echo "
                                <table class=\"table\" id=\"sche\">
								    <caption class=\"panel-body $p_class\">".$klima."</caption>
									<thead>
										<tr>
											<th colspan=\"4\">".get_lang($lang,'k137')."</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>".get_lang($lang,'k133').":</td>
											<td>".$k_settings['start_w']."</td>
											<td>".get_lang($lang,'k134').":</td>
											<td>".$k_settings['stop_w']."</td>
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
											<td>".$k_settings['start_s']."</td>
											<td>".get_lang($lang,'k134').":</td>
											<td>".$k_settings['stop_s']."</td>
										</tr>
									</tbody>
								</table>";
	}
}
DataBase::getInstance()->disconnect();
?>