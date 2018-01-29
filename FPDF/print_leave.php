<?php

include_once 'fpdf.php';
include_once 'dbconn.php';

$pdf = new FPDF('P','mm','A4');
$pdf->AddPage();

$pdf->SetFont('Arial','',6);
$id = NULL;
if(isset($_GET['id'])) {
    $id = $_GET['id'];
}

$pdo = conn();

include_once 'leave/f1_rows.php';
include_once 'leave/f2.rows.php';
include_once 'leave/f3_rows.php';
include_once 'leave/f4_rows.php';
include_once 'leave/f5_rows.php';
include_once 'leave/f6_rows.php';

$pdf->Output();
?>