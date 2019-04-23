<?php
/**
 * Created by PhpStorm.
 * User: Lourence
 * Date: 1/12/2017
 * Time: 11:18 AM
 */

ini_set('max_execution_time', 0);
ini_set('memory_limit','1000M');
ini_set('max_input_time','300000');
class AdminController extends BaseController
{
    public function index()
    {
        if(Auth::check()){
            if(Auth::user()->usertype == '0' || Auth::user()->usertype == '2' || Auth::user()->usertype == '4'){
                return Redirect::to('personal/index');
            }
            elseif(Auth::user()->usertype == '1') {
                return Redirect::to('home');
            }
            elseif(Auth::user()->usertype == '3' || Auth::user()->usertype == '5'){
                return Redirect::to('subHome');
            }
        }
        if(!Auth::check() and Request::method() == 'GET') {
            return View::make('auth.login');
        }
        if(Request::method() == 'POST') {
            $username = Input::get('username');
            $password = Input::get('password');

            if(Auth::attempt(array('username' => $username, 'password' => $password))) {
                if(Auth::user()->usertype == '0' || Auth::user()->usertype == '2' || Auth::user()->usertype == '4'){
                    return Redirect::to('personal/index');
                }
                elseif(Auth::user()->usertype == '1') {
                    return Redirect::to('home');
                }
                elseif(Auth::user()->usertype == '3' || Auth::user()->usertype == '5'){
                    return Redirect::to('subHome');
                }
            } else {
                return Redirect::to('/')->with('ops','Invalid Login')->with('username',$username);
            }
        }
    }

    public function home()
    {
        $users = DB::table('users')
            ->leftJoin('work_sched', function($join){
                $join->on('users.sched','=','work_sched.id');
            })
            ->orderBy('fname', 'ASC')
            ->paginate(20);
        return View::make('home')->with('users',$users);
    }

    public function list_all()
    {
        $users = DB::table('users')
            ->leftJoin('work_sched', function($join){
                $join->on('users.sched','=','work_sched.id');
            })
            ->where('usertype', '=', '0')
            ->orderBy('fname', 'ASC')
            ->paginate(20);

        return View::make('users.users')->with('users',$users);
    }

    public function search_jo()
    {
        if(Input::has('search')) {
            $search = Input::get('search');

            $users = DB::table('users')
                ->leftJoin('work_sched', function($join){
                    $join->on('users.sched','=','work_sched.id');
                })
                ->where('users.userid', 'LIKE', "%$search%")
                ->orWhere('users.fname', 'LIKE', "%$search%")
                ->orWhere('users.lname', 'LIKE', "%$search%")
                ->orderBy('users.fname', 'DESC')
                ->paginate(20);

            return Redirect::back()->with('users', $users);
        }
        return Redirect::to('employees');
    }

    public function search()
    {
        if(Auth::user()->usertype == 3){
            $condition = "=";
            $location = 2;
        }
        elseif(Auth::user()->usertype == 5){
            $condition = "=";
            $location = 4;
        } elseif(Auth::user()->usertype = 1) {
            $condition = "!=";
            $location = 1;
        }

        $keyword = Input::get('search');
        $users = DB::table('users')
            ->leftJoin('work_sched', function($join){
                $join->on('users.sched','=','work_sched.id');
            })
            ->where(function($q) use ($keyword){
                $q->where('fname','like',"%$keyword%")
                    ->orwhere('lname','like',"%$keyword%")
                    ->orwhere('userid','like',"%$keyword%");
            })
            ->where('usertype',$condition,$location)
            ->orderBy('fname', 'ASC')
            ->paginate(10);

        return View::make('sub.subHome',[
            'users' => $users
        ]);

    }

