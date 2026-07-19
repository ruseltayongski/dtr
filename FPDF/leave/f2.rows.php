<?php
$pdf->Ln();
$pdf->setX('15');
$pdf->Cell(180,.8,'',1,'','C');
$pdf->Ln();
$pdf->setX('15');
$pdf->SetFont('Arial','B',10.5);
$pdf->Cell(180,6,'',1);
$pdf->Text(85,77,'6. DETAILS OF APPLICATION');
$pdf->Ln();
$pdf->setX('15');
$pdf->Cell(180,.8,'',1,'','C');
$pdf->Ln();
$pdf->setX('15');
$pdf->Cell(97.5,98,'',1);
$pdf->Cell(82.5,98,'',1);
$pdf->SetFont('Arial','',8);
$pdf->Text(16,85,'6. A TYPE OF LEAVE TO BE AVAILED OF');
if (in_array('VL', $all_leave_type)) {
    $pdf->Image(__DIR__.'../../image/check.png', 19,88,4,4);
} else {
    $pdf->Image(__DIR__.'../../image/square.png', 19,88,4,4);
}
$pdf->Text(24,91,'Vacation Leave');
$pdf->SetFont('Helvetica','',6);
$pdf->Text(44,91,'(Sec. 51, Rule XVI, Omnibus Rules Implementing E.O. No.292)');
$pdf->SetFont('Arial','',8);
if (in_array('FL', $all_leave_type)) {
    $pdf->Image(__DIR__.'../../image/check.png', 19,94,4,4);
} else {
    $pdf->Image(__DIR__.'../../image/square.png', 19,94,4,4);
}
$pdf->Text(24,97,'Mandatory/Forced Leave');
$pdf->SetFont('Helvetica','',5.5);
$pdf->Text(56,97,'(Sec. 25, Rule XVI, Omnibus Rules Implementing E.O. No.292)');
$pdf->SetFont('Arial','',8);
if (in_array('SL', $all_leave_type)) {
    $pdf->Image(__DIR__.'../../image/check.png', 19,100,4,4);
} else {
    $pdf->Image(__DIR__.'../../image/square.png', 19,100,4,4);
}
$pdf->Text(24,103,'Sick Leave');
$pdf->SetFont('Helvetica','',6);
$pdf->Text(39,103,'(Sec. 43, Rule XVI, Omnibus Rules Implementing E.O. No.292)');
$pdf->SetFont('Arial','',8);
if (in_array('ML', $all_leave_type)) {
    $pdf->Image(__DIR__.'../../image/check.png', 19,105.5,4,4);
} else {
    $pdf->Image(__DIR__.'../../image/square.png', 19,105.5,4,4);
}
$pdf->Text(24,108.5,'Maternity Leave');
$pdf->SetFont('Helvetica','',6);
$pdf->Text(45,108.5,'(R.A. No. 11210/ IRR issued by CSC, DOLE and SSS)');
$pdf->SetFont('Arial','',8);
if (in_array('PL', $all_leave_type)) {
    $pdf->Image(__DIR__.'../../image/check.png', 19,111,4,4);
} else {
    $pdf->Image(__DIR__.'../../image/square.png', 19,111,4,4);
}
$pdf->Text(24,114,'Paternity Leave');
$pdf->SetFont('Helvetica','',6);
$pdf->Text(45,114,'(R.A. No. 8187 / CSC MC No. 71, s. 1998, as ammended)');
$pdf->SetFont('Arial','',8);
if (in_array('SPL', $all_leave_type)) {
    $pdf->Image(__DIR__.'../../image/check.png', 19,116.5,4,4);
    if($spl >=1){
        $pdf->SetFont('Helvetica','',7);
        $pdf->Text(24,117,'Domestic Emergency');
        $pdf->SetFont('Arial','',8);
    }
} else {
    $pdf->Image(__DIR__.'../../image/square.png', 19,116.5,4,4);
}

