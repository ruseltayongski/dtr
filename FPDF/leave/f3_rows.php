<?php

$pdf->Ln();
$pdf->setX('5');
$pdf->Cell(97.5,30,'',1);
$pdf->Cell(102.5,30,'',1);

$pdf->SetFont('Arial','B',8);
$pdf->Text(11,118,'(6. C) Number of Working Days applied for:');


$pdf->Text(18,123,'Inclusive Dates :');
$pdf->Image(__DIR__.'../../image/line.png', 12,135,83,0.6);

$pdf->Text(108,118,'(6. D) Commutation');

if($leave['com_requested'] == 'yes'){
    $pdf->Image(__DIR__.'../../image/check.png', 117,120,4,4);
} else {
    $pdf->Image(__DIR__.'../../image/square.png', 117,120,4,4);
}
$pdf->Text(123,123,'Requested');

if($leave['com_requested'] == 'no'){
    $pdf->Image(__DIR__.'../../image/check.png', 150,120,4,4);
} else {
    $pdf->Image(__DIR__.'../../image/square.png', 150,120,4,4);
}
$pdf->Text(156,123,'Not Requested');

$pdf->Image(__DIR__.'../../image/line.png', 113,135,83,0.6);
$pdf->Text(138,139,'Signature of Applicant');


?>