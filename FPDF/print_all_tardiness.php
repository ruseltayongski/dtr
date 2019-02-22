<?php
require('dbconn.php');
require('fpdf.php');
ini_set('max_execution_time', 0);
ini_set('memory_limit','1000M');
ini_set('max_input_time','300000');
$GLOBALS['rank'] = 0;
class PDF extends FPDF
{
    private $empname = "";
// Page header

    var $widths;
    var $aligns;

    function Header()
    {
        // Logo
        $this->Image(__DIR__.'/image/doh.png',7,6,30);
        // Arial bold 15
        $this->SetFont('Arial','B',15);
        // Move to the right
        $this->Cell(80);
        // Title
        $this->Cell(85);
        $this->Image(__DIR__.'/image/f1.jpg',173,6,30);

        $this->SetFont('Arial','',9);
        $this->SetXY(0,7);
        $this->Cell(210,5,'Republic of the Philippines',0,0,'C');
        $this->SetXY(0,12);
        $this->Cell(210,5,'DEPARTMENT OF HEALTH',0,0,'C');
        $this->SetFont('Arial','B',9);
        $this->SetXY(0,17);
        $this->Cell(210,5,'CENTRAL VISAYAS CENTER for HEALTH DEVELOPMENT',0,0,'C');
        $this->SetFont('Arial','',9);
        $this->SetXY(0,22);
        $this->Cell(210,5,iconv('UTF-8', 'windows-1252','Osmeña Boulevard,Sambag II,Cebu City, 6000 Philippines'),0,0,'C');
        $this->SetXY(0,27);
        $this->Cell(210,5,"Regional Director's Office Tel. No. (032) 253-6355 Fax No. (032) 254-0109",0,0,'C');
        $this->SetXY(0,32);
        $this->Cell(210,5,'Official Website: http://www.ro7.doh.gov.ph Email Address: dohro7@gmail.com',0,0,'C');

        $str = $_POST['filter_range'];
        $temp1 = explode('-',$str);
        $temp2 = array_slice($temp1, 0, 1);
        $tmp = implode(',', $temp2);
        $date_from = date('Y-m-d',strtotime($tmp));
        $temp3 = array_slice($temp1, 1, 1);
        $tmp = implode(',', $temp3);
        $date_to = date('Y-m-d',strtotime($tmp));
        $this->SetFont('Arial','B',9);
        $this->SetXY(0,40);
        $this->Cell(210,10,'TARDINESS FROM '.strtoupper(date("F d,Y",strtotime($date_from))).' TO '.strtoupper(date("F d,Y",strtotime($date_to))),0,0,'C');


        // Line break
        $this->Ln(10);
    }

    function SetWidths($w)
    {
        //Set the array of column widths
        $this->widths=$w;
    }

    function SetAligns($a)
    {
        //Set the array of column alignments
        $this->aligns=$a;
    }

    function printTardiness($data,$count){
        if($count == 0){
            $this->SetWidths(array(15,20,55,67,15,19));
            $this->SetFont('Arial','',10);
            $this->Row(array("RANK","ID #","NAME","LOGS","DAYS","MINUTES"));
            $this->SetFont('Arial','',8);
        }

        $logs = '';
        if(isset($data["am_in"]) || isset($data["pm_in"]) || isset($data["late"])){
            $logs .= "        Day           AM IN            PM IN           LATE\n";
            for($j=0;$j<=count($data["am_in"]);$j++){
                $day = $j+1;
                if(isset($data["day_name"][$j]) && isset($data["late"][$j]) && !empty($data["late"][$j])){
                    //NOTE: IF IT WAS SATURDAY AND SUNDAY THE WILL NOT APPEAR
                    if($day > 9){
                        $logs .= " ".$day."   ";
                    } else {
                        $logs .= " ".$day."     ";
                    }
                    if(isset($data["am_in"][$j])){
                        if($data["day_name"][$j] == 'Mon' || $data["day_name"][$j] == 'Wed')
                            $day_name_space = "         ";
                        elseif($data["day_name"][$j] == 'Tue')
                            $day_name_space = "          ";
                        elseif($data["day_name"][$j] == 'Fri')
                            $day_name_space = "            ";
                        else
                            $day_name_space = "          ";

                        !empty($data["am_in"][$j]) ? $am_in=$data["am_in"][$j] : $am_in = "              ";

                        $logs .= $data["day_name"][$j].$day_name_space.$am_in;
                    }
                    if(isset($data["pm_in"][$j])){
                        !empty($data["pm_in"][$j]) ? $pm_in=$data["pm_in"][$j] : $pm_in = "              ";
                        $logs .= "        ".$pm_in;
                    }
                    if(isset($data["late"][$j])){
                        $logs .= "        ".$data["late"][$j];
                    }
                    $logs .= "\n";
                }

            }
        }
        $this->Row(array($count+1,$data['userid'],utf8_decode(str_replace("??","ñ",$data['name'])),$logs,$data["late_day_total"],$data["late_total"]));
    }

