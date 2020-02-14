<?php
$st = $pdo->prepare("SELECT 
                                    lea.*,pi.vacation_balance,pi.sick_balance 
                                    FROM dohdtr.`leave` lea 
                                    join pis.personal_information pi on pi.userid = lea.userid
                                    WHERE lea.id = :id
                              ");
$st->bindParam(":id",$id,PDO::PARAM_INT);
$st->execute();
$leave = $st->fetch(PDO::FETCH_ASSOC);
$pdf->setX('5');
$pdf->Text(5,7,'CSC Form 6');
$pdf->Text(5,9,'Revised 1998');

// ROW 1
$pdf->SetFont('Arial','B',15);
$pdf->Cell(200,6,'APPLICATION FOR LEAVE',1,'','C');
$pdf->Ln();
//ROW 2
$pdf->setX('5');
$pdf->SetFont('Arial','B',8);

$pdf->Cell(65,13,'',1,'','C');

$pdf->Text(7,20,'(1.) Office / Agency');
$pdf->Text(12,25,$leave['office_agency']);

$pdf->Cell(135,13,'',1,'','C');

$pdf->Text(80,20,'(2.) Name');
$pdf->Text(110,20,'(Last)');
$pdf->Text(150,20,'(First)');
$pdf->Text(180,20,'(MI.)');


// SAMPLE DATA
$pdf->Text(110,25,$leave['lastname']);
$pdf->Text(150,25,$leave['firstname']);
$pdf->Text(180,25,$leave['middlename']);

$pdf->Ln();
//ROW 3
$pdf->setX('5');
$pdf->Cell(65,13,'',1,'','C');
$pdf->Cell(70,13,'',1,'','C');
$pdf->Cell(65,13,'',1,'','C');

$pdf->Text(7,33,'(3.) Date of Filling');
$pdf->Text(75,33,'(4.) Position');
$pdf->Text(145,33,'(5.) Salary (Monthly)');

// SAMPLE DATA

$date_time = new DateTime($leave['date_filling']);
$date = $date_time->format('M')." ".$date_time->format('d') .", ". $date_time->format('Y');
$pdf->Text(17,37,$date);
$pdf->Text(80,37,$leave['position']);
$pdf->Text(150,37,number_format($leave['salary'],2));

?>