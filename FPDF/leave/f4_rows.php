<?php




$pdf->Ln();
$pdf->SetFont('Arial','B',15);
$pdf->Cell(195,6,'DETAILS OF ACTION ON APPLICATION',1,'','C');

$pdf->Ln();
$pdf->Cell(97.5,60,'',1);
$pdf->Cell(97.5,60,'',1);


$pdf->SetFont('Arial','B',8);
$pdf->Text(11,154,'(7. A) Certification of Leave Credits');
$pdf->Text(19,159,'as of ');
$pdf->Image(__DIR__.'../../image/line.png',27,159,60,0.6);

$pdf->Image(__DIR__.'../../image/table.png',30,163,55,25);


$pdf->Text(39,204,'REBECCA Q. BULAWAN ');
$pdf->Image(__DIR__.'../../image/line.png',26,205,60,0.6);
$pdf->Text(42,208,'Authorized Official');

$pdf->SetFont('Arial','B',8);
$pdf->Text(109,154,'(7. B) Recommendation:');

if(false){
    $pdf->Image(__DIR__.'../../image/check.png', 117,160,4,4);
} else {
    $pdf->Image(__DIR__.'../../image/square.png', 117,160,4,4);
}
$pdf->Text(123,163,'Approval');

if(false){
    $pdf->Image(__DIR__.'../../image/check.png', 117,165,4,4);
} else {
    $pdf->Image(__DIR__.'../../image/square.png', 117,165,4,4);
}
$pdf->Text(123,168,'Disapproval');
$pdf->Text(123,173,'Due to:');

$pdf->Text(140,204,'Name of Authorize');
$pdf->Image(__DIR__.'../../image/line.png',123,205,60,0.6);
$pdf->Text(140,208,'Authorized Official');


?>