    public function search_regular()
    {
        if(Input::has('search')) {
            $search = Input::get('search');
            $regulars = DB::table('users')
                ->leftJoin('work_sched', function($join){
                    $join->on('users.sched','=','work_sched.id');
                })
                ->where('users.userid', 'LIKE', "%$search%")
                ->orWhere('users.fname', 'LIKE', "%$search%")
                ->orWhere('users.lname', 'LIKE', "%$search%")
                ->orderBy('users.fname', 'DESC')
                ->paginate(20);
            return View::make('users.regular')->with('users', $regulars);
        }
    }


    public function list_regular()
    {
        $regulars = DB::table('users')
            ->leftJoin('work_sched', function($join){
                $join->on('users.sched','=','work_sched.id');
            })
            ->orderBy('fname','ASC')
            ->where('emptype','=','REG')
            ->paginate(20);
        return View::make('users.regular')->with('regulars',$regulars);
    }


    public function change_schedule()
    {
        if(Request::method() == "GET") {
            $sched = WorkScheds::all();
            if(Input::has('id')){
                Session::forget('sched_id');
                Session::put('sched_id',Input::get('id'));
                $user = Users::where('userid','=', Session::get('sched_id'))->first();
                return View::make('users.change_sched')->with('sched',$sched)->with('user',$user);

            } else {
                return "<strong>No employee ID is sent.</strong>";
            }
        }

        if(Request::method() == "POST") {
            $user = Users::where('userid', '=', Session::get('sched_id'))->first();
            if(isset($user) and count($user) > 0) {
                $user->sched = Input::get('schedule_id');
                $user->save();
                return Redirect::back()->with('updatedSchedule',"Successfully Updated Schedule");
            }
        }
    }

    public function adduser()
    {
        if(Request::method() == "GET") {
            $sched = WorkScheds::all();
            $lastUserid = InformationPersonal::where('userid','REGEXP','^[0-9]+$')
                ->where(DB::raw("LENGTH(userid)"),'<=',4)
                ->where('userid','<',1000)
                ->orderBy(DB::raw("CONVERT(SUBSTRING_INDEX(userid,'-',-1),UNSIGNED INTEGER)"),'desc')
                ->where('job_status','=','Job Order')
                ->first()->userid;

            return View::make('users.adduser',[
                "lastUserid" => $lastUserid
            ])->with('scheds',$sched);
        }

        $check = User::where("userid","=",Input::get('userid'))->first();
        if(isset($check)){
            return Redirect::to('add/user')->with('useridExist',"Userid:".Input::get('userid')." Existed!");
        } else{
            $password = Hash::make('123');
            //DTR
            $user = new Users();
            $user->userid = Input::get('userid');
            $user->fname = Input::get('fname');
            $user->lname = Input::get('lname');
            $user->sched = Input::get('sched');
            $user->username = Input::get('userid');
            $user->password = $password;
            $user->emptype = Input::get('emptype');
            if(Auth::user()->usertype == 1) { //CEBU ADMIN
                $usertype = 0; //CEBU USER
            }
            elseif(Auth::user()->usertype == 3) { //NEGROS ADMIN
                $usertype = 2; // NEGROS USER
            }
            elseif(Auth::user()->usertype == 5) { //BOHOL ADMIN
                $usertype = 4; // BOHOL USER
            }
            $user->usertype = $usertype;
            $user->unique_row = Input::get('userid');
            $user->save();

            //PIS
            $personal_information = new InformationPersonal();
            $personal_information->userid = Input::get('userid');
            $personal_information->fname = Input::get('fname');
            $personal_information->lname = Input::get('lname');
            $personal_information->sched = Input::get('sched');
            if(Input::get('emptype') == 'REG'){
                $job_status = 'Permanent';
                $disbursement_type = "ATM";
            }
            else{
                $job_status = 'Job Order';
                $disbursement_type = "CASH_CARD";
            }
            $personal_information->job_status = $job_status;
            $personal_information->disbursement_type = $disbursement_type;
            $personal_information->employee_status = 'Active';
            $personal_information->user_status = '1';
            $personal_information->save();

            //PIS USER
            $user_pis = new UserPis();
            $user_pis->username = Input::get('userid');
            $user_pis->password = $password;
            $user_pis->usertype = 0;
            $user_pis->pin = 1234;
            $user_pis->save();

            //DTS USER
            $user_dts = new UserDts();
            $user_dts->fname = Input::get('fname');
            $user_dts->lname = Input::get('lname');
            $user_dts->username = Input::get('userid');
            $user_dts->password = $password;
            $user_dts->user_priv = 0;
            $user_dts->status = 0;
            $user_dts->save();

            return Redirect::back()->with('userAdded','Added User');
        }

    }

