<?php
error_reporting(E_ALL);
define('start', TRUE);
include('inc/db.php');
include('inc/functions.php');
include('inc/init.php');
DataBase::getInstance()->connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
include('inc/config.php');
check_login($lang,$web_dir);
$r = $_GET['r'];
$month_ini = $_GET['month_ini'];
$month_end = $_GET['month_end'];
$filter = $_GET['filter'];
$query = "SELECT inv, COUNT(`id`) as total FROM `tempo` WHERE `router`='".$r."' AND `day` BETWEEN '".$month_ini."' AND '".$month_end."' GROUP BY inv ORDER BY total DESC;";
$result = mysql_query($query);
confirm_query($result);
if (mysql_num_rows($result) != 0) {
    $i=0;
    echo "
    <div class=\"table-responsive\" id=\"res\">
        <table class=\"table table-striped table-bordered table-hover\" id=\"tempos\">
            <thead>
                <tr><th colspan=\"5\" style=\"text-align:center;\">".$r." : ".get_lang($lang,"k320")." ".$month_ini."-".$month_end."</th><tr>
            </thead>
            <tbody>
            <tr><td>".get_lang($lang,"k68")."</td><td>".get_lang($lang,"k44")."</td><td>".get_lang($lang,"k309")."</td><td>".get_lang($lang,"k197")."</td><td>".get_lang($lang,"k323")."</td></tr>";
    while($row = mysql_fetch_array($result)) {
        if($row['total']>=$filter) {
            echo "<tr><td>".$row['inv']."</td><td>".get_klima_floor($row['inv'])."</td><td>".convertToHoursMins($row['total'],"%02d ".get_lang($lang,'k309')." %02d ".get_lang($lang,'k197'))."</td><td>".$row['total']."</td><td>".get_tempo_last_cleaned($r,$row['inv'])."</td></tr>";
            $i++;
        }
    }
    echo "
            </tbody>
            <tfoot>
                <tr><td colspan=\"5\" style=\"text-align:right;\">".sprintf(get_lang($lang,"k322"),$i)."</td></tr>
            </tfoot>
        </table>
    </div>
    <button type=\"button\" class=\"btn btn-primary fr\" id=\"print\" onclick=\"printDiv".substr($r,0,4)."()\"><i class=\"fa fa-print\"></i>&nbsp;".get_lang($lang,'k315')."&nbsp;</button>
    <p>&nbsp;</p>";
}
?>