<?php

$pdf->Ln();
$pdf->Cell(195,32.9,'',1);

$pdf->SetFont('Arial','BI',10);
$pdf->Text(80,250,'By Authority of the Secretary of Health');


$pdf->SetFont('Arial','B',8);
$pdf->Text(12,275,'Date :');
$pdf->Image(__DIR__.'../../image/line.png', 20,275,30,0.6);



$pdf->Text(95,271,'');
$pdf->Image(__DIR__.'../../image/line.png',77,272,60,0.6);
$pdf->Text(95,275,'Authorized Official');


?>