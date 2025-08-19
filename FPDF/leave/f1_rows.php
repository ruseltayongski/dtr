<?php
try{
    $pdo = new PDO("mysql:host=192.168.110.31; dbname=dohdtr",'rtayong_31','rtayong_31');
//    $pdo = new PDO("mysql:host=localhost; dbname=dohdtr",'root','D0h7_1T');
    $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    $query = "SELECT lea.*, pi.vacation_balance, pi.sick_balance FROM dohdtr.`leave` lea JOIN pis.personal_information pi ON pi.userid = lea.userid WHERE lea.id = :id";
    $st = $pdo->prepare($query);
    $st->bindParam(":id", $id, PDO::PARAM_INT);
    $st->execute();
    $leave = $st->fetch(PDO::FETCH_ASSOC);

    $dates_q = "SELECT * FROM dohdtr.`leave_applied_dates` WHERE leave_id = :id AND status != 1";
    $dates_st = $pdo->prepare($dates_q);
    $dates_st->bindParam(":id", $id, PDO::PARAM_INT);
    $dates_st->execute();
    $leave_dates= $dates_st->fetchAll(PDO::FETCH_ASSOC);



    $officer_1 = "SELECT dts.fname, dts.lname, dts.mname FROM dohdtr.`leave` lea JOIN dts.users dts ON dts.id = lea.officer_1 WHERE lea.id = :id";
    $st = $pdo->prepare($officer_1);
    $st->bindParam(":id", $id, PDO::PARAM_INT);
    $st->execute();
    $officer_1 = $st->fetch(PDO::FETCH_ASSOC);

    $officer_2 = "SELECT dts.fname, dts.lname, dts.mname FROM dohdtr.`leave` lea JOIN dts.users dts ON dts.id = lea.officer_2 WHERE lea.id = :id";
    $st = $pdo->prepare($officer_2);
    $st->bindParam(":id", $id, PDO::PARAM_INT);
    $st->execute();
    $officer_2 = $st->fetch(PDO::FETCH_ASSOC);

    $officer_3 = "SELECT dts.fname, dts.lname, dts.mname FROM dohdtr.`leave` lea JOIN dts.users dts ON dts.id = lea.officer_3 WHERE lea.id = :id";
    $st = $pdo->prepare($officer_3);
    $st->bindParam(":id", $id, PDO::PARAM_INT);
    $st->execute();
    $officer_3 = $st->fetch(PDO::FETCH_ASSOC);

    $dates = [];
    $length = count($leave_dates);
    $check=[];

    if ($length > 0) {
        $start = ($leave_dates[0]['status'] != 2)?$leave_dates[0]['startdate']: $leave_dates[0]['from_date'];
        $initial_date = ($leave_dates[0]['status'] != 2)?$leave_dates[0]['startdate']: $leave_dates[0]['from_date'];

        foreach ($leave_dates as $index => $date) {
            $start_date = ($date['status'] != 2)?$date['startdate']:$date['from_date'];
            $end_date = ($date['status'] != 2)?$date['enddate']:$date['to_date'];

            if ($start_date == $end_date) {
                if ($index + 1 != $length) {
                    $current_date = new DateTime($initial_date);
                    $next_date = ($leave_dates[$index + 1]['status'] != 2)? new DateTime($leave_dates[$index + 1]['startdate']) : new DateTime($leave_dates[$index + 1]['from_date']);
                    $diff = $next_date->diff($current_date)->days;

                    if ($diff == 1) {
                        $start_date = $current_date->format('Y-m-d');
                        $end_date = $next_date->format('Y-m-d');
                        $initial_date = ($date['status'] != 2)?$leave_dates[$index + 1]['startdate'] :$leave_dates[$index + 1]['from_date'];
                        $check[] = 'check1 '.$diff. $start_date .$end_date;
                    } else {
                        $dates[] = $start . ' - ' . $end_date;
                        $start = ($leave_dates[$index + 1]['status'] != 2)?$leave_dates[$index + 1]['startdate'] :$leave_dates[$index + 1]['from_date'];
                        $initial_date = ($leave_dates[$index + 1]['status'] != 2)?$leave_dates[$index + 1]['startdate'] :$leave_dates[$index + 1]['from_date'];
                        $check[] = 'check2 '.$diff . $start. $initial_date.'---'.$date['status'];

                    }
                } else {
                    $dates[] = $start . ' - ' . $end_date;
                }
            } else {
                $dates[] = $start_date . ' - ' . $end_date;
            }
        }
    }

//    var_dump($leave['route_no']);
}catch (Exception $e){
    // var_dump(1);
}   

// var_dump($dates);

// $imagePath = __DIR__ . '\FPDF\image\doh.png';
// $imagePath =realpath(__DIR__ . '/../../..').'\public\img\doh.png';
//$imagePath = 'C:/Apache24/htdocs/dtr/FPDF/image/doh.png';
$imagePath = 'C:/xampp_7/htdocs/dtr/FPDF/image/doh.png';

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