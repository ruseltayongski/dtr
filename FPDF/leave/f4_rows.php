<?php

$pdf->Ln();
$pdf->setX('5');
$pdf->SetFont('Arial','B',15);
$pdf->Cell(200,6,'DETAILS OF ACTION ON APPLICATION',1,'','C');

$pdf->Ln();

$pdf->setX('5');
$pdf->Cell(97.5,52,'',1);
$pdf->Cell(102.5,52,'',1);


$pdf->SetFont('Arial','B',8);
$pdf->Text(7,195,'7. A CERTIFICATION OF LEAVE CREDITS');
$pdf->Text(19,201,'As of ');
$pdf->Text(45,201,$leave['date_filling']);
$pdf->Image(__DIR__.'../../image/line.png',26,202,60,0.6);

//$pdf->Image(__DIR__.'../../image/table.png',30,163,55,25);
$pdf->SetFont('Arial','B',15);

//$pdf->Text(38,177,$leave['leave_type'] == 'Vication' ? $leave['applied_num_days'] : 0); //vacation applied
//$pdf->Text(53,177,$leave['leave_type'] == 'Vication' ? 0 : $leave['applied_num_days']); //sick applied
//$pdf->Text(72,177,$leave['applied_num_days']); //total applied

$pdf->SetFont('Arial','B',8);

$pdf->SetFont('Arial', '', 8);

// Table data
$pdf->setX(7);
$pdf->setY(204);
$pdf->Cell(30, 5, '', 1);
$pdf->Cell(29, 5, 'Vacation Leave', 1,'', 'C');
$pdf->Cell(29, 5, 'Sick Leave', 1,'', 'C');
$pdf->Ln(); // Move to the next line
$pdf->Cell(30, 5, 'Total Earned', 1);
$pdf->Cell(29, 5, $leave['vacation_balance'], 1,'', 'C');
$pdf->Cell(29, 5, $leave['sick_balance'], 1,'', 'C');
$pdf->Ln(); // Move to the next line
$pdf->Cell(30, 5, 'Less this application', 1);
$pdf->Cell(29, 5, '', 1,'', 'C');
$pdf->Cell(29, 5, '', 1,'', 'C');
$pdf->Ln(); // Move to the next line
$pdf->Cell(30, 5, 'Balance', 1);
$pdf->Cell(29, 5, '', 1,'', 'C');
$pdf->Cell(29, 5, '', 1,'', 'C');
$pdf->Ln(); // Move to the next line
//$pdf->Text(37,185.2,$vacation_balance); //vacation balance
//$pdf->Text(56,185.2,$sick_balance); //sick balance
//$pdf->Text(73,185.2,$total_balance); //total balance

$pdf->Text(39,235,'THERESA Q. TRAGICO');
$pdf->Image(__DIR__.'../../image/line.png',26,236,60,0.6);
$pdf->Text(42,240,'(Authorized Officer)');

$pdf->SetFont('Arial','B',8);
$pdf->Text(104,195,'7.B RECOMMENDATION');

if(false){
    $pdf->Image(__DIR__.'../../image/check.png', 115,198,4,4);
} else {
    $pdf->Image(__DIR__.'../../image/square.png', 115,198,4,4);
}
$pdf->Text(121,201,'Approval');

if(false){
    $pdf->Image(__DIR__.'../../image/check.png', 115,203,4,4);
} else {
    $pdf->Image(__DIR__.'../../image/square.png', 115,203,4,4);
}
$pdf->Text(121,206,'For disapproval due to');
$pdf->Image(__DIR__.'../../image/line.png',150,206,50,0.6);
$pdf->Image(__DIR__.'../../image/line.png',115,212,85,0.6);
$pdf->Image(__DIR__.'../../image/line.png',115,218,85,0.6);
$pdf->Image(__DIR__.'../../image/line.png',115,224,85,0.6);
$pdf->Text(140,235,'');
$pdf->Image(__DIR__.'../../image/line.png',125,236,60,0.6);
$pdf->Text(150,240,'(Authorized Officer)');


?>