    function Row($data)
    {
        //Calculate the height of the row
        $nb=0;
        for($i=0;$i<count($data);$i++) {
            $displayData = $data[$i];
            $nb = max($nb, $this->NbLines($this->widths[$i], $displayData));
        }
        $h=5*$nb;
        //Issue a page break first if needed
        $this->CheckPageBreak($h);
        //Draw the cells of the row
        for($i=0;$i<count($data);$i++)
        {
            $w=$this->widths[$i];
            $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
            //Save the current position
            $x=$this->GetX();
            $y=$this->GetY();
            //Draw the border
            $this->Rect($x,$y,$w,$h);
            //Print the text
            $displayData = $data[$i];
            $this->MultiCell($w,5,$displayData,0,$a);
            //Put the position to the right of the cell
            $this->SetXY($x+$w,$y);
        }
        //Go to the next line
        $this->Ln($h);
    }

    function CheckPageBreak($h)
    {
        //If the height h would cause an overflow, add a new page immediately
        if($this->GetY()+$h>$this->PageBreakTrigger)
            $this->AddPage($this->CurOrientation);
    }

    function NbLines($w,$txt)
    {
        //Computes the number of lines a MultiCell of width w will take
        $cw=&$this->CurrentFont['cw'];
        if($w==0)
            $w=$this->w-$this->rMargin-$this->x;
        $wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
        $s=str_replace("\r",'',$txt);
        $nb=strlen($s);
        if($nb>0 and $s[$nb-1]=="\n")
            $nb--;
        $sep=-1;
        $i=0;
        $j=0;
        $l=0;
        $nl=1;
        while($i<$nb)
        {
            $c=$s[$i];
            if($c=="\n")
            {
                $i++;
                $sep=-1;
                $j=$i;
                $l=0;
                $nl++;
                continue;
            }
            if($c==' ')
                $sep=$i;
            $l+=$cw[$c];
            if($l>$wmax)
            {
                if($sep==-1)
                {
                    if($i==$j)
                        $i++;
                }
                else
                    $i=$sep+1;
                $sep=-1;
                $j=$i;
                $l=0;
                $nl++;
            }
            else
                $i++;
        }
        return $nl;
    }

