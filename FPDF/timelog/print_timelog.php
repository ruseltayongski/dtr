<?php
session_start();

function conn()
{
    $server = '192.168.110.31';
    try{
        $pdo = new PDO("mysql:host=$server; dbname=dohdtr",'rtayong_31','rtayong_31');
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


function offsen_in($userid,$datein)
{
    $db= conn();
    $sql="SELECT time FROM dohdtr.dtr_file where userid = ? and datein = ? order by time asc limit 1";
    $pdo = $db->prepare($sql);
    $pdo->execute(array($userid,$datein));
    $row = $pdo->fetch();
    $db = null;
    return $row;
}


function offsen_out($userid,$datein)
{
    $db= conn();
    $sql="SELECT time FROM dohdtr.dtr_file where userid = ? and datein = ? order by time desc limit 1";
    $pdo = $db->prepare($sql);
    $pdo->execute(array($userid,$datein));
    $row = $pdo->fetch();
    $db = null;
    return $row;
}

function api_get_logs($userid,$date_from,$date_to) {
    $url = "http://192.168.81.7/dtr_api/logs/GetLogs/".$userid;

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

if(isset($_POST['filter_range'])){
    $_SESSION['date_range'] = $_POST['filter_range'];
    $userid = $_POST['userid'];
    $filter_date = explode(' - ',$_POST['filter_range']);
    $date_from = date("Y-m-d",strtotime($filter_date[0]));
    $date_to = date("Y-m-d",strtotime($filter_date[1]));
    $september_2_2024 = "2024-09-01";
    
    isset($_POST['job_status']) ? $job_status = $_POST['job_status'] : $job_status = getJobStatus($userid)['job_status'];
//    date("Y",strtotime($date_from)) >= 2020 && $job_status == 'Permanent' ? $query_req = "CALL Gliding_2020('$userid','$date_from','$date_to')"
// : $query_req = "CALL GETLOGS2('$userid','$date_from','$date_to')";

    if($job_status == 'Permanent' && date("Y",strtotime($date_from)) >= 2020){
        if($date_from >= $september_2_2024){
            $query_req = "CALL Gliding_2024('$userid','$date_from','$date_to')";
        }else{
            $query_req = "CALL Gliding_2020('$userid','$date_from','$date_to')";
        }
    }else{
        if($date_from >= $september_2_2024 && date("Y",strtotime($date_from)) >= 2020){
            $query_req = "CALL GETLOGS2024('$userid','$date_from','$date_to')";
        }else{
            $query_req = "CALL GETLOGS2('$userid','$date_from','$date_to')";
        }
    }


    api_get_logs($userid,$date_from,$date_to);
    $timelog = getLogs($query_req);

    $name = $timelog[0]['name'];

    $set_size_center = 16;
    $pdf->SetFont('Arial','',8);
    $pdf->SetWidths(array(43.5,43.5,$set_size_center,43.5,43.5));
    $border = 0;
    $pdf->Row(array(
            ["word" => "Civil Service Form No. 48",'font_style' => '','font_size'=>8,'border'=>$border,"position"=>'L'],
            ["word" => "Printed: ".date("Y-m-d"),'font_style' => '','font_size'=>8,'border'=>$border,"position"=>'R'],
            ["word" => "",'font_style' => 'B','font_size'=>8,'border'=>$border,"position"=>'C'],
            ["word" => "Civil Service Form No. 48",'font_style' => '','font_size'=>8,'border'=>$border,"position"=>'L'],
            ["word" => "Printed: ".date("Y-m-d"),'font_style' => '','font_size'=>8,'border'=>$border,"position"=>'R']
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


        $late = $row['late'];
        $undertime = $row['undertime'];

        if(
            ($am_in == 'DAY OFF' && $am_out == 'DAY OFF' && $pm_in == 'DAY OFF' && $pm_out == 'DAY OFF') ||
            ($am_in == 'HOLIDAY' && $am_out == 'HOLIDAY' && $pm_in == 'HOLIDAY' && $pm_out == 'HOLIDAY') ||
            ($am_in == 'JO BREAK' && $am_out == 'JO BREAK' && $pm_in == 'JO BREAK' && $pm_out == 'JO BREAK') ||
            ($am_in == 'CDO' && $am_out == 'CDO' && $pm_in == 'CDO' && $pm_out == 'CDO') ||
            ($am_in == 'FLEXI-TIME' && $am_out == 'FLEXI-TIME' && $pm_in == 'FLEXI-TIME' && $pm_out == 'FLEXI-TIME') ||
            (empty($am_in) && empty($am_out) && empty($pm_in) && empty($pm_out)) ||
            (
                strpos( $am_in, 'RPO #' ) !== false && strpos( $am_out, 'RPO #' ) !== false && strpos( $pm_in, 'RPO #' ) !== false && strpos( $pm_out, 'RPO #' ) !== false
                && $am_in == $pm_in
            ) ||
            (
                strpos( $am_in, 'TO #' ) !== false && strpos( $am_out, 'TO #' ) !== false && strpos( $pm_in, 'TO #' ) !== false && strpos( $pm_out, 'TO #' ) !== false
                && $am_in == $pm_in
            ) ||
            (
                strpos( $am_in, 'MO #' ) !== false && strpos( $am_out, 'MO #' ) !== false && strpos( $pm_in, 'MO #' ) !== false && strpos( $pm_out, 'MO #' ) !== false
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
            $undertime = $undertime == 0 ? '' : $undertime;
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
            ($am_in == 'FLEXI-TIME' && $am_out == 'FLEXI-TIME') ||
            (empty($am_in) && empty($am_out)) ||
            (strpos( $am_in, 'RPO #' ) !== false && strpos( $am_out, 'RPO #' ) !== false) ||
            (strpos( $am_in, 'TO #' ) !== false && strpos( $am_out, 'TO #' ) !== false) ||
            (strpos( $am_in, 'LEAVE' ) !== false && strpos( $am_out, 'LEAVE' ) !== false) ||
            (strpos( $am_in, 'MO #' ) !== false && strpos( $am_out, 'MO #' ) !== false)
        ){
            if((empty($am_in) && empty($am_out)) || ($am_in == 'empty' && $am_out == 'empty')){
                $morning_log_2 = '';
                $date = $row['datein'];
                if ($day_name != 'Sat' && $day_name != 'Sun'){
                    $morning_log_2 = 'HALF DAY';
                    $late += 240;
                }
            } else
                $morning_log_2 = $am_in;

            if($pm_in == $pm_out) {
                if (empty($pm_in) && empty($pm_out)){
                    if($date == "2024-03-27") {
                        $pm_in = 'MC 45';
                    }
                    else {
                        $pm_in = 'HALF DAY';
                        $late += 240;
                    }
                }
                $late = $late == 0 ? '' : $late;
                $undertime = $undertime == 0 ? '' : $undertime;
                $pdf->SetWidths(array(5,7.5,30,30,7.5,7,$set_size_center,5,7.5,30,30,7.5,7));
                $pdf->Row(array(
                    ["word" => explode('-',$row['datein'])[2],'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'L'],
                    ["word" => $day_name,'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'L'],
                    ["word" => $morning_log_2,'font_style' => $am_in_style,'font_size'=>7.5,'border'=>$border,"position"=>'C'],
                    ["word" => $pm_in,'font_style' => $pm_in_style,'font_size'=>0,'border'=>$border,"position"=>'C'],
                    ["word" => $late,'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'C'],
                    ["word" => $undertime,'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'C'],
                    ["word" => "",'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'C'],
                    ["word" => explode('-',$row['datein'])[2],'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'L'],
                    ["word" => $day_name,'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'L'],
                    ["word" => $morning_log_2,'font_style' => $am_in_style,'font_size'=>7.5,'border'=>$border,"position"=>'C'],
                    ["word" => $pm_in,'font_style' => $pm_in_style,'font_size'=>0,'border'=>$border,"position"=>'C'],
                    ["word" => $late,'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'C'],
                    ["word" => $undertime,'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'C']
                ),5);
            }
            else{
                if($pm_out >= '23:00:00' and $pm_out <= '23:59:59'){ //OFFSEN LOGS
                    $am_in = '';
                    $am_out = '';
                    $pm_in = offsen_in($userid,$row['datein'])['time'];
                    $am_in_style = '';
                    $am_out_style = '';
                    $pm_in_style = '';
                    $pm_out_style = '';
                    $late = '';
                    $undertime = '';
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
                } else {
                    $late = $late == 0 ? '' : $late;
                    $undertime = $undertime == 0 ? '' : $undertime;
                    $pdf->SetWidths(array(5,7.5,30,15,15,7.5,7,$set_size_center,5,7.5,30,15,15,7.5,7));
                    $pdf->Row(array(
                        ["word" => explode('-',$row['datein'])[2],'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'L'],
                        ["word" => $day_name,'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'L'],
                        ["word" => $morning_log_2,'font_style' => $am_in_style,'font_size'=>7.5,'border'=>$border,"position"=>'C'],
                        ["word" => $pm_in,'font_style' => $pm_in_style,'font_size' => $pm_in == "FLEXI-TIME" ? 6.5 : strpos( $pm_in, 'RPO #' ) !== false ? 6 : 7.5,'border'=>$border,"position"=>'C'],
                        ["word" => $pm_out,'font_style' => $pm_out_style,'font_size'=> $pm_out == "FLEXI-TIME" ? 6.5 : 7.5,'border'=>$border,"position"=>'C'],
                        ["word" => $late,'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'C'],
                        ["word" => $undertime,'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'C'],
                        ["word" => "",'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'C'],
                        ["word" => explode('-',$row['datein'])[2],'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'L'],
                        ["word" => $day_name,'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'L'],
                        ["word" => $morning_log_2,'font_style' => $am_in_style,'font_size'=>7.5,'border'=>$border,"position"=>'C'],
                        ["word" => $pm_in,'font_style' => $pm_in_style,'font_size'=> $pm_in == "FLEXI-TIME" ? 6.5 : strpos( $pm_in, 'RPO #' ) !== false ? 6 : 7.5,'border'=>$border,"position"=>'C'],
                        ["word" => $pm_out,'font_style' => $pm_out_style,'font_size'=> $pm_out == "FLEXI-TIME" ? 6.5 : 7.5,'border'=>$border,"position"=>'C'],
                        ["word" => $late,'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'C'],
                        ["word" => $undertime,'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'C']
                    ),5);
                }

            }

        }
        elseif(
            ($pm_in == 'DAY OFF' && $pm_out == 'DAY OFF') ||
            ($pm_in == 'HOLIDAY' && $pm_out == 'HOLIDAY') ||
            ($pm_in == 'CDO' && $pm_out == 'CDO') ||
            ($pm_in == 'FLEXI-TIME' && $pm_out == 'FLEXI-TIME') ||
            (empty($pm_in) && empty($pm_out)) ||
            (strpos( $pm_in, 'RPO #' ) !== false && strpos( $pm_out, 'RPO #' ) !== false ) ||
            (strpos( $pm_in, 'TO #' ) !== false && strpos( $pm_out, 'TO #' ) !== false ) ||
            (strpos( $pm_in, 'LEAVE' ) !== false && strpos( $pm_out, 'LEAVE' ) !== false)
        )
        {
            if((empty($pm_in) && empty($pm_out)) || ($pm_in == 'empty' && $pm_out == 'empty')){
                $afternoon_log_2 = '';
                $date = $row['datein'];
                if ($day_name != 'Sat' && $day_name != 'Sun'){
                    if($date == "2024-03-27") {
                        $afternoon_log_2 = 'MC 45';
                    }
                    else{
                        $afternoon_log_2 = 'HALF DAY';
                        $late += 240;
                    }
                }
            } else
                $afternoon_log_2 = $pm_in;

            if($am_in == $am_out){
                $late = $late == 0 ? '' : $late;
                $undertime = $undertime == 0 ? '' : $undertime;
                $pdf->SetWidths(array(5,7.5,30,30,7.5,7,$set_size_center,5,7.5,30,30,7.5,7));
                $pdf->Row(array(
                    ["word" => explode('-',$row['datein'])[2],'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'L'],
                    ["word" => $day_name,'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'L'],
                    ["word" => $am_in,'font_style' => $am_in_style,'font_size'=>7.5,'border'=>$border,"position"=>'C'],
                    ["word" => $afternoon_log_2,'font_style' => $pm_in_style,'font_size'=>0,'border'=>$border,"position"=>'C'],
                    ["word" => $late,'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'C'],
                    ["word" => $undertime,'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'C'],
                    ["word" => "",'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'C'],
                    ["word" => explode('-',$row['datein'])[2],'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'L'],
                    ["word" => $day_name,'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'L'],
                    ["word" => $am_in,'font_style' => $am_in_style,'font_size'=>7.5,'border'=>$border,"position"=>'C'],
                    ["word" => $afternoon_log_2,'font_style' => $pm_in_style,'font_size'=>0,'border'=>$border,"position"=>'C'],
                    ["word" => $late,'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'C'],
                    ["word" => $undertime,'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'C']
                ),5);
            } else {
                $late = $late == 0 ? '' : $late;
                $undertime = $undertime == 0 ? '' : $undertime;
                $date = $row['datein'];
                if($date == "2024-03-27") {
                    if((empty($pm_in) && empty($pm_out)) || ($pm_in == 'empty' && $pm_out == 'empty')) {
                        $pm_in = "MC 45";
                        }
                    }
                if($am_in >= '00:00:00' and $am_in <= '01:00:00'){ //OFFSEN LOGS
                    $am_out = offsen_out($userid,$row['datein'])['time'];
                    $pm_in = '';
                    $pm_out = '';
                    $am_in_style = '';
                    $am_out_style = '';
                    $pm_in_style = '';
                    $pm_out_style = '';
                    $late = '';
                    $undertime = '';
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
                } else {
                    //$am_in = 'RPO # 448-A';
                    $finalAmOut = '';
                    if($am_out) {
                        $finalAmOut = $am_out;
                    } else if($day_name != 'Sat' && $day_name != 'Sun') {
                        $finalAmOut = 'HALF DAY';
                    }
                    // $am_out = 'RPO # 1000-A';    
                    if($finalAmOut != 'RPO # 1000-A') {
                        $pdf->SetWidths(array(5, 7.5, 15, 15, 30, 7.5, 7, $set_size_center, 5, 7.5, 15, 15, 30, 7.5, 7));
                    $pdf->Row(array(
                        ["word" => explode('-', $row['datein'])[2], 'font_style' => '', 'font_size' => 7.5, 'border' => $border, "position" => 'L'],
                        ["word" => $day_name, 'font_style' => '', 'font_size' => 7.5, 'border' => $border, "position" => 'L'],
                        ["word" => $am_in, 'font_style' => $am_in_style, 'font_size' => $am_in == "FLEXI-TIME" ? 6.5 : strpos( $am_in, 'RPO #' ) !== false ? 6 : 7.5, 'border' => $border, "position" => 'C'],
                        ["word" => $finalAmOut, 'font_style' => $am_out_style, 'font_size' => $am_out == "FLEXI-TIME" ? 6.5 : strpos( $am_out, 'RPO #' ) !== false || strpos( $am_out, 'LEAVE' ) !== false ? 6 : 7.5, 'border' => $border, "position" => 'C'],
                        ["word" => $afternoon_log_2, 'font_style' => $pm_in_style, 'font_size' => 7.5, 'border' => $border, "position" => 'C'],
                        ["word" => $late, 'font_style' => '', 'font_size' => 7.5, 'border' => $border, "position" => 'C'],
                        ["word" => $undertime, 'font_style' => '', 'font_size' => 7.5, 'border' => $border, "position" => 'C'],
                        ["word" => "", 'font_style' => '', 'font_size' => 7.5, 'border' => $border, "position" => 'C'],
                        ["word" => explode('-', $row['datein'])[2], 'font_style' => '', 'font_size' => 7.5, 'border' => $border, "position" => 'L'],
                        ["word" => $day_name, 'font_style' => '', 'font_size' => 7.5, 'border' => $border, "position" => 'L'],
                        ["word" => $am_in, 'font_style' => $am_in_style, 'font_size' => $am_in == "FLEXI-TIME" ? 6.5 : strpos( $am_in, 'RPO #' ) !== false ? 6 : 7.5, 'border' => $border, "position" => 'C'],
                        ["word" => $finalAmOut, 'font_style' => $am_out_style, 'font_size' => $am_out == "FLEXI-TIME" ? 6.5 : strpos( $am_out, 'RPO #' ) !== false || strpos( $am_out, 'LEAVE' ) !== false ? 6 : 7.5, 'border' => $border, "position" => 'C'],
                        ["word" => $afternoon_log_2, 'font_style' => $pm_in_style, 'font_size' => 7.5, 'border' => $border, "position" => 'C'],
                        ["word" => $late, 'font_style' => '', 'font_size' => 7.5, 'border' => $border, "position" => 'C'],
                        ["word" => $undertime, 'font_style' => '', 'font_size' => 7.5, 'border' => $border, "position" => 'C']
                    ), 5);
                }else{
                    $pdf->SetWidths(array(5, 7.5, 15, 15, 30, 7.5, 7, $set_size_center, 5, 7.5, 15, 15, 30, 7.5, 7));
                    $pdf->Row(array(
                        ["word" => explode('-', $row['datein'])[2], 'font_style' => '', 'font_size' => 7.5, 'border' => $border, "position" => 'L'],
                        ["word" => $day_name, 'font_style' => '', 'font_size' => 7.5, 'border' => $border, "position" => 'L'],
                        ["word" => $am_in, 'font_style' => $am_in_style, 'font_size' => $am_in == "FLEXI-TIME" ? 6.5 : strpos( $am_in, 'RPO #' ) !== false ? 6 : 7.5, 'border' => $border, "position" => 'C'],
                        ["word" => $finalAmOut, 'font_style' => $am_out_style, 'font_size' => $am_out == "FLEXI-TIME" ? 6.5 : strpos( $am_out, 'RPO #' ) !== false || strpos( $am_out, 'LEAVE' ) !== false ? 5 : 7.5, 'border' => $border, "position" => 'C'],
                        ["word" => $afternoon_log_2, 'font_style' => $pm_in_style, 'font_size' => 7.5, 'border' => $border, "position" => 'C'],
                        ["word" => $late, 'font_style' => '', 'font_size' => 7.5, 'border' => $border, "position" => 'C'],
                        ["word" => $undertime, 'font_style' => '', 'font_size' => 7.5, 'border' => $border, "position" => 'C'],
                        ["word" => "", 'font_style' => '', 'font_size' => 7.5, 'border' => $border, "position" => 'C'],
                        ["word" => explode('-', $row['datein'])[2], 'font_style' => '', 'font_size' => 7.5, 'border' => $border, "position" => 'L'],
                        ["word" => $day_name, 'font_style' => '', 'font_size' => 7.5, 'border' => $border, "position" => 'L'],
                        ["word" => $am_in, 'font_style' => $am_in_style, 'font_size' => $am_in == "FLEXI-TIME" ? 6.5 : strpos( $am_in, 'RPO #' ) !== false ? 6 : 7.5, 'border' => $border, "position" => 'C'],
                        ["word" => $finalAmOut, 'font_style' => $am_out_style, 'font_size' => $am_out == "FLEXI-TIME" ? 6.5 : strpos( $am_out, 'RPO #' ) !== false || strpos( $am_out, 'LEAVE' ) !== false ? 5 : 7.5, 'border' => $border, "position" => 'C'],
                        ["word" => $afternoon_log_2, 'font_style' => $pm_in_style, 'font_size' => 7.5, 'border' => $border, "position" => 'C'],
                        ["word" => $late, 'font_style' => '', 'font_size' => 7.5, 'border' => $border, "position" => 'C'],
                        ["word" => $undertime, 'font_style' => '', 'font_size' => 7.5, 'border' => $border, "position" => 'C']
                    ), 5);
                }   
                    
                }

            }
        }
        else {
            //$pm_out = 'RPO # 555-A';
            $late = $late == 0 ? '' : $late;
            if($late == 0) {
                if(empty($pm_out))
                    $late += 240;
            }
            $undertime = $undertime == 0 ? '' : $undertime;
            $pdf->SetWidths(array(5,7.5,15,15,15,15,7.5,7,$set_size_center,5,7.5,15,15,15,15,7.5,7));
            $pdf->Row(array(
                ["word" => explode('-',$row['datein'])[2],'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'L'],
                ["word" => $day_name,'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'L'],
                ["word" => $am_in,'font_style' => $am_in_style,'font_size'=> $am_in == "FLEXI-TIME" ? 6.5 : strpos( $am_in, 'RPO #' ) !== false ? 6 : 7.5,'border'=>$border,"position"=>'C'],
                ["word" => $am_out,'font_style' => $am_out_style,'font_size'=> $am_out == "FLEXI-TIME" ? 6.5 : strpos( $am_out, 'RPO #' ) !== false ? 4.7 : 7.5,'border'=>$border,"position"=>'C'],
                ["word" => $pm_in,'font_style' => $pm_in_style,'font_size'=> $pm_in == "FLEXI-TIME" ? 6.5 : strpos( $am_out, 'RPO #' ) !== false ? 4.7 : 7.5,'border'=>$border,"position"=>'C'],
                ["word" => $pm_out ? $pm_out : 'HALF DAY','font_style' => $pm_out_style,'font_size'=> $pm_out == "FLEXI-TIME" ? 6.5 : $pm_out ? strpos( $pm_out, 'RPO #' ) !== false ? 5.6 : 7.5 : 5.6,'border'=>$border,"position"=>'C'],
                ["word" => $late,'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'C'],
                ["word" => $undertime,'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'C'],
                ["word" => "",'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'C'],
                ["word" => explode('-',$row['datein'])[2],'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'L'],
                ["word" => $day_name,'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'L'],
                ["word" => $am_in,'font_style' => $am_in_style,'font_size'=> $am_in == "FLEXI-TIME" ? 6.5 : strpos( $am_in, 'RPO #' ) !== false ? 6 : 7.5,'border'=>$border,"position"=>'C'],
                ["word" => $am_out,'font_style' => $am_out_style,'font_size'=> $am_out == "FLEXI-TIME" ? 6.5 : strpos( $am_out, 'RPO #' ) !== false ? 4.7 : 7.5,'border'=>$border,"position"=>'C'],
                ["word" => $pm_in,'font_style' => $pm_in_style,'font_size'=> $pm_in == "FLEXI-TIME" ? 6.5 : strpos( $am_out, 'RPO #' ) !== false ? 4.7 : 7.5,'border'=>$border,"position"=>'C'],
                ["word" => $pm_out ? $pm_out : 'HALF DAY','font_style' => $pm_out_style,'font_size'=> $pm_out == "FLEXI-TIME" ? 6.5 : $pm_out ? strpos( $pm_out, 'RPO #' ) !== false ? 5.6 : 7.5 : 5.6,'border'=>$border,"position"=>'C'],
                ["word" => $late,'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'C'],
                ["word" => $undertime,'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'C']
            ),5);
        }

        $late_total += (int)$late;
        $undertime_total += (int)$undertime;
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
        ["word" => $late_total == 0 ? ' ' : $late_total,'font_style' => '','font_size'=>7,'border'=>$border,"position"=>'C'],
        ["word" => $undertime_total == 0 ? ' ' : $undertime_total,'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'C'],
        ["word" => '','font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'C'],
        ["word" => 'TOTAL','font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'L'],
        ["word" => $late_total == 0 ? ' ' : $late_total,'font_style' => '','font_size'=>7,'border'=>$border,"position"=>'C'],
        ["word" => $undertime_total == 0 ? ' ' : $undertime_total,'font_style' => '','font_size'=>7.5,'border'=>$border,"position"=>'C']
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