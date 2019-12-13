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
$b = $_GET['b'];
$f = $_GET['f'];
$i = $_GET['i'];
$r_settings = get_rout_settings($r);
$klima = get_klima_settings($i);
if($klima['type'] == "1") { $class="primary"; $help_color = "#3598DB"; } else { $class="success"; $help_color= "#2DCC70"; }
//print_r(get_tempos_by_month($r,$i));
$last_cleaned = get_tempo_last_cleaned($r,$i);
if($last_cleaned === "N/A") {
    $cleaned = get_lang($lang,'k302');
    //$datex = date("Y-m-d",strtotime(date('Y-m-01')."-1 months"));
    $query = "SELECT `inv`,`day` as day, COUNT(id) as minuti FROM `tempo` WHERE `router`='".$r."' AND `inv`='".$i."' GROUP BY `day` ORDER BY `id` ASC;";
} else {
    $cleaned = $last_cleaned;
    $month_ini = new DateTime($last_cleaned);
    $begin = $month_ini->format('Y-m-d');
    $query = "SELECT `inv`,`day` as day, COUNT(id) as minuti FROM `tempo` WHERE `router`='".$r."' AND `inv`='".$i."' AND `day` >= '".$begin."' GROUP BY `day` ORDER BY `id` ASC;";
}
//$month_ini = new DateTime("first day of last month");
//$month_end = new DateTime("first day of next month");
//$end = $today_e;
$x=0;
$total_mins = 0;
$total_mins_by_month = 0;
$result = mysql_query($query);
confirm_query($result);
if (mysql_num_rows($result) != 0) {
    echo "
    <div class=\"table-responsive\" id=\"res\">
    <table class=\"table table-striped table-bordered table-hover\" id=\"tempos\">
    <thead>
    <tr style=\"background-color:".$help_color.";color:#FFFFFF;text-transform:uppercase;\">
    <th colspan=\"3\" style=\"text-align:center;\">".$i." - ".get_lang($lang,'k312')."</th>
    </tr>
    </thead>
    <tbody>";
    while($row = mysql_fetch_array($result)) {
        $test = new DateTime($row['day']);
        $check = $test->format('d');
        if(($x===0)&&($check!="01")) { 
            echo "<tr><td colspan=\"3\" style=\"text-align:center;background-color:#ffb84d;\">".get_lang($lang,date("F",strtotime($row['day'])))."</td></tr>";
            echo "<tr><td style=\"background-color:#ffdb4d;\">".get_lang($lang,'k117')."</td><td style=\"background-color:#ffdb4d;\">".get_lang($lang,'k197')."</td><td style=\"background-color:#ffdb4d;\">".get_lang($lang,'k309')."</td></tr>";
        }
        if($check==="01") { 
            if($total_mins_by_month!==0){
                echo "<tr><td style=\"background-color:#fff0b3;\"></td><td style=\"background-color:#fff0b3;\"></td><td style=\"background-color:#ffd11a;\">".get_lang($lang,'k310')."=".$total_mins_by_month." ".get_lang($lang,'k197')." / ".convertToHoursMins($total_mins_by_month,"%02d ".get_lang($lang,'k309')." %02d ".get_lang($lang,'k197'))."</td></tr>";
            }
            $total_mins_by_month=0;
            echo "<tr><td colspan=\"3\" style=\"text-align:center;background-color:#ffb84d;\">".get_lang($lang,date("F",strtotime($row['day'])))."</td></tr>";
            echo "<tr><td style=\"background-color:#ffdb4d;\">".get_lang($lang,'k117')."</td><td style=\"background-color:#ffdb4d;\">".get_lang($lang,'k197')."</td><td style=\"background-color:#ffdb4d;\">".get_lang($lang,'k309')."</td></tr>";
        }
        echo "<tr><td style=\"background-color:#fff0b3;\">".$row['day']."</td><td style=\"background-color:#fff0b3;\">".$row['minuti']."</td><td style=\"background-color:#fff0b3;\">".convertToHoursMins($row['minuti'],"%02d ".get_lang($lang,'k309')." %02d ".get_lang($lang,'k197'))."</td></tr>";
        
        $total_mins=($total_mins+$row['minuti']);
        $total_mins_by_month=($total_mins_by_month+$row['minuti']);
        $x++;
    }
    echo "<tr><td style=\"background-color:#fff0b3;\"></td><td style=\"background-color:#fff0b3;\"></td><td style=\"background-color:#ffd11a;\">".get_lang($lang,'k310')."=".$total_mins_by_month." ".get_lang($lang,'k197')." / ".convertToHoursMins($total_mins_by_month,"%02d ".get_lang($lang,'k309')." %02d ".get_lang($lang,'k197'))."</td></tr>";
    echo "
    </tbody>
    <tfoot>
    <tr><td colspan=\"3\" style=\"text-align:center;background-color:#ff8566;\">".get_lang($lang,'k311').": ".$total_mins." ".get_lang($lang,'k197')." / ".convertToHoursMins($total_mins,"%02d ".get_lang($lang,'k309')." %02d ".get_lang($lang,'k197'))."</td></tr>
    </tfoot>
    </table>
    </div>
    <button type=\"button\" class=\"btn btn-primary fr\" id=\"print\" onclick=\"printDiv()\"><i class=\"fa fa-print\"></i>&nbsp;".get_lang($lang,'k315')."&nbsp;</button>
    <script type=\"text/javascript\"> 
        function printDiv() { 
            var divContents = document.getElementById(\"res\").innerHTML; 
            var a = window.open('', '', 'height=800, width=800'); 
            a.document.write('<html>');
            a.document.write('<style>table{width:100%;border:1px solid #000000;}table tr th{border:1px solid #000000 !important;}table tr td{border:1px solid #000000 !important;}</style>');
            a.document.write('<body>'); 
            a.document.write(divContents); 
            a.document.write('</body></html>'); 
            a.document.close(); 
            a.print(); 
        } 
    </script>";
} else {
    echo "<div class=\"panel-body\"><div class=\"alert alert-info\">".get_lang($lang,'k313')."</div></div>";
}

/*
$month_ini = new DateTime("first day of last month");
//$month_end = new DateTime("first day of this month");

//$begin = $month_ini->format('Y-m-d');
//$end = $month_end->format('Y-m-d'); 
$month_end = new DateTime($today_e);

$begin = $month_ini;
$end = $month_end;

$interval = DateInterval::createFromDateString('1 day');
$period = new DatePeriod($begin,$interval,$end);

$total_rows = 0;
foreach ($period as $dt) {
    $day = $dt->format("Y-m-d");
	$query = "SELECT `status` FROM `tempo` WHERE `router`='".$r."' AND `inv`='".$i."' AND `day` LIKE '".$day."'";
    $result = mysql_query($query);
    confirm_query($result);
    
    if (mysql_num_rows($result) != 0) {
        $num_rows = mysql_num_rows($result);
        echo $day.":";
        echo "$num_rows minutes / ".convertToHoursMins($num_rows,'%02d hours %02d minutes');
        echo "<br/>";
        $total_rows=($total_rows+$num_rows);
	}
}
echo "Total=".$total_rows." minutes / ".convertToHoursMins($total_rows,'%02d hours %02d minutes');
echo "<br/>";
*/
?>