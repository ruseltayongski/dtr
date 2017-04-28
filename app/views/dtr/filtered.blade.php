<?php



ini_set('max_execution_time', 0);
ini_set('memory_limit','1000M');
ini_set('max_input_time','300000');

if(isset($lists) and count($lists) > 0) {
    $day1 = explode('-',$date_from);
    $day2 = explode('-',$date_to);

    $startday = floor($day1[2]);
    $endday = $day2[2];
}
?>



@if(isset($lists) and count($lists) >0)
    <div class="table-responsive">
        <table class="table table-list table-hover table-striped">
            <thead>
            <tr>
                <th class="col-sm-3" style="text-align: center;">AM</th>
                <th class="col-sm-3" style="text-align: center;">PM</th>
            </tr>
            </thead>
        </table>
        <table border="1" class="table table-list table-hover table-striped">
            <thead>
            <tr>
                <td class="text-center">Date</td>
                <td class="text-center">DAY</td>
                <td class="text-center">IN</td>
                <td class="text-center">OUT</td>
                <td class="text-center">IN</td>
                <td class="text-center">OUT</td>
                <td class="text-center">LATE</td>
                <td class="text-center">UNDERTIME</td>
            </tr>
            </thead>
            <tbody>
                <?php
                    $w = array(10,15,15,15,15);
                    $index = 0;
                    $log_date = "";
                    $log = "";
                    
                    $late_total = 0;
                    $ut_total = 0;
                    
                    $pdo = conn();
                    $query = "SELECT * FROM work_sched WHERE id = '1'";
                    $st = $pdo->prepare($query);
                    $st->execute();
                    $sched = $st->fetchAll(PDO::FETCH_ASSOC);

                    $s_am_in = $sched[0]["am_in"];
                    $s_am_out =  $sched[0]["am_out"];
                    $s_pm_in = $sched[0]["pm_in"];
                    $s_pm_out = $sched[0]["pm_out"];

                    $logs = get_logs($userid,$date_from,$date_to);

                    $temp1 = -0;
                    $temp2 = -0;
                    $condition = -0;
                    $title = '';
                    $am_in = '';
                    $am_out = '';
                    $pm_in = '';
                    $pm_out = '';
                ?>    
                    @if(isset($logs) and count($logs))
                
                        @for($r1 = $startday; $r1 <= $endday; $r1++)
                            <?php
                            $r1 >= 1 && $r1 < 10 ? $zero='0' : $zero = '';
                            $datein = $day1[0]."-".$day1[1]."-".$zero.$r1;

                            if($index != count($logs)) {
                                if($datein == $logs[$index]['datein']){
                                    $log_date = $logs[$index]['datein'];
                                    $log = $logs[$index];
                                    $index = $index + 1;
                                }
                            }
                            $day_name = date('D', strtotime($datein));
                            if($datein == $log_date)
                            {
                                $am_in = $log['am_in'];
                                $am_out = $log['am_out'];
                                $pm_in = $log['pm_in'];
                                $pm_out = $log['pm_out'];

                                $late = late($s_am_in,$s_pm_in,$am_in,$pm_in,$log['datein']);
                                if($late != '' or $late != null)
                                {
                                    $late_total = $late_total + $late;
                                }
                                $ut = undertime($s_am_out,$s_pm_out,$am_out,$pm_out,$log['datein']);
                                if($ut != '' or $ut != null)
                                {
                                    $ut_total = $ut_total + $ut;
                                }
                            } else {
                                $am_in = '';
                                $am_out = '';
                                $pm_in = '';
                                $pm_out = '';
                                $late = '';
                            }
                            ?>
                            <tr>
                                <td class="text-center">{{ $datein }}</td>
                                <td class="text-center">{{ $day_name }}</td>

                                <?php
                                    //$am_in == '' ? ($am_in = look_calendar($datein,$userid,$temp1,$temp2) AND $this->SetTextColor(255,0,0)) : $this->SetTextColor(0,0,0);
                                    if($day_name == 'Sat' || $day_name == 'Sun' AND $am_in == '') $am_out = 'DAY OFF';

                                    //$am_out == '' ? ($am_out = look_calendar($datein,$userid,$temp1,$temp2) AND $this->SetTextColor(255,0,0)) : $this->SetTextColor(0,0,0);
                                    if($day_name == 'Sat' || $day_name == 'Sun' AND $am_in == '' AND $am_out == '') $am_out = 'DAY OFF';

                                    //$pm_in == '' ? ($pm_in = look_calendar($datein,$userid,$temp1,$temp2) AND $this->SetTextColor(255,0,0)) : $this->SetTextColor(0,0,0);
                                    if($day_name == 'Sat' || $day_name == 'Sun' AND $am_in == '' AND $am_out == '' AND $pm_in == '') $am_out = 'DAY OFF';

                                   // $pm_out == '' ? ($pm_out = look_calendar($datein,$userid,$temp1,$temp2) AND $this->SetTextColor(255,0,0)) : $this->SetTextColor(0,0,0);
                                    if($day_name == 'Sat' || $day_name == 'Sun' AND $am_in == '' AND $am_out == '' AND $pm_in == '' AND $pm_out == '') $am_out = 'DAY OFF';
                                ?>
                                <td class="text-center">{{ isset($am_in) ? $am_in : '' }}</td>
                                <td class="text-center">{{ isset($am_out) ? $am_out : '' }}</td>
                                <td class="text-center">{{ isset($pm_in) ? $pm_in : '' }}</td>
                                <td class="text-center">{{ isset($pm_out) ? $pm_out : '' }}</td>

                                <td class="text-center">{{ isset($late) ? $late : '' }}</td>
                                <td class="text-center">{{ isset($ut) ? $ut : '' }}</td>
                            </tr>
                        @endfor
                    @else
                          <div class="alert alert-danger" role="alert">DTR logs are empty.</div>
                    @endif
            </tbody>
        </table>
    </div>
