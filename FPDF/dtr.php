
<?php

$filename = 'attendace-2017-01-16-2017-01-31_0034';

$host = $_SERVER['HTTP_HOST'];
$uri = explode('/',$_SERVER['REQUEST_URI']);
$protocol = 'http://';
$address = $protocol.$host.'/'.$uri[1].'/index';



//require('dbconn.php');
require('fpdf.php');
ini_set('max_execution_time', 0);
ini_set('memory_limit','1000M');
ini_set('max_input_time','300000');

class PDF extends FPDF
{

// Page header
    function form($name,$userid,$date_from,$date_to)
    {

        $day1 = explode('-',$date_from);
        $day2 = explode('-',$date_to);

        $startday = floor($day1[2]);
        $endday = $day2[2];


        $this->SetFont('Arial','',8);
        $this->SetX(10);
        $this->Cell(40,10,'Civil Service Form No. 43',0);
        $this->SetX(60);
        $this->Cell(40,10,'Printed : '. date('Y-m-d'),0);

        $this->SetX(120);
        $this->Cell(40,10,'Civil Service Form No. 43',0);
        $this->SetX(-40);
        $this->Cell(40,10,'Printed : '.date('Y-m-d') ,0);

        $this->Ln(5);
        $this->SetFont('Arial','',10);
        $this->SetXY(35,15);
        $this->Cell(40,10,'DAILY TIME RECORD',0);

        $this->SetFont('Arial','B',10);
        $this->SetXY(10,22);
        $this->Cell(40,10,'Name : '.$name,1,1,'C');

        $this->SetFont('Arial','',10);
        $this->SetXY(10,28);
        $this->Cell(40,10,'For the month of',0);

        $this->SetFont('Arial','',10);
        $this->SetXY(60,28);
        $this->Cell(40,10,'ID No.  '.$userid,0);

        $this->SetFont('Arial','',10);
        $this->SetXY(10,33);
        $this->Cell(40,10,'Official hours for (days A.M. P.M. arrival and departure)',0);



        $this->SetFont('Arial','',10);
        $this->SetXY(145,15);
        $this->Cell(40,10,'DAILY TIME RECORD',0);

        $this->SetFont('Arial','B',10);
        $this->SetXY(120,22);

        $this->Cell(40,10,'Name : '.$name,0);

        $this->SetFont('Arial','',10);
        $this->SetXY(120,28);
        $this->Cell(40,10,'For the month of',0);

        $this->SetFont('Arial','',10);
        $this->SetXY(170,28);
        $this->Cell(40,10,'ID No.  '.$userid,0);

        $this->SetFont('Arial','',10);
        $this->SetXY(120,33);
        $this->Cell(40,10,'Official hours for (days A.M. P.M. arrival and departure)',0);



        $this->SetFont('Arial','',9);
        $this->SetXY(10,42);
        $this->Cell(89,8,'                     AM                             PM              UNDERTIME',1);


        $this->SetFont('Arial','',7.5);
        $this->SetXY(10,50);
        $this->Cell(89,8,'  DAY     ARRIVAL | DEPARTURE   ARRIVAL | DEPARTURE   LATE | UT',1);

        $this->SetFont('Arial', '', 7.5);
        $this->SetXY(10,65);

        $w = array(10,15,15,15,15);
        $index = 0;
        $log_date = "";
        $log = "";

        $logs = get_logs($userid,$date_from,$date_to);


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

                   // $late = personal::late($am_in, $pm_in);
                   // $ut = personal::undertime($am_out,$pm_out);
                } else {
                    $am_in = '';
                    $am_out = '';
                    $pm_in = '';
                    $pm_out = '';
                    $late = '';
                    //$ut = personal::undertime($am_out,$pm_out);
                }


                $this->Cell(5,6,$r1,'');
                $this->Cell(7,6,$day_name,'');
                $this->Cell($w[1],6,$am_in,'');
                $this->Cell($w[1],6,$am_out,'');
                $this->Cell($w[2],6,$pm_in,'',0,'R');
                $this->Cell($w[3],6,$pm_out,'',0,'R');

                $this->Cell(37);
                $this->Cell(5,6,$r1,'');
                $this->Cell(7,6,$day_name,'');
                $this->Cell($w[1],6,$am_in,'');
                $this->Cell($w[1],6,$am_out,'');
                $this->Cell($w[2],6,$pm_in,'',0,'R');
                $this->Cell($w[3],6,$pm_out,'',0,'R');

                $this->Ln();
            }
        }

        $this->SetFont('Arial','',9);
        $this->SetXY(120,42);
        $this->Cell(89,8,'                     AM                              PM              UNDERTIME',1);

        $this->SetFont('Arial','',7.5);
        $this->SetXY(120,50);
        $this->Cell(89,8,'  DAY     ARRIVAL | DEPARTURE   ARRIVAL | DEPARTURE   LATE | UT',1);
        $this->Ln(500);


    }


