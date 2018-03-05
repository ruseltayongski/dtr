<?php


$route_no = 1;
if(isset($_GET['route'])){
    $route_no = $_GET['route'];
}

$pdf->Code128(70,290,$route_no,80,10);
$pdf->SetXY(80,300);
$pdf->Write(5,'Route No. "'.$route_no.'"');

?>