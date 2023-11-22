<?php
try{
    $pdo = new PDO("mysql:host=localhost; dbname=dohdtr",'root','adm1n');
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
$imagePath = 'C:/xampp/htdocs/dtrLatest/FPDF/image/doh.png';

//echo "okiii".$imagePath;

$pdf->setX('5');
$pdf->Text(5,7,'CSC Form No.6');
$pdf->Text(5,9,'Revised 2020');
$pdf->Image($imagePath, 40, 10, 20, 20);
$pdf->SetFont('Arial','',8);
$pdf->Text(92,15,'Republic of the Philippines');
$pdf->Text(96,19,'Department of Health');
$pdf->SetFont('Arial','B',8);
$pdf->Text(70,23,'CENTRAL VISAYAS CENTER for HEALTH DEVELOPMENT');
$pdf->SetFont('Arial','I',8);
$pdf->Text(77,27,utf8_decode('Osmeña Boulevard, Cebu City, 6000 Philippines'));
$pdf->SetFont('Arial','',8);
$pdf->Text(165,19,'__________________');
$pdf->Text(169,23,'Date of Receipt');
// ROW 1
//$pdf->setX(100);
$pdf->setY($pdf->getY()+20);
$pdf->SetFont('Arial','B',14);
$pdf->Cell(200,6,'APPLICATION FOR LEAVE',0,'','C');
$pdf->Ln();
$pdf->setY($pdf->getY()+2);
//ROW 2

$pdf->setX('5');

$pdf->SetFont('Arial','',8);

$pdf->Cell(65,11,'',1,'','C');

$pdf->Text(7,42,'1. OFFICE/DEPARTMENT');
$pdf->Text(12,47,$leave['office_agency']);

$pdf->Cell(135,11,'',1,'','C');

$pdf->Text(73,42,'2. NAME');
$pdf->Text(102,42,'(Last)');
$pdf->Text(138,42,'(First)');
$pdf->Text(168,42,'(Middle)');


// SAMPLE DATA
$pdf->Text(102,47,$leave['lastname']);
$pdf->Text(138,47,$leave['firstname']);
$pdf->Text(168,47,$leave['middlename']);

$pdf->Ln();
//ROW 3
$pdf->setX('5');
$pdf->Cell(65,11,'',1,'','C');
$pdf->Cell(135,11,'',1,'','C');

$pdf->Text(7,55,'3. DATE OF FILING');
$pdf->Text(72,55,'4. POSITION');
$pdf->Text(150,55,'5. SALARY');

// SAMPLE DATA

$date_time = new DateTime($leave['date_filling']);
$date = $date_time->format('M')." ".$date_time->format('d') .", ". $date_time->format('Y');
$pdf->Text(42,55,$date);
$pdf->Image(__DIR__.'../../image/line.png', 32,56,33,0.6);
$pdf->Text(95,55,$leave['position']);
$pdf->Image(__DIR__.'../../image/line.png', 86,56,50,0.6);
$pdf->Text(175,55,number_format($leave['salary'],2));
$pdf->Image(__DIR__.'../../image/line.png', 165,56,30,0.6);

?>