    function simplifyDtr($name,$userid,$date_from,$date_to,$sched){
        unset($records);
        $records = array();
        $records["name"] = $name;
        $records["userid"] = $userid;
        $records["date_from"] = $date_from;
        $records["date_to"] = $date_to;
        $records["sched"] = $sched;
        $day1 = explode('-',$date_from);
        $day2 = explode('-',$date_to);
        $records["day1"] = $day1;
        $records["day2"] = $day2;
        $startday = floor($day1[2]);
        $endday = $day2[2];
        $records["startday"] = $startday;
        $records["endday"] = $endday;

        $late_total = 0;
        $late_day_total = 0;
        $ut_total = 0;
        $late = '';
        $ut = '';

        $index = 0;
        $log_date = "";
        $log = "";
        $pdo = conn();
        $query = "SELECT * FROM work_sched WHERE id = '".$sched ."'";
        $st = $pdo->prepare($query);
        $st->execute();
        $sched = $st->fetchAll(PDO::FETCH_ASSOC);
        if(isset($sched) and count($sched) > 0) {
            $s_am_in = $sched[0]["am_in"];
            $s_am_out =  $sched[0]["am_out"];
            $s_pm_in = $sched[0]["pm_in"];
            $s_pm_out = $sched[0]["pm_out"];

            $logs = get_logs($s_am_in,$s_am_out,$s_pm_in,$s_pm_out,$userid,$date_from,$date_to);
            $records["logs"] = $logs;
            if(count($logs) <= 0) {
                //include_once('empty_dtr.php');
            } else {
                $records["month_of"] = date("M",strtotime($date_from)).' '. $day1[2].'-'.$day2[0];
                if(isset($logs) and count($logs)) {
                    unset($am_in_logs);
                    $am_in_logs = array();
                    unset($am_out_logs);
                    $am_out_logs = array();
                    unset($pm_in_logs);
                    $pm_in_logs = array();
                    unset($pm_out_logs);
                    $pm_out_logs = array();
                    unset($late_logs);
                    $late_logs = array();
                    unset($ut_logs);
                    $ut_logs = array();
                    unset($date_in_logs);
                    $date_in_logs = array();
                    unset($day_name_logs);
                    $day_name_logs = array();
                    $records["startday"] = $startday;
                    $records["endday"] = $endday;
                    for($r1 = $startday; $r1 <= $endday; $r1++)
                    {
                        $r1 >= 1 && $r1 < 10 ? $zero='0' : $zero = '';
                        $datein = $day1[0]."-".$day1[1]."-".$zero.$r1;
                        $date_in_logs[] = $datein;
                        if($index != count($logs)) {
                            if($datein == $logs[$index]['datein']){
                                $log_date = $logs[$index]['datein'];
                                $log = $logs[$index];
                                $index = $index + 1;
                            }
                        }
                        $day_name = date('D', strtotime($datein));
                        if($day_name != "Sat" && $day_name != "Sun"){
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
                                    $am_in = $a[0];
                                } else {
                                    $am_in = '';
                                }

                                if(isset($am_out)) {
                                    $b = explode('_', $am_out);
                                    $am_out = $b[0];
                                } else {
                                    $am_out = '';
                                }

                                if(isset($pm_in)) {
                                    $c = explode('_', $pm_in);
                                    $pm_in = $c[0];
                                } else {
                                    $pm_in = '';
                                }

                                if(isset($pm_out)) {
                                    $d = explode('_', $pm_out);
                                    $pm_out = $d[0];
                                } else {
                                    $pm_out = '';
                                }
                                if(!$log['holiday'] == '001' OR !$log['holiday'] == '003' OR !$log['holiday'] == '002') {
                                    if($day_name == 'Mon') {
                                        $late = late('08:00:00',$s_pm_in,$am_in,$pm_in,$log['datein']);
                                    } else {
                                        $late = late($s_am_in,$s_pm_in,$am_in,$pm_in,$log['datein']);
                                    }
                                    if( $late != '' or $late != null )
                                    {
                                        $late_total = $late_total + $late;
                                        $late_day_total++;
                                    }
                                    $ut = undertime($s_am_in,$s_pm_in,$am_in,$pm_in,$s_am_out,$s_pm_out,$am_out,$pm_out,$datein);
                                    if($ut != '' or $ut != null)
                                    {
                                        $ut_total = $ut_total + $ut;
                                    }
                                } else {
                                    //CTO
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

                            if(!$am_in AND !$pm_in AND !$pm_out AND !$am_out){
                                $hol = GET_HOLIDAY($datein);
                                if($hol == 1){
                                    if($day_name != "Sat" AND $day_name != "Sun"){
                                        $am_in = "";
                                        $am_out = "HOLIDAY";
                                        $pm_in = "";
                                        $pm_out = "";
                                    }
                                }else{
                                    if($day_name != "Sat" AND $day_name != "Sun"){
                                        $am_in = "";
                                        $am_out = "ABSENT";
                                        $pm_in = "";
                                        $pm_out = "";
                                    }
                                }
                            }

                            if(!$am_in AND !$am_out AND $pm_in AND $pm_out ){
                                $hol = GET_HOLIDAY($datein);
                                if($hol == 1){
                                    if($day_name != "Sat" AND $day_name != "Sun"){
                                        $am_in = "HOLIDAY";
                                        $am_out = "";
                                    }
                                }else{
                                    if($day_name != "Sat" AND $day_name != "Sun"){
                                        //$am_in = "HALFDAY";
                                        $am_in = "";
                                        $am_out = "";
                                    }
                                }
                            }
                            if($am_in AND $am_out AND !$pm_in AND !$pm_out){
                                $hol = GET_HOLIDAY($datein);
                                if($hol == 1){
                                    if($day_name != "Sat" AND $day_name != "Sun"){
                                        $pm_in = "";
                                        $pm_out = "HOLIDAY";
                                    }
                                }else{
                                    if($day_name != "Sat" AND $day_name != "Sun"){
                                        $pm_in = "";
                                        //$pm_out = "HALFDAY";
                                        $pm_out = "";
                                    }
                                }
                            }
                            $day_name_logs[] = $day_name;
                            $am_in_logs[] = $am_in;
                            $am_out_logs[] = $am_out;
                            $pm_in_logs[] = $pm_in;
                            $pm_out_logs[] = $pm_out;
                            $late_logs[] = $late;
                            $ut_logs = $ut;
                        }
                    } // last loop
                }
                $records['late_total'] = $late_total;
                $records["late_day_total"] = $late_day_total;
                $records['ut_total'] = $ut_total;
                $records["am_in"] = $am_in_logs;
                $records["am_out"] = $am_out_logs;
                $records["pm_in"] = $pm_in_logs;
                $records["pm_out"] = $pm_out_logs;
                $records["late"] = $late_logs;
                $records["ut"] = $ut_logs;
                $records["datein"] = $date_in_logs;
                $records["day_name"] = $day_name_logs;
            }
        }

        return $records;
    }

