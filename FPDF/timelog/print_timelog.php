<?php

function conn()
{
    $server = 'localhost';
    try{
        $pdo = new PDO("mysql:host=$server; dbname=dohdtr",'root','');
        $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    }
    catch (PDOException $err) {
        echo "<h3>Can't connect to database server address $server</h3>";
        exit();
    }
    return $pdo;
}

function getLogs($userid,$date_from,$date_to)
{
    $pdo = conn();
    $query = "CALL GETLOGS2('$userid','$date_from','$date_to')";

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

if(isset($_POST['filter_range'])){
    $userid = $_POST['userid'];
    $filter_date = explode(' - ',$_POST['filter_range']);
    $date_from = date("Y-m-d",strtotime($filter_date[0]));
    $date_to = date("Y-m-d",strtotime($filter_date[1]));
    $timelog = getLogs($userid,$date_from,$date_to);

    $set_size_center = 16;

    $pdf->SetWidths(array(43.5,43.5,$set_size_center,43.5,43.5));
    $pdf->SetFont('Arial','',8);
    $pdf->Row(array("Civil Service Form No. 48|L","Printed: 2019-04-29|R","","Civil Service Form No. 48|L","Printed: 2019-04-29|R"));

    $pdf->SetWidths(array(86,$set_size_center,86));
    $pdf->SetFont('Arial','',10);
    $pdf->Row(array("DAILY TIME RECORD|C","","DAILY TIME RECORD|C",));

    $pdf->SetFont('Arial','B',10);
    $pdf->Row(array("                  RUSEL T. TAYONG                  |C","","                  RUSEL T. TAYONG                  |C"));

    $pdf->SetFont('Arial','',8);
    $pdf->Row(array("For the month of :|L","","For the month of :|L"));

    $pdf->SetWidths(array(86,$set_size_center,86));
    $pdf->Row(array("Official hours for (days A.M. P.M. arrival and departure)|L","","Official hours for (days A.M. P.M. arrival and departure)|L",));

    $pdf->SetWidths(array(28.5,31,28.5,$set_size_center,28.5,31,28.5));
    $pdf->Row(array("AM|C","PM|C","UNDERTIME|C","","AM|C","PM|C","UNDERTIME|C"));

    $pdf->SetFont('Arial','',7.5);
    $pdf->Row(array("DAY ARRIVAL","DEPARTURE ARRIVAL","DEPARTURE LATE","","DAY ARRIVAL","DEPARTURE ARRIVAL","DEPARTURE LATE UT"));

    $pdf->SetWidths(array(14.5,14.5,14.5,14.5,14.5,14.5,$set_size_center,14.5,14.5,14.5,14.5,14.5,14.5));
    $pdf->SetFont('Arial','',7.5);
    foreach($timelog as $row){
        $am_in = explode('_',explode('|',$row['time'])[0])[0];
        $am_out = explode('_',explode('|',$row['time'])[1])[0];
        $pm_in = explode('_',explode('|',$row['time'])[2])[0];
        $pm_out = explode('_',explode('|',$row['time'])[3])[0];
        $day_name = date('D', strtotime($row['datein']));
        $pdf->Row(array(explode('-',$row['datein'])[2]."   ".$day_name,$am_in,$am_out,$pm_in,$pm_out,$row['late'].' '.$row['undertime'],"",explode('-',$row['datein'])[2]."   ".$day_name,$am_in,$am_out,$pm_in,$pm_out,$row['late'].' '.$row['undertime']));
    }

}


?>