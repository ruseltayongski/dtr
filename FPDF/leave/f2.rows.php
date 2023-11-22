<?php


$pdf->Ln();
$pdf->setX('5');
$pdf->SetFont('Arial','B',12);
$pdf->Cell(200,8,'DETAILS OF APPLICATION',1,'','C');

$pdf->Ln();
$pdf->setX('5');
$pdf->Cell(97.5,80,'',1);
$pdf->Cell(102.5,80,'',1);

$pdf->SetFont('Arial','',8);
$pdf->Text(7,73,'6. A TYPE OF LEAVE TO BE AVAILED OF');


if($leave['leave_type'] == 'VL'){
    $pdf->Image(__DIR__.'../../image/check.png', 15,76,4,4);
} else {
    $pdf->Image(__DIR__.'../../image/square.png', 15,76,4,4);
}
$pdf->Text(21,79,'Vacation Leave');

if($leave['leave_type'] == 'FL'){
    $pdf->Image(__DIR__.'../../image/check.png', 15,81,4,4);
} else {
    $pdf->Image(__DIR__.'../../image/square.png', 15,81,4,4);
}
$pdf->Text(21,84,'Mandatory/Forced Leave');

if($leave['leave_type'] == 'SL'){
    $pdf->Image(__DIR__.'../../image/check.png', 15,86,4,4);
} else {
    $pdf->Image(__DIR__.'../../image/square.png', 15,86,4,4);
}
$pdf->Text(21,89,'Sick Leave');

if($leave['leave_type'] == 'PL'){
    $pdf->Image(__DIR__.'../../image/check.png', 15,91,4,4);
} else {
    $pdf->Image(__DIR__.'../../image/square.png', 15,91,4,4);
}
$pdf->Text(21,94,'Paternity Leave');

if($leave['leave_type'] == 'SPL'){
    $pdf->Image(__DIR__.'../../image/check.png', 15,96,4,4);
} else {
    $pdf->Image(__DIR__.'../../image/square.png', 15,96,4,4);
}
$pdf->Text(21,99,'Special Privilege Leave');

if($leave['leave_type'] == 'SOLO_PL'){
    $pdf->Image(__DIR__.'../../image/check.png', 15,101,4,4);
} else {
    $pdf->Image(__DIR__.'../../image/square.png', 15,101,4,4);
}
$pdf->Text(21,104,'Solo Parent Leave');

if($leave['leave_type'] == 'Stud_L'){
    $pdf->Image(__DIR__.'../../image/check.png', 15,106,4,4);
} else {
    $pdf->Image(__DIR__.'../../image/square.png', 15,106,4,4);
}
$pdf->Text(21,109,'Study Leave');
if($leave['leave_type'] == '10D_VAWCL'){
    $pdf->Image(__DIR__.'../../image/check.png', 15,111,4,4);
} else {
    $pdf->Image(__DIR__.'../../image/square.png', 15,111,4,4);
}
$pdf->Text(21,114,'10-Day VAWC Leave');

if($leave['leave_type'] == 'RL'){
    $pdf->Image(__DIR__.'../../image/check.png', 15,116,4,4);
} else {
    $pdf->Image(__DIR__.'../../image/square.png', 15,116,4,4);
}
$pdf->Text(21,119,'Rehabilitation Privilege');

if($leave['leave_type'] == 'SLBW'){
    $pdf->Image(__DIR__.'../../image/check.png', 15,121,4,4);
} else {
    $pdf->Image(__DIR__.'../../image/square.png', 15,121,4,4);
}
$pdf->Text(21,124,'Special Leave Benefits for Women');

if($leave['leave_type'] == 'SOLO_PL'){
    $pdf->Image(__DIR__.'../../image/check.png', 15,126,4,4);
} else {
    $pdf->Image(__DIR__.'../../image/square.png', 15,126,4,4);
}
$pdf->Text(21,129,'Special Emergency (Calamity) Leave');

if($leave['leave_type'] == 'AL'){
    $pdf->Image(__DIR__.'../../image/check.png', 15,131,4,4);
} else {
    $pdf->Image(__DIR__.'../../image/square.png', 15,131,4,4);
}
$pdf->Text(21,134,'Adoption Leave');
if($leave['leave_type'] == 'ML'){
    $pdf->Image(__DIR__.'../../image/check.png', 15,136,4,4);
    $pdf->Text(25, 144, $leave['for_others']);
} else {
    $pdf->Image(__DIR__.'../../image/square.png', 15,136,4,4);
}
$pdf->Text(21,139,'Maternity Leave:');
if($leave['leave_type'] == 'Others'){
    $pdf->Image(__DIR__.'../../image/check.png', 15,141,4,4);
    $pdf->Text(25, 144, $leave['for_others']);
} else {
    $pdf->Image(__DIR__.'../../image/square.png', 15,141,4,4);
}
$pdf->Image(__DIR__.'../../image/line.png', 29,145,65,0.6);
$pdf->Text(21,144,'Others:');

