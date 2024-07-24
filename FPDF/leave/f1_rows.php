<?php
try{
    $pdo = new PDO("mysql:host=localhost; dbname=dohdtr",'root','D0h7_1T');
    $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    $query = "SELECT lea.*, pi.vacation_balance, pi.sick_balance FROM dohdtr.`leave` lea JOIN pis.personal_information pi ON pi.userid = lea.userid WHERE lea.id = :id";
    $st = $pdo->prepare($query);
    $st->bindParam(":id", $id, PDO::PARAM_INT);
    $st->execute();
    $leave = $st->fetch(PDO::FETCH_ASSOC);

    $dates_q = "SELECT * FROM dohdtr.`leave_applied_dates` WHERE leave_id = :id";
    $dates_st = $pdo->prepare($dates_q);
    $dates_st->bindParam(":id", $id, PDO::PARAM_INT);
    $dates_st->execute();
    $applied_dates= $dates_st->fetchAll(PDO::FETCH_ASSOC);
//    var_dump($leave['route_no']);
}catch (Exception $e){

}

//$imagePath = __DIR__ . '/FPDF/image/doh.png';
$imagePath = 'C:/xampp_7/htdocs/dtr/FPDF/image/doh.png';

//echo "okiii".$imagePath;

$pdf->setX('15');
$pdf->Text(15,15,'CSC Form No.6');
$pdf->Text(15,18,'Revised 2020');
$pdf->Image($imagePath, 40, 20, 20, 20);
$pdf->SetFont('Arial','',8);
$pdf->Text(92,25,'Republic of the Philippines');
$pdf->Text(96,29,'Department of Health');
$pdf->SetFont('Arial','B',8);
$pdf->Text(70,33,'CENTRAL VISAYAS CENTER for HEALTH DEVELOPMENT');
$pdf->SetFont('Arial','I',8);
$pdf->Text(77,37,utf8_decode('Osmeña Boulevard, Cebu City, 6000 Philippines'));
$pdf->SetFont('Arial','',8);
$pdf->Text(165,29,'__________________');
$pdf->Text(169,33,'Date of Receipt');
//// ROW 1
//$pdf->setX(100);
$pdf->setY($pdf->getY()+27);
$pdf->SetFont('Arial','B',14);
$pdf->Cell(200,16,'APPLICATION FOR LEAVE',0,'','C');
$pdf->Ln();
$pdf->setY($pdf->getY()-3);

//ROW 2

$pdf->setX('15');
$pdf->SetFont('Arial','',8);
$pdf->Cell(65,11,'',1,'','C');

$pdf->Text(17,54.5,'1. OFFICE/DEPARTMENT');
$pdf->Text(25,58,$leave['office_agency']);
$pdf->Cell(115,11,'',1,'','C');
$pdf->Text(83,54.5,'2. NAME');
$pdf->Text(102,54.5,'(Last)');
$pdf->Text(138,54.5,'(First)');
$pdf->Text(168,54.5,'(Middle)');
$pdf->Text(102,58,$leave['lastname']);
$pdf->Text(138,58,$leave['firstname']);
$pdf->Text(168,58,$leave['middlename']);
$pdf->Ln();
//ROW 3
$pdf->setX('15');
$pdf->Cell(65,11,'',1,'','C');
$pdf->Cell(115,11,'',1,'','C');
$pdf->Text(17,67,'3. DATE OF FILING');
$pdf->Text(82,67,'4. POSITION');
$pdf->Text(150,67,'5. SALARY');

$date_time = new DateTime($leave['date_filling']);
$date = $date_time->format('M')." ".$date_time->format('d') .", ". $date_time->format('Y');
$pdf->Text(47,67,$date);
$pdf->Image(__DIR__.'../../image/line.png', 45,68,30,0.6);
$pdf->Text(102,67,$leave['position']);
$pdf->Image(__DIR__.'../../image/line.png', 100,68,45,0.6);
$pdf->Text(170,67,number_format($leave['salary'],2));
$pdf->Image(__DIR__.'../../image/line.png', 165,68,25,0.6);

?>