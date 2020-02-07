<?php



$pdf->Code128(70,269,$route_no,80,7);
$pdf->Text(82,280,'Route No. "'.$route_no.'"');

?>