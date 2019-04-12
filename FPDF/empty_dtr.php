<?php
$this->Image(__DIR__.'/image/doh2.png', 15, 50,80,80);
$this->Image(__DIR__.'/image/doh2.png', 118, 50,80,80);
$this->SetFont('Arial','',8);
$this->SetX(10);
$this->Cell(40,10,'Civil Service Form No. 43',0);
$this->SetX(70);
$this->Cell(40,10,'Printed : '. date('Y-m-d'),0);

$this->SetX(112);
$this->Cell(40,10,'Civil Service Form No. 43',0);
$this->SetX(-40);
$this->Cell(40,10,'Printed : '.date('Y-m-d') ,0);

$this->Ln(5);
$this->SetFont('Arial','',10);
$this->SetXY(35,15);
$this->Cell(40,10,'DAILY TIME RECORD',0);

$this->SetFont('Arial','B',10);
$this->SetXY(25,22);
$this->Cell(60,10,'                  '.$name.'                  ',0,1,'C');

$this->SetFont('Arial','BU',8);
$this->SetXY(51,22);
$this->Cell(5,10,'                                                                                                             ',0,0,'C');


$this->SetFont('Arial','',8);
$this->SetXY(10,28);
$this->Cell(40,10,'For the month of : ',0);

$this->SetFont('Arial','B',9);
$this->SetXY(33,28);
$this->Cell(40,10,date("M",strtotime($date_from)).' '. $day1[2].'-'.$day2[2].'  '.$day2[0],0);


$this->SetFont('Arial','',8);
$this->SetXY(60,28);
$this->Cell(40,10,'ID No :',0);

$this->SetFont('Arial','B',9);
$this->SetXY(70,28);
$this->Cell(40,10,$userid,0);

$this->SetFont('Arial','',8);
$this->SetXY(10,33);
$this->Cell(40,10,'Official hours for (days A.M. P.M. arrival and departure)',0);



$this->SetFont('Arial','',10);
$this->SetXY(135,15);
$this->Cell(40,10,'DAILY TIME RECORD',0);

$this->SetFont('Arial','B',10);
$this->SetXY(135,22);
$this->Cell(40,10,'                  '.$name.'                  ',0,1,'C');


$this->SetFont('Arial','BU',8);
$this->SetXY(153,22);
$this->Cell(5,10,'                                                                                                             ',0,0,'C');



$this->SetFont('Arial','',8);
$this->SetXY(112,28);
$this->Cell(40,10,'For the month of : ',0);

$this->SetFont('Arial','B',9);
$this->SetXY(135,28);
$this->Cell(40,10,date("M",strtotime($date_from)).' '. $day1[2].'-'.$day2[2].'  '.$day2[0],0);

$this->SetFont('Arial','',8);
$this->SetXY(170,28);
$this->Cell(40,10,'ID No : ',0);

$this->SetFont('Arial','B',9);
$this->SetXY(179,28);
$this->Cell(40,10,$userid,0);

$this->SetFont('Arial','',8);
$this->SetXY(112,33);
$this->Cell(40,10,'Official hours for (days A.M. P.M. arrival and departure)',0);


$this->SetFont('Arial','',9);
$this->SetXY(10,42);
$this->Cell(89,5,'                     AM                             PM              UNDERTIME',1);


$this->SetFont('Arial','',7.5);
$this->SetXY(10,47);
$this->Cell(89,5,'  DAY     ARRIVAL | DEPARTURE   ARRIVAL | DEPARTURE   LATE | UT',1);

$this->SetFont('Arial', '', 7.5);
$this->SetXY(10,54);

