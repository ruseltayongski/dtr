<?php

$pdf->Ln();
$pdf->setX('5');
$pdf->Cell(97.5,28,'',1);
$pdf->Cell(102.5,28,'',1);

$pdf->SetFont('Arial','B',8);
$pdf->Text(11,214,'(7. C) Approved for:');

$pdf->SetFont('Arial','BU',8);
$pdf->Text(15,220,'             ');

$pdf->SetFont('Arial','B',8);
$pdf->Text(26,220,'day(s) with pay');

$pdf->SetFont('Arial','BU',8);
$pdf->Text(15,225,'             ');

$pdf->SetFont('Arial','B',8);
$pdf->Text(26,225,'day(s) without pay');

$pdf->SetFont('Arial','BU',8);
$pdf->Text(15,230,'             ');

$pdf->SetFont('Arial','B',8);
$pdf->Text(26,230,'	others (specify) :');

$pdf->SetFont('Arial','B',8);
$pdf->Text(109,215,'(7. D) Disapproved due to:');




?>