<?php

include_once 'fpdf.php';
include_once 'dbconn.php';

include_once 'barcode.php';
$pdf=new PDF_Code128('P','mm','LEGAL');
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

include_once 'print_barcode.php';

$pdf->Output();
?>