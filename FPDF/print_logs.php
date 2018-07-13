

<?php

require('dbconn.php');
require('fpdf.php');
ini_set('max_execution_time', 0);
ini_set('memory_limit','1000M');
ini_set('max_input_time','300000');
class PDF extends FPDF
{
    var $widths;
    var $aligns;

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

    function Row($data,$border = 0)
    {
        //Calculate the height of the row
        $nb=0;
        for($i=0;$i<count($data);$i++)
            $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
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
            if($border == 0)
            {
                $this->Rect($x,$y,$w,$h);
            }

            //Print the text
            if($i == count($data)) {
                $this->SetFont('Arial','',5);
            }
            $this->MultiCell($w,5,$data[$i],0,$a);
            //Put the position to the right of the cell
            $this->SetXY($x+$w,$y);
        }
        //Go to the next line
        $this->Ln($h);
    }
    

    function CheckPageBreak($h)
    {
        //If the height h would cause an overflow, add a new page immediately
        if($this->GetY()+$h>$this->PageBreakTrigger) {
            $this->AddPage($this->CurOrientation);
            $this->SetFont('Arial','B',8);
            
            $this->Cell(20,5,'USERID','LTRB',0,'C',0);
            $this->Cell(60,5,'NAME','LTRB',0,'C',0);
            $this->Cell(25,5,'DATE','LTRB',0,'C',0);
            $this->Cell(20,5,'WEEKDAY','LTRB',0,'C',0);
            $this->Cell(30,5,'IN','LTRB',0,'C',0);
            $this->Cell(30,5,'OUT','LTRB',0,'C',0);

            $this->Ln();
            
        }
    }

    function NbLines($w,$txt)
    {
        
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

    

}


$pdf = new PDF('P','mm','A4');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','',12);


include_once 'thead.php';
$pdf->Ln();
$pdo = conn();

$date_from = '';
$date_to = '';
$userid = '';

if(isset($_POST['filter_range'])) {
    $str = $_POST['filter_range'];
    $temp1 = explode('-',$str);
    $temp2 = array_slice($temp1, 0, 1);
    $tmp = implode(',', $temp2);
    $date_from = date('Y-m-d',strtotime($tmp));
    $temp3 = array_slice($temp1, 1, 1);
    $tmp = implode(',', $temp3);
    $date_to = date('Y-m-d',strtotime($tmp));
    
} else {
    $pdf->SetFont('Arial','B',10);
    $pdf->SetX(40);
    $pdf->Cell(10,0,"Something went wrong. Go back to webpage",0,0,'C');
    $pdf->Output();
    exit();
}

$query = "SELECT userid,fname,lname FROM users";


$emptype = "";
if(!empty($_POST['emptype'])){
    $emptype = $_POST['emptype'];
    $query .= " WHERE emptype = '$emptype'";
}


if(!empty($_POST['userid'])){
    $userid = $_POST['userid'];
    $query .=" AND userid =$userid";
}

$query .= " ORDER BY lname ASC";


$st = $pdo->prepare($query);
$st->execute();
$users = $st->fetchAll(PDO::FETCH_ASSOC);

$pdf->SetWidths(array(20,60,25,20,30,30));

$day1 = explode('-',$date_from);
$day2 = explode('-',$date_to);

$startday = floor($day1[2]);
$endday = $day2[2];

foreach($users as $user)
{
    $name = $user['lname']." ".$user['fname'];
    if(isset($user['lname']) and !empty($user['fname'])){
        for($r1 = $startday; $r1 <= $endday; $r1++)
        {
            $r1 >= 1 && $r1 < 10 ? $zero='0' : $zero = '';
            $datein = $day1[0]."-".$day1[1]."-".$zero.$r1;
            $day_name = date('D', strtotime($datein));
            $logs = get_user_logs($user['userid'],$datein);
            
            $in = "";
            $out = "";
        
            foreach($logs as $log)
            {
                if($log['event'] == "IN"){
                    $in .= $log['time'] ."\n";
                }else if($log['event'] == "OUT"){
                    $out .= $log['time'] ."\n";
                }
                
            }
            $pdf->SetFont('Arial','',8);
            $pdf->Row(array($user['userid'],$name,$datein,$day_name,$in,$out));
        }
    }
    
    
}


$pdf->Output();

function get_user_logs($userid,$datein){
    $pdo = conn();
    $query = "SELECT time,event,remark FROM dtr_file WHERE userid ='$userid' AND datein = '$datein' AND remark ='#FP#'";
    
    $st = $pdo->prepare($query);
    $st->execute();
    $logs = $st->fetchAll(PDO::FETCH_ASSOC);

    return $logs;

}
