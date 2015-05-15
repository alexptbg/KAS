<?php
$serverName = "192.168.17.10";
$uid = "sa";
$pwd = "icb99";
$db = "SEMPirinTex";
$connectionInfo = array("UID" => $uid, "PWD" => $pwd, "Database"=>"$db", "CharacterSet" => "UTF-8");
$conn = sqlsrv_connect($serverName,$connectionInfo);
if($conn) {
     //echo "Connection established.<br/>";
} else {
     //echo "Connection could not be established.<br/>";
     die(print_r(sqlsrv_errors(),true));
}
$sql = "SELECT TOP 1 * FROM Min5_Delta where param_code='Avg_7_S7' ORDER BY ID DESC";
$stmt = sqlsrv_query($conn,$sql);
if($stmt === false) {
    die(print_r(sqlsrv_errors(),true));
}
while($row = sqlsrv_fetch_array($stmt,SQLSRV_FETCH_ASSOC)) {
    $temp = number_format($row['param_value'],2);
	$last_time = date_format($row['to_time'],"Y-m-d H:i:s");
	$time = date('Y-m-d H:i:s',(strtotime('+5 minutes',strtotime($last_time))));
}
sqlsrv_free_stmt($stmt);
sqlsrv_close($conn);
header("Content-type: text/json");
$x = time()*1000;
$ret = array($x,$temp,$time);
$json = json_encode($ret);
$json = preg_replace('/"(-?\d+\.?\d*)"/','$1',$json);
echo $json;
?>