    public function flexi_group()
    {
        $scheds = WorkScheds::all();
        Session::put('sched', $scheds[0]['id']);
        if(isset($scheds) and count($scheds) > 0) {
            $users = DB::table('users')
                ->leftJoin('work_sched', function($join){
                    $join->on('users.sched','=','work_sched.id');
                })
                ->where('users.sched', '=', Session::get('sched'))
                ->orderBy('fname', 'ASC')
                ->paginate(20);
            Session::forget('sched');
            return View::make('users.flixe')->with('scheds',$scheds)->with('users',$users);
        }
    }
    public function filter_flixe()
    {
        if(Input::has('sched') and Input::get('sched')) {
            Session::put('sched', Input::get('sched'));
        }

        if(Session::has('sched')) {
            $scheds = WorkScheds::all();
            $sched = Session::get('sched');
            $users = DB::table('users')
                ->leftJoin('work_sched', function ($join) {
                    $join->on('users.sched', '=', 'work_sched.id');
                })
                ->where('users.sched', '=',$sched)
                ->orderBy('fname', 'ASC')
                ->paginate(20);
            return View::make('users.flixe')->with('scheds', $scheds)->with('users', $users);
        }
    }

    public function show_group()
    {
        $scheds = WorkScheds::all();
        return View::make('users.flixe_datatable')->with('scheds',$scheds);
    }
    public function datatables()
    {
        if(Input::has('sched'))
        {
            $sched = Input::get('sched');
            $pdo = DB::connection()->getPdo();
            $query = "SELECT CONCAT('<b>',u.userid,'</b>') as userid ,CONCAT('<b>',u.fname,' ',u.lname,'</b>') as name, CONCAT('<b>',w.am_in,' to ', w.pm_out,'</b>') as sched , w.description FROM users u LEFT JOIN work_sched w ON u.sched = w.id WHERE u.usertype = '0' AND u.sched = '". $sched ."' ORDER  BY u.fname";
            $st = $pdo->prepare($query);
            $st->execute();
            $row = $st->fetchAll(PDO::FETCH_ASSOC);
            if(isset($row) and count($row) > 0) {
                return $row;
            }
        }
    }

    public function delete()
    {
        if(Input::get('date_range')) {
            $str = Input::get('date_range');
            $temp1 = explode('-',$str);
            $temp2 = array_slice($temp1, 0, 1);
            $tmp = implode(',', $temp2);
            $date_from = date('Y-m-d',strtotime($tmp));
            $temp3 = array_slice($temp1, 1, 1);
            $tmp = implode(',', $temp3);
            $date_to = date('Y-m-d',strtotime($tmp));
        }
        if(Input::get('userid') and Input::get('date_range')) {
            $dtr = DB::table('dtr_file')
                ->where('userid', '=', Input::get('userid'))
                ->whereBetween('datein', array($date_from, $date_to));
            if(isset($dtr) and count($dtr) > 0) {
                $dtr->delete();
                return Redirect::to('index')->with('msg_sched', "Time logs between $date_from and $date_to was removed for userid : ". Input::get('userid'));
            } else {
                return Redirect::to('index')->with('msg_sched', "Nothing to delete.");
            }
        } else if (Input::get('date_range')) {
            $dtr = DB::table('dtr_file')
                ->whereBetween('datein', array($date_from, $date_to));
            if(isset($dtr) and count($dtr) > 0) {
                $dtr->delete();
                return Redirect::to('index')->with('msg_sched', "Time logs between $date_from and $date_to was removed.");
            } else {
                return Redirect::to('index')->with('msg_sched', "Nothing to delete.");
            }
        }
    }