$temp1 = -0;
$temp2 = -0;
$hol_index = 0;

    for($r1 = $startday; $r1 <= $endday; $r1++)
    {
        $r1 >= 1 && $r1 < 10 ? $zero='0' : $zero = '';
        $datein = $day1[0]."-".$day1[1]."-".$zero.$r1;

        $day_name = date('D', strtotime($datein));

        $am_in = '';
        $am_out = '';
        $pm_in = '';
        $pm_out = '';
        $late = '';

        $late = late($s_am_in,$s_pm_in,$am_in,$pm_in,$datein);
        if($late != '' or $late != null)
        {
            $late_total = $late_total + $late;
        }
        $ut = undertime($s_am_in,$s_pm_in,$am_in,$pm_in,$s_am_out,$s_pm_out,$am_out,$pm_out,$datein);
        if($ut != '' or $ut != null)
        {
            $ut_total = $ut_total + $ut;
        }


        $this->SetFont('Arial','',7);
        $this->Cell(4,5,$r1,'');
        $this->Cell(8,5,$day_name,'');

        $cto = null;
                        

        if($day_name == 'Sat' || $day_name == 'Sun' AND $am_in == '') $am_out = 'DAY OFF';
        if(isset($e1) and $e1 == "1"){
            $this->SetFont('Arial','U',8);
        } else {
            $this->SetFont('Arial','',8);
        }

        $this->Cell($w[1],5,$am_in,'');
        $this->SetTextColor(0,0,0);

        

        $this->SetFont('Arial','',8);
        if($day_name == 'Sat' || $day_name == 'Sun' AND $am_in == '' AND $am_out == '') $am_out = 'DAY OFF';
        if(isset($e2) and $e2 == "1"){
            $this->SetFont('Arial','U',8);
        } else {
            $this->SetFont('Arial','',8);
        }

        $this->Cell($w[1],5,$am_out,'');
        $this->SetTextColor(0,0,0);

        if($day_name == 'Sat' || $day_name == 'Sun' AND $am_in == '' AND $am_out == '' AND $pm_in == '') $am_out = 'DAY OFF';
        if(isset($e3) and $e3 == "1"){
            $this->SetFont('Arial','U',8);
        } else {
            $this->SetFont('Arial','',8);
        }

        $this->Cell(14,5,$pm_in,'',0,'R');
        $this->SetTextColor(0,0,0);

        if($day_name == 'Sat' || $day_name == 'Sun' AND $am_in == '' AND $am_out == '' AND $pm_in == '' AND $pm_out == '') $am_out = 'DAY OFF';
        if(isset($e4) and $e4 == "1") {
            $this->SetFont('Arial','U',8);
        } else {
            $this->SetFont('Arial','',8);
        }

        $this->Cell(15,5,$pm_out,'',0,'R');
        $this->SetTextColor(0,0,0);



        //LATE/UNDERTIME
        //$this->Cell($w[3],5,"$late       $ut",'',0,'R');
        $this->SetFont('Arial','',8);
        $this->Cell(8,5,$late,'',0,'R');
        $this->Cell(9,5,$ut,'',0,'R');


        $this->Cell(14.5);
        $this->SetFont('Arial','',7);
        $this->Cell(4,5,$r1,'');
        $this->Cell(9,5,$day_name,'');

        if(isset($e1) and $e1 == "1"){
            $this->SetFont('Arial','U',8);
        } else {
            $this->SetFont('Arial','',8);
        }
        $this->Cell($w[1],5,$am_in,'');
        $this->SetTextColor(0,0,0);

        if(isset($e2) and $e2 == "1"){
            $this->SetFont('Arial','U',8);
        } else {
            $this->SetFont('Arial','',8);
        }
        $this->Cell($w[1],5,$am_out,'');
        $this->SetTextColor(0,0,0);

        if(isset($e3) and $e3 == "1"){
            $this->SetFont('Arial','U',8);
        } else {
            $this->SetFont('Arial','',8);
        }
        $this->Cell($w[2],5,$pm_in,'',0,'R');
        $this->SetTextColor(0,0,0);

        if(isset($e4) and $e4 == "1"){
            $this->SetFont('Arial','U',8);
        } else {
            $this->SetFont('Arial','',8);
        }
        $this->Cell($w[3],5,$pm_out,'',0,'R');
        $this->SetTextColor(0,0,0);


        //LATE/UNDERTIME
        $this->SetFont('Arial','',8);
        //$this->Cell($w[3],5,"$late       $ut",'',0,'R');
        $this->Cell(8,5,$late,'',0,'R');
        $this->Cell(8,5,$ut,'',0,'R');

        $late = '';
        $ut = '';

        $e1 = '';
        $e2 = '';
        $e3 = '';
        $e4 = '';

        $this->Ln();
        if($r1 == $endday)
        {
            $this->SetFont('Arial','BU',8);
            $this->SetX(52);
            $this->Cell(5,0,'                                                                                                                   ',0,0,'C');

            $this->SetX(154);
            $this->Cell(5,0,'                                                                                                                   ',0,0,'C');
            $this->Ln();

            $this->SetFont('Arial','',9);
            $this->Cell(10,7,'TOTAL',0,0,'C');
            $this->SetFont('Arial','',8);

            $this->SetX(85);
            $this->Cell(5,7,$late_total,0,0,'C');

            $this->SetX(93);
            $this->Cell(5,7,$ut_total,0,0,'C');


            $this->SetX(113);
            $this->Cell(10,7,'TOTAL',0,0,'C');

            $this->SetX(188);
            $this->Cell(5,7,$late_total,0,0,'C');

            $this->SetX(195);
            $this->Cell(5,7,$ut_total,0,0,'C');


            $this->Ln();

            $this->SetFont('Arial','',7);
            $this->SetX(45);
            $this->Cell(10,3,'      I CERTIFY on my honor that the above entry is true and correct report',0,0,'C');
            $this->SetX(148);
            $this->Cell(10,3,'      I CERTIFY on my honor that the above entry is true and correct report',0,0,'C');
            $this->Ln();
            $this->SetX(40);
            $this->Cell(10,3,'              of the hours work performed, record of which was made daily at the time',0,0,'C');
            $this->SetX(144);
            $this->Cell(10,3,'              of the hours work performed, record of which was made daily at the time',0,0,'C');
            $this->Ln();
            $this->SetX(25);
            $this->Cell(10,2,'     of arrival and departure from the office.',0,0,'C');
            $this->SetX(129);
            $this->Cell(10,2,'     of arrival and departure from the office.',0,0,'C');


            $this->Ln();
            $this->Ln();
            $this->Ln();

            $this->SetFont('Arial','BU',8);

            $this->SetX(9);
            $this->Cell(90,10,$name,0,0,'C');

            $this->SetX(9);
            $this->Cell(90,10,'                                                                                                                  ',0,0,'C');

            $this->SetX(112);
            $this->Cell(90,10,$name,0,0,'C');


            $this->SetX(112);
            $this->Cell(90,10,'                                                                                                                  ',0,0,'C');
            $this->Ln();

            $this->SetFont('Arial','',8);
            $this->SetX(9);
            $this->Cell(90,0,'Verified as to the prescribed office hours',0,0,'C');


            $this->SetX(112);
            $this->Cell(90,0,'Verified as to the prescribed office hours',0,0,'C');
            $this->Ln();

            $this->SetFont('Arial','BU',8);

            $this->SetX(9);
            $this->Cell(90,20,'                                                                                                                  ',0,0,'C');

            $this->SetX(112);
            $this->Cell(90,20,'                                                                                                                   ',0,0,'C');
            $this->Ln();

            $this->SetFont('Arial','',8);

            $this->SetX(9);
            $this->Cell(90,0,'IN-CHARGE',0,0,'C');

            $this->SetX(112);
            $this->Cell(90,0,'IN-CHARGE',0,0,'C');

        }

}

$this->SetFont('Arial','',9);
$this->SetXY(112,42);
$this->Cell(89,5,'                     AM                              PM              UNDERTIME',1);

$this->SetFont('Arial','',7.5);
$this->SetXY(112,47);
$this->Cell(89,5,'  DAY     ARRIVAL | DEPARTURE   ARRIVAL | DEPARTURE   LATE | UT',1);
$this->Ln(500);

?>