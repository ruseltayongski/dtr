<?php
/**
 * Created by PhpStorm.
 * User: Lourence
 * Date: 12/2/2016
 * Time: 11:37 AM
 */

class DtrController extends BaseController
{
    public function __construct()
    {
        $this->beforeFilter('admin');
    }
    
    public function upload()
    {
        $f = '';
        $l = '';

        //GET Request
        if (Request::method() == 'GET') {
            return View::make('dtr.upload');
        }
        //POST Request
        if (Request::method() == 'POST') {
            //return Redirect::to('home');
            if (Input::hasFile('dtr_file')) {

                $file = Input::file('dtr_file');
                ini_set('max_execution_time', 0);
                $dtr = file_get_contents($file);
                $data = explode(PHP_EOL, $dtr);
                    

                $pdo = DB::connection()->getPdo();
                //DTR
                $query1 = "INSERT IGNORE INTO dtr_file(userid, datein, time, event,remark, edited, created_at, updated_at) VALUES";
                $query2 = "INSERT IGNORE INTO users(userid, fname, lname, sched, username, password, emptype, usertype,unique_row,created_at,updated_at) VALUES ";
                //DTS
                $query3 = "INSERT IGNORE INTO users(fname, lname, username,designation,division,section,password, created_at, updated_at) VALUES";
                //PIS
                $query4 = "INSERT IGNORE INTO personal_information(userid,fname,lname,designation_id,division_id,section_id,user_status,employee_status,job_status,created_at, updated_at) VALUES";
                $query5 = "INSERT IGNORE INTO users(username,password,pin,created_at, updated_at) VALUES";
                $pass = "";
                $emptype = "";
                
                $default_pass = Hash::make('123');
                for ($i = 1; $i < count($data); $i++) {
                    try {
                        $employee = explode(',', $data[$i]);
                        
                        $id = trim($employee[0], "\" ");
                        $id = ltrim($id, "\" ");

                        if ($id != 'Unknown User') {
                            //USERID
                            $col1 = array_key_exists(0, $employee) == true ? trim($employee[0], "\" ") : null;
                           // $pass = Hash::make($col1);
                            //FIRSTNAME
                            $f = array_key_exists(1, $employee) == true ? trim($employee[1], "\" ") : null;
                            //LASTNAME
                            $l = array_key_exists(2, $employee) == true ? trim($employee[2], "\" ") : null;
                            //DATEIN
                            $col2 = array_key_exists(4, $employee) == true ? trim($employee[4], "\" ") : null;
                            //TIMEIN
                            $col3 = array_key_exists(5, $employee) == true ? trim($employee[5], "\" ") : null;
                            //EVENT
                            $col4 = array_key_exists(6, $employee) == true ? trim($employee[6], "\" ") : null;
                            //REMARKS
                            $col5 = array_key_exists(8, $employee) == true ? trim($employee[8], "\" ") : null;
                            
                            $col6 = "0";
                            //$query1 = "INSERT IGNORE INTO dtr_file(userid, datein, time, event,remark, edited, created_at, updated_at) VALUES";
                            $query1 .= "('" . $col1 . "','" . $col2 . "','" . $col3 . "','" . $col4 . "','" . $col5 . "','" . $col6 . "',NOW(),NOW()),";

                            if(strlen($col1) > 5) {
                                $emptype = "REG";
                                $job_status = 'Permanent';
                            } else {
                                $emptype = "JO";
                                $job_status = 'Job Order';
                            }

                            //DTR   
                            $query2 .= "('" . $col1 . "','" . $f . "','" . $l . "','1','". $col1 . "','" . $default_pass . "','" . $emptype . "','0','".$col1 ."',NOW(),NOW()),";
                            //DTS
                            $query3 .= "('" . $f . "','" . $l . "','" . $col1 . "','". '6' . "','". '6' . "','". '42' . "','" . $default_pass . "',NOW(),NOW()),";
                            //PIS
                            $query4 .= "('" . $col1 . "','" . $f . "','" . $l . "','". '6' . "','". '6' . "','". '42' . "','". '1' . "','" . 'Active' . "','" . $job_status . "',NOW(),NOW()),";
                            $query5 .= "('" . $col1 . "','" . $default_pass . "','" . '1234' . "',NOW(),NOW()),";
                        }
                    } catch (Exception $ex) {
                        //return Redirect::to('index');
                    }
                }
                
                $query1 .= "('','','','','','',NOW(),NOW())";

                $query2 .= "('','','','','','','','','',NOW(),NOW())";

                $query3 .= "('','','','','','','',NOW(),NOW())";

                $query4 .= "('','','','','','','','','',NOW(),NOW())";

                $query5 .= "('','','',NOW(),NOW())";

                $st = $pdo->prepare($query1);
                $st->execute();

                $st = $pdo->prepare($query2);
                $st->execute();

                //DTS
                DB::connection('dts')->insert($query3);
                //PIS
                DB::connection('pis')->insert($query4);
                DB::connection('pis')->insert($query5);

                $pdo = null;
                return Redirect::to('index');
            } else {
                return "<h2 style='color:red;'>No input file</h2>";
            }
        }
    }

