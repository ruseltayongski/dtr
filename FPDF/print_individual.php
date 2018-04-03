

<?php

require('dbconn.php');

require('fpdf.php');
ini_set('max_execution_time', 0);
ini_set('memory_limit','1000M');
ini_set('max_input_time','300000');


class PDF extends FPDF
{
    private $empname = "";
// Page header

    function form($name,$userid,$date_from,$date_to,$sched)
    {

        $day1 = explode('-',$date_from);
        $day2 = explode('-',$date_to);

        $startday = floor($day1[2]);
        $endday = $day2[2];

        //echo date("M",strtotime($date_from)).' '. $day1[2].'-'.$day2[2].'  '.$day2[0];
        $late_total = 0;
        $ut_total = 0;
        $late = '';
        $ut = '';

        $w = array(10,15,15,15,15);
        $index = 0;
        $log_date = "";
        $log = "";
        $holidays = "";
        $pdo = conn();
        $query = "SELECT * FROM work_sched WHERE id = '".$sched ."' LIMIT 1";
        $st = $pdo->prepare($query);
        $st->execute();
        $sched = $st->fetch(PDO::FETCH_ASSOC);
        if(isset($sched) and count($sched) > 0) {
            $s_am_in = $sched["am_in"];
            $s_am_out =  $sched["am_out"];
            $s_pm_in = $sched["pm_in"];
            $s_pm_out = $sched["pm_out"];


            $logs = get_logs($s_am_in,$s_am_out,$s_pm_in,$s_pm_out,$userid,$date_from,$date_to);

            if(count($logs) <= 0) {
                include_once('empty_dtr.php');
            } else {

                $this->Image(__DIR__.'/image/doh2.png', 15, 50,80,80);
                $this->Image(__DIR__.'/image/doh2.png', 118, 50,80,80);

                $this->SetFont('Arial','',8);
                $this->SetX(10);
                $this->Cell(40,10,'Civil Service Form No. 48',0);
                $this->SetX(70);
                $this->Cell(40,10,'Printed : '. date('Y-m-d'),0);

                $this->SetX(112);
                $this->Cell(40,10,'Civil Service Form No. 48',0);
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


                if(isset($logs) and count($logs))
                {
                    for($r1 = $startday; $r1 <= $endday; $r1++)
                    {
                        $r1 >= 1 && $r1 < 10 ? $zero='0' : $zero = '';
                        $datein = $day1[0]."-".$day1[1]."-".$zero.$r1;

                        if($index != count($logs)) {
                            if($datein == $logs[$index]['datein']){
                                $log_date = $logs[$index]['datein'];
                                $log = $logs[$index];
                                $index = $index + 1;
                            }
                        }
                        $day_name = date('D', strtotime($datein));
                        if($datein == $log_date)
                        {

                            $am_in = $log['am_in'];
                            $am_out = $log['am_out'];
                            $pm_in = $log['pm_in'];
                            $pm_out = $log['pm_out'];


                            if($am_in and $am_out and $pm_in and !$pm_out) {
                                if($am_out > $pm_in) {
                                    $pm_in = null;
                                }
                            }
                            if($am_in and !$am_out and $pm_in and !$pm_out) {
                                if($pm_in > $am_in) {
                                    $pm_out = $pm_in;
                                    $pm_in = null;
                                } else {
                                    $pm_out = $pm_in;
                                    $pm_in = null;
                                }
                            }

                            if($am_in and $am_out and $pm_in and $pm_out) {
                                if($am_out > $pm_in) {
                                    $tmp = $am_out;
                                    $am_out = $pm_in;
                                    $pm_in = $tmp;
                                }
                            }
                            if($am_in and !$am_out and $pm_in and $pm_out) {
                                if($pm_in > $pm_out) {
                                    $pm_in = null;
                                }
                            }

                            if( ! ($pm_out >= $s_pm_in)) {
                                $pm_out = null;
                            }

                            if(isset($am_in)) {
                                $a = explode('_', $am_in);
                                $e1 = $a[1];
                                $am_in = $a[0];
                            } else {
                                $am_in = '';
                                $e1 = '';
                            }

                            if(isset($am_out)) {
                                $b = explode('_', $am_out);
                                $e2 = $b[1];
                                $am_out = $b[0];
                            } else {
                                $am_out = '';
                                $e2 = '';
                            }

                            if(isset($pm_in)) {
                                $c = explode('_', $pm_in);
                                $e3 = $c[1];
                                $pm_in = $c[0];
                            } else {
                                $pm_in = '';
                                $e3 = '';
                            }

                            if(isset($pm_out)) {
                                $d = explode('_', $pm_out);
                                $e4 = $d[1];
                                $pm_out = $d[0];
                            } else {
                                $pm_out = '';
                                $e4 = '';
                            }

                            if(!$log['holiday'] == '001' OR !$log['holiday'] == '003' OR !$log['holiday'] == '002') {

                                if($day_name == 'Mon') {
                                    $late = late('08:00:00',$s_pm_in,$am_in,$pm_in,$log['datein']);
                                } else {
                                    $late = late($s_am_in,$s_pm_in,$am_in,$pm_in,$log['datein']);
                                }
                                if($late != '' or $late != null)
                                {
                                    $late_total = $late_total + $late;
                                }
                                $ut = undertime($s_am_in,$s_pm_in,$am_in,$pm_in,$s_am_out,$s_pm_out,$am_out,$pm_out,$datein);
                                if($ut != '' or $ut != null)
                                {
                                    $ut_total = $ut_total + $ut;
                                }
                            } else {
                                /*CTO*/
                                if($log['holiday'] == '002') {
                                    $am_in = '';
                                    $am_out = $log['remark'];
                                    $pm_in = '';
                                    $pm_out = '';
                                    $late = '';
                                }
                                /*SO*/
                                elseif($log['holiday'] == '003') {
                                    $am_in = '';
                                    $am_out = 'SO:'.$log['remark'];
                                    $pm_in = '';
                                    $pm_out = '';
                                    $late = '';
                                }
                                /*LEAVE*/
                                elseif($log['holiday'] == '004') {
                                    $am_in = '';
                                    $am_out = 'LEAVE';
                                    $pm_in = '';
                                    $pm_out = '';
                                    $late = '';
                                }
                                /*HOLIDAY*/
                                elseif($log['holiday'] == '001') {
                                    $am_in = '';
                                    $am_out = 'HOLIDAY';
                                    $pm_in = '';
                                    $pm_out = '';
                                    $late = '';
                                }
                                /*ABSENT*/
                                elseif($log['holiday'] == '005') {
                                    $am_in = '';
                                    $am_out = $log['remark'];
                                    $pm_in = '';
                                    $pm_out = '';
                                    $late = '';
                                    $ut = '480';
                                } else if($log['holiday'] == '006') {
                                    $am_in = '';
                                    $am_out = $log['remark'];
                                    $pm_in = '';
                                    $pm_out = '';
                                    $late = '';
                                    $ut = '480';
                                }
                            }
                        } else {
                            $am_in = '';
                            $am_out = '';
                            $pm_in = '';
                            $pm_out = '';
                            $late = '';

                            if($day_name != 'Sat' and $day_name != 'Sun') {

                                $ut = undertime($s_am_in,$s_pm_in,$am_in,$pm_in,$s_am_out,$s_pm_out,$am_out,$pm_out,$datein);
                                if($ut != '' or $ut != null)
                                {
                                    $ut_total = $ut_total + $ut;
                                }
                            }
                        }

                        $this->SetFont('Arial','',7);
                        $this->Cell(4,5,$r1,'');
                        $this->Cell(8,5,$day_name,'');


                        $cto = null;
                        $so = null;
                        $edited_logs = null;



                        if(!$am_in AND !$am_out AND $pm_in AND $pm_out){
                            $cto = GET_CDO_SO($s_am_in,$s_am_out,$s_pm_in,$s_pm_out,$userid,$datein,'GETCDO');

                            if($cto['remark'] == 'CTO'){
                                $am_out = 'CTO';
                            } else {
                                $so = GET_CDO_SO($s_am_in,$s_am_out,$s_pm_in,$s_pm_out,$userid,$datein,'GETSO');
                                if($so['holiday'] === '003'){
                                    $am_in = "SO#:".$so['remark'];
                                    $am_out = "SO#:".$so['remark'];
                                } else {
                                    $leave = GET_CDO_SO($s_am_in,$s_am_out,$s_pm_in,$s_pm_out,$userid,$datein,'LEAVE_LOGS');
                                    if($leave['holiday'] == '007'){
                                        $am_in = $leave['remark'];
                                        $am_out = $leave['remark'];
                                    } else {
                                        $edited_logs = GET_CDO_SO($s_am_in,$s_am_out,$s_pm_in,$s_pm_out,$userid,$datein,'EDITED_LOGS');
                                        if($edited_logs) {
                                            $am_in =  $edited_logs['am_in'];
                                            $am_out =  $edited_logs['am_out'];


                                            if(isset($am_in)) {
                                                $a = explode('_', $am_in);
                                                $e1 = $a[1];
                                                $am_in = $a[0];
                                            } else {
                                                $am_in = '';
                                                $e1 = '';
                                            }

                                            if(isset($am_out)) {
                                                $b = explode('_', $am_out);
                                                $e2 = $b[1];
                                                $am_out = $b[0];
                                            } else {
                                                $am_out = '';
                                                $e2 = '';
                                            }
                                        }
                                    }

                                }
                            }
                        }else if(!$pm_in AND !$pm_out AND $am_in AND $am_out) {

                            $cto = GET_CDO_SO($s_am_in,$s_am_out,$s_pm_in,$s_pm_out,$userid,$datein,'GETCDO');

                            if($cto['remark'] == 'CTO'){
                                $pm_in = 'CTO';
                                $pm_out = 'CTO';
                            } else {
                                $so = GET_CDO_SO($s_am_in,$s_am_out,$s_pm_in,$s_pm_out,$userid,$datein,'GETSO');
                                if($so['holiday'] ==='003'){
                                    $pm_in = "SO#:".$so['remark'];
                                    $pm_out = "SO#:".$so['remark'];
                                } else {
                                    $leave = GET_CDO_SO($s_am_in,$s_am_out,$s_pm_in,$s_pm_out,$userid,$datein,'LEAVE_LOGS');
                                    if($leave['holiday'] == '007'){
                                        $pm_in = $leave['remark'];
                                        $pm_out = $leave['remark'];
                                    } else {
                                        $edited_logs = GET_CDO_SO($s_am_in,$s_am_out,$s_pm_in,$s_pm_out,$userid,$datein,'EDITED_LOGS');
                                        if($edited_logs) {
                                            $pm_in = $edited_logs['pm_in'];
                                            $pm_out =  $edited_logs['pm_out'];

                                            if(isset($pm_in)) {
                                                $c = explode('_', $pm_in);
                                                $e3 = $c[1];
                                                $pm_in = $c[0];
                                            } else {
                                                $pm_in = '';
                                                $e3 = '';
                                            }

                                            if(isset($pm_out)) {
                                                $d = explode('_', $pm_out);
                                                $e4 = $d[1];
                                                $pm_out = $d[0];
                                            } else {
                                                $pm_out = '';
                                                $e4 = '';
                                            }
                                        }
                                    }

                                }
                            }
                        } else if(!$am_in AND !$am_out AND !$pm_in AND !$pm_out){

                            $cto = GET_CDO_SO($s_am_in,$s_am_out,$s_pm_in,$s_pm_out,$userid,$datein,'GETCDO');

                            if($cto['remark'] == 'CTO'){
                                if($cto['time_type'] == 'AM'){
                                    $am_in = 'CTO';
                                }elseif($cto['time_type'] == 'PM') {
                                    $pm_out = 'CTO';
                                }elseif($cto['time_type'] == 'WH'){
                                    $am_out = 'CTO';
                                }
                            } else {
                                
                                $so = GET_CDO_SO($s_am_in,$s_am_out,$s_pm_in,$s_pm_out,$userid,$datein,'GETSO');
                                if($so['holiday'] === '003'){
                                    if($so['time_type'] == 'WH') {
                                        $am_out = "SO#:".$so['remark'];
                                    } elseif($so['time_type'] == 'AM') {
                                        $am_in = "SO#:".$so['remark'];
                                        $am_out = "SO#:".$so['remark'];
                                    }elseif($so['time_type'] == 'PM') {
                                        $pm_in = "SO#:".$so['remark'];
                                        $pm_out = "SO#:".$so['remark'];
                                    }
                                } else {
                                    $leave = GET_CDO_SO($s_am_in,$s_am_out,$s_pm_in,$s_pm_out,$userid,$datein,'LEAVE_LOGS');
                                    if($leave['holiday'] == '007'){
                                        $am_out = $leave['remark'];
                                    }else {
                                        $edited_logs = GET_CDO_SO($s_am_in,$s_am_out,$s_pm_in,$s_pm_out,$userid,$datein,'EDITED_LOGS');
                                        if($edited_logs) {
                                            $am_in =  $edited_logs['am_in'];
                                            $am_out =  $edited_logs['am_out'];
                                            $pm_in =  $edited_logs['pm_in'];
                                            $pm_out =  $edited_logs['pm_out'];

                                            if(isset($am_in)) {
                                                $a = explode('_', $am_in);
                                                $e1 = $a[1];
                                                $am_in = $a[0];
                                            } else {
                                                $am_in = '';
                                                $e1 = '';
                                            }

                                            if(isset($am_out)) {
                                                $b = explode('_', $am_out);
                                                $e2 = $b[1];
                                                $am_out = $b[0];
                                            } else {
                                                $am_out = '';
                                                $e2 = '';
                                            }

                                            if(isset($pm_in)) {
                                                $c = explode('_', $pm_in);
                                                $e3 = $c[1];
                                                $pm_in = $c[0];
                                            } else {
                                                $pm_in = '';
                                                $e3 = '';
                                            }

                                            if(isset($pm_out)) {
                                                $d = explode('_', $pm_out);
                                                $e4 = $d[1];
                                                $pm_out = $d[0];
                                            } else {
                                                $pm_out = '';
                                                $e4 = '';
                                            }
                                        }
                                    }

                                }
                            }
                        } else if($am_in AND $am_out AND $pm_in AND !$pm_out) {
                            $cto = GET_CDO_SO($s_am_in,$s_am_out,$s_pm_in,$s_pm_out,$userid,$datein,'GETCDO');

                            if($cto['remark'] == 'CTO'){
                                $pm_out = 'CTO';
                            } else {
                                $so = GET_CDO_SO($s_am_in,$s_am_out,$s_pm_in,$s_pm_out,$userid,$datein,'GETSO');
                                if($so['holiday'] === '003'){
                                    $pm_out = "SO#:".$so['remark'];
                                } else {
                                    $leave = GET_CDO_SO($s_am_in,$s_am_out,$s_pm_in,$s_pm_out,$userid,$datein,'LEAVE_LOGS');
                                    if($leave['holiday'] == '007'){
                                        $pm_out = $leave['remark'];
                                    }else {
                                        $edited_logs = GET_CDO_SO($s_am_in,$s_am_out,$s_pm_in,$s_pm_out,$userid,$datein,'EDITED_LOGS');
                                        if($edited_logs) {

                                            $pm_out =  $edited_logs['pm_out'];

                                            if(isset($pm_out)) {
                                                $d = explode('_', $pm_out);
                                                $e4 = $d[1];
                                                $pm_out = $d[0];
                                            } else {
                                                $pm_out = '';
                                                $e4 = '';
                                            }
                                        }
                                    }

                                }
                            }
                        }else if($am_in AND !$am_out AND !$pm_in AND $pm_out){
                            $cto = GET_CDO_SO($s_am_in,$s_am_out,$s_pm_in,$s_pm_out,$userid,$datein,'GETCDO');

                            if($cto['remark'] == 'CTO'){
                                $am_out = 'CTO';
                                $pm_in = 'CTO';
                            } else {
                                $so = GET_CDO_SO($s_am_in,$s_am_out,$s_pm_in,$s_pm_out,$userid,$datein,'GETSO');
                                if($so['holiday'] === '003'){
                                    $am_out = "SO#:".$so['remark'];
                                    $pm_in = "SO#:".$so['remark'];
                                } else {
                                    $leave = GET_CDO_SO($s_am_in,$s_am_out,$s_pm_in,$s_pm_out,$userid,$datein,'LEAVE_LOGS');
                                    if($leave['holiday'] == '007'){
                                        $am_out = $leave['remark'];
                                        $pm_in = $leave['remark'];
                                    } else {
                                        $edited_logs = GET_CDO_SO($s_am_in,$s_am_out,$s_pm_in,$s_pm_out,$userid,$datein,'EDITED_LOGS');
                                        if($edited_logs) {

                                            $am_out = $edited_logs['am_out'];
                                            $pm_in = $edited_logs['pm_in'];

                                            if(isset($am_out)) {
                                                $b = explode('_', $am_out);
                                                $e2 = $b[1];
                                                $am_out = $b[0];
                                            } else {
                                                $am_out = '';
                                                $e2 = '';
                                            }

                                            if(isset($pm_in)) {
                                                $c = explode('_', $pm_in);
                                                $e3 = $c[1];
                                                $pm_in = $c[0];
                                            } else {
                                                $pm_in = '';
                                                $e3 = '';
                                            }
                                        }
                                    }

                                }
                            }

                        } else if(!$am_in AND !$am_out AND $pm_in AND !$pm_out){
                            $cto = GET_CDO_SO($s_am_in,$s_am_out,$s_pm_in,$s_pm_out,$userid,$datein,'GETCDO');

                            if($cto['remark'] == 'CTO'){
                                $am_in = 'CTO';
                                $am_out = 'CTO';
                                $pm_out = 'CTO';
                            } else {
                                $so = GET_CDO_SO($s_am_in,$s_am_out,$s_pm_in,$s_pm_out,$userid,$datein,'GETSO');
                                if($so['holiday'] === '003'){
                                    $am_in = "SO#:".$so['remark'];
                                    $am_out = "SO#:".$so['remark'];
                                    $pm_out = "SO#:".$so['remark'];
                                } else {
                                    $leave = GET_CDO_SO($s_am_in,$s_am_out,$s_pm_in,$s_pm_out,$userid,$datein,'LEAVE_LOGS');
                                    if($leave['holiday'] == '007'){
                                        $am_in = $leave['remark'];
                                        $am_out = $leave['remark'];
                                        $pm_out = $leave['remark'];
                                    }else {
                                        $edited_logs = GET_CDO_SO($s_am_in,$s_am_out,$s_pm_in,$s_pm_out,$userid,$datein,'EDITED_LOGS');
                                        if($edited_logs) {

                                            $am_in =  $edited_logs['am_in'];
                                            $am_out =  $edited_logs['am_out'];

                                            $pm_out =  $edited_logs['pm_out'];

                                            if(isset($am_in)) {
                                                $a = explode('_', $am_in);
                                                $e1 = $a[1];
                                                $am_in = $a[0];
                                            } else {
                                                $am_in = '';
                                                $e1 = '';
                                            }

                                            if(isset($am_out)) {
                                                $b = explode('_', $am_out);
                                                $e2 = $b[1];
                                                $am_out = $b[0];
                                            } else {
                                                $am_out = '';
                                                $e2 = '';
                                            }


                                            if(isset($pm_out)) {
                                                $d = explode('_', $pm_out);
                                                $e4 = $d[1];
                                                $pm_out = $d[0];
                                            } else {
                                                $pm_out = '';
                                                $e4 = '';
                                            }
                                        }
                                    }

                                }
                            }

                        } else if($am_in AND !$am_out AND !$pm_in AND !$pm_out){
                            $cto = GET_CDO_SO($s_am_in,$s_am_out,$s_pm_in,$s_pm_out,$userid,$datein,'GETCDO');

                            if($cto['remark'] == 'CTO'){
                                $am_out = 'CTO';
                                $pm_in = 'CTO';
                                $pm_out = 'CTO';
                            } else {
                                $so = GET_CDO_SO($s_am_in,$s_am_out,$s_pm_in,$s_pm_out,$userid,$datein,'GETSO');
                                if($so['holiday'] === '003'){
                                    $am_out = "SO#:".$so['remark'];
                                    $pm_in = "SO#:".$so['remark'];
                                    $pm_out = "SO#:".$so['remark'];
                                } else {
                                    $leave = GET_CDO_SO($s_am_in,$s_am_out,$s_pm_in,$s_pm_out,$userid,$datein,'LEAVE_LOGS');
                                    if($leave['holiday'] == '007'){
                                        $am_out = $leave['remark'];
                                        $pm_in = $leave['remark'];
                                        $pm_out = $leave['remark'];
                                    } else {
                                        $edited_logs = GET_CDO_SO($s_am_in,$s_am_out,$s_pm_in,$s_pm_out,$userid,$datein,'EDITED_LOGS');
                                        if($edited_logs) {
                                            $am_out =  $edited_logs['am_out'];
                                            $pm_in =  $edited_logs['pm_in'];
                                            $pm_out =  $edited_logs['pm_out'];

                                            if(isset($am_out)) {
                                                $b = explode('_', $am_out);
                                                $e2 = $b[1];
                                                $am_out = $b[0];
                                            } else {
                                                $am_out = '';
                                                $e2 = '';
                                            }

                                            if(isset($pm_in)) {
                                                $c = explode('_', $pm_in);
                                                $e3 = $c[1];
                                                $pm_in = $c[0];
                                            } else {
                                                $pm_in = '';
                                                $e3 = '';
                                            }

                                            if(isset($pm_out)) {
                                                $d = explode('_', $pm_out);
                                                $e4 = $d[1];
                                                $pm_out = $d[0];
                                            } else {
                                                $pm_out = '';
                                                $e4 = '';
                                            }
                                        }
                                    }

                                }
                            }
                        } else if(!$am_in AND !$am_out AND !$pm_in AND $pm_out){
                            $cto = GET_CDO_SO($s_am_in,$s_am_out,$s_pm_in,$s_pm_out,$userid,$datein,'GETCDO');

                            if($cto['remark'] == 'CTO'){
                                $am_in = 'CTO';
                                $am_out = 'CTO';
                                $pm_in = 'CTO';
                            } else {
                                $so = GET_CDO_SO($s_am_in,$s_am_out,$s_pm_in,$s_pm_out,$userid,$datein,'GETSO');
                                if($so['holiday'] === '003'){
                                    $am_in = "SO#:".$so['remark'];
                                    $am_out = "SO#:".$so['remark'];
                                    $pm_in = "SO#:".$so['remark'];
                                } else {
                                    $leave = GET_CDO_SO($s_am_in,$s_am_out,$s_pm_in,$s_pm_out,$userid,$datein,'LEAVE_LOGS');
                                    if($leave['holiday'] == '007'){
                                        $am_in = $leave['remark'];
                                        $am_out = $leave['remark'];
                                        $pm_in = $leave['remark'];
                                    } else {
                                        $edited_logs = GET_CDO_SO($s_am_in,$s_am_out,$s_pm_in,$s_pm_out,$userid,$datein,'EDITED_LOGS');
                                        if($edited_logs) {
                                            $am_in =  $edited_logs['am_in'];
                                            $am_out =  $edited_logs['am_out'];
                                            $pm_in =  $edited_logs['pm_in'];
                                           

                                            if(isset($am_in)) {
                                                $a = explode('_', $am_in);
                                                $e1 = $a[1];
                                                $am_in = $a[0];
                                            } else {
                                                $am_in = '';
                                                $e1 = '';
                                            }

                                            if(isset($am_out)) {
                                                $b = explode('_', $am_out);
                                                $e2 = $b[1];
                                                $am_out = $b[0];
                                            } else {
                                                $am_out = '';
                                                $e2 = '';
                                            }

                                            if(isset($pm_in)) {
                                                $c = explode('_', $pm_in);
                                                $e3 = $c[1];
                                                $pm_in = $c[0];
                                            } else {
                                                $pm_in = '';
                                                $e3 = '';
                                            }
                                        }
                                    }

                                }
                            }
                        }  else if($am_in AND $am_out AND !$pm_in AND $pm_out){
                            $cto = GET_CDO_SO($s_am_in,$s_am_out,$s_pm_in,$s_pm_out,$userid,$datein,'GETCDO');
                            
                            if($cto['remark'] == 'CTO'){
                               
                                $pm_in = 'CTO';
                            } else {
                                $so = GET_CDO_SO($s_am_in,$s_am_out,$s_pm_in,$s_pm_out,$userid,$datein,'GETSO');
                                if($so['holiday'] === '003'){
                                    
                                    $pm_in = "SO#:".$so['remark'];
                                } else {
                                    $leave = GET_CDO_SO($s_am_in,$s_am_out,$s_pm_in,$s_pm_out,$userid,$datein,'LEAVE_LOGS');
                                    if($leave['holiday'] == '007'){
                                       
                                        $pm_in = $leave['remark'];
                                    } else {
                                        $edited_logs = GET_CDO_SO($s_am_in,$s_am_out,$s_pm_in,$s_pm_out,$userid,$datein,'EDITED_LOGS');
                                        if($edited_logs) {
                                           
                                            $pm_in =  $edited_logs['pm_in'];
                                            if(isset($pm_in)) {
                                                $c = explode('_', $pm_in);
                                                $e3 = $c[1];
                                                $pm_in = $c[0];
                                            } else {
                                                $pm_in = '';
                                                $e3 = '';
                                            }
                                        }
                                    }

                                }
                            }
                        }
                        if(!$am_in AND !$pm_in AND !$pm_out AND !$am_out){
                            if($r1 == 29 OR $r1 == 30 ){
                                $am_in = "";
                                $am_out = "HOLIDAY";
                                $pm_in = "";
                                $pm_out = "";
                            } else {
                                if($day_name != "Sat" AND $day_name != "Sun"){
                                    $am_in = "";
                                    $am_out = "ABSENT";
                                    $pm_in = "";
                                    $pm_out = "";
                                }
                                
                            }
                        }
                        
                        //if($day_name == 'Sat' || $day_name == 'Sun' AND $am_in == '') $am_out = 'DAY OFF';
                        if(isset($e1) and $e1 == "1"){
                            $this->SetFont('Arial','IU',8);
                        } else {
                            $this->SetFont('Arial','',8);
                        }

                        $this->Cell($w[1],5,$am_in,'');
                        $this->SetTextColor(0,0,0);


                        $this->SetFont('Arial','',8);
                        if($day_name == 'Sat' || $day_name == 'Sun' AND $am_in == '' AND $am_out == '') $am_out = 'DAY OFF';
                        if(isset($e2) and $e2 == "1"){
                            $this->SetFont('Arial','IUB',8);
                        } else {
                            $this->SetFont('Arial','',8);
                        }

                        $this->Cell($w[1],5,$am_out,'');
                        $this->SetTextColor(0,0,0);

                        if($day_name == 'Sat' || $day_name == 'Sun' AND $am_in == '' AND $am_out == '' AND $pm_in == '') $am_out = 'DAY OFF';
                        if(isset($e3) and $e3 == "1"){
                            $this->SetFont('Arial','IUB',8);
                        } else {
                            $this->SetFont('Arial','',8);
                        }
                        
                        $this->Cell(14,5,$pm_in,'',0,'R');
                        $this->SetTextColor(0,0,0);

                        if($day_name == 'Sat' || $day_name == 'Sun' AND $am_in == '' AND $am_out == '' AND $pm_in == '' AND $pm_out == '') $am_out = 'DAY OFF';
                        if(isset($e4) and $e4 == "1") {
                            $this->SetFont('Arial','IUB',8);
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
                            $this->SetFont('Arial','IUB',8);
                        } else {
                            $this->SetFont('Arial','',8);
                        }
                        $this->Cell($w[1],5,$am_in,'');
                        $this->SetTextColor(0,0,0);

                        if(isset($e2) and $e2 == "1"){
                            $this->SetFont('Arial','IUB',8);
                        } else {
                            $this->SetFont('Arial','',8);
                        }
                        $this->Cell($w[1],5,$am_out,'');
                        $this->SetTextColor(0,0,0);

                        if(isset($e3) and $e3 == "1"){
                            $this->SetFont('Arial','IUB',8);
                        } else {
                            $this->SetFont('Arial','',8);
                        }
                        $this->Cell($w[2],5,$pm_in,'',0,'R');
                        $this->SetTextColor(0,0,0);

                        if(isset($e4) and $e4 == "1"){
                            $this->SetFont('Arial','IUB',8);
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
                }

                $this->SetFont('Arial','',9);
                $this->SetXY(112,42);
                $this->Cell(89,5,'                     AM                              PM              UNDERTIME',1);

                $this->SetFont('Arial','',7.5);
                $this->SetXY(112,47);
                $this->Cell(89,5,'  DAY     ARRIVAL | DEPARTURE   ARRIVAL | DEPARTURE   LATE | UT',1);
                $this->Ln(500);

            }
        } else {
            $this->SetFont('Arial','B',8);
            $this->SetX(100);
            $this->Cell(10,0,"ATTENDANCE FOR USERID $userid CANNOT BE GENERATED. NO WORK SCHEDULE IS SET.",0,0,'C');
        }
    }
    function SetEmpname($empname)
    {
        $this->empname = $empname;
    }
    function GetName()
    {
        return $this->empname;
    }
// Page footer

}

$pdf = new PDF('P','mm','A4');
$pdf->AliasNbPages();
$pdf->AddPage();




$pdf->SetFont('Arial','',12);
$date_from = '';
$date_to = '';
$userid = '';


if(isset($_POST['filter_range']) and isset($_POST['userid'])) {
    $str = $_POST['filter_range'];
    $temp1 = explode('-',$str);
    $temp2 = array_slice($temp1, 0, 1);
    $tmp = implode(',', $temp2);
    $date_from = date('Y-m-d',strtotime($tmp));
    $temp3 = array_slice($temp1, 1, 1);
    $tmp = implode(',', $temp3);
    $date_to = date('Y-m-d',strtotime($tmp));
    $userid = $_POST['userid'];
} else {
    $pdf->SetFont('Arial','B',10);
    $pdf->SetX(40);
    $pdf->Cell(10,0,"Something went wrong. Go back to webpage",0,0,'C');
    $pdf->Output();
    exit();
}


$pdf->SetTitle('DTR report From : ' . date('M d, Y', strtotime($date_from)) .'---'.date('M d, Y', strtotime($date_to)));
$emp = userlist($userid);

if(isset($emp) and count($emp) > 0)
{
    $pdf->form($emp[0]['lname'] . ', ' . $emp[0]['fname'] . ' ' . $emp[0]['mname'], $emp[0]['userid'], $date_from, $date_to,$emp[0]['sched']);
    $pdf->SetEmpname($emp[0]['lname'] . ' ' . $emp[0]['fname'] . ' ' . $emp[0]['mname']);
    $pdf->SetTitle($emp[0]['lname'] . ' ' . $emp[0]['fname'] . ' ' . $emp[0]['mname']);
} else {
    $pdf->SetFont('Arial','B',10);
    $pdf->SetX(40);
    $pdf->Cell(10,0,"NO RECORDS FOUND FOR $userid ",0,0,'C');
}


$pdf->Output();
exit();


function get_logs($am_in,$am_out,$pm_in,$pm_out,$id,$date_from,$date_to)
{
    $pdo = conn();


    $query = "CALL GETLOGS('". $am_in ."','" . $am_out ."','" . $pm_in ."','" . $pm_out . "','" . $id . "','" . $date_from . "','" . $date_to ."')";
    try
    {
        $st = $pdo->prepare($query);
        $st->execute();
        $row = $st->fetchAll(PDO::FETCH_ASSOC);
    }catch(PDOException $ex){
        echo $ex->getMessage();
        exit();
    }
    return $row;
}

function userlist($userid)
{
    $pdo = conn();
    try {
        $st = $pdo->prepare("SELECT DISTINCT userid,fname,lname,mname,sched FROM users  WHERE usertype != '1' and userid = :id");

        $st->bindParam(":id", $userid);
        $st->execute();
        $row = $st->fetchAll(PDO::FETCH_ASSOC);
        if(isset($row) and count($row) > 0)
        {
            $pdo = null;
            return $row;
        }
    }catch(PDOException $ex)
    {
        echo $ex->getMessage();
        exit();
    }
}
function save_file_name($filename,$date_from,$date_to,$emtype)
{
    $pdo = conn();
    $time = date("h:i:sa");
    $date = date("Y-m-d");
    $query = "INSERT INTO generated_pdf(filename,date_created,time_created,date_from,date_to,created_at,updated_at,type,is_filtered)";
    $query .= " VALUES('".$filename . "','" . $date . "','" . $time . "','". $date_from. "','".$date_to ."',NOW(),NOW(),'". $emtype ."','0')";
    $st = $pdo->prepare($query);
    $st->execute();
    $pdo = null;
}





function user_search($id)
{
    $db= dts_con();
    $sql="SELECT * FROM USERS WHERE USERNAME = ?";
    $pdo = $db->prepare($sql);
    $pdo->execute(array($id));
    $row = $pdo->fetch();
    $db = null;

    return $row;
}

function late($s_am_in,$s_pm_in,$am_in,$pm_in,$datein)
{
    $hour = 0;
    $min = 0;
    $total = 0;

    if(isset($am_in) and $am_in != '' || $am_in != null) {
        if(strtotime($am_in) > strtotime($s_am_in)) {
            $a = new DateTime($datein.' '. $am_in);
            $b = new DateTime($datein.' '. $s_am_in);

            $interval = $a->diff($b);
            $hour1 = $interval->h;
            $min1 = $interval->i;


            if($hour1 > 0) {
                $hour1 = $hour1 * 60;
            }
            $total += ($hour1 + $min1);
        }

    }

    if(isset($pm_in) and $pm_in != '' || $pm_in != null) {
        if(strtotime($pm_in) > strtotime($s_pm_in)) {
            $a = new DateTime($datein.' '.$pm_in);
            $b = new DateTime($datein.' '.$s_pm_in);

            $interval = $a->diff($b);
            $hour2 = $interval->h;
            $min2 = $interval->i;


            if($hour2 > 0) {
                $hour2 = $hour2 * 60;
            }

            $total += ($hour2 + $min2);
        }
    }

    if($total == 0) $total = '';
    return $total;

}

function undertime($s_am_in,$s_pm_in,$am_in,$pm_in,$s_am_out,$s_pm_out,$am_out,$pm_out,$datein)
{
    $total = null;

    if($am_in == '' and $am_out == '') {
        $a = new DateTime($datein.' '. $s_am_in);
        $b = new DateTime($datein.' '. $s_am_out);

        $interval = $b->diff($a);
        $hour1 = $interval->h;
        $min1 = $interval->i;

        if($hour1 > 0) {
            $hour1 = $hour1 * 60;
        }
        $total += ($hour1 + $min1);

    }


    if($pm_in != '' and $pm_out == '') {
        $a = new DateTime($datein.' '. $s_pm_in);
        $b = new DateTime($datein.' '. $s_pm_out);

        $interval = $b->diff($a);
        $hour2 = $interval->h;
        $min1 = $interval->i;

        if($hour2 > 0) {
            $hour2 = $hour2 * 60;
        }
        $total += ($hour2 + $min1);
    }

    if($pm_in == '' and $pm_out == '') {

        $a = new DateTime($datein.' '. $s_pm_in);
        $b = new DateTime($datein.' '. $s_pm_out);

        $interval = $b->diff($a);
        $hour2 = $interval->h;
        $min1 = $interval->i;

        if($hour2 > 0) {
            $hour2 = $hour2 * 60;
        }
        $total += ($hour2 + $min1);

    }

    if(isset($am_out) and $am_out != '' || $am_out != null) {
        if(strtotime($am_out) < strtotime($s_am_out)) {
            $a = new DateTime($datein.' '. $am_out);
            $b = new DateTime($datein.' '. $s_am_out);

            $interval = $b->diff($a);
            $hour1 = $interval->h;
            $min1 = $interval->i;

            if($hour1 > 0) {
                $hour1 = $hour1 * 60;
            }
            $total += ($hour1 + $min1);
        }
    }
    if(isset($pm_out) and $pm_out != '' || $pm_out != null) {

        if(strtotime($pm_out) < strtotime($s_pm_out)) {
            $hour2 = 0;
            $a = new DateTime($datein.' '.$pm_out);
            $b = new DateTime($datein.' '.$s_pm_out);

            $interval = $b->diff($a);
            $hour2 = $interval->h;
            $min2 = $interval->i;

            if($hour2 > 0) {
                $hour2 = $hour2 * 60;
            }
            $total += ($hour2 + $min2);
        }
    }
    if($total == 0 ) $total = '';
    return $total;
}

function GET_CDO_SO($am_in,$am_out,$pm_in,$pm_out,$id,$datein,$func)
{
    $pdo = conn();
    $query = "CALL $func('". $am_in ."','" . $am_out ."','" . $pm_in ."','" . $pm_out . "','" . $id . "','" . $datein ."')";
    try
    {
        $st = $pdo->prepare($query);
        $st->execute();
        $row = $st->fetch(PDO::FETCH_ASSOC);
    }catch(PDOException $ex){
        echo $ex->getMessage();
        exit();
    }
    return $row;
}

?>