$pdf->Text(24,119.5,'Special Privilege Leave');
$pdf->SetFont('Helvetica','',5.7);
$pdf->Text(54,119.5,'(Sec. 21, Rule XVI, Omnibus Rules Implementing E. O. No 292)');
$pdf->SetFont('Arial','',8);
if (in_array('SOLO_PL', $all_leave_type)) {
    $pdf->Image(__DIR__.'../../image/check.png', 19,122,4,4);
} else {
    $pdf->Image(__DIR__.'../../image/square.png', 19,122,4,4);
}
$pdf->Text(24,125,'Solo Parent Leave');
$pdf->SetFont('Helvetica','',6);
$pdf->Text(48,125,'(Sec 68, Rule XVI, Omnibus Rules Implementing E.O. No. 292)');
$pdf->SetFont('Arial','',8);
if (in_array('STUD_L', $all_leave_type)) {
    $pdf->Image(__DIR__.'../../image/check.png', 19,127.8,4,4);
} else {
    $pdf->Image(__DIR__.'../../image/square.png', 19,127.8,4,4);
}
$pdf->Text(24,130.5,'Study Leave');
$pdf->SetFont('Helvetica','',6);
$pdf->Text(41,130.5,'(RA No. 9262 / CSC MC No. 15, s. 2005)');
$pdf->SetFont('Arial','',8);
if (in_array('10D_VAWCL', $all_leave_type)) {
    $pdf->Image(__DIR__.'../../image/check.png', 19,133.4,4,4);
} else {
    $pdf->Image(__DIR__.'../../image/square.png', 19,133.4,4,4);
}
$pdf->Text(24,135.9,'10-Day VAWC Leave');
$pdf->SetFont('Helvetica','',6);
$pdf->Text(51.5,135.5,'(Sec 55, Rule XVI, Omnibus Rules Implementing E.O. No. 292)');
$pdf->SetFont('Arial','',8);
if (in_array('RL', $all_leave_type)) {
    $pdf->Image(__DIR__.'../../image/check.png', 19,139,4,4);
} else {
    $pdf->Image(__DIR__.'../../image/square.png', 19,139,4);
}
$pdf->Text(24,141.5,'Rehabilitation Privilege');
$pdf->SetFont('Helvetica','',6);
$pdf->Text(54,141.5,'(RA No. 9710 / CSC MC No. 25, s. 2010)');
$pdf->SetFont('Arial','',8);
if (in_array('SLBW', $all_leave_type)) {
    $pdf->Image(__DIR__.'../../image/check.png', 19,144,4,4);
} else {
    $pdf->Image(__DIR__.'../../image/square.png', 19,144,4,4);
}
$pdf->Text(24,147.5,'Special Leave Benefits for Women');
$pdf->SetFont('Helvetica','',6);
$pdf->Text(68,147.5,'(RA No. 9710 / CSC MC No. 25, s. 2010)');
$pdf->SetFont('Arial','',8);
if (in_array('SEL', $all_leave_type)) {
    $pdf->Image(__DIR__.'../../image/check.png', 19,149.8,4,4);
} else {
    $pdf->Image(__DIR__.'../../image/square.png', 19,149.8,4,4);
}
$pdf->Text(24,153,'Special Emergency (Calamity) Leave');
$pdf->SetFont('Helvetica','',5.5);
$pdf->Text(72,153,'(CSC MC No. 2, s. 2012, as ammended)');
$pdf->SetFont('Arial','',8);
if($leave['leave_type'] == 'AL'){
    $pdf->Image(__DIR__.'../../image/check.png', 19,155.7,4,4);
    $pdf->Text(25, 144, $leave['for_others']);
} else {
    $pdf->Image(__DIR__.'../../image/square.png', 19,155.7,4,4);
}
$pdf->Text(24,159,'Adoption Leave');
$pdf->SetFont('Helvetica','',5.5);
$pdf->Text(45,159,'(R.A. No. 8552)');
$pdf->SetFont('Arial','',8);
$pdf->Image(__DIR__.'../../image/line.png', 19.5,174.5,65,0.6);
$pdf->Text(19,168.5,'Others:');
$pdf->SetFont('Arial','',8);
$pdf->Text(113.7,85,'6.B DETAILS OF LEAVE');
$pdf->SetFont('Arial','I',8);
$pdf->Text(117,91,'In case of Vacation/Special Privilege leave:');
if (($index = array_search('1', array_map('strval', array_column($details, 'details')))) !== false) {
    $pdf->Image(__DIR__.'../../image/check.png', 117,94,4,4);
    $pdf->Text(151, 96.5, $details[$index]['remarks']);
} else {
    $pdf->Image(__DIR__.'../../image/square.png', 117,94,4,4);
}
$pdf->SetFont('Arial','',8);
$pdf->Text(122,97,'Within the Philippines');
$pdf->Image(__DIR__.'../../image/line.png', 150,97,41,0.6);
if (($index = array_search('2', array_map('strval', array_column($details, 'details')))) !== false) {
    $pdf->Image(__DIR__.'../../image/check.png', 117,100,4,4);
    $pdf->Text(144, 103, $details[$index]['remarks']);
} else {
    $pdf->Image(__DIR__.'../../image/square.png', 117,100,4,4);
}
$pdf->SetFont('Arial','',8);
$pdf->Image(__DIR__.'../../image/line.png', 143,103,46,0.6);
$pdf->Text(122,103,'Abroad(Specify)');
$pdf->SetFont('Arial','I',8);

