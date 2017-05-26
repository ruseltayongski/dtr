<?php



function get_logs($am_in,$am_out,$pm_in,$pm_out,$id,$date_from,$date_to)
{
    $pdo = conn();


    $query = "SELECT DISTINCT e.userid, datein,

                    (SELECT DISTINCT MIN(t1.time) FROM dtr_file t1 WHERE t1.userid = '". $id."' and datein = d.datein and t1.time < '". $am_out ."') as am_in,
                    (SELECT DISTINCT MAX(t2.time) FROM dtr_file t2 WHERE t2.userid = '". $id."' and datein = d.datein and t2.time < '". $pm_in."' AND t2.event = 'OUT') as am_out,
                    (SELECT DISTINCT MIN(t3.time) FROM dtr_file t3 WHERE t3.userid = '". $id."' AND datein = d.datein and t3.time >= '". $am_out."' and t3.time < '". $pm_out."' AND t3.event = 'IN' ) as pm_in,
                    (SELECT DISTINCT MAX(t4.time) FROM dtr_file t4 WHERE t4.userid = '". $id."' AND datein = d.datein and t4.time > '". $pm_in ."' and t4. time < '24:00:00') as pm_out,

                    (SELECT t1.edited FROM dtr_file t1 WHERE t1.userid = '". $id."' and datein = d.datein and t1.time < '". $am_out ."' AND t1.edited = '1' LIMIT 1) as e1,
                    (SELECT t2.edited  FROM dtr_file t2 WHERE t2.userid = '". $id."' and datein = d.datein and t2.time < '". $pm_in."' AND t2.event = 'OUT' AND t2.edited = '1' LIMIT 1) as e2,
                    (SELECT t3.edited FROM dtr_file t3 WHERE t3.userid = '". $id."' AND datein = d.datein and t3.time >='". $am_out."' and t3.time < '". $pm_out."' AND t3.event = 'IN' AND t3.edited = '1' LIMIT 1) as e3,
                    (SELECT t4.edited FROM dtr_file t4 WHERE t4.userid = '". $id."' AND datein = d.datein and t4.time > '". $pm_in ."'  and t4. time < '24:00:00' AND t4.edited = '1' LIMIT 1) as e4

                    FROM dtr_file d LEFT JOIN users e
                        ON d.userid = e.userid
                    WHERE d.datein BETWEEN :date_from AND :date_to
                          AND e.userid = :id
                    ORDER BY datein ASC";
    try
    {
        $st = $pdo->prepare($query);
        $st->execute(array('date_from' => $date_from, 'date_to' => $date_to, 'id' => $id));
        $row = $st->fetchAll(PDO::FETCH_ASSOC);
    }catch(PDOException $ex){
        echo $ex->getMessage();
        exit();
    }
    return $row;
}

function userlist($emptype)
{
    $pdo = conn();
    try {
        $st = $pdo->prepare("SELECT DISTINCT userid,fname,lname,mname,sched FROM users  WHERE usertype != '1' and emptype = '" . $emptype ."'");
        //$st = $pdo->prepare("SELECT DISTINCT userid,fname,lname,mname FROM users WHERE usertype != '1' and userid !='Unknown User' ORDER BY lname ASC");
        $st->execute();
        $row = $st->fetchAll(PDO::FETCH_ASSOC);
        if(isset($row) and count($row) > 0)
        {
            $pdo = null;
            return $row;
        }
    }catch(PDOException $ex)
    {
        echo $ex->getMessage();
        exit();
    }
}
function save_file_name($filename,$date_from,$date_to,$emtype)
{
    $pdo = conn();
    $time = date("h:i:sa");
    $date = date("Y-m-d");
    $query = "INSERT INTO generated_pdf(filename,date_created,time_created,date_from,date_to,created_at,updated_at,type,is_filtered)";
    $query .= " VALUES('".$filename . "','" . $date . "','" . $time . "','". $date_from. "','".$date_to ."',NOW(),NOW(),'". $emtype ."','0')";
    $st = $pdo->prepare($query);
    $st->execute();
    $pdo = null;
}
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

function approved_rdard()
{
    $db = dts_con();
    $sql = 'SELECT * FROM USERS where section = 36';
    $pdo = $db->prepare($sql);
    $pdo->execute();
    $row = $pdo->fetchAll();
    $db = null;

    return $row;
}

function so_no($route_no)
{
    $db = conn();
    $sql = 'SELECT id FROM OFFICE_ORDER where route_no = ?';
    $pdo = $db->prepare($sql);
    $pdo->execute(array($route_no));
    $row = $pdo->fetch();
    $db = null;

    return $row;
}

function approved_record($route_no,$received_by)
{
    $db = dts_con();
    $sql = 'SELECT * FROM TRACKING_DETAILS where route_no = ? and received_by = ?';
    $pdo = $db->prepare($sql);
    $pdo->execute(array($route_no,$received_by));
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
    $row = $pdo->fetchAll();
    $db = null;

    return $row;
}

function check_holiday()
{
    $db = conn();
    $sql = 'SELECT title,start,end FROM calendar where status = 1';
    $pdo = $db->prepare($sql);
    $pdo->execute();
    $row = $pdo->fetchAll();
    $db = null;

    return $row;
}

function look_holiday($datein){
    $condition = floor(strtotime($datein) / (60 * 60 * 24));
    foreach(check_holiday() as $holiday) {
        if($holiday){
            $holiday_start = floor(strtotime($holiday['start']) / (60 * 60 * 24));
            $holiday_end = floor(strtotime($holiday['end']) / (60 * 60 * 24));
            if($condition >= $holiday_start and $condition < $holiday_end and $holiday['title'] != ''){
                return $holiday['title'];
            }
        }
    }
}

function check_cdo()
{
    $db = conn();
    $sql = 'SELECT start,end FROM cdo where approved_status = 1';
    $pdo = $db->prepare($sql);
    $pdo->execute();
    $row = $pdo->fetchAll();
    $db = null;

    return $row;
}

function look_cdo($datein){
    $condition = floor(strtotime($datein) / (60 * 60 * 24));
    foreach(check_cdo() as $cdo) {
        if($cdo){
            $cdo_start = floor(strtotime($cdo['start']) / (60 * 60 * 24));
            $cdo_end = floor(strtotime($cdo['end']) / (60 * 60 * 24));
            if($condition >= $cdo_start and $condition < $cdo_end){
                return 'CTO';
            }
        }
    }
}

function look_calendar($datein,$userid){
    $condition = floor(strtotime($datein) / (60 * 60 * 24));
    foreach(check_inclusive_name(user_search($userid)['id']) as $check)
    {
        foreach(approved_rdard() as $record)
        {
            foreach(approved_record($check['route_no'],$record['id']) as $details)
            {
                foreach(check_calendar($details['route_no']) as $calendar){
                    if($calendar) {
                        $calendar_start = floor(strtotime($calendar['start']) / (60 * 60 * 24));
                        $calendar_end = floor(strtotime($calendar['end']) / (60 * 60 * 24));
                        if($condition >= $calendar_start and $condition < $calendar_end and $calendar['title'] != ''){
                            return 'S.O. No.'.sprintf('%04d',so_no($details['route_no'])['id']);
                        }
                    }
                }
            }
        }
    }
}

function user_search($id)
{
    $db= dts_con();
    $sql="SELECT * FROM USERS WHERE USERNAME = ?";
    $pdo = $db->prepare($sql);
    $pdo->execute(array($id));
    $row = $pdo->fetch();
    $db = null;

    return $row;
}




?>