@else
    <div class="alert alert-danger" role="alert">DTR records are empty.</div>
@endif
<div class="modal-footer">
    <form action="{{ asset('personal/filter/save') }}" method="POST">
        <input type="hidden" name="date_from" value="{{ $date_from }}" />
        <input type="hidden" name="date_to" value="{{ $date_to }}" />

        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
        <button type="submit" href="{{ asset('') }}" class="btn btn-success"><i class="fa fa-barcode"></i> Save</button>
    </form>

</div>

<?php


function get_logs($id,$date_from,$date_to)
{
    $pdo = conn();
    $query = "SELECT * FROM work_sched WHERE id = '1'";
    $st = $pdo->prepare($query);
    $st->execute();
    $sched = $st->fetchAll(PDO::FETCH_ASSOC);
    $am_in = explode(':',$sched[0]['am_in']);
    $am_out =  explode(':',$sched[0]['am_out']);
    $pm_in =  explode(':',$sched[0]['pm_in']);
    $pm_out = explode(':',$sched[0]['pm_out']);
    $query = "SELECT DISTINCT e.userid, datein,
                    (SELECT MIN(t1.time) FROM dtr_file t1 WHERE t1.userid = '". $id."' and datein = d.datein and t1.time_h < ". $am_out[0] .") as am_in,
                    (SELECT MAX(t2.time) FROM dtr_file t2 WHERE t2.userid = '". $id."' and datein = d.datein and t2.time_h < ". $pm_in[0]." AND t2.event = 'OUT') as am_out,
                    (SELECT MIN(t3.time) FROM dtr_file t3 WHERE t3.userid = '". $id."' AND datein = d.datein and t3.time_h >= ". $am_out[0]." and t3.time_h < ". $pm_out[0]." AND t3.event = 'IN' ) as pm_in,
                    (SELECT MAX(t4.time) FROM dtr_file t4 WHERE t4.userid = '". $id."' AND datein = d.datein and t4.time_h > ". $pm_in[0] ." and t4. time_h < 24) as pm_out
                    FROM dtr_file d LEFT JOIN users e
                        ON d.userid = e.userid
                    WHERE d.datein BETWEEN '". $date_from. "' AND '" . $date_to . "'
                          AND e.userid = '". $id."'
                    ORDER BY datein ASC";
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


function late($s_am_in,$s_pm_in,$am_in,$pm_in,$datein)
{
    $hour = 0;
    $min = 0;
    $total = 0;

    if(isset($am_in) and $am_in != '' || $am_in != null) {
        if(strtotime($am_in) > strtotime($s_am_in)) {
            $a = new DateTime($datein.' '. $am_in);
            $b = new DateTime($datein.' '. $s_am_in);

            $interval = $a->diff($b);
            $hour1 = $interval->h;
            $min1 = $interval->i;


            if($hour1 > 0) {
                $hour1 = $hour1 * 60;
            }
            $total += ($hour1 + $min1);
        }

    }

    if(isset($pm_in) and $pm_in != '' || $pm_in != null) {
        if(strtotime($pm_in) > strtotime($s_pm_in)) {
            $a = new DateTime($datein.' '.$pm_in);
            $b = new DateTime($datein.' '.$s_pm_in);

            $interval = $a->diff($b);
            $hour2 = $interval->h;
            $min2 = $interval->i;


            if($hour2 > 0) {
                $hour2 = $hour2 * 60;
            }

            $total += ($hour2 + $min2);
        }
    }

    if($total == 0) $total = '';
    return $total;

}
function undertime($s_am_out,$s_pm_out,$am_out,$pm_out,$datein)
{

    $hour = '';
    $min = '';
    $total = '';

    if(isset($am_out) and $am_out != '' || $am_out != null) {
        if(strtotime($am_out) < strtotime($s_am_out)) {
            $a = new DateTime($datein.' '. $am_out);
            $b = new DateTime($datein.' '. $s_am_out);

            $interval = $b->diff($a);
            $hour1 = $interval->h;
            $min1 = $interval->i;


            if($hour1 > 0) {
                $hour1 = $hour1 * 60;
            }
            $total += ($hour1 + $min1);
        }

    }

    if(isset($pm_out) and $pm_out != '' || $pm_out != null) {
        if(strtotime($pm_out) < strtotime($s_pm_out)) {
            $a = new DateTime($datein.' '.$pm_out);
            $b = new DateTime($datein.' '.$s_pm_out);

            $interval = $b->diff($a);
            $hour2 = $interval->h;
            $min2 = $interval->i;


            if($hour2 > 0) {
                $hour2 = $hour2 * 60;
            }


            $total += ($hour2 + $min2);
        }
    }
    if($total == 0 ) $total = '';
    return $total;
}

//RUSEL
function check_inclusive_name($id)
{
    $db = conn();
    $sql = 'SELECT * FROM inclusive_name where user_id = ?';
    $pdo = $db->prepare($sql);
    $pdo->execute(array($id));
    $row = $pdo->fetchAll();
    $db = null;

    return $row;
}

function check_calendar($route_no)
{
    $db = conn();
    $sql = 'SELECT * FROM calendar where route_no = ?';
    $pdo = $db->prepare($sql);
    $pdo->execute(array($route_no));
    $row = $pdo->fetch();
    $db = null;

    return $row;
}

function look_calendar($datein,$userid,$temp1,$temp2){
    $condition = floor(strtotime($datein) / (60 * 60 * 24));
    foreach(check_inclusive_name($userid) as $check)
    {
        if(check_calendar($check['route_no'])) {
            $title = check_calendar($check['route_no']);

            $temp1 = floor(strtotime($title['start']) / (60 * 60 * 24));
            $temp2 = floor(strtotime($title['end']) / (60 * 60 * 24));
        }
        if($condition < $temp2 and $condition > $temp1 and $title != ''){
            return 'sono.1234';
        }
    }
}


function conn()
{
    $pdo = null;
    try{
        $pdo = new PDO('mysql:host=localhost; dbname=dohdtr','root','');
        $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    }
    catch (PDOException $err) {
        echo $err->getMessage();
        exit();
    }
    return $pdo;
}

?>

