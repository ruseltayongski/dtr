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

    $pdf->SetFont('Arial','',8);
    $pdf->SetWidths(array(43.5,43.5,$set_size_center,43.5,43.5));
    $border = 1;
    $pdf->Row(array(
            ["word" => "Civil Service Form No. 48",'font_style' => '','font_size'=>8,'border'=>$border,"position"=>'C'],
            ["word" => "Printed: 2019-04-29",'font_style' => '','font_size'=>8,'border'=>$border,"position"=>'C'],
            ["word" => "",'font_style' => 'B','font_size'=>8,'border'=>$border,"position"=>'C'],
            ["word" => "Civil Service Form No. 48",'font_style' => '','font_size'=>8,'border'=>$border,"position"=>'C'],
            ["word" => "Printed: 2019-04-29",'font_style' => '','font_size'=>8,'border'=>$border,"position"=>'C']
    ));

    $pdf->SetWidths(array(87,$set_size_center,87));
    $pdf->Row(array(
            ["word" => "DAILY TIME RECORD",'font_style' => '','font_size'=>10,'border'=>$border,"position"=>'C'],
            ["word" => "",'font_style' => '','font_size'=>10,'border'=>$border,"position"=>'C'],
            ["word" => "DAILY TIME RECORD",'font_style' => '','font_size'=>10,'border'=>$border,"position"=>'C']
    ));

    $pdf->Row(array(
        ["word" => "                  RUSEL T. TAYONG                  ",'font_style' => 'B','font_size'=>10,'border'=>$border,"position"=>'C'],
        ["word" => "",'font_style' => 'B','font_size'=>10,'border'=>$border,"position"=>'C'],
        ["word" => "                  RUSEL T. TAYONG                  ",'font_style' => 'B','font_size'=>10,'border'=>$border,"position"=>'C']
    ));

    $pdf->Row(array(
        ["word" => "For the month of :",'font_style' => '','font_size'=>8,'border'=>$border,"position"=>'C'],
        ["word" => "",'font_style' => '','font_size'=>8,'border'=>$border,"position"=>'C'],
        ["word" => "For the month of :",'font_style' => '','font_size'=>8,'border'=>$border,"position"=>'C']
    ));

    $pdf->Row(array(
        ["word" => "Official hours for (days A.M. P.M. arrival and departure)",'font_style' => '','font_size'=>8,'border'=>$border,"position"=>'C'],
        ["word" => "",'font_style' => '','font_size'=>8,'border'=>$border,"position"=>'C'],
        ["word" => "Official hours for (days A.M. P.M. arrival and departure)",'font_style' => '','font_size'=>8,'border'=>$border,"position"=>'C']
    ));

    $pdf->SetWidths(array(29,29,29,$set_size_center,29,29,29));
    $pdf->Row(array(
        ["word" => "AM",'font_style' => '','font_size'=>8,'border'=>$border,"position"=>'C'],
        ["word" => "PM",'font_style' => '','font_size'=>8,'border'=>$border,"position"=>'C'],
        ["word" => "UNDERTIME",'font_style' => '','font_size'=>8,'border'=>$border,"position"=>'C'],
        ["word" => "",'font_style' => '','font_size'=>8,'border'=>$border,"position"=>'C'],
        ["word" => "AM",'font_style' => '','font_size'=>8,'border'=>$border,"position"=>'C'],
        ["word" => "PM",'font_style' => '','font_size'=>8,'border'=>$border,"position"=>'C'],
        ["word" => "UNDERTIME",'font_style' => '','font_size'=>8,'border'=>$border,"position"=>'C']
    ));

    $pdf->Row(array(
            ["word" => "DAY ARRIVAL",'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'C'],
            ["word" => "DEPARTURE ARRIVAL",'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'C'],
            ["word" => "DEPARTURE LATE",'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'C'],
            ["word" => "",'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'C'],
            ["word" => "DAY ARRIVAL",'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'C'],
            ["word" => "DEPARTURE ARRIVAL",'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'C'],
            ["word" => "DEPARTURE LATE UT",'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'C']
    ));

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

        if( ($am_in == 'DAY OFF' && $am_out == 'DAY OFF' && $pm_in == 'DAY OFF' && $pm_out == 'DAY OFF') ||
            ($am_in == 'HOLIDAY' && $am_out == 'HOLIDAY' && $pm_in == 'HOLIDAY' && $pm_out == 'HOLIDAY')
        ){
            $pdf->SetWidths(array(14.5,58,14.5,$set_size_center,14.5,58,14.5));
            $pdf->Row(array(
                ["word" => explode('-',$row['datein'])[2]."   ".$day_name,'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'C'],
                ["word" => $am_in,'font_style' => $am_in_style,'font_size'=>7.5,'border'=>$border,"position"=>'C'],
                ["word" => $late.' '.$undertime,'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'C'],
                ["word" => "",'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'C'],
                ["word" => explode('-',$row['datein'])[2]."   ".$day_name,'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'C'],
                ["word" => $am_in,'font_style' => $am_in_style,'font_size'=>7.5,'border'=>$border,"position"=>'C'],
                ["word" => $late.' '.$undertime,'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'C']
            ));
        } else {
            $pdf->SetWidths(array(14.5,14.5,14.5,14.5,14.5,14.5,$set_size_center,14.5,14.5,14.5,14.5,14.5,14.5));
            $pdf->Row(array(
                ["word" => explode('-',$row['datein'])[2]."   ".$day_name,'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'C'],
                ["word" => $am_in,'font_style' => $am_in_style,'font_size'=>7.5,'border'=>$border,"position"=>'C'],
                ["word" => $am_out,'font_style' => $am_out_style,'font_size'=>7.5,'border'=>$border,"position"=>'C'],
                ["word" => $pm_in,'font_style' => $pm_in_style,'font_size'=>7.5,'border'=>$border,"position"=>'C'],
                ["word" => $pm_out,'font_style' => $pm_out_style,'font_size'=>7.5,'border'=>$border,"position"=>'C'],
                ["word" => $late.' '.$undertime,'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'C'],
                ["word" => "",'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'C'],
                ["word" => explode('-',$row['datein'])[2]."   ".$day_name,'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'C'],
                ["word" => $am_in,'font_style' => $am_in_style,'font_size'=>7.5,'border'=>$border,"position"=>'C'],
                ["word" => $am_out,'font_style' => $am_out_style,'font_size'=>7.5,'border'=>$border,"position"=>'C'],
                ["word" => $pm_in,'font_style' => $pm_in_style,'font_size'=>7.5,'border'=>$border,"position"=>'C'],
                ["word" => $pm_out,'font_style' => $pm_out_style,'font_size'=>7.5,'border'=>$border,"position"=>'C'],
                ["word" => $late.' '.$undertime,'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'C']
            ));
        }

    }




}


?>