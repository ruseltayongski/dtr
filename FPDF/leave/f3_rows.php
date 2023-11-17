<?php

$pdf->Ln();
$pdf->setX('5');
$pdf->Cell(97.5,30,'',1);
$pdf->Cell(102.5,30,'',1);

$pdf->SetFont('Arial','B',8);
$pdf->Text(11,118,'(6. C) Number of Working Days applied for:');
$pdf->Text(20,122,$leave['applied_num_days']);
$pdf->Image(__DIR__.'../../image/line.png', 12,123,83,0.6);

$pdf->Text(18,130,'Inclusive Dates :');
$pdf->SetFont('Arial','BI',8);
$pdf->Text(42,130,date('F d,Y',strtotime($leave['inc_from'])).' to '.date('F d,Y',strtotime($leave['inc_to'])));
$pdf->SetFont('Arial','I',8);
if(!empty($leave['half_day_first']) && !empty($leave['half_day_last']))
    $half_day_message = 'Half day in first day('.$leave['half_day_first'].') and half day('.$leave['half_day_last'].') in last day';
elseif(!empty($leave['half_day_first']))
    $half_day_message = 'Half day in first day('.$leave['half_day_first'].')';
elseif(!empty($leave['half_day_last']))
    $half_day_message = 'Half day in last day('.$leave['half_day_last'].')';
else
    $half_day_message = '';
$pdf->Text(20,134.3,$half_day_message);
$pdf->SetFont('Arial','B',8);
$pdf->Image(__DIR__.'../../image/line.png', 12,135,83,0.6);

$pdf->Text(108,118,'(6. D) Commutation');

//if($leave['com_requested'] == 'yes'){
//    $pdf->Image(__DIR__.'../../image/check.png', 117,120,4,4);
//} else {
//    $pdf->Image(__DIR__.'../../image/square.png', 117,120,4,4);
//}
//$pdf->Text(123,123,'Requested');
//
//if($leave['com_requested'] == 'no'){
//    $pdf->Image(__DIR__.'../../image/check.png', 150,120,4,4);
//} else {
//    $pdf->Image(__DIR__.'../../image/square.png', 150,120,4,4);
//}
//$pdf->Text(156,123,'Not Requested');

$pdf->Image(__DIR__.'../../image/line.png', 113,135,83,0.6);
$pdf->Text(138,139,'Signature of Applicant');


?>