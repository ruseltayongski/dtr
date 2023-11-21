<?php

$pdf->Ln();
$pdf->setX('5');
$pdf->SetFont('Arial','B',12);
$pdf->Cell(200,8,'DETAILS OF ACTION ON APPLICATION',1,'','C');

$pdf->Ln();

$pdf->setX('5');
$pdf->Cell(97.5,50,'',1);
$pdf->Cell(102.5,50,'',1);

$pdf->SetFont('Arial','',8);
$pdf->Text(7,201,'7. A CERTIFICATION OF LEAVE CREDITS');
$pdf->Text(19,206,'As of ');
$pdf->Text(45,206,$leave['date_filling']);
$pdf->Image(__DIR__.'../../image/line.png',26,206,60,0.6);
//$pdf->Image(__DIR__.'../../image/table.png',30,163,55,25);

$pdf->SetFont('Arial', '', 8);

// Table data
$pdf->setX(7);
$pdf->setY(208);
$pdf->Cell(30, 5, '', 1);
$pdf->Cell(29, 5, 'Vacation Leave', 1,'', 'C');
$pdf->Cell(29, 5, 'Sick Leave', 1,'', 'C');
$pdf->Ln(); // Move to the next line
$vl=0;
$sl=0;
if($leave['leave_type'] == "VL"){
    $vl = $leave['applied_num_days'];
}else if($leave['leave_type'] == "SL"){
    $sl = $leave['applied_num_days'];
}
$vl_earned = !empty($leave['vacation_balance'])? $leave['vacation_balance']: 0;
$sl_earned = !empty($leave['sick_balance'])?$leave['sick_balance']:0;
$vl_bal = $vl_earned - $vl;
$sl_bal = $sl_earned - $sl;
$pdf->Cell(30, 5, 'Total Earned', 1);
$pdf->Cell(29, 5, $vl_earned, 1,'', 'C');
$pdf->Cell(29, 5, $sl_earned, 1,'', 'C');
$pdf->Ln(); // Move to the next line
$pdf->Cell(30, 5, 'Less this application', 1);

$pdf->Cell(29, 5, $vl, 1,'', 'C');
$pdf->Cell(29, 5, $sl, 1,'', 'C');
$pdf->Ln(); // Move to the next line
$pdf->Cell(30, 5, 'Balance', 1);
$pdf->Cell(29, 5, $vl_bal, 1,'', 'C');
$pdf->Cell(29, 5, $sl_bal, 1,'', 'C');
$pdf->Text(39,239,'THERESA Q. TRAGICO');
$pdf->Image(__DIR__.'../../image/line.png',26,240,60,0.6);
$pdf->Text(42,244,'(Authorized Officer)');

$pdf->SetFont('Arial','',8);
$pdf->Text(104,201,'7.B RECOMMENDATION');

if(false){
    $pdf->Image(__DIR__.'../../image/check.png', 115,205,4,4);
} else {
    $pdf->Image(__DIR__.'../../image/square.png', 115,205,4,4);
}
$pdf->Text(121,208,'Approval');

if(false){
    $pdf->Image(__DIR__.'../../image/check.png', 115,210,4,4);
} else {
    $pdf->Image(__DIR__.'../../image/square.png', 115,210,4,4);
}
$pdf->Text(121,213,'For disapproval due to');
$pdf->Image(__DIR__.'../../image/line.png',150,214,50,0.6);
$pdf->Image(__DIR__.'../../image/line.png',115,219,85,0.6);
$pdf->Image(__DIR__.'../../image/line.png',115,224,85,0.6);
$pdf->Image(__DIR__.'../../image/line.png',115,229,85,0.6);

$pdf->Image(__DIR__.'../../image/line.png',125,240,60,0.6);
$pdf->Text(145,244,'(Authorized Officer)');

$pdf->setY(241);
?>