// LEFT PAIN
$pdf->SetFont('Arial','',8);
$pdf->Text(104,73,'6.B DETAILS OF LEAVE');

$pdf->SetFont('Arial','I',8);
$pdf->Text(110,79,'In case of Vacation/Special Privilege leave:');

if($leave['leave_details'] == '1'){
    $pdf->Image(__DIR__.'../../image/check.png', 115,81,4,4);
    $pdf->SetFont('Arial','U',8);
    $pdf->Text(155, 84, $leave['leave_specify']);
} else {
    $pdf->Image(__DIR__.'../../image/square.png', 115,81,4,4);
}
$pdf->SetFont('Arial','',8);
$pdf->Text(121,84,'Within the Philippines');

if($leave['leave_details'] == '2'){
    $pdf->Image(__DIR__.'../../image/check.png', 115,86,4,4);
    $pdf->SetFont('Arial','U',8);
    $pdf->Text(155, 89, $leave['leave_specify']);
} else {
    $pdf->Image(__DIR__.'../../image/square.png', 115,86,4,4);
}
$pdf->SetFont('Arial','',8);
$pdf->Text(121,89,'Abroad(Specify)');
$pdf->SetFont('Arial','I',8);
$pdf->Text(110,94,'In case of Sick Leave:');

if($leave['leave_details'] == '3'){
    $pdf->Image(__DIR__.'../../image/check.png', 115,96,4,4);
    $pdf->SetFont('Arial','U',8);
    $pdf->Text(160, 99, $leave['leave_specify']);
} else {
    $pdf->Image(__DIR__.'../../image/square.png', 115,96,4,4);
}
$pdf->SetFont('Arial','',8);
$pdf->Text(121,99,'In Hospital(Specify Illness)');

if($leave['leave_details'] == '4'){
    $pdf->Image(__DIR__.'../../image/check.png', 115,101,4,4);
    $pdf->SetFont('Arial','U',8);
    $pdf->Text(160, 104, $leave['leave_specify']);
} else {
    $pdf->Image(__DIR__.'../../image/square.png', 115,101,4,4);
}
$pdf->SetFont('Arial','',8);
$pdf->Text(121,104,'Out Patient(Specify Illness)');
$pdf->SetFont('Arial','I',8);
$pdf->Text(110,109,'In case of Special Leave Benefits for Women:');

if($leave['leave_details'] == '5'){
    $pdf->Image(__DIR__.'../../image/check.png', 115,111,4,4);
    $pdf->SetFont('Arial','U',8);
    $pdf->Text(150, 114, $leave['leave_specify']);
} else {
    $pdf->Image(__DIR__.'../../image/square.png', 115,111,4,4);
}
$pdf->SetFont('Arial','',8);
$pdf->Text(121,114,'(Specify Illness)');
$pdf->SetFont('Arial','I',8);
$pdf->Text(110,119,'In case of Study Leave:');

if($leave['leave_details'] == '6'){
    $pdf->Image(__DIR__.'../../image/check.png', 115,121,4,4);
    $pdf->SetFont('Arial','U',8);
    $pdf->Text(165, 124, $leave['leave_specify']);
} else {
    $pdf->Image(__DIR__.'../../image/square.png', 115,121,4,4);
}
$pdf->SetFont('Arial','',8);
$pdf->SetFont('Arial','I',8);
$pdf->Text(121,124,"Completion of Master's Degree");

if($leave['leave_details'] == '7'){
    $pdf->Image(__DIR__.'../../image/check.png', 115,126,4,4);
    $pdf->SetFont('Arial','U',8);
    $pdf->Text(167, 129, $leave['leave_specify']);
} else {
    $pdf->Image(__DIR__.'../../image/square.png', 115,126,4,4);
}
$pdf->SetFont('Arial','',8);
$pdf->Text(121,129,"BAR/Board Examination Review");
$pdf->SetFont('Arial','I',8);
$pdf->Text(110,134,"Other Purpose:");

if($leave['leave_details'] == '8'){
    $pdf->Image(__DIR__.'../../image/check.png', 115,136,4,4);
} else {
    $pdf->Image(__DIR__.'../../image/square.png', 115,136,4,4);
}
$pdf->SetFont('Arial','',8);
$pdf->Text(121,139,"Monetization of Leave Credits");

if($leave['leave_details'] == '9'){
    $pdf->Image(__DIR__.'../../image/check.png', 115,141,4,4);
} else {
    $pdf->Image(__DIR__.'../../image/square.png', 115,141,4,4);
}
$pdf->SetFont('Arial','',8);
$pdf->Text(121,144,"Terminal Leave");
?>