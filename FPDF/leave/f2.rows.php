<?php


$pdf->Ln();
$pdf->SetFont('Arial','B',15);
$pdf->Cell(195,6,'DETAILS OF APPLICATIONS',1,'','C');

$pdf->Ln();
$pdf->Cell(97.5,65,'',1);
$pdf->Cell(97.5,65,'',1);

$pdf->SetFont('Arial','B',8);
$pdf->Text(11,54,'(6.A) TYPE OF LEAVE');


if($leave['leave_type'] == 'Vication'){
    $pdf->Image(__DIR__.'../../image/check.png', 20,60,4,4);
} else {
    $pdf->Image(__DIR__.'../../image/square.png', 20,60,4,4);
}

$pdf->Text(26,63,'VICATION');

if($leave['leave_type'] == 'To_sake_employement'){
    $pdf->Image(__DIR__.'../../image/check.png', 20,65,4,4);
} else {
    $pdf->Image(__DIR__.'../../image/square.png', 20,65,4,4);
}
$pdf->Text(26,68,'TO SAKE EMPLOYMENT');

if($leave['leave_type'] == 'Others'){
    $pdf->Image(__DIR__.'../../image/check.png', 20,70,4,4);
} else {
    $pdf->Image(__DIR__.'../../image/square.png', 20,70,4,4);
}
$pdf->Text(26,73,'OTHERS (Specify)');

$text = $leave['leave_type_others_1'];
$pdf->Image(__DIR__.'../../image/line.png', 20,81,83,0.6);
$pdf->Text(26,80,$text);

if($leave['leave_type'] == 'Sick'){
    $pdf->Image(__DIR__.'../../image/check.png', 20,85,4,4);
} else {
    $pdf->Image(__DIR__.'../../image/square.png', 20,85,4,4);
}
$pdf->Text(26,88.3,'SICK');


if($leave['leave_type'] == 'Maternity'){
    $pdf->Image(__DIR__.'../../image/check.png', 20,90,4,4);
} else {
    $pdf->Image(__DIR__.'../../image/square.png', 20,90,4,4);
}
$pdf->Text(26,93.3,'MATERNITY');


if($leave['leave_type'] == 'Others2'){
    $pdf->Image(__DIR__.'../../image/check.png', 20,95,4,4);
} else {
    $pdf->Image(__DIR__.'../../image/square.png', 20,95,4,4);
}

$pdf->Text(26,98,'OTHERS (Specify)');
$text = $leave['leave_type_others_2'];
$pdf->Image(__DIR__.'../../image/line.png', 20,106,83,0.6);
$pdf->Text(26,105,$text);

// LEFT PAIN

$pdf->SetFont('Arial','B',8);
$pdf->Text(108,54,'(6.B) WHERE LEAVE WILL BE SPENT');

$pdf->SetFont('Arial','B',8);
$pdf->Text(115,62,'(1) In case of vaction leave');


if($leave['vication_loc'] == 'local'){
    $pdf->Image(__DIR__.'../../image/check.png', 120,64,4,4);
} else {
    $pdf->Image(__DIR__.'../../image/square.png', 120,64,4,4);
}
$pdf->Text(126,67,'Within the Philippines');

if($leave['vication_loc'] == 'abroad'){
    $pdf->Image(__DIR__.'../../image/check.png', 120,69,4,4);
} else {
    $pdf->Image(__DIR__.'../../image/square.png', 120,69,4,4);
}
$pdf->Text(126,72.5,'Abroad (Specify)');

$text = $leave['abroad_others'];
$pdf->Image(__DIR__.'../../image/line.png', 120,80,83,0.6);
$pdf->Text(126,80,$text);


$pdf->SetFont('Arial','B',8);
$pdf->Text(115,85,'(2) In case of sick leave');


if($leave['sick_loc'] == 'in_hostpital'){
    $pdf->Image(__DIR__.'../../image/check.png', 120,87,4,4);
} else {
    $pdf->Image(__DIR__.'../../image/square.png', 120,87,4,4);
}
$pdf->Text(126,90,'In Hospital (Specify)');

$text = $leave['in_hospital_specify'];
$pdf->Image(__DIR__.'../../image/line.png', 120,95,83,0.6);
$pdf->Text(126,95,$text);


if($leave['sick_loc'] == 'out_patient'){
    $pdf->Image(__DIR__.'../../image/check.png', 120,97,4,4);
} else {
    $pdf->Image(__DIR__.'../../image/square.png', 120,97,4,4);
}
$pdf->Text(126,100,'Out - Patient (Specify)');

$text = $leave['out_patient_specify'];
$pdf->Image(__DIR__.'../../image/line.png', 120,105,83,0.6);
$pdf->Text(126,107,$text);


?>