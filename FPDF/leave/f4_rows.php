<?php
$pdf->Ln();
$pdf->setX('15');
$pdf->Cell(180,.8,'',1,'','C');
$pdf->Ln();
$pdf->setX('15');
$pdf->SetFont('Arial','B',10.5);
$pdf->Cell(180,6,'7. DETAILS OF ACTION ON APPLICATION',1,'','C');
$pdf->Ln();
$pdf->setX('15');
$pdf->Cell(180,.8,'',1,'','C');
//
$pdf->Ln();
//
$pdf->setX('15');
$pdf->Cell(97.5,52,'',1);
$pdf->Cell(82.5,52,'',1);
//
$pdf->SetFont('Arial','',8);
$pdf->Text(16,225,'7. A CERTIFICATION OF LEAVE CREDITS');
$pdf->Text(40,231,'As of ');
$pdf->Text(50,231,$leave['as_of']);
$pdf->Image(__DIR__.'../../image/line.png',47,231.5,35,0.6);

// Table data
//$pdf->Ln();
$pdf->setY(234.5);
$pdf->setX('22');
$pdf->Cell(27, 5, '', 1);
$pdf->Cell(28, 5, 'Vacation Leave', 1,'', 'C');
$pdf->Cell(28, 5, 'Sick Leave', 1,'', 'C');
$pdf->Ln(); // Move to the next line
$vl=0;
$sl=0;
$days = $leave['applied_num_days'];
if($leave['leave_type'] == "VL"){
    $vl = $days;
}else if($leave['leave_type'] == "SL"){
    $sl = $days;
}else if ($leave['leave_type'] == "FL"){
    if($leave['vacation_total'] >= $days){
        $vl = $days;
    }else{
        $vl = $leave['vacation_total'];
        $sl = $days - $leave['vacation_total'];
    }
}
$vl_earned = !empty($leave['vacation_total'])? $leave['vacation_total']: 0;
$sl_earned = !empty($leave['sick_total'])?$leave['sick_total']:0;
$vl_bal = $vl_earned - $vl;
$sl_bal = $sl_earned - $sl;
$pdf->setX('22');
$pdf->Cell(27, 5, 'Total Earned', 1);
$pdf->Cell(28, 5, $vl_earned <= 0 ? 0 : $vl_earned, 1,'', 'C');
$pdf->Cell(28, 5, $sl_earned <= 0 ? 0 : $sl_earned, 1,'', 'C');
$pdf->Ln(); // Move to the next line
$pdf->setX('22');
$pdf->Cell(27, 5, 'Less this application', 1);
//
$pdf->Cell(28, 5, $vl <= 0 ? 0 : $vl, 1,'', 'C');
$pdf->Cell(28, 5, $sl <= 0 ? 0 : $sl, 1,'', 'C');
$pdf->Ln(); // Move to the next line
$pdf->setX('22');
$pdf->Cell(27, 5, 'Balance', 1);
$pdf->Cell(28, 5, $vl_bal <= 0 ? 0 : $vl_bal, 1,'', 'C');
$pdf->Cell(28, 5, $sl_bal <= 0 ? 0 : $sl_bal, 1,'', 'C');
$pdf->Text(40,264.5,$officer_1['fname'] .' '.$officer_1['lname']);
$pdf->Image(__DIR__.'../../image/line.png',22,265,83,0.6);
$pdf->Text(51,269,'(Authorized Officer)');
//
$pdf->SetFont('Arial','',8);
$pdf->Text(114,225,'7.B RECOMMENDATION');
//
if(false){
    $pdf->Image(__DIR__.'../../image/check.png', 117,228,4,4);
} else {
    $pdf->Image(__DIR__.'../../image/square.png', 117,228,4,4);
}
$pdf->Text(122,231.5,'For approval');
//
if(false){
    $pdf->Image(__DIR__.'../../image/check.png', 117,234,4,4);
} else {
    $pdf->Image(__DIR__.'../../image/square.png', 117,234,4,4);
}
$pdf->Text(122,238,'For disapproval due to');
$pdf->Image(__DIR__.'../../image/line.png',151,237,37,0.6);
$pdf->Image(__DIR__.'../../image/line.png',122,243,66,0.6);
$pdf->Image(__DIR__.'../../image/line.png',122,249,66,0.6);
$pdf->Image(__DIR__.'../../image/line.png',122,255,66,0.6);
//
$pdf->Text(130,264.5,$officer_2['fname'] .' '.$officer_2['lname']);
$pdf->Image(__DIR__.'../../image/line.png',122,265,66,0.6);
$pdf->Text(145,269,'(Authorized Officer)');
//
?>