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
$klimas = array();
$query = "SELECT * FROM `klimatiki` WHERE `router`='".$r."' ORDER BY `inv` ASC";
$result = mysql_query($query);
confirm_query($result);
if (mysql_num_rows($result) != 0 ) {
    while($k = mysql_fetch_array($result)) {
        $klimas[] = $k['inv'];
    }
}
//print_r($klimas);
if(!empty($klimas)) {
    
    foreach($klimas as $klima) {
        $tempos = array();
        $query = "SELECT EXTRACT(MONTH FROM datetime) as month, EXTRACT(YEAR FROM datetime) as year, COUNT(`id`) as total FROM `tempo` WHERE `router`='".$r."' AND `inv`='".$klima."' AND `day` >= '".$month_ini."' AND `day` <= '".$month_end."' GROUP BY month, year ORDER BY year ASC, month ASC";
        $result = mysql_query($query);
        confirm_query($result);
        if (mysql_num_rows($result) != 0) {
            
            echo "
            <div class=\"table-responsive\" id=\"res\">
                <table class=\"table table-striped table-bordered table-hover\" id=\"tempos\">
                    <thead>
                        <tr>
                            <th colspan=\"3\" style=\"text-align:center;\">".$klima."</th>
                        <tr>
                    </thead>
                    <tbody>
                    <tr><td>".get_lang($lang,"k318")."</td><td>".get_lang($lang,"k317")."</td><td>".get_lang($lang,"k309")." / ".get_lang($lang,"k197")."</td></tr>
            ";
            
            while($row = mysql_fetch_array($result)) {
                echo "<tr><td>".$row['year']."</td><td>".$row['month']."</td><td>".convertToHoursMins($row['total'],"%02d ".get_lang($lang,'k309')." %02d ".get_lang($lang,'k197'))."</td></tr>";
            }
            
            echo "
                    </tbody>
                </table>
            </div>
            ";
            
        }
    }
    

}
?>