<?php

include_once 'fpdf.php';
include_once 'dbconn.php';

include_once 'barcode.php';
$pdf=new PDF_Code128('P','mm',array(210, 330));
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

//include_once 'leave/f6_rows.php';

$pdo = new PDO("mysql:host=localhost; dbname=dohdtr",'root','D0h7_1T');
$pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
$query = "SELECT route_no FROM dohdtr.leave WHERE id = ? LIMIT 1";
$st = $pdo->prepare($query);
$st->execute(array($id));
$route_no = $st->fetch(PDO::FETCH_ASSOC);

//$st = $pdo->prepare("SELECT route_no FROM dohdtr.leave WHERE id = ? LIMIT 1");
//$st->execute(array($id));
//$route_no = $st->fetch(PDO::FETCH_ASSOC)['route_no'];

include_once 'print_barcode.php';

$pdf->Output();
?>