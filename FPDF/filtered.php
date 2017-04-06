
<?php



/*$host = $_SERVER['HTTP_HOST'];
$uri = explode('/',$_SERVER['REQUEST_URI']);
$protocol = 'http://';
$address = $protocol.$host.'/'.$uri[1].'/index';*/


//require('dbconn.php');

echo "Hello World";
exit();


require('fpdf.php');
ini_set('max_execution_time', 0);
ini_set('memory_limit','1000M');
ini_set('max_input_time','300000');

class PDF extends FPDF
{

    private $empname = "";
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

        $this->SetFont('Arial','BU',10);
        $this->SetXY(25,22);
        $this->Cell(60,10,'                  '.$name.'                  ',0,1,'C');

        $this->SetFont('Arial','',10);
        $this->SetXY(10,28);
        $this->Cell(40,10,'For the month of : '.date("M",strtotime($date_from)).' '. $day1[2].'-'.$day2[2].'  '.$day2[0],0);

        $this->SetFont('Arial','',10);
        $this->SetXY(60,28);
        $this->Cell(40,10,'ID No.  '.$userid,0);

        $this->SetFont('Arial','',10);
        $this->SetXY(10,33);
        $this->Cell(40,10,'Official hours for (days A.M. P.M. arrival and departure)',0);



        $this->SetFont('Arial','',10);
        $this->SetXY(135,15);
        $this->Cell(40,10,'DAILY TIME RECORD',0);

        $this->SetFont('Arial','BU',10);
        $this->SetXY(135,22);
        $this->Cell(40,10,'                  '.$name.'                  ',0,1,'C');

        $this->SetFont('Arial','',10);
        $this->SetXY(112,28);
        $this->Cell(40,10,'For the month of : '.date("M",strtotime($date_from)).' '. $day1[2].'-'.$day2[2].'  '.$day2[0],0);

        $this->SetFont('Arial','',10);
        $this->SetXY(170,28);
        $this->Cell(40,10,'ID No.  '.$userid,0);

        $this->SetFont('Arial','',10);
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

                } else {
                    $am_in = '';
                    $am_out = '';
                    $pm_in = '';
                    $pm_out = '';
                    $late = '';
                    //$ut = personal::undertime($am_out,$pm_out);
                }


                $this->Cell(5,5,$r1,'');
                $this->Cell(7,5,$day_name,'');
                $this->Cell($w[1],5,$am_in,'');
                $this->Cell($w[1],5,$am_out,'');
                $this->Cell($w[2],5,$pm_in,'',0,'R');
                $this->Cell($w[3],5,$pm_out,'',0,'R');

                $this->Cell(30);
                $this->Cell(5,5,$r1,'');
                $this->Cell(7,5,$day_name,'');
                $this->Cell($w[1],5,$am_in,'');
                $this->Cell($w[1],5,$am_out,'');
                $this->Cell($w[2],5,$pm_in,'',0,'R');
                $this->Cell($w[3],5,$pm_out,'',0,'R');

                $this->Ln();

                if($r1 == $endday)
                {
                    $this->SetFont('Arial','BU',8);
                    $this->SetX(50);
                    $this->Cell(5,0,'                                                                                                             ',0,0,'C');

                    $this->SetX(153);
                    $this->Cell(5,0,'                                                                                                             ',0,0,'C');
                    $this->Ln();

                    $this->SetFont('Arial','',9);
                    $this->Cell(10,7,'TOTAL',0,0,'C');

                    $this->SetX(113);
                    $this->Cell(10,7,'TOTAL',0,0,'C');
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

                    $this->SetFont('Arial','BU',8);
                    $this->SetX(50);
                    $this->Cell(5,10,'                                                                                                              ',0,0,'C');
                    $this->SetX(153);
                    $this->Cell(5,10,'                                                                                                              ',0,0,'C');
                    $this->Ln();

                    $this->SetFont('Arial','',8);
                    $this->SetX(49);
                    $this->Cell(10,0,'Verified as to the prescribed office hours',0,0,'C');
                    $this->SetX(153);
                    $this->Cell(10,0,'Verified as to the prescribed office hours',0,0,'C');
                    $this->Ln();

                    $this->SetFont('Arial','BU',8);
                    $this->SetX(50);
                    $this->Cell(5,10,'                                                                                                             ',0,0,'C');
                    $this->SetX(153);
                    $this->Cell(5,10,'                                                                                                             ',0,0,'C');
                    $this->Ln();

                    $this->SetFont('Arial','',8);
                    $this->SetX(40);
                    $this->Cell(10,0,'IN-CHARGE',0,0,'C');
                    $this->SetX(150);
                    $this->Cell(10,0,'IN-CHARGE',0,0,'C');
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

    function SetEmpname($empname)
    {
        $this->empname = $empname;
    }
    function GetName()
    {
        return $this->empname;
    }

// Page footer
    function Footer()
    {
        $this->SetFont('Arial','BU',8);
        $this->SetXY(47,-175);
        $this->Cell(10,10,'                                                                                                             ',0,0,'C');

        $this->SetFont('Arial','',9);
        $this->SetXY(20,-170);
        $this->Cell(10,10,'TOTAL',0,0,'C');

        $this->SetFont('Arial','',7);
        $this->SetXY(10,-163);
        $this->MultiCell(80,4, '        I CERTIFY on my honor that above entry is true and correct report of the hours work performed, record of which was made daily at the time of arrival and departure from the office.');


        $this->SetFont('Arial','BU',8);
        $this->SetXY(47,-150);
        $this->Cell(10,10,'                              '. $this->GetName() .'                                    ',0,0,'C');

        $this->SetFont('Arial','',8);
        $this->SetXY(47,-146);
        $this->Cell(10,10,'Verified as to the prescribed office hours',0,0,'C');

        $this->SetFont('Arial','BU',8);
        $this->SetXY(47,-139);
        $this->Cell(10,10,'                                                                                                             ',0,0,'C');

        $this->SetFont('Arial','',8);
        $this->SetXY(47,-135);
        $this->Cell(10,10,'IN-CHARGE',0,0,'C');



        $this->SetFont('Arial','BU',8);
        $this->SetXY(150,-175);
        $this->Cell(10,10,'                                                                                                                 ',0,0,'C');

        $this->SetFont('Arial','',9);
        $this->SetXY(120    ,-170);
        $this->Cell(10,10,'TOTAL',0,0,'C');


        $this->SetFont('Arial','',7);
        $this->SetXY(110,-163);
        $this->MultiCell(80,4, '        I CERTIFY on my honor that above entry is true and correct report of the hours work performed, record of which was made daily at the time of arrival and departure from the office.');


        $this->SetFont('Arial','BU',8);
        $this->SetXY(150,-150);
        $this->Cell(10,10,'                              '. $this->GetName() .'                                     ',0,0,'C');

        $this->SetFont('Arial','',8);
        $this->SetXY(150,-146);
        $this->Cell(10,10,'Verified as to the prescribed office hours',0,0,'C');


        $this->SetFont('Arial','BU',8);
        $this->SetXY(150,-139);
        $this->Cell(10,10,'                                                                                                             ',0,0,'C');

        $this->SetFont('Arial','',8);
        $this->SetXY(150,-135);
        $this->Cell(10,10,'IN-CHARGE',0,0,'C');
    }
}

