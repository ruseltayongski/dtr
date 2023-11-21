<?php

$pdf->Ln();
$pdf->setX('5');
$pdf->Cell(200,28.5,'',1);

$pdf->SetFont('Arial','',8);
$pdf->Text(7,250,'7.C APPROVED FOR:');

$pdf->SetFont('Arial','BU',8);
$pdf->Text(15,255,'             ');

$pdf->SetFont('Arial','',8);
$pdf->Text(26,255,'days with pay');

$pdf->SetFont('Arial','BU',8);
$pdf->Text(15,259,'             ');

$pdf->SetFont('Arial','',8);
$pdf->Text(26,259,'days without pay');

$pdf->SetFont('Arial','BU',8);
$pdf->Text(15,263,'             ');

$pdf->SetFont('Arial','',8);
$pdf->Text(26,263,'	others (Specify)');

$pdf->Text(104,250,'7.D DISAPPROVED DUE TO:');

$pdf->Image(__DIR__.'../../image/line.png',115,255,85,0.6);
$pdf->Image(__DIR__.'../../image/line.png',115,259,85,0.6);
$pdf->Image(__DIR__.'../../image/line.png',115,263,85,0.6);
$pdf->Image(__DIR__.'../../image/line.png',70,269,60,0.6);
$pdf->SetFont('Arial','B',8);
$pdf->Text(88,273,'(Authorized Official)');
?>