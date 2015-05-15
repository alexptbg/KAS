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
     die( print_r( sqlsrv_errors(), true));
}
$sql = "SELECT TOP 4320 * FROM Min5_Delta where param_code='Avg_7_S7' ORDER BY ID DESC";
$stmt = sqlsrv_query($conn,$sql);
if($stmt === false) {
    die(print_r(sqlsrv_errors(),true));
}
while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    $temp = number_format($row['param_value'],2);
    $mydatestring = date_format($row['to_time'],"Y-m-d H:i:s");
    $timestamp = strtotime($mydatestring);
	$return_data[] = array($timestamp*1000,$temp);
}
$data_return = array_reverse($return_data);
sqlsrv_free_stmt($stmt);
sqlsrv_close($conn);
header('Content-type: application/json');
$json = json_encode($data_return);
$json = preg_replace('/"(-?\d+\.?\d*)"/', '$1', $json);
echo $json;
?>