$pdf = new PDF('P','mm','A4');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','',12);
$date_from = '';
$date_to = '';
if(isset($_POST['filter_range'])) {

    $str = $_POST['filter_range'];
    $temp1 = explode('-',$str);
    $temp2 = array_slice($temp1, 0, 1);
    $tmp = implode(',', $temp2);
    $date_from = date('Y-m-d',strtotime($tmp));

    $temp3 = array_slice($temp1, 1, 1);
    $tmp = implode(',', $temp3);
    $date_to = date('Y-m-d',strtotime($tmp));

}


$pdf = new PDF('P','mm','A4');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','',12);
$pdf->SetTitle('DTR report From : ' . date('l', strtotime($date_from)) .'---'.date('l', strtotime($date_to)));

$row = userlist();

if(isset($row) and count($row) > 0)
{
    for($i = 0; $i < 1; $i++) {
        $pdf->form($row[$i]['fname'] . ' ' . $row[$i]['lname'] . ' ' . $row[$i]['mname'], $row[$i]['userid'], $date_from, $date_to);
        $pdf->SetEmpname($row[$i]['fname'] . ' ' . $row[$i]['lname'] . ' ' . $row[$i]['mname']);
    }
}
$pdf->Output();



/*$time = rand(1,1000);

$filename = __DIR__.'/pdf-files/'.$time.'-dtr-'.$date_from .'-'.$date_to.'_.pdf';
$file =  $time.'-dtr-'.$date_from .'-'.$date_to.'_.pdf';
save_file_name($file,$date_from,$date_to);
$pdf->Output($filename,'F');




$host = $_SERVER['HTTP_HOST'];
$uri = explode('/',$_SERVER['REQUEST_URI']);
$protocol = 'http://';
$address = $protocol.$host.'/'.$uri[1].'/dtr/list/jo';

header('Location:'.$address);
exit();*/


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
        $st = $pdo->prepare("SELECT DISTINCT e.userid,e.fname,e.lname,e.mname FROM users e LEFT JOIN dtr_file d ON e.userid = d.userid WHERE e.usertype != '1' and e.emptype = 'JO' ORDER BY e.lname ASC");
        //$st = $pdo->prepare("SELECT DISTINCT userid,fname,lname,mname FROM users WHERE usertype != '1' and userid !='Unknown User' ORDER BY lname ASC");
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

function save_file_name($filename,$date_from,$date_to)
{
    $pdo = conn();

    $time = date("h:i:sa");
    $date = date("Y-m-d");
    $userid = "0001";
    $query = "INSERT INTO generated_pdf(filename,date_created,time_created,date_from,date_to,created_at,updated_at,type,is_filtered)";
    $query .= " VALUES('".$filename . "','" . $date . "','" . $time . "','". $date_from. "','".$date_to ."',NOW(),NOW(),'JO','1')";


    $st = $pdo->prepare($query);
    $st->execute();

    $pdo = null;
}


?>