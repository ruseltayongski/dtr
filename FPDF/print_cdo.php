<?php

require('fpdf.php');


class PDF_MC_Table extends FPDF
{
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
        $this->Cell(30,30,'Republic of the Philippines',0,0,'C');

        $this->Cell(85);
        $this->Image(__DIR__.'/image/logo.png',173,6,30);
        // Line break
        $this->Ln(30);
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

    function Row($data)
    {
        $position = 'L';
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
            if($GLOBALS['rank'] == 0){
                $this->SetFont('Arial','B',10);
            }
            elseif($GLOBALS['rank'] == 1){
                $this->SetTextColor(255,0,0);
                $this->SetFont('Arial','B',10);
            }
            elseif($GLOBALS['rank'] == 2){
                $this->SetTextColor(0,0,255);
                $this->SetFont('Arial','B',10);
            }
            elseif($GLOBALS['rank'] == 3){
                $this->SetTextColor(0,128,0);
                $this->SetFont('Arial','B',10);
            }
            else {
                $this->SetTextColor(0,0,0);
                $this->SetFont('Arial','',8);
            }

            if($i == 0 || $i == 5 || $i == 6){
                $position = 'C';
            } else {
                $position = 'L';
            }

            $w=$this->widths[$i];
            $a=isset($this->aligns[$i]) ? $this->aligns[$i] : $position;
            //Save the current position
            $x=$this->GetX();
            $y=$this->GetY();
            //Draw the border

            $this->Rect($x,$y,$w,$h);
            //Print the text
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
}

$pdf=new PDF_MC_Table();
$pdf->AddPage();
include 'tayong_fpdf/cdo_page1.php';
?>