<?php
$route_no = implode(', ', $route_no);
$pdf->Code128(70,280,$route_no,80,7);
$pdf->SetFont('Arial', '', '8');
$pdf->Text(100  ,290,$route_no);
?>