// Page footer
    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial','I',8);
        $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
    }
}


$pdf = new PDF('P','mm','A4');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','',12);
$date_from = '';
$date_to = '';
if(isset($_POST['from']) and isset($_POST['to'])) {
    $date_from = $_POST['from'];
    $date_to = $_POST['to'];

    $_from = explode('/',$date_from);
    $_to = explode('/', $date_to);
    $date_from = $_from[2].'-'.$_from[0].'-'.$_from[1];
    $date_to = $_to[2].'-'.$_to[0].'-'.$_to[1];


} else {
    $pdf->SetFont('Arial','B',10);
    $pdf->SetX(40);
    $pdf->Cell(10,0,"Something went wrong. Go back to webpage",0,0,'C');
    $pdf->Output();
    exit();
}


$row = userlist();

if(isset($row) and count($row) > 0)
{
    for($i = 0; $i < count($row); $i++)
    {

        $pdf->form($row[$i]['fname'].' '.$row[$i]['lname'].' '.$row[$i]['mname'],$row[$i]['userid'],$date_from,$date_to);

       /* $filename = __DIR__.'/pdf-files/attendace-'.$date_from .'-'.$date_to.'_'.$row[$i]['userid'].'.pdf';
        $pdf->Output($filename,'F');
        save_file_name($row[$i]['userid'],$filename);
        $pdf = null;*/
    }
    $filename = __DIR__.'/pdf-files/attendace-'.$date_from .'-'.$date_to.'___.pdf';
    $pdf->Output($filename,'F');
}




$host = $_SERVER['HTTP_HOST'];
$uri = explode('/',$_SERVER['REQUEST_URI']);
$protocol = 'http://';
$address = $protocol.$host.'/'.$uri[1].'/index';

header('Location:'.$address);
exit();


function get_logs($id,$date_from,$date_to)
{
    $pdo = conn();
    $query = "SELECT * FROM work_sched WHERE id = '1'";
    $st = $pdo->prepare($query);
    $st->execute();
    $sched = $st->fetchAll(PDO::FETCH_ASSOC);

        $am_in = explode(':',$sched[0]['am_in']);
        $am_out =  explode(':',$sched[0]['am_out']);
        $pm_in =  explode(':',$sched[0]['pm_in']);
        $pm_out = explode(':',$sched[0]['pm_out']);

        $query = "SELECT DISTINCT e.userid, datein,

                    (SELECT MIN(t1.time) FROM dtr_file t1 WHERE t1.userid = '". $id."' and datein = d.datein and t1.time_h < ". $am_out[0] .") as am_in,
                    (SELECT MAX(t2.time) FROM dtr_file t2 WHERE t2.userid = '". $id."' and datein = d.datein and t2.time_h < ". $pm_in[0]." AND t2.event = 'OUT') as am_out,
                    (SELECT MIN(t3.time) FROM dtr_file t3 WHERE t3.userid = '". $id."' AND datein = d.datein and t3.time_h >= ". $am_out[0]." and t3.time_h < ". $pm_out[0]." AND t3.event = 'IN' ) as pm_in,
                    (SELECT MAX(t4.time) FROM dtr_file t4 WHERE t4.userid = '". $id."' AND datein = d.datein and t4.time_h > ". $pm_in[0] ." and t4. time_h < 24) as pm_out

                    FROM dtr_file d LEFT JOIN users e
                        ON d.userid = e.userid
                    WHERE d.datein BETWEEN '". $date_from. "' AND '" . $date_to . "'
                          AND e.userid = '". $id."'
                    ORDER BY datein ASC";
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


function conn()
{
    $pdo = null;

    try{
        $pdo = new PDO('mysql:host=localhost; dbname=dohdtr','root','');
        $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    }
    catch (PDOException $err) {
        $err->getMessage() . "<br/>";
        die();
    }
    return $pdo;
}

function userlist()
{
    $pdo = conn();
    try {
        $st = $pdo->prepare("SELECT DISTINCT userid,fname,lname,mname FROM users WHERE usertype != '1' and userid !='Unknown User' ORDER BY lname ASC");
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

function save_file_name($userid,$filename)
{
    $pdo = conn();

    $time = date("h:i:sa");
    $date = date("Y-m-d");

    $userid = '00001';
    $query = "INSERT INTO generated_pdf(filename,date_created,time_created,userid,created_at,updated_at)";
    $query .= " VALUES('".$filename . "','" . $date . "','" . $time . "','". $userid ."',NOW(),NOW())";


    $st = $pdo->prepare($query);
    $st->execute();

    $pdo = null;
}



?>