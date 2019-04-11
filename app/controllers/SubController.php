<?php

class SubController extends BaseController
{
    public function __construct()
    {
        if(Auth::check())
        {
            return Redirect::to('/');
        }
    }

    public function subHome(){
        if(Auth::user()->usertype == 3)
            $location = 2; //NEGROS
        elseif(Auth::user()->usertype == 5)
            $location = 4; //BOHOL

        $users = DB::table('users')
            ->leftJoin('work_sched', function($join){
                $join->on('users.sched','=','work_sched.id');
            })
            ->where('usertype','=',$location)
            ->orderBy('fname', 'ASC')
            ->paginate(20);
        return View::make('sub.subHome')->with('users',$users);
    }

    public function upload()
    {

        //POST Request
        if (Request::method() == 'POST') {
            //return Redirect::to('home');
            if (Input::hasFile('dtr_file')) {

                $file = Input::file('dtr_file');
                ini_set('max_execution_time', 0);
                $dtr = file_get_contents($file);
                $data = explode(PHP_EOL, $dtr);

                $pdo = DB::connection()->getPdo();
                //DTR FILE
                $query1 = "INSERT IGNORE INTO dtr_file(userid, datein, time, event,remark, edited, created_at, updated_at) VALUES";

                for ($i = 1; $i < count($data); $i++) {
                    try {
                        $employee = explode(',', $data[$i]);

                        $id = trim($employee[0], "\" ");
                        $id = ltrim($id, "\" ");

                        if ($id != 'Unknown User') {
                            //USERID
                            $col1 = array_key_exists(0, $employee) == true ? trim($employee[0], "\" ") : null;
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

                        }
                    } catch (Exception $ex) {
                        return json_encode($ex);
                    }
                }

                $query1 .= "('','','','','','',NOW(),NOW())";
                $st = $pdo->prepare($query1);
                $st->execute();

                $pdo = null;
                return Redirect::back()->with('sub_upload','Uploaded logs');
            } else {
                return "<h2 style='color:red;'>No input file</h2>";
            }
        }
    }

}