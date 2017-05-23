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
        if(Request::method() == 'GET'){
            return View::make('dtr.upload');
        }
        //POST Request
        if(Request::method() == 'POST'){

            if(Input::hasFile('dtr_file')){

                $file = Input::file('dtr_file');
                ini_set('max_execution_time', 0);
                $dtr = file_get_contents($file);
                $data = explode(PHP_EOL,$dtr);
                for($i = 1; $i < count($data); $i++) {
                    try
                    {
                        $employee = explode(',', $data[$i]);
                        $details = new DtrDetails();

                        //$details->setTable('next_dtr_file');

                        $id = trim($employee[0], "\" ");
                        $id = ltrim($id, "\" ");

                        if($id != 'Unknown User'){
                            $details->userid = array_key_exists(0, $employee) == true ? trim($employee[0], "\" ") : null;

                            $f = array_key_exists(1, $employee) == true ? trim($employee[1], "\" ") : null;
                            $l = array_key_exists(2, $employee) == true ? trim($employee[2], "\" ") : null;

                            $details->datein = array_key_exists(4, $employee) == true ? trim($employee[4], "\" ") : null;
                            $details->time = array_key_exists(5, $employee) == true ? trim($employee[5], "\" ") : null;

                            $details->event = array_key_exists(6, $employee) == true ? trim($employee[6], "\" ") : null;
                            $details->remark = array_key_exists(8, $employee) == true ? trim($employee[8], "\" ") : null;

                            $details->edited = "0";
                            $details->save();


                            //FOR INSERTING DATA TO THE USERS TABLE ONLY. IF THE USERS TABLE HAS NO DATA, JUST UNCOMMENT THIS COMMENT.
                            $user = User::where('userid',$details->userid)->first();
                            //checking for duplicate userid
                            if( !isset($user) and !count($user) > 0){
                                $user = new User();
                                $user->fname = $f;
                                $user->lname = $l;
                                $user->userid = $details->userid;
                                $user->username = $details->userid;
                                $user->password = Hash::make($details->userid);

                                $user->usertype = 0;

                                if(strlen($id)> 5) {
                                    $user->emptype = 'REG';
                                    $user->sched = "2";
                                } else {
                                    $user->emptype = 'JO';
                                    $user->sched = "1";
                                }
                                $user->save();
                            }
                        }
                    } catch (Exception $ex) {

                    }
                }
               return Redirect::to('index');
            } else {
                return "<h2 style='color:red;'>No input file</h2>";
            }
        }
    }
    public function dtr_list()
    {
        $lists = DB::table('dtr_file')
            ->where('userid','<>', NULL)
            ->orderBy('lastname', 'ASC')
            ->groupBy('userid')
            ->paginate(30);
        return view('dashboard.dtrlist')->with('lists',$lists);
    }
    public function search()
    {
        $lists = null;
        if (Input::has('keyword')) {
            $keyword = Input::get('keyword');
            Session::put('keyword', $keyword);

        }
        if (Input::has('from') and Input::has('to')) {
            Session::forget('keyword');
            $_from = explode('/', Input::get('from'));
            $_to = explode('/', Input::get('to'));

            $f_from = $_from[2] . '-' . $_from[0] . '-' . $_from[1];
            $f_to = $_to[2] . '-' . $_to[0] . '-' . $_to[1];
            Session::put('f_from', $f_from);
            Session::put('f_to', $f_to);

        }

        if (Session::has('f_from') and Session::has('f_to') and Session::has('keyword')) {
            $f_from = Session::get('f_from');
            $f_to = Session::get('f_to');
            $keyword = Session::get('keyword');
            $lists = DtrDetails::where('department','<>','- -')
                ->where('datein', '>=', $f_from)
                ->where('datein', '<=', $f_to)
                ->orWhere('userid', 'LIKE', '%'.$keyword.'%')
                ->orWhere('firstname', 'LIKE', '%'.$keyword.'%')
                ->orWhere('lastname', 'LIKE', '%'.$keyword.'%')
                ->orderBy('datein', 'ASC')
                ->paginate(20);

        }
        if(Session::has('keyword')) {
            $keyword = Session::get('keyword');
            $lists = DB::table('dtr_file')->where('userid','!=', "")
                                ->orWhere('userid', 'LIKE', '%'.$keyword.'%')
                                ->orWhere('firstname', 'LIKE', '%'.$keyword.'%')
                                ->orWhere('lastname', 'LIKE', '%'.$keyword.'%')
                                ->orderBy('userid','DESC')
                                ->paginate(20);

        }
        return View::make('home')->with('lists', $lists);
    }
    public function create_attendance()
    {
        if(Request::method() == 'GET') {
            return View::make('dtr.new_attendance');
        }
        if(Request::method() == 'POST') {
            $dtr = new DtrDetails();
            $dtr->userid = Input::get('userid');
            $dtr->firstname = Input::get('firstname');
            $dtr->lastname = Input::get('lastname');
            $dtr->department = Input::get('department');
            $date = explode('/', Input::get('datein'));
            $date = $date[2] . '-' . $date[0] . '-' . $date[1];
            $dtr->datein = $date;
            $date = explode('-', $date);
            $dtr->date_y = array_key_exists(0, $date) == true ? trim($date[0], "\" ") : null;
            $dtr->date_m = array_key_exists(1, $date) == true ?trim($date[1], "\" ") : null;
            $dtr->date_d = array_key_exists(2, $date) == true ?trim($date[2], "\" ") : null;

            $dtr->time = Input::get('time');
            $time = explode(':', Input::get('time'));
            $dtr->time_h = array_key_exists(0, $time) == true ?trim($time[0], "\" ") : null;
            $dtr->time_m = array_key_exists(1, $time) == true ?trim($time[1], "\" ") : null;
            $dtr->time_s = array_key_exists(2, $time) == true ? trim($time[2], "\" ") : null;

            $dtr->event = Input::get('event');
            $dtr->terminal = Input::get('terminal');
            $dtr->remark = Input::get('remarks');
            $dtr->save();


            $user = User::where('userid',$dtr->userid)->first();
            //checking for duplicate userid
            if( !isset($user) and !count($user) > 0){
                $user = new User();
                $user->fname = $dtr->firstname;
                $user->lname = $dtr->lastname;
                $user->userid = $dtr->userid;
                $user->username = $dtr->userid;
                $user->password = Hash::make($dtr->userid);
                $user->usertype = 0;
                $user->save();
            }
            return Redirect::to('home');
        }
    }
    public function edit_attendance($id = null)
    {
        if(Request::method() == 'GET') {
            if(isset($id)) {
                Session::put('dtr_id',$id);
            }
            $dtr = DtrDetails::where('dtr_id', $id)->first();
            return View::make('dtr.edit_attendance')->with('dtr',$dtr);
        }
        if(Request::method() == 'POST') {
            if(Session::has('dtr_id')) {
                $dtr_id = Session::get('dtr_id');
                $dtr = DtrDetails::where('dtr_id', $dtr_id)->first();
                $dtr->time = Input::get('time');
                $time = explode(':', Input::get('time'));
                $dtr->time_h = array_key_exists(0, $time) == true ?trim($time[0], "\" ") : null;
                $dtr->time_m = array_key_exists(1, $time) == true ?trim($time[1], "\" ") : null;
                $dtr->time_s = array_key_exists(2, $time) == true ? trim($time[2], "\" ") : null;
                $dtr->event = Input::get('event');
                $dtr->terminal = Input::get('terminal');
                $dtr->remark = Input::get('remarks');
                $dtr->save();
                Session::forget('dtr_id');
                return Redirect::to('home');
            }
        }
    }
    public function delete()
    {
        $dtr = DtrDetails::where('dtr_id',Input::get('dtr_id'))->first();
        if(isset($dtr) and $dtr != null)
        {
            $dtr->delete();
            return Redirect::to('index')->with('message','Attendance succesfully deleted.');
        }
    }

    private function create_table($desc,$date_from, $date_to,$name)
    {
        $pdo = null;
        $ok = false;
        try{
            $pdo = new PDO('mysql:host=localhost; dbname=dohdtr','root','');
            $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
            $query = "INSERT INTO dtr_table(desc,date_from,$date_to,name,created_at,updated_at)
                      VALUES(:desc,:date_from,:date_to,:name,NOW(),NOW())";
            $st = $pdo->prepare($query);
            $st->bindParam(':desc', $desc);
            $st->bindParam(':date_from', $date_from);
            $st->bindParam(':date_to', $date_to);
            $st->bindParam(':name',$name);
            if($st->execute()) {
                $ok = true;
            }
        }
        catch (PDOException $err) {
            $err->getMessage() . "<br/>";
            die();
        }
        return $ok;

    }
}