    function searchArray( array $array, $search )
    {
        while( $array ) {
            if( isset( $array[ $search ] ) ) return $array[ $search ];
            $segment = array_shift( $array );
            if( is_array( $segment ) ) {
                if( $return = searchArray( $segment, $search ) ) return $return;
            }
        }
        return false;
    }

    public function user_edit()
    {
        if(Request::method() == 'GET') {
            $usertype = [
                ["value" => 0,"description" =>"CEBU USER"],
                ["value" => 1,"description" =>"CEBU ADMIN"],
                ["value" => 2,"description" =>"NEGROS USER"],
                ["value" => 3,"description" =>"NEGROS ADMIN"],
                ["value" => 4,"description" =>"BOHOL USER"],
                ["value" => 5,"description" =>"BOHOL ADMIN"],
            ];

            $user = DB::table('users')->where('userid', '=', Input::get('id'))->first();
            Session::put('edit_user', $user->id);
            return View::make('users.user_edit',[
                "user" => $user,
                "usertype" => $usertype,
                "usertype_default" => $this->searchArray($usertype,$user->usertype)
            ]);
        }
        if(Request::method() == 'POST') {
            $user = Users::where('id', '=', Session::get('edit_user'))->first();

            if(strlen(Input::get('username')) > 5) {
                $user->emptype = "REG";
            } else {
                $user->emptype = "JO";
            }
            $user->userid = Input::get('username');
            $user->unique_row = Input::get('username');
            $user->fname = Input::get('fname');
            $user->lname = Input::get('lname');
            $user->mname = Input::get('mname');
            $user->username = Input::get('username');
            $user->imei = Input::get('imei');
            if(Auth::user()->usertype == "1")
                $user->usertype = Input::get("usertype");
            elseif(Auth::user()->usertype == "3")
                $user->usertype = "2";
            elseif(Auth::user()->usertype == "5")
                $user->usertype = "4";
            $user->save();
            Session::forget('edit_user');
            return Redirect::back()->with('updatedUser',"Successfully Updated User");
        }
    }
    public function print_employees()
    {
        if(Input::has('emp_type')) {
            $users = DB::table('users')->where('emptype', '=', Input::get('emp_type'))
                ->orderBy('lname', 'ASC')
                ->get();
            $type = Input::get('emp_type');
            $display = View::make("pdf.employees")->with('users',$users)->with('type', $type);
            $pdf = App::make('dompdf');
            $pdf->loadHTML($display);
            return $pdf->stream();
        }
    }

    public function delete_user()
    {
        if(Input::has('userid')) {
            $id = Input::get('userid');
            $user = Users::where('userid', '=', $id)->first();
            if(count($user)) {
                $name = $user->lname . ", " . $user->fname;
                $user->delete();
                return Redirect::back()->with("deletedUser","Successfully Deleted User");
            }
        }
    }

