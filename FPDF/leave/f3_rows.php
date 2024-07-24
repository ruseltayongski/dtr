<?php

$pdf->Ln();
$pdf->setX('15');
$pdf->Cell(97.5,35,'',1);
$pdf->Cell(82.5,35,'',1);
//
$pdf->SetFont('Arial','',8);
$pdf->Text(16,183,'6.C NUMBER OF WORKING DAYS APPLIED FOR');
$pdf->Text(50,188.5, (int) $leave['applied_num_days']);
$pdf->Image(__DIR__.'../../image/line.png', 22,188.5,80,0.6);

$pdf->Text(25,194.5,'INCLUSIVE DATES :');
//$pdf->SetFont('Arial','',8);
$y = 202;
$yy = 203;
foreach ($applied_dates as $dates) {
    $start = date('F j, Y', strtotime($dates['startdate']));
    $end = date('F j, Y',strtotime($dates['enddate']));
    if($start == $end){
        $pdf->Text(25,$y,$start);
        $pdf->Image(__DIR__.'../../image/line.png', 22,$yy,80,0.6);
    }else{
        $pdf->Text(25   ,$y,$start.' - '. $end);
        $pdf->Image(__DIR__.'../../image/line.png', 22,$yy,80,0.6);
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

$pdf->Text(114,183,'6.D COMMUTATION');
//
if($leave['commutation'] == '1'){
    $pdf->Image(__DIR__.'../../image/check.png', 117,186,4,4);
} else {
    $pdf->Image(__DIR__.'../../image/square.png', 117,186,4,4);
}
$pdf->Text(122,189,'Requested');
//
if($leave['commutation'] == '2'){
    $pdf->Image(__DIR__.'../../image/check.png', 117,191.5,4,4);
} else {
    $pdf->Image(__DIR__.'../../image/square.png', 117,191.5,4,4);
}
$pdf->Text(122,195,'Not Requested');
//
$pdf->Image(__DIR__.'../../image/line.png', 122,203,72.8,0.6);
$pdf->Text(138,207,'(Signature of Applicant)');

?>