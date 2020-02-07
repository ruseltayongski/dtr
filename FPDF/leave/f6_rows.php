<?php

$pdf->Ln();
$pdf->setX('5');
$pdf->Cell(200,28,'',1);

$pdf->SetFont('Arial','BI',10);
$pdf->Text(80,242,'By Authority of the Secretary of Health');


$pdf->SetFont('Arial','B',8);
$pdf->Text(12,256,'Date :');
$pdf->Image(__DIR__.'../../image/line.png', 20,256,30,0.6);


$pdf->Image(__DIR__.'../../image/line.png',77,256,60,0.6);
$pdf->Text(95,261,'Authorized Official');


?>