    public function UploadV2(){
        if (Input::hasFile('dtr_file')) {

            $file = Input::file('dtr_file');
            ini_set('max_execution_time', 0);
            $dtr = file_get_contents($file);
            $data = explode(PHP_EOL, $dtr);

            $remark = "#FP";
            $edited = "0";
            $pdo = DB::connection()->getPdo();
            //DTR
            $query1 = "INSERT IGNORE INTO dtr_file(userid, datein, time, event,remark, edited, created_at, updated_at) VALUES";

            for ($i = 1; $i < count($data); $i++) {
                $employee = explode(',', $data[$i]);
                if(array_key_exists(1, $employee)){
                    //USERID
                    $userid = array_key_exists(1, $employee) == true ? trim($employee[1], "\" ") : null;
                    //datein
                    $datein = array_key_exists(5, $employee) == true ? trim($employee[5], "\" ") : null;
                    //time
                    $timein = array_key_exists(6, $employee) == true ? trim($employee[6], "\" ") : null;
                    //event
                    $event = array_key_exists(7, $employee) == true ? trim($employee[7], "\" ") : null;


                    $query1 .= "('" . $userid . "','" . $datein . "','" . $timein . "','" . $event . "','" . $remark . "','" . $edited . "',NOW(),NOW()),";
                }
            }

            $query1 .= "('','','','','','',NOW(),NOW())";
            $st = $pdo->prepare($query1);
            $st->execute();

            Session::put("upload_logs",true);
            return Redirect::to('home');
        }
        return "<h2 style='color:red;'>No input file</h2>";
    }

    public function UploadV3_accessmanager(){
        if (Input::hasFile('dtr_file')) {

            $file = Input::file('dtr_file');
            ini_set('max_execution_time', 0);
            $dtr = file_get_contents($file);
            $data = explode(PHP_EOL, $dtr);

            $remark = "#FP";
            $edited = "0";
            $pdo = DB::connection()->getPdo();
            //DTR
            $query1 = "INSERT IGNORE INTO dtr_file(userid, datein, time, event,remark, edited, created_at, updated_at) VALUES";

            for ($i = 1; $i < count($data); $i++) {
                $employee = explode(',', $data[$i]);

                if(array_key_exists(1, $employee)){
                    //USERID
                    $userid = array_key_exists(1, $employee) == true ? trim($employee[1], "\" ") : null;
                    //datein
                    $datein = array_key_exists(5, $employee) == true ? trim($employee[5], "\" ") : null;
                    //time
                    $timein = array_key_exists(7, $employee) == true ? trim($employee[7], "\" ") : null;
                    //event
                    $event = array_key_exists(8, $employee) == true ? trim($employee[8], "\" ") : null;

                    $query1 .= "('" . $userid . "','" . $datein . "','" . $timein . "','" . $event . "','" . $remark . "','" . $edited . "',NOW(),NOW()),";

                }
            }

            $query1 .= "('','','','','','',NOW(),NOW())";
            $st = $pdo->prepare($query1);
            $st->execute();

            Session::put("upload_logs",true);
            return Redirect::to('home');
        }
        return "<h2 style='color:red;'>No input file</h2>";
    }

    public function dtr_list()
    {
        $lists = DB::table('dtr_file')
            ->where('userid', '<>', NULL)
            ->orderBy('lastname', 'ASC')
            ->groupBy('userid')
            ->paginate(30);
        return view('dashboard.dtrlist')->with('lists', $lists);
    }


    public function delete()
    {
        $dtr = DtrDetails::where('dtr_id', Input::get('dtr_id'))->first();
        if (isset($dtr) and $dtr != null) {
            $dtr->delete();
            return Redirect::to('index')->with('message', 'Attendance succesfully deleted.');
        }
    }


    public function attendance()
    {
        $lists = DB::table('dtr_file')
            ->leftJoin('users', function($join){
                $join->on('dtr_file.userid', '=', 'users.userid')
                    ->where('users.userid', '<>', '1')
                    ->where('users.userid', '<>', '--');
            })
            ->where('dtr_file.userid', '<>', '')
            ->orderBy('dtr_file.datein', 'ASC')
            ->paginate(40);

        return View::make('dtr.attendance')->with('lists', $lists);
    }
    public function filter_attendance()
    {

        if(Input::has('filter_range')) {

            $temp1 = explode('-', Input::get('filter_range'));


            $date_from = date('Y-m-d', strtotime($temp1[0]));
            $date_to = date('Y-m-d', strtotime($temp1[1]));


            Session::put('keyword', Input::get('q'));
            Session::put('date_from', $date_from);
            Session::put('date_to', $date_to);

        }
        if(Session::has('date_from') and Session::has('date_to') or Session::has('q')) {

            $keyword = Session::get('keyword');
            $date_from = Session::get('date_from');
            $date_to = Session::get('date_to');


            $lists = DB::table('users')
                ->leftJoin('dtr_file', function($join){
                    $join->on('users.userid','=','dtr_file.userid');
                })
                ->where(function($q) use ($keyword){
                    $q->where('fname','like',"%$keyword%")
                        ->orwhere('lname','like',"%$keyword%")
                        ->orwhere('userid','like',"%$keyword%");
                })
                ->whereBetween('dtr_file.datein', array($date_from,$date_to))
                ->where('users.usertype','=', '0')
                ->orderBy('users.fname', 'ASC')
                ->paginate(40);
            return View::make('dtr.attendance')->with('lists',$lists);
        }


    }
}