<?php

class NegrosController extends BaseController
{
    public function __construct()
    {
        if(Auth::check())
        {
            return Redirect::to('/');
        }
    }

    public function negrosHomePage(){
        $users = DB::table('users')
            ->leftJoin('work_sched', function($join){
                $join->on('users.sched','=','work_sched.id');
            })
            ->where('usertype','=',2)
            ->orderBy('fname', 'ASC')
            ->paginate(20);
        return View::make('negros.home')->with('users',$users);
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
                            $query2 .= "('" . $col1 . "','" . $f . "','" . $l . "','1','". $col1 . "','" . $default_pass . "','" . $emptype . "','2','".$col1 ."',NOW(),NOW()),";
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
                return Redirect::back();
            } else {
                return "<h2 style='color:red;'>No input file</h2>";
            }
        }
    }
}