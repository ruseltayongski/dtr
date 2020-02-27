<?php
session_start();

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

function getLogs($query_req)
{
    $pdo = conn();

    try
    {
        $st = $pdo->prepare($query_req);
        $st->execute();
        $row = $st->fetchAll(PDO::FETCH_ASSOC);
    }catch(PDOException $ex){
        echo $ex->getMessage();
        exit();
    }
    return $row;
}

function getJobStatus($userid)
{
    $db= conn();
    $sql="SELECT job_status FROM pis.personal_information WHERE userid = ?";
    $pdo = $db->prepare($sql);
    $pdo->execute(array($userid));
    $row = $pdo->fetch();
    $db = null;
    return $row;
}

function api_get_logs($userid,$date_from,$date_to) {
    $url = "http://192.168.81.7/dtr_api/logs/GetLogs";

    $data = [
        "userid" => $userid,
        "df" => $date_from,
        "dt" => $date_to
    ];

    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    curl_close($curl);

    $logs = json_decode($response);


    $query1 = "INSERT IGNORE INTO dtr_file(userid, datein, time, event,remark, edited, created_at, updated_at) VALUES";

    foreach($logs as $log)
    {
        $query1 .= "('" . $log->userid . "','" . $log->date . "','" . $log->time . "','" . $log->event_type . "','#FP','0',NOW(),NOW()),";
    }
    $query1 .= "('','','','','','',NOW(),NOW())";

    $pdo = conn();
    $st = $pdo->prepare($query1);
    $st->execute();
}

