<?php

$pdf->SetWidths(array(10,20,55,45,22,15,19));
$pdf->SetFont('Arial','',8);
$pdf->Row(array("RANK","ID #","NAME","POSITION","STATUS","DAYS","MINUTES"));

$set_size_center = 16;
$border = 1;
$pdf->SetFont('Arial','',7.5);
$pdf->SetWidths(array(24,32.4,10,20.6,$set_size_center,24,32.4,10,20.6));
$pdf->Row(array(
    "For the month of :",
    "Apr 01 to Apr 30, 2019",
    "ID No:",
    "200400037",
    "",
    "For the month of :",
    "Apr 01 to Apr 30, 2019",
    "ID No:",
    "200400037"
));

$pdf->output();