$pdf->Text(117,108.5,'In case of Sick Leave:');
if (($index = array_search('3', array_map('strval', array_column($details, 'details')))) !== false) {
    $pdf->Image(__DIR__.'../../image/check.png', 117,111,4,4);
    $pdf->Text(157, 113.2, $details[$index]['remarks']);
} else {
    $pdf->Image(__DIR__.'../../image/square.png', 117,111,4,4);
}
$pdf->SetFont('Arial','',8);
$pdf->Image(__DIR__.'../../image/line.png', 157,113.5,32.5,0.6);
$pdf->Text(122,114,'In Hospital(Specify Illness)');

if (($index = array_search('4', array_map('strval', array_column($details, 'details')))) !== false) {
    $pdf->Image(__DIR__.'../../image/check.png', 117,116.8,4,4);
    $pdf->SetFont('Arial','',8);
    $pdf->Text(158, 119, $details[$index]['remarks']);
} else {
    $pdf->Image(__DIR__.'../../image/square.png', 117,116.8,4,4);
}
$pdf->SetFont('Arial','',8);
$pdf->Image(__DIR__.'../../image/line.png', 157,119.5,32.5,0.6);
$pdf->Text(122,120,'Out Patient(Specify Illness)');
$pdf->Image(__DIR__.'../../image/line.png', 117.5,125,70,0.6);
$pdf->SetFont('Arial','I',8);
$pdf->Text(117,130.5,'In case of Special Leave Benefits for Women:');
if (($index = array_search('5', array_map('strval', array_column($details, 'details')))) !== false) {
    $pdf->SetFont('Arial','',8);
    $pdf->Text(139, 135, explode(' -- ', $details[$index]['remarks'])[0]);
    $pdf->Text(120, 140, explode(' -- ', $details[$index]['remarks'])[1]);
} else {
}
$pdf->Image(__DIR__.'../../image/line.png', 138,135,50,0.6);
$pdf->SetFont('Arial','',8);
$pdf->Image(__DIR__.'../../image/line.png', 117,140.5,71.5,0.6);
$pdf->Text(117,135.5,'(Specify Illness)');
$pdf->SetFont('Arial','I',8);
$pdf->Text(117,146.5,'In case of Study Leave:');
if (($index = array_search('6', array_map('strval', array_column($details, 'details')))) !== false) {
    $pdf->Image(__DIR__.'../../image/check.png', 117,149,4,4);
} else {
    $pdf->Image(__DIR__.'../../image/square.png', 117,149,4,4);
}
$pdf->SetFont('Arial','',8);
$pdf->Text(122,152,"Completion of Master's Degree");
if (($index = array_search('7', array_map('strval', array_column($details, 'details')))) !== false) {
    $pdf->Image(__DIR__.'../../image/check.png', 117,154.7,4,4);
} else {
    $pdf->Image(__DIR__.'../../image/square.png', 117,154.7,4,4);
}
$pdf->SetFont('Arial','',8);
$pdf->Text(122,158,"BAR/Board Examination Review");
$pdf->SetFont('Arial','I',8);
$pdf->Text(117,163.8,"Other Purpose:");
if($leave['leave_details'] == '8'){
    $pdf->Image(__DIR__.'../../image/check.png', 117,166,4,4);
} else {
    $pdf->Image(__DIR__.'../../image/square.png', 117,166,4,4);
}
$pdf->Text(122,169,"Monetization of Leave Credits");
if($leave['leave_details'] == '9'){
    $pdf->Image(__DIR__.'../../image/check.png', 117,171.5,4,4);
} else {
    $pdf->Image(__DIR__.'../../image/square.png', 117,171.5,4,4);
}
$pdf->Text(122,175,"Terminal Leave");
?>