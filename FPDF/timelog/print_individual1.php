<?php

require('../fpdf.php');

class PDF_MC_Table extends FPDF
{
    var $widths;
    var $aligns;

    function Header()
    {
        // Logo
        $this->Image(__DIR__.'/../image/doh2.png', 12, 50,80,80);
        $this->Image(__DIR__.'/../image/doh2.png', 118, 50,80,80);
        $this->Ln(5);
    }

// Page footer
    function Footer()
    {
        // Position at 1.5 cm from bottom
        /*$this->SetY(-15);
        $this->SetFont('Times','UI',9);
        $this->Cell(0,10,"OFFICE - MOBILE DEVICE - 08:00 12:00 13:00 17:00",0,0,'L');*/
        $this->SetY(-20);
        $this->SetFont('Times','U',9);
        $this->Cell(0,10,"MOBILE DEVICE - 08:00 12:00 13:00 17:00",0,0,'L');
        $this->SetY(-25);
        $this->SetFont('Arial','BUI',8);
        $this->Cell(0,10,"WEB CREATED - 08:00 12:00 13:00 17:00",0,0,'L');
        $this->SetY(-30);
        $this->SetFont('Arial','',8);
        $this->Cell(0,10,"BIOMETRIC DEVICE - 08:00 12:00 13:00 17:00",0,0,'L');
        $this->SetY(-35);
        $this->SetFont('Arial','B',12);
        $this->Cell(0,10,"Legend:",0,0,'L');
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

    function Row($data,$padding_top)
    {
        //Calculate the height of the row
        $nb=0;
        for($i=0;$i<count($data);$i++){
            $nb=max($nb,$this->NbLines($this->widths[$i],substr($data[$i]["word"], 0, -6)));
            //$nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]["word"]));
        }

        $h=$padding_top*$nb;
        //Issue a page break first if needed
        $this->CheckPageBreak($h);
        //Draw the cells of the row
        for($i=0;$i<count($data);$i++)
        {
            $this->SetFont('Arial',$data[$i]['font_style'],$data[$i]['font_size']);

            $w=$this->widths[$i];
            $a=isset($this->aligns[$i]) ? $this->aligns[$i] : $data[$i]['position'];
            //Save the current position
            $x=$this->GetX();
            $y=$this->GetY();
            //Draw the border
            if($data[$i]['border']){
                $this->Rect($x,$y+4,$w,0); //border
                //$this->Rect($x,$y,$w,$h); //border
            }
            //Print the text
            $this->MultiCell($w,5,$data[$i]['word'],0,$a);
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

$pdf=new PDF_MC_Table('P','mm','A4');
$pdf->AddPage();
$pdf->AliasNbPages();
include 'print_timelog.php';
$pdf->Output();
?>