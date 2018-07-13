<?php
$pdf->SetFont('Arial','B',8);


$pdf->Cell(20,5,'USERID','LTRB',0,'C',0);
$pdf->Cell(60,5,'NAME','LTRB',0,'C',0);
$pdf->Cell(25,5,'DATE','LTRB',0,'C',0);
$pdf->Cell(20,5,'WEEKDAY','LTRB',0,'C',0);
$pdf->Cell(30,5,'IN','LTRB',0,'C',0);
$pdf->Cell(30,5,'OUT','LTRB',0,'C',0);

?>