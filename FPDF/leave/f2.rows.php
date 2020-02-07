<?php


$pdf->Ln();
$pdf->setX('5');
$pdf->SetFont('Arial','B',15);
$pdf->Cell(200,6,'DETAILS OF APPLICATIONS',1,'','C');

$pdf->Ln();
$pdf->setX('5');
$pdf->Cell(97.5,65,'',1);
$pdf->Cell(102.5,65,'',1);

$pdf->SetFont('Arial','B',8);
$pdf->Text(6,54,'(6.A) TYPE OF LEAVE');


if($leave['leave_type'] == 'Vication'){
    $pdf->Image(__DIR__.'../../image/check.png', 15,60,4,4);
} else {
    $pdf->Image(__DIR__.'../../image/square.png', 15,60,4,4);
}

$pdf->Text(21,63,'Vacation');

if($leave['leave_type'] == 'To_sake_employement'){
    $pdf->Image(__DIR__.'../../image/check.png', 15,65,4,4);
} else {
    $pdf->Image(__DIR__.'../../image/square.png', 15,65,4,4);
}
$pdf->Text(21,68,'TO SAKE EMPLOYMENT');

if($leave['leave_type'] == 'Others'){
    $pdf->Image(__DIR__.'../../image/check.png', 15,70,4,4);
} else {
    $pdf->Image(__DIR__.'../../image/square.png', 15,70,4,4);
}
$pdf->Text(21,73,'OTHERS (Specify)');

$text = $leave['leave_type_others_1'];
$pdf->Image(__DIR__.'../../image/line.png', 15,81,83,0.6);
$pdf->Text(21,80,$text);

if($leave['leave_type'] == 'Sick'){
    $pdf->Image(__DIR__.'../../image/check.png', 15,85,4,4);
} else {
    $pdf->Image(__DIR__.'../../image/square.png', 15,85,4,4);
}
$pdf->Text(21,88.3,'SICK');


if($leave['leave_type'] == 'Maternity'){
    $pdf->Image(__DIR__.'../../image/check.png', 15,90,4,4);
} else {
    $pdf->Image(__DIR__.'../../image/square.png', 15,90,4,4);
}
$pdf->Text(21,93.3,'MATERNITY');


if($leave['leave_type'] == 'Others2'){
    $pdf->Image(__DIR__.'../../image/check.png', 15,95,4,4);
} else {
    $pdf->Image(__DIR__.'../../image/square.png', 15,95,4,4);
}

$pdf->Text(21,98,'OTHERS (Specify)');
$text = $leave['leave_type_others_2'];
$pdf->Image(__DIR__.'../../image/line.png', 15,106,83,0.6);
$pdf->Text(21,105,$text);

// LEFT PAIN
$pdf->SetFont('Arial','B',8);
$pdf->Text(103,54,'(6.B) WHERE LEAVE WILL BE SPENT');

$pdf->SetFont('Arial','B',8);
$pdf->Text(110,62,'(1) In case of vaction leave');


if($leave['vication_loc'] == 'local'){
    $pdf->Image(__DIR__.'../../image/check.png', 115,64,4,4);
} else {
    $pdf->Image(__DIR__.'../../image/square.png', 115,64,4,4);
}
$pdf->Text(121,67,'Within the Philippines');

if($leave['vication_loc'] == 'abroad'){
    $pdf->Image(__DIR__.'../../image/check.png', 115,69,4,4);
} else {
    $pdf->Image(__DIR__.'../../image/square.png', 115,69,4,4);
}
$pdf->Text(121,72.5,'Abroad (Specify)');

$text = $leave['abroad_others'];
$pdf->Image(__DIR__.'../../image/line.png', 120,80,83,0.6);
$pdf->Text(121,80,$text);


$pdf->SetFont('Arial','B',8);
$pdf->Text(110,85,'(2) In case of sick leave');


if($leave['sick_loc'] == 'in_hostpital'){
    $pdf->Image(__DIR__.'../../image/check.png', 115,87,4,4);
} else {
    $pdf->Image(__DIR__.'../../image/square.png', 115,87,4,4);
}
$pdf->Text(126,90,'In Hospital (Specify)');

$text = $leave['in_hospital_specify'];
$pdf->Image(__DIR__.'../../image/line.png', 115,95,83,0.6);
$pdf->Text(121,95,$text);


if($leave['sick_loc'] == 'out_patient'){
    $pdf->Image(__DIR__.'../../image/check.png', 115,97,4,4);
} else {
    $pdf->Image(__DIR__.'../../image/square.png', 115,97,4,4);
}
$pdf->Text(121,100,'Out - Patient (Specify)');

$text = $leave['out_patient_specify'];
$pdf->Image(__DIR__.'../../image/line.png', 115,105,83,0.6);
$pdf->Text(121,107,$text);


?>