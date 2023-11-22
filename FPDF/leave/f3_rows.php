<?php

$pdf->Ln();
$pdf->setX('5');
$pdf->Cell(97.5,40,'',1);
$pdf->Cell(102.5,40,'',1);

$pdf->SetFont('Arial','',8);
$pdf->Text(7,153,'6.C NUMBER OF WORKING DAYS APPLIED FOR');
$pdf->Text(25,158,$leave['applied_num_days']);
$pdf->Image(__DIR__.'../../image/line.png', 15,159,80,0.6);

$pdf->Text(13,165,'INCLUSIVE DATES :');
$pdf->SetFont('Arial','',8);
$y = 170;
$yy = 171;
foreach ($applied_dates as $dates) {
    $start = date('F j, Y', strtotime($dates['startdate']));
    $end = date('F j, Y',strtotime($dates['enddate']));
    if($start == $end){
        $pdf->Text(25,$y,$start);
        $pdf->Image(__DIR__.'../../image/line.png', 15,$yy,80,0.6);
    }else{
        $pdf->Text(25   ,$y,$start.' - '. $end);
        $pdf->Image(__DIR__.'../../image/line.png', 15,$yy,80,0.6);
    }
    $y += 5;
    $yy = $y + 1;
}

//if(!empty($leave['half_day_first']) && !empty($leave['half_day_last']))
//    $half_day_message = 'Half day in first day('.$leave['half_day_first'].') and half day('.$leave['half_day_last'].') in last day';
//elseif(!empty($leave['half_day_first']))
//    $half_day_message = 'Half day in first day('.$leave['half_day_first'].')';
//elseif(!empty($leave['half_day_last']))
//    $half_day_message = 'Half day in last day('.$leave['half_day_last'].')';
//else
//    $half_day_message = '';
//$pdf->Text(20,134.3,$half_day_message);
$pdf->SetFont('Arial','',8);

$pdf->Text(104,153,'6.D COMMUTATION');

if($leave['commutation'] == '1'){
    $pdf->Image(__DIR__.'../../image/check.png', 115,156,4,4);
} else {
    $pdf->Image(__DIR__.'../../image/square.png', 115,156,4,4);
}
$pdf->Text(121,159,'Requested');

if($leave['commutation'] == '2'){
    $pdf->Image(__DIR__.'../../image/check.png', 115,162,4,4);
} else {
    $pdf->Image(__DIR__.'../../image/square.png', 115,162,4,4);
}
$pdf->Text(121,165,'Not Requested');

$pdf->Image(__DIR__.'../../image/line.png', 113,180,83,0.6);
$pdf->Text(138,184,'(Signature of Applicant)');

?>