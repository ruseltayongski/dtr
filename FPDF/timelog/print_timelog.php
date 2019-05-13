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
    $name = $timelog[0]['name'];

    $set_size_center = 16;
    $pdf->SetFont('Arial','',8);
    $pdf->SetWidths(array(43.5,43.5,$set_size_center,43.5,43.5));
    $border = 0;
    $pdf->Row(array(
            ["word" => "Civil Service Form No. 48",'font_style' => '','font_size'=>8,'border'=>$border,"position"=>'L'],
            ["word" => "Printed: 2019-04-29",'font_style' => '','font_size'=>8,'border'=>$border,"position"=>'R'],
            ["word" => "",'font_style' => 'B','font_size'=>8,'border'=>$border,"position"=>'C'],
            ["word" => "Civil Service Form No. 48",'font_style' => '','font_size'=>8,'border'=>$border,"position"=>'L'],
            ["word" => "Printed: 2019-04-29",'font_style' => '','font_size'=>8,'border'=>$border,"position"=>'R']
    ),5);

    $pdf->SetWidths(array(87,$set_size_center,87));
    $pdf->Row(array(
            ["word" => "DAILY TIME RECORD",'font_style' => '','font_size'=>10,'border'=>$border,"position"=>'C'],
            ["word" => "",'font_style' => '','font_size'=>10,'border'=>$border,"position"=>'C'],
            ["word" => "DAILY TIME RECORD",'font_style' => '','font_size'=>10,'border'=>$border,"position"=>'C']
    ),5);

    $pdf->Ln(2);

    $pdf->Row(array(
        ["word" => $name,'font_style' => 'B','font_size'=>10,'border'=>1,"position"=>'C'],
        ["word" => "",'font_style' => 'B','font_size'=>10,'border'=>$border,"position"=>'C'],
        ["word" => $name,'font_style' => 'B','font_size'=>10,'border'=>1,"position"=>'C']
    ),5);

    $pdf->SetWidths(array(24,32.4,10,20.6,$set_size_center,24,32.4,10,20.6));
    $date_range = date('M',strtotime($date_from)).' '.explode('-',$date_from)[2].' to '.date('M',strtotime($date_to)).' '.explode('-',$date_to)[2].', '.explode('-',$date_from)[0];
    $forthe_month_of = "For the month of :";
    $pdf->Row(array(
        ["word" => $forthe_month_of,'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'L'],
        ["word" => $date_range,'font_style' => 'B','font_size'=>7.5,'border'=>$border,"position"=>'L'],
        ["word" => "ID No:",'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'L'],
        ["word" => $timelog[0]['userid'],'font_style' => 'B','font_size'=>7.5,'border'=>$border,"position"=>'L'],
        ["word" => "",'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'C'],
        ["word" => $forthe_month_of,'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'L'],
        ["word" => $date_range,'font_style' => 'B','font_size'=>7.5,'border'=>$border,"position"=>'L'],
        ["word" => "ID No:",'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'L'],
        ["word" => $timelog[0]['userid'],'font_style' => 'B','font_size'=>7.5,'border'=>$border,"position"=>'L']
    ),5);

    $pdf->SetWidths(array(87,$set_size_center,87));
    $pdf->Row(array(
        ["word" => "Official hours for (days A.M. P.M. arrival and departure)",'font_style' => '','font_size'=>8,'border'=>$border,"position"=>'L'],
        ["word" => "",'font_style' => '','font_size'=>8,'border'=>$border,"position"=>'L'],
        ["word" => "Official hours for (days A.M. P.M. arrival and departure)",'font_style' => '','font_size'=>8,'border'=>$border,"position"=>'L']
    ),5);

    $pdf->SetWidths(array(12.5,30,30,14.5,$set_size_center,12.5,30,30,14.5));
    $pdf->Row(array(
        ["word" => "",'font_style' => '','font_size'=>8,'border'=>$border,"position"=>'C'],
        ["word" => "AM",'font_style' => '','font_size'=>8,'border'=>$border,"position"=>'C'],
        ["word" => "PM",'font_style' => '','font_size'=>8,'border'=>$border,"position"=>'C'],
        ["word" => "MINUTES",'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'C'],
        ["word" => "",'font_style' => '','font_size'=>8,'border'=>$border,"position"=>'C'],
        ["word" => "",'font_style' => '','font_size'=>8,'border'=>$border,"position"=>'C'],
        ["word" => "AM",'font_style' => '','font_size'=>8,'border'=>$border,"position"=>'C'],
        ["word" => "PM",'font_style' => '','font_size'=>8,'border'=>$border,"position"=>'C'],
        ["word" => "MINUTES",'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'C']
    ),5);

    $pdf->SetWidths(array(12.5,15,15,15,15,7.5,7,$set_size_center,12.5,15,15,15,15,7.5,7));
    $pdf->Row(array(
            ["word" => "DAY",'font_style' => '','font_size'=>5.7,'border'=>$border,"position"=>'C'],
            ["word" => "ARRIVAL",'font_style' => '','font_size'=>5.7,'border'=>$border,"position"=>'C'],
            ["word" => "DEPARTURE",'font_style' => '','font_size'=>5.7,'border'=>$border,"position"=>'C'],
            ["word" => "ARRIVAL",'font_style' => '','font_size'=>5.7,'border'=>$border,"position"=>'C'],
            ["word" => "DEPARTURE",'font_style' => '','font_size'=>5.7,'border'=>$border,"position"=>'L'],
            ["word" => "LATE",'font_style' => '','font_size'=>5.7,'border'=>$border,"position"=>'C'],
            ["word" => "UT",'font_style' => '','font_size'=>5.7,'border'=>$border,"position"=>'C'],
            ["word" => "",'font_style' => '','font_size'=>5.7,'border'=>$border,"position"=>'C'],
            ["word" => "DAY",'font_style' => '','font_size'=>5.7,'border'=>$border,"position"=>'C'],
            ["word" => "ARRIVAL",'font_style' => '','font_size'=>5.7,'border'=>$border,"position"=>'C'],
            ["word" => "DEPARTURE",'font_style' => '','font_size'=>5.7,'border'=>$border,"position"=>'C'],
            ["word" => "ARRIVAL",'font_style' => '','font_size'=>5.7,'border'=>$border,"position"=>'C'],
            ["word" => "DEPARTURE",'font_style' => '','font_size'=>5.7,'border'=>$border,"position"=>'L'],
            ["word" => "LATE",'font_style' => '','font_size'=>5.7,'border'=>$border,"position"=>'C'],
            ["word" => "UT",'font_style' => '','font_size'=>5.7,'border'=>$border,"position"=>'C']
    ),5);

    $late_total = 0;
    $undertime_total = 0;
    foreach($timelog as $row){
        $day_name = date('D', strtotime($row['datein']));
        $am_in = str_replace('empty','',explode('_',explode('|',$row['time'])[0])[0]);
        $am_out = str_replace('empty','',explode('_',explode('|',$row['time'])[1])[0]);
        $pm_in = str_replace('empty','',explode('_',explode('|',$row['time'])[2])[0]);
        $pm_out = str_replace('empty','',explode('_',explode('|',$row['time'])[3])[0]);

        $am_in_style = explode('_',explode('|',$row['time'])[0])[1];
        $am_out_style = explode('_',explode('|',$row['time'])[1])[1];
        $pm_in_style = explode('_',explode('|',$row['time'])[2])[1];
        $pm_out_style = explode('_',explode('|',$row['time'])[3])[1];

        $late = str_replace('late','',$row['late']);
        $undertime = str_replace('undertime','',$row['undertime']);
        $late_total += $late;
        $undertime_total += $undertime;

        if(
            ($am_in == 'DAY OFF' && $am_out == 'DAY OFF' && $pm_in == 'DAY OFF' && $pm_out == 'DAY OFF') ||
            ($am_in == 'HOLIDAY' && $am_out == 'HOLIDAY' && $pm_in == 'HOLIDAY' && $pm_out == 'HOLIDAY') ||
            ($am_in == 'CDO' && $am_out == 'CDO' && $pm_in == 'CDO' && $pm_out == 'CDO') ||
            (empty($am_in) && empty($am_out) && empty($pm_in) && empty($pm_out)) ||
            (strpos( $am_in, 'SO #' ) !== false && strpos( $am_out, 'SO #' ) !== false && strpos( $pm_in, 'SO #' ) !== false && strpos( $pm_out, 'SO #' ) !== false ) ||
            (strpos( $am_in, 'LEAVE' ) !== false && strpos( $am_out, 'LEAVE' ) !== false && strpos( $pm_in, 'LEAVE' ) !== false && strpos( $pm_out, 'LEAVE' ) !== false)
        ){
            if(empty($am_in)){
                $whole_log = 'ABSENT';
            } else {
                $whole_log = $am_in;
            }
            $pdf->SetWidths(array(5,7.5,60,7.5,7,$set_size_center,5,7.5,60,7.5,7));
            $pdf->Row(array(
                ["word" => explode('-',$row['datein'])[2],'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'L'],
                ["word" => $day_name,'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'L'],
                ["word" => $whole_log,'font_style' => $am_in_style,'font_size'=>7.5,'border'=>$border,"position"=>'C'],
                ["word" => $late,'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'C'],
                ["word" => $undertime,'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'C'],
                ["word" => "",'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'C'],
                ["word" => explode('-',$row['datein'])[2],'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'L'],
                ["word" => $day_name,'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'L'],
                ["word" => $whole_log,'font_style' => $am_in_style,'font_size'=>7.5,'border'=>$border,"position"=>'C'],
                ["word" => $late,'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'C'],
                ["word" => $undertime,'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'C']
            ),5);
        } //WHOLE LOG EMPTY AND EDITED
        elseif(
            ($am_in == 'DAY OFF' && $am_out == 'DAY OFF') ||
            ($am_in == 'HOLIDAY' && $am_out == 'HOLIDAY') ||
            ($am_in == 'CDO' && $am_out == 'CDO') ||
            (empty($am_in) && empty($am_out)) ||
            (strpos( $am_in, 'SO #' ) !== false && strpos( $am_out, 'SO #' ) !== false) ||
            (strpos( $am_in, 'LEAVE' ) !== false && strpos( $am_out, 'LEAVE' ) !== false)
        ){
            $pdf->SetWidths(array(5,7.5,30,15,15,7.5,7,$set_size_center,5,7.5,30,15,15,7.5,7));
            $pdf->Row(array(
                ["word" => explode('-',$row['datein'])[2],'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'L'],
                ["word" => $day_name,'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'L'],
                ["word" => $am_in,'font_style' => $am_in_style,'font_size'=>7.5,'border'=>$border,"position"=>'C'],
                ["word" => $pm_in,'font_style' => $pm_in_style,'font_size'=>0,'border'=>$border,"position"=>'C'],
                ["word" => $pm_out,'font_style' => $pm_out_style,'font_size'=>7.5,'border'=>$border,"position"=>'C'],
                ["word" => $late,'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'C'],
                ["word" => $undertime,'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'C'],
                ["word" => "",'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'C'],
                ["word" => explode('-',$row['datein'])[2],'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'L'],
                ["word" => $day_name,'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'L'],
                ["word" => $am_in,'font_style' => $am_in_style,'font_size'=>7.5,'border'=>$border,"position"=>'C'],
                ["word" => $pm_in,'font_style' => $pm_in_style,'font_size'=>0,'border'=>$border,"position"=>'C'],
                ["word" => $pm_out,'font_style' => $pm_out_style,'font_size'=>7.5,'border'=>$border,"position"=>'C'],
                ["word" => $late,'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'C'],
                ["word" => $undertime,'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'C']
            ),5);
        }
        elseif(
            ($pm_in == 'DAY OFF' && $pm_out == 'DAY OFF') ||
            ($pm_in == 'HOLIDAY' && $pm_out == 'HOLIDAY') ||
            ($pm_in == 'CDO' && $pm_out == 'CDO') ||
            (empty($pm_in) && empty($pm_out)) ||
            (strpos( $pm_in, 'SO #' ) !== false && strpos( $pm_out, 'SO #' ) !== false ) ||
            (strpos( $pm_in, 'LEAVE' ) !== false && strpos( $pm_out, 'LEAVE' ) !== false)
        ){
            /*if(empty($pm_in)){
                $halfday_log = 'HALF DAY';
            } else {
                $halfday_log = $pm_in;
            }*/
            $pdf->SetWidths(array(5,7.5,15,15,30,7.5,7,$set_size_center,5,7.5,15,15,30,7.5,7));
            $pdf->Row(array(
                ["word" => explode('-',$row['datein'])[2],'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'L'],
                ["word" => $day_name,'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'L'],
                ["word" => $am_in,'font_style' => $am_in_style,'font_size'=>7.5,'border'=>$border,"position"=>'C'],
                ["word" => $am_out,'font_style' => $am_out_style,'font_size'=>7.5,'border'=>$border,"position"=>'C'],
                ["word" => $pm_in,'font_style' => $pm_in_style,'font_size'=>7.5,'border'=>$border,"position"=>'C'],
                ["word" => $late,'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'C'],
                ["word" => $undertime,'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'C'],
                ["word" => "",'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'C'],
                ["word" => explode('-',$row['datein'])[2],'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'L'],
                ["word" => $day_name,'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'L'],
                ["word" => $am_in,'font_style' => $am_in_style,'font_size'=>7.5,'border'=>$border,"position"=>'C'],
                ["word" => $am_out,'font_style' => $am_out_style,'font_size'=>7.5,'border'=>$border,"position"=>'C'],
                ["word" => $pm_in,'font_style' => $pm_in_style,'font_size'=>7.5,'border'=>$border,"position"=>'C'],
                ["word" => $late,'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'C'],
                ["word" => $undertime,'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'C']
            ),5);
        }
        else {
            $pdf->SetWidths(array(5,7.5,15,15,15,15,7.5,7,$set_size_center,5,7.5,15,15,15,15,7.5,7));
            $pdf->Row(array(
                ["word" => explode('-',$row['datein'])[2],'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'L'],
                ["word" => $day_name,'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'L'],
                ["word" => $am_in,'font_style' => $am_in_style,'font_size'=>7.5,'border'=>$border,"position"=>'C'],
                ["word" => $am_out,'font_style' => $am_out_style,'font_size'=>7.5,'border'=>$border,"position"=>'C'],
                ["word" => $pm_in,'font_style' => $pm_in_style,'font_size'=>7.5,'border'=>$border,"position"=>'C'],
                ["word" => $pm_out,'font_style' => $pm_out_style,'font_size'=>7.5,'border'=>$border,"position"=>'C'],
                ["word" => $late,'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'C'],
                ["word" => $undertime,'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'C'],
                ["word" => "",'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'C'],
                ["word" => explode('-',$row['datein'])[2],'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'L'],
                ["word" => $day_name,'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'L'],
                ["word" => $am_in,'font_style' => $am_in_style,'font_size'=>7.5,'border'=>$border,"position"=>'C'],
                ["word" => $am_out,'font_style' => $am_out_style,'font_size'=>7.5,'border'=>$border,"position"=>'C'],
                ["word" => $pm_in,'font_style' => $pm_in_style,'font_size'=>7.5,'border'=>$border,"position"=>'C'],
                ["word" => $pm_out,'font_style' => $pm_out_style,'font_size'=>7.5,'border'=>$border,"position"=>'C'],
                ["word" => $late,'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'C'],
                ["word" => $undertime,'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'C']
            ),5);
        }
    }
    $pdf->Ln(-3);
    $pdf->SetWidths(array(87,$set_size_center,87));
    $pdf->Row(array(
        ["word" => '','font_style' => '','font_size'=>7.5,'border'=>1,"position"=>'C'],
        ["word" => '','font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'C'],
        ["word" => '','font_style' => '','font_size'=>7.5,'border'=>1,"position"=>'C']
    ),5);

    $pdf->SetWidths(array(72.5,7.5,7,$set_size_center,72.5,7.5,7));
    $pdf->Row(array(
        ["word" => 'TOTAL','font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'L'],
        ["word" => $late_total,'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'C'],
        ["word" => $undertime_total,'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'C'],
        ["word" => '','font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'C'],
        ["word" => 'TOTAL','font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'L'],
        ["word" => $late_total,'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'C'],
        ["word" => $undertime_total,'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'C']
    ),5);

    $pdf->SetWidths(array(87,$set_size_center,87));
    $pdf->Row(array(
        ["word" => " I CERTIFY on my honor that the above entry is true and correct report",'font_style' => '','font_size'=>7,'border'=>$border,"position"=>'L'],
        ["word" => '','font_style' => '','font_size'=>7,'border'=>$border,"position"=>'L'],
        ["word" => " I CERTIFY on my honor that the above entry is true and correct report",'font_style' => '','font_size'=>7,'border'=>$border,"position"=>'L']
    ),3);
    $pdf->SetWidths(array(87,$set_size_center,87));
    $pdf->Row(array(
        ["word" => "of the hours work performed, record of which was made daily at the time",'font_style' => '','font_size'=>7,'border'=>$border,"position"=>'L'],
        ["word" => '','font_style' => '','font_size'=>7,'border'=>$border,"position"=>'L'],
        ["word" => "of the hours work performed, record of which was made daily at the time",'font_style' => '','font_size'=>7,'border'=>$border,"position"=>'L']
    ),3);
    $pdf->SetWidths(array(87,$set_size_center,87));
    $pdf->Row(array(
        ["word" => "of arrival and departure from the office.",'font_style' => '','font_size'=>7,'border'=>$border,"position"=>'L'],
        ["word" => '','font_style' => '','font_size'=>7,'border'=>$border,"position"=>'L'],
        ["word" => "of arrival and departure from the office.",'font_style' => '','font_size'=>7,'border'=>$border,"position"=>'L']
    ),3);

    $pdf->Ln(5);
    $pdf->SetWidths(array(87,$set_size_center,87));
    $pdf->Row(array(
        ["word" => $name,'font_style' => 'B','font_size'=>8,'border'=>1,"position"=>'C'],
        ["word" => '','font_style' => 'B','font_size'=>8,'border'=>$border,"position"=>'L'],
        ["word" => $name,'font_style' => 'B','font_size'=>8,'border'=>1,"position"=>'C']
    ),5);

    $pdf->Row(array(
        ["word" => "Verified as to the prescribed office hours",'font_style' => '','font_size'=>8,'border'=>$border,"position"=>'C'],
        ["word" => '','font_style' => '','font_size'=>8,'border'=>$border,"position"=>'L'],
        ["word" => "Verified as to the prescribed office hours",'font_style' => '','font_size'=>8,'border'=>$border,"position"=>'C']
    ),5);

    $pdf->Ln(5);
    $pdf->Row(array(
        ["word" => "",'font_style' => 'B','font_size'=>8,'border'=>1,"position"=>'C'],
        ["word" => '','font_style' => 'B','font_size'=>8,'border'=>$border,"position"=>'L'],
        ["word" => "",'font_style' => 'B','font_size'=>8,'border'=>1,"position"=>'C']
    ),5);
    $pdf->Ln(5);
    $pdf->Row(array(
        ["word" => "IN-CHARGE",'font_style' => '','font_size'=>8,'border'=>$border,"position"=>'C'],
        ["word" => '','font_style' => '','font_size'=>8,'border'=>$border,"position"=>'L'],
        ["word" => "IN-CHARGE",'font_style' => '','font_size'=>8,'border'=>$border,"position"=>'C']
    ),5);


}


?>