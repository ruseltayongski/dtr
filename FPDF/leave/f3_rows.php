<?php

$pdf->Ln();
$pdf->setX('5');
$pdf->Cell(97.5,31,'',1);
$pdf->Cell(102.5,31,'',1);

$pdf->SetFont('Arial','B',8);
$pdf->Text(7,158,'6.C NUMBER OF WORKING DAYS APPLIED FOR');
$pdf->Text(20,164,$leave['applied_num_days']);
$pdf->Image(__DIR__.'../../image/line.png', 7,165,83,0.6);

$pdf->Text(13,171,'INCLUSIVE DATES :');
$pdf->SetFont('Arial','BI',8);
$pdf->Text(20,176,date('F d,Y',strtotime($leave['inc_from'])).' to '.date('F d,Y',strtotime($leave['inc_to'])));
$pdf->SetFont('Arial','I',8);
//if(!empty($leave['half_day_first']) && !empty($leave['half_day_last']))
//    $half_day_message = 'Half day in first day('.$leave['half_day_first'].') and half day('.$leave['half_day_last'].') in last day';
//elseif(!empty($leave['half_day_first']))
//    $half_day_message = 'Half day in first day('.$leave['half_day_first'].')';
//elseif(!empty($leave['half_day_last']))
//    $half_day_message = 'Half day in last day('.$leave['half_day_last'].')';
//else
//    $half_day_message = '';
//$pdf->Text(20,134.3,$half_day_message);
$pdf->SetFont('Arial','B',8);
$pdf->Image(__DIR__.'../../image/line.png', 7,177,83,0.6);

$pdf->Text(104,158,'6.D COMMUTATION');

if($leave['commutation'] == '1'){
    $pdf->Image(__DIR__.'../../image/check.png', 115,162,4,4);
} else {
    $pdf->Image(__DIR__.'../../image/square.png', 115,162,4,4);
}
$pdf->Text(121,165,'Requested');

if($leave['commutation'] == '2'){
    $pdf->Image(__DIR__.'../../image/check.png', 115,168,4,4);
} else {
    $pdf->Image(__DIR__.'../../image/square.png', 115,168,4,4);
}
$pdf->Text(121,171,'Not Requested');

$pdf->Image(__DIR__.'../../image/line.png', 113,179,83,0.6);
$pdf->Text(138,182,'Signature of Applicant');


?>