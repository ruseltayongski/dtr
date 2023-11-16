<?php



$pdf->Code128(70,269,$route_no,80,7);
$route_no_str = implode(', ', $route_no);
$pdf->Text(82, 280, 'Route No. "' . $route_no_str . '"');
//$pdf->Text(82,280,'Route No. "'.$route_no.'"');

?>