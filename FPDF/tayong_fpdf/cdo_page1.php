<?php

$GLOBALS['rank'] = 0;

//Table with 20 rows and 4 columns
$pdf->SetWidths(array(15,20,55,45,22,15,19));
srand(microtime()*1000000);
$pdf->SetFont('Arial','',10);
$pdf->Row(array("RANK","ID #","NAME","POSITION","STATUS","DAYS","MINUTES"));
$GLOBALS['rank']++;
$pdf->SetFont('Arial','',8);