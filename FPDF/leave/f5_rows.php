<?php

$pdf->Ln();
$pdf->setY('272');

$pdf->setX('15');
$pdf->Cell(180,37.5,'',1);
$pdf->Image(__DIR__.'../../image/line.png',15.2,272.5,179.5,0.6);
$pdf->SetFont('Arial','',8);
$pdf->Text(16,278,'7.C APPROVED FOR:');

$pdf->Image(__DIR__.'../../image/line.png',22,282.5,12,0.6);
$pdf->Image(__DIR__.'../../image/line.png',22,286.5,12,0.6);
$pdf->Image(__DIR__.'../../image/line.png',22,290.5,12,0.6);
$pdf->Text(35,282.5,'days with pay');
$pdf->Text(35,286.5,'others without pay');
$pdf->Text(35,290.5,'others (Specify)');

//
//$pdf->SetFont('Arial','BU',8);
//$pdf->Text(15,255,'             ');
//
//$pdf->SetFont('Arial','',8);
//$pdf->Text(26,255,'days with pay');
//
//$pdf->SetFont('Arial','BU',8);
//$pdf->Text(15,259,'             ');
//
//$pdf->SetFont('Arial','',8);
//$pdf->Text(26,259,'days without pay');
//
//$pdf->SetFont('Arial','BU',8);
//$pdf->Text(15,263,'             ');
//
//$pdf->SetFont('Arial','',8);
//$pdf->Text(26,263,'	others (Specify)');
//
$pdf->Text(114,278,'7.D DISAPPROVED DUE TO:');
//
$pdf->Image(__DIR__.'../../image/line.png',122,282.5,66,0.6);
$pdf->Image(__DIR__.'../../image/line.png',122,286.5,66,0.6);
$pdf->Image(__DIR__.'../../image/line.png',122,290.5,66,0.6);
$pdf->Image(__DIR__.'../../image/line.png',72,304,60,0.6);
$pdf->SetFont('Arial','B',8);
$pdf->Text(88,308,'(Authorized Official)');
?>