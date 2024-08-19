<?php

$pdf->Ln();
$pdf->setX('15');
$pdf->Cell(97.5,35,'',1);
$pdf->Cell(82.5,35,'',1);
//
$pdf->SetFont('Arial','',8);
$pdf->Text(16,183,'6.C NUMBER OF WORKING DAYS APPLIED FOR');
$pdf->Text(50,188.5, (int) $leave['applied_num_days']);
$pdf->Image(__DIR__.'../../image/line.png', 22,188.5,82.7,0.6);

$pdf->Text(22,194.5,'INCLUSIVE DATES :');
//$pdf->SetFont('Arial','',8);
$y = 202;
$yy = 203;
$x = 22;
$date_list = [];
foreach ($dates as $index => $date) {
    $check = 0;
    $this_date = explode(' - ', $date);
    $start = date('F j, Y', strtotime($this_date[0]));
    $end = date('F j, Y',strtotime($this_date[1]));
    if($start == $end){
        $pdf->Text($x,$y,$start .' , ');
        $pdf->Image(__DIR__.'../../image/line.png', 22,$yy,82.7,0.6);
    }else{
        $date_from = date('Y-m-d', strtotime($this_date[0]));
        $date_to = date('Y-m-d', strtotime($this_date[1]));
        if(date('F', strtotime($date_from)) == date('F', strtotime($date_to))){
            $display_date = date('F', strtotime($date_from)) .' '. date('d', strtotime($date_from)) .'-'.  date('d', strtotime($date_to)) . ", ". date('Y', strtotime($date_to));
        }else{
//            $index = $index +1;
            $check = 1;
            $display_date = date('F j, Y', strtotime($this_date[0])).' - '.date('F j, Y',strtotime($this_date[1]));
        }
        $date_list[] = $display_date;
//        $pdf->Text($x   ,$y,$display_date .', ');
//        $pdf->Image(__DIR__.'../../image/line.png', 22,$yy,82.7,0.6);
    }
}
$pdf->SetXY(21, 198); // Set the position
$pdf->SetFont('Arial','BU',8);
$pdf->MultiCell(90, 5, implode(', ', $date_list), 0, 'L');

$pdf->SetFont('Arial','',8);
$pdf->SetXY(22, 208);
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