    function form($data)
    {
        $w = array(10,15,15,15,15);

        if(isset($data['sched']) and count($data['sched']) > 0) {

            if(count($data['logs']) <= 0) {
                //include_once('empty_dtr.php');
            } else {

                $this->Image(__DIR__.'/image/doh2.png', 15, 50,80,80);

                $this->SetFont('Arial','',8);
                $this->SetX(10);
                $this->Cell(40,10,'Civil Service Form No. 48',0);
                $this->SetX(70);
                $this->Cell(40,10,'Printed : '. date('Y-m-d'),0);


                $this->Ln(5);
                $this->SetFont('Arial','',10);
                $this->SetXY(35,15);
                $this->Cell(40,10,'DAILY TIME RECORD',0);

                $this->SetFont('Arial','B',10);
                $this->SetXY(25,22);
                $this->Cell(60,10,'                  '.$data['name'].'                  ',0,1,'C');

                $this->SetFont('Arial','BU',8);
                $this->SetXY(51,22);
                $this->Cell(5,10,'                                                                                                             ',0,0,'C');


                $this->SetFont('Arial','',8);
                $this->SetXY(10,28);
                $this->Cell(40,10,'For the month of : ',0);

                $this->SetFont('Arial','B',9);
                $this->SetXY(33,28);
                $this->Cell(40,10,$data["month_of"],0);

                $this->SetFont('Arial','',8);
                $this->SetXY(60,28);
                $this->Cell(40,10,'ID No :',0);

                $this->SetFont('Arial','B',9);
                $this->SetXY(70,28);
                $this->Cell(40,10,$data['userid'],0);

                $this->SetFont('Arial','',8);
                $this->SetXY(10,33);
                $this->Cell(40,10,'Official hours for (days A.M. P.M. arrival and departure)',0);


                $this->SetFont('Arial','',9);
                $this->SetXY(10,42);
                $this->Cell(89,5,'                     AM                             PM              UNDERTIME',1);


                $this->SetFont('Arial','',7.5);
                $this->SetXY(10,47);
                $this->Cell(89,5,'  DAY     ARRIVAL | DEPARTURE   ARRIVAL | DEPARTURE   LATE | UT',1);

                $this->SetFont('Arial', '', 7.5);
                $this->SetXY(10,54);

                if(isset($data["logs"]) and count($data["logs"]))
                {
                    $count = 0;
                    for($r1 = $data["startday"]; $r1 <= $data["endday"]; $r1++)
                    {
                        $datein = $data["datein"][$count];

                        $this->SetFont('Arial','',7);
                        $this->Cell(4,5,$r1,'');
                        $this->Cell(8,5,$data["day_name"][$count],'');

                        $this->Cell($w[1],5,$data["am_in"][$count],'');

                        $this->Cell($w[1],5,$data["am_out"][$count],'');
                        $this->SetTextColor(0,0,0);

                        $this->Cell(14,5,$data["pm_in"][$count],'',0,'R');
                        $this->SetTextColor(0,0,0);

                        $this->Cell(15,5,$data["pm_out"][$count],'',0,'R');
                        $this->SetTextColor(0,0,0);

                        $this->SetFont('Arial','',8);
                        $this->Cell(8,5,$data["late"][$count],'',0,'R');
                        $this->Cell(9,5,$data["ut"][$count],'',0,'R');

                        $this->Ln();
                        if($r1 == $data["endday"])
                        {
                            $this->SetFont('Arial','BU',8);
                            $this->SetX(52);
                            $this->Cell(5,0,'                                                                                                                   ',0,0,'C');

                            $this->Ln();

                            $this->SetFont('Arial','',9);
                            $this->Cell(10,7,'TOTAL',0,0,'C');
                            $this->SetFont('Arial','',8);

                            $this->SetX(85);
                            $this->Cell(5,7,$data["late_total"],0,0,'C');

                            $this->SetX(93);
                            $this->Cell(5,7,$data["ut_total"],0,0,'C');

                            $this->Ln();

                            $this->SetFont('Arial','',7);
                            $this->SetX(45);
                            $this->Cell(10,3,'      I CERTIFY on my honor that the above entry is true and correct report',0,0,'C');
                            $this->Ln();
                            $this->SetX(40);
                            $this->Cell(10,3,'              of the hours work performed, record of which was made daily at the time',0,0,'C');
                            $this->Ln();
                            $this->SetX(25);
                            $this->Cell(10,2,'     of arrival and departure from the office.',0,0,'C');

                            $this->Ln();
                            $this->Ln();
                            $this->Ln();

                            $this->SetFont('Arial','BU',8);

                            $this->SetX(9);
                            $this->Cell(90,10,$data['name'],0,0,'C');

                            $this->SetX(9);
                            $this->Cell(90,10,'                                                                                                                  ',0,0,'C');

                            $this->Ln();

                            $this->SetFont('Arial','',8);
                            $this->SetX(9);
                            $this->Cell(90,0,'Verified as to the prescribed office hours',0,0,'C');

                            $this->Ln();

                            $this->SetFont('Arial','BU',8);

                            $this->SetX(9);
                            $this->Cell(90,20,'                                                                                                                  ',0,0,'C');

                            $this->Ln();

                            $this->SetFont('Arial','',8);

                            $this->SetX(9);
                            $this->Cell(90,0,'IN-CHARGE',0,0,'C');

                        }
                        $count++;
                    }
                }

                $this->Ln(500);

            }
        } else {
            $this->SetFont('Arial','B',8);
            $this->SetX(100);
            $this->Cell(10,0,"ATTENDANCE FOR USERID".$data['userid']." CANNOT BE GENERATED. NO WORK SCHEDULE IS SET.",0,0,'C');
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
$emptype = '';
if(isset($_POST['filter_range']) and isset($_POST['emptype'])) {
    $emptype = $_POST['emptype'];
    $str = $_POST['filter_range'];
    $temp1 = explode('-',$str);
    $temp2 = array_slice($temp1, 0, 1);
    $tmp = implode(',', $temp2);
    $date_from = date('Y-m-d',strtotime($tmp));
    $temp3 = array_slice($temp1, 1, 1);
    $tmp = implode(',', $temp3);
    $date_to = date('Y-m-d',strtotime($tmp));
    $userid = null;
    api_get_logs($userid,$date_from,$date_to);
} else {
    $pdf->SetFont('Arial','B',10);
    $pdf->SetX(40);
    $pdf->Cell(10,0,"Something went wrong. Go back to webpage",0,0,'C');
    $pdf->Output();
    exit();
}

$pdf->SetFont('Arial','',12);
$employeeList = userlist($emptype);

include('tayong_fpdf/tardiness.php');
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
        echo $ex->getMessage() . $id;
        exit();
    }
    return $row;
}

function userlist($emptype)
{
    $pdo = conn();
    try {
        $st = $pdo->prepare("SELECT DISTINCT userid,fname,lname,mname,sched FROM users WHERE usertype != '1' and emptype = :emptype ORDER BY lname");
        //$st = $pdo->prepare("SELECT DISTINCT userid,fname,lname,mname FROM users WHERE usertype != '1' and userid !='Unknown User' ORDER BY lname ASC");
        $st->bindParam(":emptype", $emptype);
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

function GET_HOLIDAY($datein)
{

    $pdo = conn();
    $query = "";
    $query = "SELECT * FROM edited_logs WHERE datein = '$datein' AND holiday = 'B' AND userid = '001' GROUP BY remark ORDER BY datein";
    try
    {
        $st = $pdo->prepare($query);
        $st->execute();
        $row = $st->fetchAll(PDO::FETCH_ASSOC);
    }catch(PDOException $ex){
        echo $ex->getMessage();
        return 0;
    }
    if(isset($row) AND count($row > 0)) {
        return count($row);
    }
    return 0;

}
function api_get_logs($userid,$date_from,$date_to) {

    $url = "http://192.168.100.81/dtr_api/logs/GetLogs";

    $data = [
        "userid" => $userid,
        "df" => $date_from,
        "dt" => $date_to
    ];

    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    curl_close($curl);

    $logs = json_decode($response);

    $query1 = "INSERT IGNORE INTO dtr_file(userid, datein, time, event,remark, edited, created_at, updated_at) VALUES";

    foreach($logs as $log)
    {
        $query1 .= "('" . $log->userid . "','" . $log->date . "','" . $log->time . "','" . $log->event_type . "','#FP','0',NOW(),NOW()),";
    }
    $query1 .= "('','','','','','',NOW(),NOW())";

    $pdo = conn();
    $st = $pdo->prepare($query1);
    $st->execute();
}

?>