    public function track_leave()
    {
        $leaves = DB::table('leave')->orderBy('created_at','ASC')->paginate(20);
        return View::make('form.leave_list',['leaves' => $leaves]);
    }
    public function approve_leave()
    {
        DB::table('leave')->where('route_no','=',Input::get('route_no'))->update(['approve' => 1]);
        $leave = DB::table('leave')->where('route_no','=',Input::get('route_no'))->first();
        $from = date('Y-m-d',strtotime($leave->inc_from));

        $end_date = date('Y-m-d',strtotime($leave->inc_to));

        $f = new DateTime($from.' '. '24:00:00');
        $t = new DateTime($end_date.' '. '24:00:00');


        $interval = $f->diff($t);
        $remarks = "LEAVE";
        $f_from = explode('-',$from);
        $startday = $f_from[2];
        $j = 0;
        while($j <= $interval->days) {

            $datein = $f_from[0].'-'.$f_from[1] .'-'. $startday;

            $details = new LeaveLogs();
            $details->userid = $leave->userid;
            $details->datein = $datein;
            $details->time = '08:00:00';
            $details->event = 'IN';
            $details->remark = strtoupper($leave->leave_type)." ".$remarks;
            $details->edited = '1';
            $details->holiday = '007';

            $details->save();

            $details = new LeaveLogs();
            $details->userid =  $leave->userid;
            $details->datein = $datein;
            $details->time = '12:00:00';
            $details->event = 'OUT';
            $details->remark = strtoupper($leave->leave_type)." ".$remarks;
            $details->edited = '1';
            $details->holiday = '007';

            $details->save();

            $details = new LeaveLogs();
            $details->userid =  $leave->userid;
            $details->datein = $datein;
            $details->time = '13:00:00';
            $details->event = 'IN';
            $details->remark = strtoupper($leave->leave_type)." ".$remarks;
            $details->edited = '1';
            $details->holiday = '007';

            $details->save();

            $details = new LeaveLogs();
            $details->userid =$leave->userid;
            $details->datein = $datein;
            $details->time = '18:00:00';
            $details->event = 'OUT';
            $details->remark = strtoupper($leave->leave_type)." ".$remarks;
            $details->edited = '1';
            $details->holiday = '007';

            $details->save();

            $startday = $startday + 1;
            $j++;
        }
        return Redirect::to('tracked/leave');
    }

    public function cancel_leave($route_no) {
        $leave = DB::table('leave')->where('route_no','=',$route_no)->first();
        DB::table('leave_logs')
            ->where('userid','=',$leave->userid)
            ->where('edited','=',1)
            ->where('holiday','=','006')
            ->whereBetween('datein',array($leave->inc_from,$leave->inc_to))
            ->delete();
        DB::table('leave')->where('route_no','=',$route_no)->update(['approve' => 0]);
        return Redirect::to('tracked/leave');
    }
    public function search_leave()
    {
        $q = Input::get('q');
        $leaves = DB::table('leave')
            ->where('route_no','LIKE', "%$q%")
            ->orWhere('firstname','LIKE',"%$q%")
            ->orWhere('lastname','LIKE',"%$q%")
            ->orderBy('created_at','ASC')
            ->paginate(20);
        return View::make('form.leave_list',['leaves' => $leaves]);
    }
    public function print_user_logs()
    {
        return View::make('print.print_logs');
    }

    public function print_mobile_logs()
    {
        $userid = Input::get('userid');

        $str = $_POST['filter_range'];
        $temp1 = explode('-',$str);
        $temp2 = array_slice($temp1, 0, 1);
        $tmp = implode(',', $temp2);
        $date_from = date('Y-m-d',strtotime($tmp));
        $temp3 = array_slice($temp1, 1, 1);
        $tmp = implode(',', $temp3);
        $date_to = date('Y-m-d',strtotime($tmp));

        $emptype = Input::get('emptype');


        $day1 = explode('-',$date_from);
        $day2 = explode('-',$date_to);

        $startday = floor($day1[2]);
        $endday = $day2[2];

        $data['date_from'] = $date_from;
        $data['date_to'] = $date_to;
        $data['startday'] = $startday;
        $data['endday'] = $endday;
        $data['userid'] = $userid;
        $data['day1'] = $day1;
        $data['day2'] = $day2;

        return View::make('print.mobile_logs',['data' => $data]);

    }
    public function leave_credits()
    {
        if(Request::method() == "GET")
        {
            return View::make('users.leave_credits');
        }
    }

    public function get_regular_emp()
    {
        $employees = DB::table('users')->where('emptype','=','REG')->get(['lname','fname','mname','userid']);
        return json_encode($employees);
    }
    public function add_leave_table()
    {
        Schema::create('leave_credits',function($table){
            $table->increments('id');
            $table->string('userid');
            $table->double('vacation');
            $table->double('sick');
        });
    }
}