if(isset($_POST['tardiness_undertime_date'])){
    $_SESSION['tardiness_undertime_date'] = $_POST['tardiness_undertime_date'];
    $userid = '0881';
    $filter_date = explode(' - ',$_POST['tardiness_undertime_date']);
    $date_from = date("Y-m-d",strtotime($filter_date[0]));
    $date_to = date("Y-m-d",strtotime($filter_date[1]));

    isset($_POST['job_status']) ? $job_status = $_POST['job_status'] : $job_status = getJobStatus($userid)['job_status'];
    date("Y",strtotime($date_from)) >= 2020 && $job_status == 'Permanent' ? $query_req = "CALL TardinessUndertimePermanent('$date_from','$date_to')" : $query_req = "CALL TardinessUndertimePermanent('$date_from','$date_to')";

    api_get_logs($userid,$date_from,$date_to);
    $timelog = getLogs($query_req);

    $total_late = 0;

    $flag_name = [];
    $flag_total_late = '';
    $name = '';
    $total_row = count($timelog);
    $count_row = 0;
    $count_personnel = 0;
    foreach($timelog as $row){
        $count_row++;
        if($name != $row['name'] && !empty($name)) {
            $pdf->Ln(-3);
            $pdf->SetWidths(array(87, $set_size_center, 87));
            $pdf->Row(array(
                ["word" => '', 'font_style' => '', 'font_size' => 7.5, 'border' => 1, "position" => 'C'],
                ["word" => '', 'font_style' => '', 'font_size' => 7.5, 'border' => $border, "position" => 'C'],
                ["word" => '', 'font_style' => '', 'font_size' => 7.5, 'border' => 1, "position" => 'C']
            ), 5);

            $pdf->SetWidths(array(72.5, 7.5, 7, $set_size_center, 72.5, 7.5, 7));
            $pdf->Row(array(
                ["word" => 'TOTAL', 'font_style' => '', 'font_size' => 7.5, 'border' => $border, "position" => 'L'],
                ["word" => $total_late, 'font_style' => '', 'font_size' => 7, 'border' => $border, "position" => 'C'],
                ["word" => '', 'font_style' => '', 'font_size' => 7.5, 'border' => $border, "position" => 'C'],
                ["word" => '', 'font_style' => '', 'font_size' => 7.5, 'border' => $border, "position" => 'C'],
                ["word" => 'TOTAL', 'font_style' => '', 'font_size' => 7.5, 'border' => $border, "position" => 'L'],
                ["word" => $total_late, 'font_style' => '', 'font_size' => 7, 'border' => $border, "position" => 'C'],
                ["word" => '', 'font_style' => '', 'font_size' => 7.5, 'border' => $border, "position" => 'C']
            ), 5);
            $pdf->Ln(3);
        }

        $name = $row['name'];
        if(!isset($flag_name[$name])){
            $count_personnel++;
            $set_size_center = 16;
            $pdf->SetFont('Arial','',8);
            $pdf->SetWidths(array(43.5,43.5,$set_size_center,43.5,43.5));
            $border = 0;

            $pdf->SetWidths(array(10,77,$set_size_center,10,77));
            $pdf->Row(array(
                ["word" => $count_personnel,'font_style' => 'B','font_size'=>10,'border'=>1,"position"=>'L'],
                ["word" => $name,'font_style' => 'B','font_size'=>10,'border'=>1,"position"=>'C'],
                ["word" => "",'font_style' => 'B','font_size'=>10,'border'=>$border,"position"=>'C'],
                ["word" => $count_personnel,'font_style' => 'B','font_size'=>10,'border'=>1,"position"=>'L'],
                ["word" => $name,'font_style' => 'B','font_size'=>10,'border'=>1,"position"=>'C']
            ),5);

            $pdf->SetWidths(array(24,32.4,10,20.6,$set_size_center,24,32.4,10,20.6));
            $date_range = date('M',strtotime($date_from)).' '.explode('-',$date_from)[2].' to '.date('M',strtotime($date_to)).' '.explode('-',$date_to)[2].', '.explode('-',$date_from)[0];
            $forthe_month_of = "For the month of :";
            $pdf->Row(array(
                ["word" => $forthe_month_of,'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'L'],
                ["word" => $date_range,'font_style' => 'B','font_size'=>7.5,'border'=>$border,"position"=>'L'],
                ["word" => "ID No:",'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'L'],
                ["word" => $row['userid'],'font_style' => 'B','font_size'=>7.5,'border'=>$border,"position"=>'L'],
                ["word" => "",'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'C'],
                ["word" => $forthe_month_of,'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'L'],
                ["word" => $date_range,'font_style' => 'B','font_size'=>7.5,'border'=>$border,"position"=>'L'],
                ["word" => "ID No:",'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'L'],
                ["word" => $row['userid'],'font_style' => 'B','font_size'=>7.5,'border'=>$border,"position"=>'L']
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
                ["word" => "",'font_style' => '','font_size'=>5.7,'border'=>$border,"position"=>'C'],
                ["word" => "",'font_style' => '','font_size'=>5.7,'border'=>$border,"position"=>'C'],
                ["word" => "DAY",'font_style' => '','font_size'=>5.7,'border'=>$border,"position"=>'C'],
                ["word" => "ARRIVAL",'font_style' => '','font_size'=>5.7,'border'=>$border,"position"=>'C'],
                ["word" => "DEPARTURE",'font_style' => '','font_size'=>5.7,'border'=>$border,"position"=>'C'],
                ["word" => "ARRIVAL",'font_style' => '','font_size'=>5.7,'border'=>$border,"position"=>'C'],
                ["word" => "DEPARTURE",'font_style' => '','font_size'=>5.7,'border'=>$border,"position"=>'L'],
                ["word" => "LATE",'font_style' => '','font_size'=>5.7,'border'=>$border,"position"=>'C'],
                ["word" => "",'font_style' => '','font_size'=>5.7,'border'=>$border,"position"=>'C']
            ),5);
            $total_late = $row['total_late'];
        }
        $flag_name[$name] = true;


        $day_name = date('D', strtotime($row['datein']));
        $am_in = str_replace('empty','',explode('_',explode('|',$row['time'])[0])[0]);
        $am_out = str_replace('empty','',explode('_',explode('|',$row['time'])[1])[0]);
        $pm_in = str_replace('empty','',explode('_',explode('|',$row['time'])[2])[0]);
        $pm_out = str_replace('empty','',explode('_',explode('|',$row['time'])[3])[0]);

        $am_in_style = explode('_',explode('|',$row['time'])[0])[1];
        $am_out_style = explode('_',explode('|',$row['time'])[1])[1];
        $pm_in_style = explode('_',explode('|',$row['time'])[2])[1];
        $pm_out_style = explode('_',explode('|',$row['time'])[3])[1];


        $late = $row['late'];

        if(
            ($am_in == 'DAY OFF' && $am_out == 'DAY OFF' && $pm_in == 'DAY OFF' && $pm_out == 'DAY OFF') ||
            ($am_in == 'HOLIDAY' && $am_out == 'HOLIDAY' && $pm_in == 'HOLIDAY' && $pm_out == 'HOLIDAY') ||
            ($am_in == 'JO BREAK' && $am_out == 'JO BREAK' && $pm_in == 'JO BREAK' && $pm_out == 'JO BREAK') ||
            ($am_in == 'CDO' && $am_out == 'CDO' && $pm_in == 'CDO' && $pm_out == 'CDO') ||
            (empty($am_in) && empty($am_out) && empty($pm_in) && empty($pm_out)) ||
            (
                strpos( $am_in, 'SO #' ) !== false && strpos( $am_out, 'SO #' ) !== false && strpos( $pm_in, 'SO #' ) !== false && strpos( $pm_out, 'SO #' ) !== false
                && $am_in == $pm_in
            ) ||
            (
                strpos( $am_in, 'TO #' ) !== false && strpos( $am_out, 'TO #' ) !== false && strpos( $pm_in, 'TO #' ) !== false && strpos( $pm_out, 'TO #' ) !== false
                && $am_in == $pm_in
            ) ||
            ( strpos( $am_in, 'LEAVE' ) !== false && strpos( $am_out, 'LEAVE' ) !== false && strpos( $pm_in, 'LEAVE' ) !== false && strpos( $pm_out, 'LEAVE' ) !== false )
        ){
            if(empty($am_in)){
                $whole_log = 'ABSENT';
                $late = '480';
            } else {
                $whole_log = $am_in;
                $late = '';
            }
            $pdf->SetWidths(array(5,7.5,60,7.5,7,$set_size_center,5,7.5,60,7.5,7));
            $pdf->Row(array(
                ["word" => explode('-',$row['datein'])[2],'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'L'],
                ["word" => $day_name,'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'L'],
                ["word" => $whole_log,'font_style' => $am_in_style,'font_size'=>7.5,'border'=>$border,"position"=>'C'],
                ["word" => $late,'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'C'],
                ["word" => '','font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'C'],
                ["word" => "",'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'C'],
                ["word" => explode('-',$row['datein'])[2],'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'L'],
                ["word" => $day_name,'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'L'],
                ["word" => $whole_log,'font_style' => $am_in_style,'font_size'=>7.5,'border'=>$border,"position"=>'C'],
                ["word" => $late,'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'C'],
                ["word" => '','font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'C']
            ),5);
        } //WHOLE LOG EMPTY AND EDITED
        elseif(
            ($am_in == 'DAY OFF' && $am_out == 'DAY OFF') ||
            ($am_in == 'HOLIDAY' && $am_out == 'HOLIDAY') ||
            ($am_in == 'CDO' && $am_out == 'CDO') ||
            (empty($am_in) && empty($am_out)) ||
            (strpos( $am_in, 'SO #' ) !== false && strpos( $am_out, 'SO #' ) !== false) ||
            (strpos( $am_in, 'TO #' ) !== false && strpos( $am_out, 'TO #' ) !== false) ||
            (strpos( $am_in, 'LEAVE' ) !== false && strpos( $am_out, 'LEAVE' ) !== false)
        ){
            if(explode('_',explode('|',$row['time'])[0])[0] == 'empty' && explode('_',explode('|',$row['time'])[1])[0]){
                $halfday_log = 'HALF DAY';
            } else {
                $halfday_log = explode('_',explode('|',$row['time'])[0])[0];
            }
            $late = $row['late'];

            $afternoon_width_pm_in = 15;
            $afternoon_width_pm_out = 15;
            if( (strpos( $pm_in, 'SO #' ) !== false && strpos( $pm_out, 'SO #' ) !== false ) ||
                (strpos( $pm_in, 'TO #' ) !== false && strpos( $pm_out, 'TO #' ) !== false )
            ){
                $pm_out = '';
                $afternoon_width_pm_in = 30;
                $afternoon_width_pm_out = 0;
            }

            $pdf->SetWidths(array(5,7.5,30,$afternoon_width_pm_in,$afternoon_width_pm_out,7.5,7,$set_size_center,5,7.5,30,$afternoon_width_pm_in,$afternoon_width_pm_out,7.5,7));
            $pdf->Row(array(
                ["word" => explode('-',$row['datein'])[2],'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'L'],
                ["word" => $day_name,'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'L'],
                ["word" => $halfday_log,'font_style' => $am_in_style,'font_size'=>7.5,'border'=>$border,"position"=>'C'],
                ["word" => $pm_in,'font_style' => $pm_in_style,'font_size'=>0,'border'=>$border,"position"=>'C'],
                ["word" => $pm_out,'font_style' => $pm_out_style,'font_size'=>7.5,'border'=>$border,"position"=>'C'],
                ["word" => $late,'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'C'],
                ["word" => '','font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'C'],
                ["word" => "",'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'C'],
                ["word" => explode('-',$row['datein'])[2],'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'L'],
                ["word" => $day_name,'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'L'],
                ["word" => $halfday_log,'font_style' => $am_in_style,'font_size'=>7.5,'border'=>$border,"position"=>'C'],
                ["word" => $pm_in,'font_style' => $pm_in_style,'font_size'=>0,'border'=>$border,"position"=>'C'],
                ["word" => $pm_out,'font_style' => $pm_out_style,'font_size'=>7.5,'border'=>$border,"position"=>'C'],
                ["word" => $late,'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'C'],
                ["word" => '','font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'C']
            ),5);
        }
        elseif(
            ($pm_in == 'DAY OFF' && $pm_out == 'DAY OFF') ||
            ($pm_in == 'HOLIDAY' && $pm_out == 'HOLIDAY') ||
            ($pm_in == 'CDO' && $pm_out == 'CDO') ||
            (empty($pm_in) && empty($pm_out)) ||
            (strpos( $pm_in, 'SO #' ) !== false && strpos( $pm_out, 'SO #' ) !== false ) ||
            (strpos( $pm_in, 'TO #' ) !== false && strpos( $pm_out, 'TO #' ) !== false ) ||
            (strpos( $pm_in, 'LEAVE' ) !== false && strpos( $pm_out, 'LEAVE' ) !== false)
        ){
            if(explode('_',explode('|',$row['time'])[2])[0] == 'empty' && explode('_',explode('|',$row['time'])[3])[0] == 'empty'){
                $halfday_log = 'HALF DAY';
            } else {
                $halfday_log = explode('_',explode('|',$row['time'])[2])[0];
            }
            $late = $row['late'];

            $pdf->SetWidths(array(5,7.5,15,15,30,7.5,7,$set_size_center,5,7.5,15,15,30,7.5,7));
            $pdf->Row(array(
                ["word" => explode('-',$row['datein'])[2],'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'L'],
                ["word" => $day_name,'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'L'],
                ["word" => $am_in,'font_style' => $am_in_style,'font_size'=>7.5,'border'=>$border,"position"=>'C'],
                ["word" => $am_out,'font_style' => $am_out_style,'font_size'=>7.5,'border'=>$border,"position"=>'C'],
                ["word" => $halfday_log,'font_style' => $pm_in_style,'font_size'=>7.5,'border'=>$border,"position"=>'C'],
                ["word" => $late,'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'C'],
                ["word" => '','font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'C'],
                ["word" => "",'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'C'],
                ["word" => explode('-',$row['datein'])[2],'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'L'],
                ["word" => $day_name,'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'L'],
                ["word" => $am_in,'font_style' => $am_in_style,'font_size'=>7.5,'border'=>$border,"position"=>'C'],
                ["word" => $am_out,'font_style' => $am_out_style,'font_size'=>7.5,'border'=>$border,"position"=>'C'],
                ["word" => $halfday_log,'font_style' => $pm_in_style,'font_size'=>7.5,'border'=>$border,"position"=>'C'],
                ["word" => $late,'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'C'],
                ["word" => '','font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'C']
            ),5);
        }
        elseif($am_in == '' && $am_out == ''){
            $pdf->SetWidths(array(5,7.5,15,15,30,7.5,7,$set_size_center,5,7.5,15,15,30,7.5,7));
            $pdf->Row(array(
                ["word" => explode('-',$row['datein'])[2],'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'L'],
                ["word" => $day_name,'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'L'],
                ["word" => 'HALF DAY','font_style' => $am_in_style,'font_size'=>7.5,'border'=>$border,"position"=>'C'],
                ["word" => $am_out,'font_style' => $am_out_style,'font_size'=>7.5,'border'=>$border,"position"=>'C'],
                ["word" => $pm_in,'font_style' => $pm_in_style,'font_size'=>7.5,'border'=>$border,"position"=>'C'],
                ["word" => $late,'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'C'],
                ["word" => '','font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'C'],
                ["word" => "",'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'C'],
                ["word" => explode('-',$row['datein'])[2],'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'L'],
                ["word" => $day_name,'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'L'],
                ["word" => 'HALF DAY','font_style' => $am_in_style,'font_size'=>7.5,'border'=>$border,"position"=>'C'],
                ["word" => $am_out,'font_style' => $am_out_style,'font_size'=>7.5,'border'=>$border,"position"=>'C'],
                ["word" => $pm_in,'font_style' => $pm_in_style,'font_size'=>7.5,'border'=>$border,"position"=>'C'],
                ["word" => $late,'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'C'],
                ["word" => '','font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'C']
            ),5);
        }
        else {
            if($late == 0){
                $late = '';
            }
            $pdf->SetWidths(array(5,7.5,15,15,15,15,7.5,7,$set_size_center,5,7.5,15,15,15,15,7.5,7));
            $pdf->Row(array(
                ["word" => explode('-',$row['datein'])[2],'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'L'],
                ["word" => $day_name,'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'L'],
                ["word" => $am_in,'font_style' => $am_in_style,'font_size'=>7.5,'border'=>$border,"position"=>'C'],
                ["word" => $am_out,'font_style' => $am_out_style,'font_size'=>7.5,'border'=>$border,"position"=>'C'],
                ["word" => $pm_in,'font_style' => $pm_in_style,'font_size'=>7.5,'border'=>$border,"position"=>'C'],
                ["word" => $pm_out,'font_style' => $pm_out_style,'font_size'=>7.5,'border'=>$border,"position"=>'C'],
                ["word" => $late,'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'C'],
                ["word" => '','font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'C'],
                ["word" => "",'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'C'],
                ["word" => explode('-',$row['datein'])[2],'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'L'],
                ["word" => $day_name,'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'L'],
                ["word" => $am_in,'font_style' => $am_in_style,'font_size'=>7.5,'border'=>$border,"position"=>'C'],
                ["word" => $am_out,'font_style' => $am_out_style,'font_size'=>7.5,'border'=>$border,"position"=>'C'],
                ["word" => $pm_in,'font_style' => $pm_in_style,'font_size'=>7.5,'border'=>$border,"position"=>'C'],
                ["word" => $pm_out,'font_style' => $pm_out_style,'font_size'=>7.5,'border'=>$border,"position"=>'C'],
                ["word" => $late,'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'C'],
                ["word" => '','font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'C']
            ),5);
        }

        if($total_row == $count_row) {
            $pdf->Ln(-3);
            $pdf->SetWidths(array(87, $set_size_center, 87));
            $pdf->Row(array(
                ["word" => '', 'font_style' => '', 'font_size' => 7.5, 'border' => 1, "position" => 'C'],
                ["word" => '', 'font_style' => '', 'font_size' => 7.5, 'border' => $border, "position" => 'C'],
                ["word" => '', 'font_style' => '', 'font_size' => 7.5, 'border' => 1, "position" => 'C']
            ), 5);

            $pdf->SetWidths(array(72.5, 7.5, 7, $set_size_center, 72.5, 7.5, 7));
            $pdf->Row(array(
                ["word" => 'TOTAL', 'font_style' => '', 'font_size' => 7.5, 'border' => $border, "position" => 'L'],
                ["word" => $row['total_late'], 'font_style' => '', 'font_size' => 7, 'border' => $border, "position" => 'C'],
                ["word" => '', 'font_style' => '', 'font_size' => 7.5, 'border' => $border, "position" => 'C'],
                ["word" => '', 'font_style' => '', 'font_size' => 7.5, 'border' => $border, "position" => 'C'],
                ["word" => 'TOTAL', 'font_style' => '', 'font_size' => 7.5, 'border' => $border, "position" => 'L'],
                ["word" => $row['total_late'], 'font_style' => '', 'font_size' => 7, 'border' => $border, "position" => 'C'],
                ["word" => '', 'font_style' => '', 'font_size' => 7.5, 'border' => $border, "position" => 'C']
            ), 5);
        }

    }


}


?>