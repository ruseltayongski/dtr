<?php
require('dbconn.php');

$userid = "0476";
$date_from = "01/01/2019";
$date_to = "01/17/2019";
$url = "http://192.168.100.81/dtr_api/logs/GetLogs";

$data = [
    "userid" => $userid,
    "df" => $date_from,
    "dt" => $date_to
];

$curl = curl_init($url);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
curl_close($curl);

$logs = json_decode($response);

$query1 = "INSERT IGNORE INTO dtr_file(userid, datein, time, event,remark, edited, created_at, updated_at) VALUES";

foreach($logs as $log)
{
    $query1 .= "('" . $log->userid . "','" . $log->date . "','" . $log->time . "','" . $log->event_type . "','#FP','0',NOW(),NOW()),";
}
$query1 .= "('','','','','','',NOW(),NOW())";


$pdo = conn();
$st = $pdo->prepare($query1);
$st->execute();
echo $response;

?>