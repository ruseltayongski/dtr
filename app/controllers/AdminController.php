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
        if(Auth::check()) {
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
            return Redirect::to('/login');
        }
        if(Request::method() == 'POST') {
            $username = Input::get('username');
            $password = Input::get('password');

            if(Auth::attempt(array('username' => $username, 'password' => $password))) {
                if(Auth::user()->usertype == '0' || Auth::user()->usertype == '2' || Auth::user()->usertype == '4') {
                    return Redirect::to('personal/index');
                }
                elseif(Auth::user()->usertype == '1')
                    return Redirect::to('home');
                elseif(Auth::user()->usertype == '3' || Auth::user()->usertype == '5')
                    return Redirect::to('subHome');
            } else {
                return Redirect::to('/login')->with('ops','Invalid Login')->with('username',$username);
            }
        }
    }

    public function login() {
        return View::make('auth.login');
    }

    public function home()
    {
        $keyword = Input::get("search");

        $users = DB::table('users')
            ->leftJoin('work_sched', function($join){
                $join->on('users.sched','=','work_sched.id');
            });

        if(isset($keyword)){
            $users = $users->where(function($q) use ($keyword){
                $q->where('users.fname','like',"%$keyword%")
                    ->orwhere('users.lname','like',"%$keyword%")
                    ->orwhere('users.userid','like',"%$keyword%");
            });
        }

        $users = $users->orderBy('users.fname', 'ASC')
              ->paginate(20);

        return View::make('home',['users' => $users,'keyword' => $keyword]);
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
            $userid = Input::get('id');
            $user = DB::table('users')->where('userid',"=",$userid)->first();
            $user_roles = UserRoles::where("userid","=",$userid)->get(['claims_id']);
            $user_claim = UserClaims::get();
            $assigned_areas = AssignedArea::where("userid", "=", $userid)->get(['area_of_assignment_id']);
            $assignment_areas = AreaAssignment::get();
            Session::put('edit_user',$userid);
            return View::make('users.user_edit',[
                "user" => $user,
                "user_roles" => $user_roles,
                "user_claim" => $user_claim,
                "assigned_areas" => $assigned_areas,
                "assignment_areas" => $assignment_areas,
                "usertype" => $usertype,
                "usertype_default" => $this->searchArray($usertype,$user->usertype)
            ]);
        }
        if(Request::method() == 'POST') {

            $userid = Session::get('edit_user');
            $prev_roles = UserRoles::where('userid','=',$userid);
            if(count((array)$prev_roles) >= 1){
                $prev_roles->delete();
            }
            if(Input::get('user_roles')){
                foreach(Input::get('user_roles') as $row){
                    $current_roles = new UserRoles();
                    $current_roles->userid = $userid;
                    $current_roles->claims_id = $row;
                    $current_roles->status = 'active';
                    $current_roles->save();
                }
            }

            $prev_assignment = AssignedArea::where('userid', '=', $userid);
            if(count((array)$prev_assignment) >= 1){
                $prev_assignment->delete();
            }
            $user_change = Auth::user();
            if(Input::get('assigned_area')){
                foreach(Input::get('assigned_area') as $row){
                    $current_areas = new AssignedArea();
                    $current_areas->userid = $userid;
                    $current_areas->area_of_assignment_id = $row;
                    $current_areas->updated_by = "(".$user_change->id."-".$user_change->username.") ".$user_change->fname." ".$user_change->lname;
                    $current_areas->save();
                }
            }

            $user = Users::where('userid','=',$userid)->first();
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
            $user->authority = Input::get('authority');
            $user->region = Input::get('region');
            $user->area_assignment_reset = Input::has('reset_user_area') ? 1 : 0;
            if(Auth::user()->usertype == "1")
                $user->usertype = Input::get("usertype");
            elseif(Auth::user()->usertype == "3")
                $user->usertype = "2";
            elseif(Auth::user()->usertype == "5")
                $user->usertype = "4";
            $user->save();
            Session::put("updatedUser",true);
            return Redirect::back();
        }
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
            if(isset($user) and $user != null) {
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

        /*$check = InformationPersonal::where("userid","=",Input::get('userid'))->first();
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
        }*/

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

    public function track_leave() // leave applications
    {
        Session::put('keyword',Input::get('keyword'));
        $keyword = Session::get('keyword');

        if( Input::get('type') ){
            $type = Input::get('type');
        }
        else {
            $type = 'pending';
        }
        $leave["count_disapproved"] = Leave::where('status',4)
            ->where(function($q) use ($keyword){
                $q->where("route_no","like","%$keyword%")
                    ->orWhere("leave_type", "like", "%$keyword%")
                    ->orWhere("lastname", "like", "%$keyword%");
            })
            ->get();
        $leave["count_cancelled"] = Leave::where('status',"3")
            ->where(function($q) use ($keyword){
                $q->where("route_no","like","%$keyword%")
                    ->orWhere("leave_type", "like", "%$keyword%")
                    ->orWhere("lastname", "like", "%$keyword%");
            })
            ->get();
        $leave["count_pending"] = Leave::where('status',"0")
            ->where(function($q) use ($keyword){
                $q->where("route_no","like","%$keyword%")
                    ->orWhere("leave_type", "like", "%$keyword%")
                    ->orWhere("lastname", "like", "%$keyword%");
            })
            ->get();
        $leave["count_approve"] = Leave::where('status', '1')
            ->where(function($q) use ($keyword){
                $q->where("route_no","like","%$keyword%")
                    ->orWhere("leave_type", "like", "%$keyword%")
                    ->orWhere("lastname", "like", "%$keyword%");
            })
            ->get();
        $leave["count_all"] = Leave::where(function($q) use ($keyword){
            $q->where("route_no","like","%$keyword%")
                ->orWhere("leave_type", "like", "%$keyword%")
                ->orWhere("lastname", "like", "%$keyword%");
        })
            ->get();

        $leave['paginate_disapproved'] = Leave::where('status',4)
            ->where(function($q) use ($keyword){
                $q->where("route_no","like","%$keyword%")
                    ->orWhere("leave_type", "like", "%$keyword%")
                    ->orWhere("lastname", "like", "%$keyword%");
            })
            ->with(['appliedDates',
                'type' => function ($query) {
                    $query->select('code', 'desc');
                }
            ])
            ->orderBy('id','desc')
            ->paginate(10);

        $leave['paginate_cancelled'] = Leave::where('status',"3")
            ->where(function($q) use ($keyword){
                $q->where("route_no","like","%$keyword%")
                    ->orWhere("leave_type", "like", "%$keyword%")
                    ->orWhere("lastname", "like", "%$keyword%");
            })
            ->with(['appliedDates',
                'type' => function ($query) {
                    $query->select('code', 'desc');
                }
            ])
            ->orderBy('id','desc')
            ->paginate(10);

        $leave['paginate_pending'] =Leave::where('status','0')
            ->where(function($q) use ($keyword){
                $q->where("route_no","like","%$keyword%")
                    ->orWhere("leave_type", "like", "%$keyword%")
                    ->orWhere("lastname", "like", "%$keyword%");
            })
            ->with(['appliedDates',
                'type' => function ($query) {
                    $query->select('code', 'desc');
                }
            ])
            ->orderBy('id','desc')
            ->paginate(10);

        $leave['paginate_approve'] = Leave::where('status', '1')
            ->where(function($q) use ($keyword){
                $q->where("route_no","like","%$keyword%")
                    ->orWhere("leave_type", "like", "%$keyword%")
                    ->orWhere("lastname", "like", "%$keyword%");
            })
            ->with(['appliedDates',
                'type' => function ($query) {
                    $query->select('code', 'desc');
                }
            ])
            ->orderBy('id','desc')
            ->paginate(10);

        $leave['paginate_all'] = Leave::where(function($q) use ($keyword){
            $q->where("route_no","like","%$keyword%")
                ->orWhere("leave_type", "like", "%$keyword%")
                ->orWhere("lastname", "like", "%$keyword%");
        })
            ->with(['appliedDates',
                'type' => function ($query) {
                    $query->select('code', 'desc');
                }
            ])
            ->orderBy('leave.id','desc')
            ->paginate(10);

        if (Request::ajax() ) {
            $view = 'form.form_'.$type;
            Session::put('page_'.$type,Input::get('page'));

            return View::make($view,[
                "leave" => $leave,

                "type" => $type,
                "count_disapproved" => count($leave["count_disapproved"]),
                "count_cancelled" => count($leave["count_cancelled"]),
                "count_pending" => count($leave["count_pending"]),
                "count_approve" => count($leave["count_approve"]),
                "count_all" => count($leave["count_all"]),
                "paginate_disapproved" => $leave["paginate_disapproved"],
                "paginate_cancelled" => $leave["paginate_cancelled"],
                "paginate_pending" => $leave["paginate_pending"],
                "paginate_approve" => $leave["paginate_approve"],
                "paginate_all" => $leave["paginate_all"]
            ]);
        }
        return View::make('form.all_leave',[
            "leave" => $leave,
            "type" => $type,
            "paginate_disapproved" => $leave["paginate_disapproved"],
            "paginate_cancelled" => $leave["paginate_cancelled"],
            "paginate_pending" => $leave["paginate_pending"],
            "paginate_approve" => $leave["paginate_approve"],
            "paginate_all" => $leave["paginate_all"]
        ]);
    }

    public function edit_leave($id)
    {
        $leave = Leave::where('id',$id)->first();
        $leave_type = LeaveTypes::get();
        $leave_dates = LeaveAppliedDates::where('leave_id', $leave->id)->get();
        $user = InformationPersonal::where('userid', Auth::user()->userid)->first();
        $spl = AditionalLeave::where('userid', Auth::user()->userid)->first();
        $id_list = [];
        $manually_added = [985329, 273, 11, 93053, 986445, 984538, 985950, 80, 976017, 466];

        foreach(pdoController::section() as $row) {
            if ($row['acronym'] !== null || in_array($row['head'], [37, 72, 243, 614, 110, 5, 163, 648384, 160, 985950, 830744, 51])) {
                if(!in_array($row['head'], [172, 173, 96, 53, 114, 442, 155, 91, 6, 51])){
                    if(!in_array($row['head'], $id_list)){
                        $id_list[]=$row['head'];
                    }
                }
            }
        }
        $list = array_merge($id_list,$manually_added);
        foreach ($list as $data_list){
            $section_head[] = pdoController::user_search1($data_list);
        }


        foreach(pdoController::division() as $row) {
            if($row['ppmp_used'] == null && $row['head'] != 51){
                $division_head[] = pdoController::user_search1($row['head']);
            }
        }

//        return $leave_dates;
//        if(isset($leave) and count($leave) > 0)  {
        if(isset($leave))  {
            return View::make('form.update_leave')->with([
                'leave'=>$leave,
                'leave_type'=>$leave_type,
                'leave_dates'=>$leave_dates,
                'user' => $user,
                'spl' => $spl,
                'officer' => $section_head
            ]);
        }
        return Redirect::to('form/leave/all');
    }

    public function delete_leave($id) {
        $leave= Leave::where('id', $id)->first();
        $leave->delete();

        Session::put('deleted',true);
        return Redirect::to('form/leave/all');
    }

    public function pending_leave(){
//        return 1;

        $route_no = Input::get('route_no');
        $leave = Leave::where('route_no','=',$route_no)->first();

        if($leave){
            $pis = InformationPersonal::where('userid', $leave->userid)->first();
            $spl = AditionalLeave::where('userid', $leave->userid)->first();

            $pis->vacation_balance = $pis->vacation_balance + $leave->vl_deduct;
            $pis->sick_balance = $pis->sick_balance + $leave->sl_deduct;
            if($leave->leave_type == "SPL"){
                $spl->SPL = $spl->SPL + intval($leave->with_pay);
            }else if($leave->leave_type == "FL"){
                $spl->FL = $spl->FL + intval($leave->vl_deduct);
            }
            $leave->status = 0;
            $leave->save();
            $pis->save();
            $spl?$spl->save():'';

            $leave_card = LeaveCardView::where('leave_id', $leave->id)->first();
            $all_data = LeaveCardView::where('id', '>', $leave_card->id)->where('userid', $leave->userid)->get();

            foreach ($all_data as $data){
                $data->vl_bal = $data->vl_bal - $leave_card->vl_abswp;
                $data->sl_bal = $data->sl_bal - $leave_card->sl_abswp;
                $data->save();
            }
            $leave_card->delete();
            Session::put('pending_leave',true);
        }
        return Redirect::to('leave/roles');
    }

    public function disapproved_leave($route_no){

        $leave = Leave::where('route_no', $route_no)->first();
        $leave->status = 4;
        $leave->disapproval_remarks = Input::get('remarks');
        $leave->save();

        Session::put('disapproved_leave',true);
        return Redirect::to('leave/roles');
    }

    public function releasedStatusChecker($route_no,$section){
        $release = Tracking_Releasev2::where("route_no","=",$route_no)
            ->where("released_section_to","=",$section)
            ->where(function ($query) {
                $query->where('status','=','waiting')
                    ->orWhere('status','=','return');
            })
            ->orderBy('id', 'DESC');

        if($release->first()){
            $minute = DocumentController::checkMinutes($release->first()->released_date);
            if($minute <= 30 && ($release->first()->status == "waiting" || $release->first()->status == "return" )){
                $release->update([
                    "status" => "accept"
                ]);
            }
            elseif($minute > 30 && $release->first()->status == "waiting" || $release->first()->status == "return" ) {
                $release->update([
                    "status" => "report"
                ]);
            }
        }
    }

    public function approved_leave($route_no)
    {
        $leave = Leave::where('route_no', $route_no)->first();
        if($leave){
            $pis = InformationPersonal::where('userid', $leave->userid)->first();
            $add_leave = AditionalLeave::where('userid', $leave->userid)->first();

            $leave->status = 1;

            $leave_card = new LeaveCardView();
            $leave_card->userid = $leave->userid;
            $leave_card->leave_id = $leave->id;

            if($leave->leave_details == 8){
                $leave_card->particulars = 'Monetization';
                $leave_card->vl_abswp = $leave->vl_deduct;
                $leave_card->vl_bal = $pis->vacation_balance - $leave->vl_deduct;
                $leave_card->sl_abswp = $leave->sl_deduct;
                $leave_card->sl_bal = $pis->sick_balance - $leave->sl_deduct;
            }else{
                $leave_card->particulars = $leave->leave_type .'('. (int) $leave->applied_num_days .')';

                if($leave->leave_type == 'FL'){
                    $add_leave->FL = $add_leave->FL - $leave->vl_deduct;
                    $leave_card->vl_abswp = ($leave->vl_deduct == 0)?'': (int) $leave->vl_deduct;
                }else if($leave->leave_type == 'SPL'){
                    $add_leave->SPL = $add_leave->SPL - (int) $leave->applied_num_days;
                }else if($leave->leave_type == 'SL'){
                    $leave_card->sl_abswp = ($leave->sl_deduct == 0)?'':$leave->sl_deduct;
                    $leave_card->vl_abswp = ($leave->vl_deduct == 0)?'':$leave->vl_deduct;
                    $leave_card->sl_abswop = ($leave->without_pay == 0)?'':intval($leave->without_pay);
                    if($leave->applied_num_days <= $pis->sick_balance){
                        $leave_card->sl_abswp = $leave->applied_num_days;
                        $leave->with_pay = $leave->applied_num_days;
                        $leave_card->sl_abswop = null;
                        $leave_card->vl_abswop = null;
                    }
                }else if($leave->leave_type == 'VL'){
//                    $leave_card->vl_abswp = ($leave->vl_deduct > $pis->vacation_balance)?$pis->vacation_balance : $leave->vl_deduct ;
//                    $leave_card->vl_abswop = intval($leave->without_pay);

                    if($leave->applied_num_days <= $pis->vacation_balance){
                        $leave_card->vl_abswp = $leave->applied_num_days;
                        $leave->with_pay =  $leave->applied_num_days;
                        $leave->without_pay = 0;
                    }else if($leave->applied_num_days > $pis->vacation_balance){
                        $rem = $leave->applied_num_days - $pis->vacation_balance;
                        $leave_card->vl_abswp = intval($pis->vacation_balance);
                        $leave_card->vl_abswop = intval($rem);
                        $leave->with_pay =  intval($pis->vacation_balance);
                        $leave->without_pay = intval($rem);
                    }
                }

                $dates = LeaveAppliedDates::where('leave_id', $leave->id)->get();
                $list = [];
                foreach ($dates as $date){
                    if($date->startdate == $date->enddate){
                        $list[] = date('F j, Y', strtotime($date->startdate));
                    }else{
                        $list[] = date('F j, Y', strtotime($date->startdate)) .' - '. date('F j, Y', strtotime($date->enddate));
                    }
                }

                $data = json_encode($list);
                $leave_card->date_used = str_replace(['[', ']', '"'], '', $data);
                $add_leave?$add_leave->save():'';

                $leave_card->vl_bal = ($pis->vacation_balance > $leave->vl_deduct)?$pis->vacation_balance - $leave->vl_deduct : 0;
                $leave_card->sl_bal = $pis->sick_balance - $leave->sl_deduct;
            }

            $pis->vacation_balance = ($pis->vacation_balance > $leave->vl_deduct)?$pis->vacation_balance - $leave->vl_deduct:0;
            $pis->sick_balance = ($pis->sick_balance > $leave->sl_deduct)?$pis->sick_balance - $leave->sl_deduct:0;

            $pis->save();
            $leave->save();
            $leave_card->save();
        }

        //TRACKING
        $doc = Tracking_Master::where('route_no',$route_no)
            ->orderBy('id','desc')
            ->first();
        $document = Tracking_Details::where('route_no',$route_no)
            ->orderBy('id','desc')
            ->first();

//        return $route_no;

        $receiver = UserDts::where('username','=',Auth::user()->username)->first();
        if($document) {
            Tracking_Details::where('route_no', $route_no)
                ->where('received_by', $document->received_by)
                ->update(['status' => 1]);
            $received_by = $document->received_by;
        }
        else {
            $received_by = $doc->prepared_by;
        }
//        return Auth::user()->username;
//        $section = 'temp;'.$receiver->section;
//
//        if($document->code === $section)
//        {
//            Tracking_Details::where('id',$document->id)
//                ->update([
//                    'code' => 'accept;'.$receiver->section,
//                    'date_in' => date('Y-m-d H:i:s'),
//                    'received_by' => $receiver->id,
//                    'status' => 0,
//                    'action' => 'Leave application approved'
//                ]);
//        }else{
//            $q = new Tracking_Details();
//            $q->route_no = $route_no;
//            $q->code = 'accept;'.$receiver->section;
//            $q->date_in = date('Y-m-d H:i:s');
//            $q->received_by = $receiver->id;
//            $q->delivered_by = $received_by;
//            $q->action = 'Leave application approved';
//            $q->save();
//        }
//        $this->releasedStatusChecker($route_no,$receiver->section);
//        ///END TRACKING

        $all_dates = LeaveAppliedDates::where('leave_id', $leave->id)->get();
        $with_pay_leave = intval($leave->with_pay);
        if($all_dates){
            foreach ($all_dates as $index => $date){
                $index = $index + 1;
                $stat = $index > $with_pay_leave ? 1 : 0;
                $from = date('Y-m-d',strtotime($date->startdate));
                $end_date = date('Y-m-d',strtotime($date->enddate));
                $f = new DateTime($from.' '. '24:00:00');
                $t = new DateTime($end_date.' '. '24:00:00');

                $interval = $f->diff($t);
                $remarks = "LEAVE";
                $f_from = explode('-',$from);
                $startday = $f_from[2];
                $j = 0;

                $pdo = DB::connection()->getPdo();
                $query1 = "INSERT IGNORE INTO leave_logs(userid,datein,time,event,remark,edited,holiday,route_no,leave_status,created_at,updated_at) VALUES";
                while($j <= $interval->days) {
                    $datein = $f_from[0].'-'.$f_from[1] .'-'. $startday;
                    $day_name = date('l', strtotime($datein));
                    $userid = $leave->userid;
                    $edited = '1';
                    $holiday = '007';
                    $remark = strtoupper($leave->leave_type)." ".$remarks;

                    if($day_name != "Saturday" && $day_name != "Sunday"){
                        if($leave->half_day_first == 'AM' || $leave->half_day_last == 'AM'){
                            $timein = '08:00:00';
                            $event = 'IN';
                            $query1 .= "('" . $userid . "','" . $datein . "','" . $timein . "','" . $event . "','" . $remark . "','" . $edited . "','" . $holiday . "','" . $route_no . "','" . $stat . "',NOW(),NOW()),";


                            $timein = '12:00:00';
                            $event = 'OUT';
                            $query1 .= "('" . $userid . "','" . $datein . "','" . $timein . "','" . $event . "','" . $remark . "','" . $edited . "','" . $holiday . "','" . $route_no . "','" . $stat . "',NOW(),NOW()),";
                        }
                        elseif($leave->half_day_first == 'PM' || $leave->half_day_last == 'PM') {
                            $timein = '13:00:00';
                            $event = 'IN';
                            $query1 .= "('" . $userid . "','" . $datein . "','" . $timein . "','" . $event . "','" . $remark . "','" . $edited . "','" . $holiday . "','" . $route_no . "','" . $stat . "',NOW(),NOW()),";


                            $timein = '18:00:00';
                            $event = 'OUT';
                            $query1 .= "('" . $userid . "','" . $datein . "','" . $timein . "','" . $event . "','" . $remark . "','" . $edited . "','" . $holiday . "','" . $route_no . "','" . $stat . "',NOW(),NOW()),";
                        }
                        else {
                            $timein = '08:00:00';
                            $event = 'IN';
                            $query1 .= "('" . $userid . "','" . $datein . "','" . $timein . "','" . $event . "','" . $remark . "','" . $edited . "','" . $holiday . "','" . $route_no . "','" . $stat . "',NOW(),NOW()),";


                            $timein = '12:00:00';
                            $event = 'OUT';
                            $query1 .= "('" . $userid . "','" . $datein . "','" . $timein . "','" . $event . "','" . $remark . "','" . $edited . "','" . $holiday . "','" . $route_no . "','" . $stat . "',NOW(),NOW()),";


                            $timein = '13:00:00';
                            $event = 'IN';
                            $query1 .= "('" . $userid . "','" . $datein . "','" . $timein . "','" . $event . "','" . $remark . "','" . $edited . "','" . $holiday . "','" . $route_no . "','" . $stat . "',NOW(),NOW()),";


                            $timein = '18:00:00';
                            $event = 'OUT';
                            $query1 .= "('" . $userid . "','" . $datein . "','" . $timein . "','" . $event . "','" . $remark . "','" . $edited . "','" . $holiday . "','" . $route_no . "','" . $stat . "',NOW(),NOW()),";
                        }
                    }

                    $startday = $startday + 1;
                    $j++;
                }

                $query1 .= "('','','','','','','','','',NOW(),NOW())";
                $st = $pdo->prepare($query1);
                $st->execute();
            }
        }
//        return 1;
//        return $type;
//        if($type){
            Session::put('approved_leave',true);
            return Redirect::to('leave/roles');
//        }else{
//            return 'success';
//        }
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
        return Redirect::to('leave/roles');
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
        // pis list isn't updated for reqular employees, people who can avail leave as of august 2, 2024

       $ids = [
            "201700267", "001", "201400188", "202100303", "199900064", "200200097", "202300324", "199100053",
            "201700272", "20230034", "198200051", "201600254", "201500252", "202300326", "199700045", "202100300",
            "202300322", "202000299", "198600029", "199400080", "202200307", "201400180", "201400185", "200300038",
            "199100050", "200000039", "201900293", "201400178", "202400339", "201900285", "201400184", "202300335",
            "201400177", "200200059", "201400182", "202400337", "201400240", "201900280", "201700271", "199000006",
            "201400181", "201800276", "198100040", "201900282", "199200016", "201700273", "199800018", "201900292",
            "202300323", "199900085", "201400222", "202300329", "201900289", "202100301", "202400341", "201400221",
            "199200075", "199600167", "201900290", "201500253", "201900281", "201400227", "202300331", "201600257",
            "201400200", "201400224", "201400194", "202300317", "201900291", "202400340", "201400210", "201400213",
            "202300320", "199100004", "202300330", "202400338", "201600258", "201800274", "201400242", "201400243",
            "199900026", "201600256", "200300012", "201800279", "201400189", "202200312", "199800063", "201400202",
            "202000300", "202100302", "202300325", "201400225", "201400208", "2014134", "201400219", "202300319",
            "201400199", "202300332", "202100304", "202300333", "201900283", "201000076", "201400176", "201400211",
            "0006", "202200311", "0553", "202200313", "0919", "202400342", "202100306", "201400209", "201400212",
            "202300328", "201700264", "202100307", "202300314", "201800275", "199800169", "202400343", "201600260",
            "201400206", "201400191", "202000305", "201800277", "199800028", "201400207", "201900287", "200200122",
            "202300327", "199700084", "198200071", "199800124", "201400229", "201400193", "201400230", "20110004",
            "201700265", "199500095", "201400244", "200300126", "202200310", "200400141", "202300315", "201400234",
            "201400232", "202200308", "200800144", "201400231", "200400142", "200300125", "199100159", "201900294",
            "199600168", "199300165", "201800278", "201900296", "201900288", "199000152", "201900295", "200800145",
            "201400237", "201400239", "201900284", "2014000238", "1572", "1127", "0005", "0190046"
        ];

        $keyword = Input::get('search');
        $leave_card = LeaveCardView::get();
        $pis = DB::connection('pis')
        ->table('pis.personal_information')
            ->whereIn('personal_information.userid', $ids)
            ->where(function ($q) use ($keyword) {
                $q->where('personal_information.fname', 'like', "%$keyword%")
                    ->orWhere('personal_information.mname', 'like', "%$keyword%")
                    ->orWhere('personal_information.lname', 'like', "%$keyword%")
                    ->orWhere('personal_information.userid', 'like', "%$keyword%");
            })
            ->leftjoin('dohdtr.addtnl_leave', 'addtnl_leave.userid', '=', 'personal_information.userid')
            ->select('personal_information.*', 'addtnl_leave.FL','addtnl_leave.SPL')
            ->orderBy('personal_information.fname', 'asc')
            ->paginate(10);
//
//        return $data = [
//            "pis" => $pis,
//            "leave_card" => $leave_card,
//            "keyword" => $keyword
//        ];

        return View::make('users.leave_credits',[
            "pis" => $pis,
            "leave_card" => $leave_card,
            "keyword" => $keyword
        ]);
    }

    public function move_dates(){
        $route = Input::get('route_no');
        $result = Input::get('result');
        $dates = Input::get('dates');

        $leave = Leave::where('route_no', $route)->first();
        if($leave){
            $applied_dates = LeaveAppliedDates::where('leave_id', $leave->id)->get();
            $hasStatus = $applied_dates->filter(function ($date) {
                    return !empty($date->status);
                })->count() > 0;

            if (!$hasStatus) {
                LeaveAppliedDates::where('leave_id', $leave->id)->delete();
                foreach ($dates as $date){
                    $new_date = new LeaveAppliedDates();
                    $new_date->leave_id = $leave->id;
                    $new_date->startdate = date('Y-m-d', strtotime($date));
                    $new_date->enddate =date('Y-m-d', strtotime($date));
                    $new_date->save();
                }
            }

            foreach ($result as $data){
                $check_leave = LeaveAppliedDates::where('startdate', date('Y-m-d', strtotime($data['from_date'])))->where('leave_id', $leave->id)->first();
                if($check_leave){
//                    return $check_leave;
                    $check_leave->from_date = date('Y-m-d', strtotime($data['move_date']));
                    $check_leave->to_date = date('Y-m-d', strtotime($data['move_date']));
                    $check_leave->status = 2;
                    $check_leave->save();
                }
            }

            $leave_card = LeaveCardView::where('leave_id', $leave->id)->first();
            $selected_dates= LeaveAppliedDates::where('leave_id', $leave->id)->get();
            $date_used = [];
            if($leave_card){
                foreach ($selected_dates as $date){
                    if($date->status == 1){
                        $date_used[] = "<s>" . date('F j, Y', strtotime($date->startdate)) . "</s>";
                    }elseif ($date->status == 2){
                        $date_used[] = "("."<s>" . date('F j, Y', strtotime($date->startdate)) . "</s>".")". " ". date('F j, Y', strtotime($date->from_date));
                    }else{
                        if($date->startdate == $date->enddate){
                            $date_used[] = date('F j, Y', strtotime($date->startdate));
                        }else{
                            $date_used[] = date('F j, Y', strtotime($date->startdate)) .'-'.  date('F j, Y', strtotime($date->enddate));
                        }
                    }
                }
                $leave_card->date_used = str_replace(['[', ']', '"'], '',json_encode($date_used));
                $leave_card->save();
            }
            return "success";
        }else{
            return "error";
        }
    }
    public function remarks(){
        $route = Input::get('route_remarks');
        $leave = Leave::where('route_no', $route)->first();
        $dis_dates = explode(',', Input::get('dis_dates'));

        if(in_array("disapproved_all", $dis_dates)){
        }else{
            $dates = explode(',', Input::get('dates_remarks'));
            if($leave->status == 0){
                $applied = LeaveAppliedDates::where('leave_id', $leave->id)->get();
                $applied->deleteAll();
                foreach ($dates as $date){
                    $app = new LeaveAppliedDates();
                    $app->leave_id = $leave->id;
                    $app->startdate = date('Y-m-d', strtotime($date));
                    $app->enddate = date('Y-m-d', strtotime($date));
                    if(in_array($date, $dis_dates)){
                        $app->status = 3;
                        $app->remarks = Input::get('remarks');
                    }
                    $app->save();
                }
            }else{
                foreach ($dates as $date){
                    $select = LeaveAppliedDates::where('leave_id', $leave->id)->whereDate('startdate', $date)->first();
                    $select->status = 3;
                    $select->remarks = Input::get('remarks');
                    $select->save();
                }
            }
        }
        $leave->status = 3;
        $leave->save();
//        return $leave;

        return Redirect::back();
    }

    public function updateLeaveBalance(){
        $userid = Input::get('userid');
        $vacation = Input::get('vacation');
        $sick = Input::get('sick');

        InformationPersonal::where('userid',$userid)->update([
            "vacation_balance" => $vacation,
            "sick_balance" => $sick
        ]);

        Session::put('update_leave_balance',true);
        return Redirect::back();
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

    public function generateFlagAttendance() {

            $daterange= Input::get('flag_attendance_date');
            $date = explode('-', $daterange);
            $start_date = date('Y-m-d', strtotime($date[0]));
            $end_date = date('Y-m-d', strtotime($date[1]));
            $dtr_files = EditedLogs::select(
                DB::raw("concat(coalesce(personal_information.fname,''),' ',coalesce(personal_information.mname,''),' ',coalesce(personal_information.lname,'')) as name"),
                "personal_information.userid",
                "personal_information.job_status",
                "edited_logs.datein",
                "edited_logs.time",
                "edited_logs.remark",
                DB::raw("coalesce(edited_logs.log_image,'wew') as log_image")
            )
                ->where(function($query) {
                    $query->where("edited", 8)
                        ->orWhere("edited", 9);
                })
                ->whereBetween('edited_logs.datein',[$start_date, $end_date])
                ->join("pis.personal_information", "personal_information.userid", "=", "edited_logs.userid")
                ->orderBy("datein", "asc")
                ->get();

            header("Content-Type: application/xls");
            header("Content-Disposition: attachment; filename=flags_attendance.xls");
            header("Pragma: no-cache");
            header("Expires: 0");
            $title = 'Flags Attendance';
            $table_body = "<tr>
                    <th></th>
                    <th>Employee Id</th>
                    <th>Employee Name</th>
                    <th>Employee Status</th>
                    <th>Date-In</th>
                    <th>Time</th>
                    <th>Remark</th>
                    <th>Log Image</th>
                </tr>";

            $count = 0;
            $facility = [];

            foreach($dtr_files as $row) {
                $userid = "#".$row->userid;
                $log_image = asset('public/logs_imageV2').'/'.$row->userid.'/'.'flag/'.$row->log_image;
                $log_image = '<img class="profile-user-img img-responsive " src="'.$log_image.'" alt="User profile picture">';
                $table_body .= "<tr>
                    <td style='height:130px;'></td>
                    <td style='height:130px;'>$userid</td>
                    <td style='height:130px;'>$row->name</td>
                    <td style='height:130px;'>$row->job_status</td>
                    <td style='height:130px;'>$row->datein</td>
                    <td style='height:130px;'>$row->time</td>
                    <td style='height:130px;'>$row->remark</td>
                    <td style='height:130px;'>$log_image</td>
                </tr>";
            }

            $display =
                '<h1>'.$title.'</h1>'.
                '<table cellspacing="1" cellpadding="5" border="1">'.$table_body.'</table>';

            return $display;
    }

    public function generateCCTVLogs()
    {
        ini_set('memory_limit', '-1');

        $daterange = Input::get('cctv_logs_date');
        $date = explode('-', $daterange);
        $start_date = date('Y-m-d', strtotime($date[0]));
        $end_date = date('Y-m-d', strtotime($date[1]));

        if (date('Y', strtotime($date[0])) == date('Y', strtotime($date[1]))) {
            if (date('m', strtotime($date[0])) == date('m', strtotime($date[1]))) {
                $display_date = date('F j', strtotime($date[0])) . " - " . date('j, Y', strtotime($date[1]));
            } else {
                $display_date = date('F j', strtotime($date[0])) . " - " . date('F j, Y', strtotime($date[1]));
            }
        } else {
            $display_date = $daterange;
        }

        $final = [];

        EditedLogs::select(
            DB::raw("concat(coalesce(personal_information.fname,''),' ',coalesce(personal_information.mname,''),' ',coalesce(personal_information.lname,'')) as name"),
            "personal_information.userid",
            "personal_information.position",
            "personal_information.section_id",
            "personal_information.job_status",
            "edited_logs.datein",
            "edited_logs.time",
            "edited_logs.remark",
            "users.region"
        )
            ->join("pis.personal_information", "personal_information.userid", "=", "edited_logs.userid")
            ->join("dohdtr.users as users", "users.userid", "=", "edited_logs.userid")
            ->where('users.region', "region_7")
            ->where('personal_information.userid',"!=", "3883")
            ->where(function ($query) {
                $query->whereNull('personal_information.position')
                    ->orWhere('personal_information.position', 'not like', '%Development Management Officer%')
                    ->orWhere('personal_information.userid', '=', '20110004');
            })
            ->where('field_status', "Office Personnel")
            ->where('datein', "!=", "2025-04-16")
            ->whereNotIn('section_id', [31, 48, 49, 50])
            ->where('personal_information.userid', '!=', "199400078")
            ->where("edited", 1)
            ->whereBetween("edited_logs.datein", [$start_date, $end_date])
            ->whereRaw("DAYOFWEEK(edited_logs.datein) NOT IN (1,7)")
            ->where(function ($query) {
                $query->where(function ($q) {
                    $q->where("edited_logs.event", "IN")
                        ->where("edited_logs.time", "<=", "10:00:00");
                })->orWhere(function ($q) {
                    $q->where("edited_logs.event", "OUT")
                        ->where("edited_logs.time", ">=", "15:00:00");
                });
            })
            ->chunk(500, function ($chunkedLogs) use (&$final) {
                foreach ($chunkedLogs as $log) {
                    $name = $log->name ?? 'Unknown Name';
                    $datein = $log->datein ?? 'Unknown Date';

                    if (!isset($final[$name])) {
                        $final[$name] = [];
                    }

                    if (!isset($final[$name][$datein])) {
                        $final[$name][$datein] = [];
                    }

                    $log->total_count = count($final[$name][$datein]) + 1;
                    $final[$name][$datein][] = $log;
                }
            });


        $userid_total_count = [];

        foreach ($final as $name => $dateGroup) {
            $userid_total_count[$name] = array_sum(array_map('count', $dateGroup));
        }

        uksort($final, function ($a, $b) use ($userid_total_count) {
            return $userid_total_count[$b] - $userid_total_count[$a];
        });

        foreach ($final as $name => $dateGroup) {
            ksort($dateGroup); // Sort by datein keys
            $final[$name] = $dateGroup;
        }

//        return $final;

        $display = View::make("pdf.cctv_logs", [
            'groupedLogs' => $final,
            'date' => $display_date
        ])->render();

        $pdf = App::make('dompdf');
        $pdf->loadHTML($display);
        return $pdf->stream();
    }


    public function get_balance($userid){
        $balance = InformationPersonal::where('userid', $userid)->first();
        return $balance;
    }

    public function update_balance(){
        $userid = Input::get('userid_bal');
        $vl = Input::get('vacation');
        $sl = Input::get('sick');
        $fl = Input::get('fl');
        $spl = Input::get('spl');
        $pis = InformationPersonal::where('userid', $userid)->first();
        $pis->vacation_balance = $vl;
        $pis->sick_balance = $sl;
        $pis->save();
        $add_leave = AditionalLeave::where('userid', $userid)->first();
        if($add_leave){
            $add_leave->FL = $fl;
            $add_leave->SPL = $spl;
            $add_leave->save();
            return Redirect::back()->with('update_leave_balance', "Leave data is not found!");
        }

        return Redirect::back()->with('update_leave_balance', "Successfully updated leave balances!");
    }

    public function update_absence(){

        $action = Input::get('action');
        $id = Input::get('card_id');
        $date = Input::get('month_date');
        $leave_card = LeaveCardView::where('id', $id)->first();
        $before_card = LeaveCardView::where('id', '<', $id)->where('userid', $leave_card->userid)->first();

        $all_card = LeaveCardView::where('id', '>', $id)->where('userid','=', $leave_card->userid)->get();

        $new_days = Input::get('absence');
        $pis = InformationPersonal::where('userid', $leave_card->userid)->first();
        if($action == 'update_1'){
            preg_match('/[=-]\s*([\d.]+)/', $leave_card->particulars, $matches);
            $deduction = isset($matches[1]) ? floatval($matches[1]) : 0;

            if($new_days > 60){
                $cal = $new_days/60;
                $base = floor($cal);
                $rem = $new_days - ($base * 60);
                $new_deduction = round($base * 0.125, 3) + round($rem * 0.00208, 3);
            }else{
                $new_deduction = round(($new_days * 0.00208),3);
            }
//            return $all_card;
            foreach ($all_card as $data){
                $data->vl_bal = ($data->vl_bal != null)? $data->vl_bal + $deduction - $new_deduction : null;
                $data->sl_bal = ($data->sl_bal != null)? $data->sl_bal + $deduction - $new_deduction : null;
                $data->save();
            }

            $pis->vacation_balance = $pis->vacation_balance + $deduction - $new_deduction;
            $pis->sick_balance = $pis->sick_balance + $deduction - $new_deduction;
            $pis->save();
            $date = explode('-', $date);
            $date_from = date('Y-m-d', strtotime($date[0]));
            $date_to = date('Y-m-d', strtotime($date[1]));
            $display_date = date('F', strtotime($date_from)) . " 1-" .  date('d', strtotime($date_to)) . ", ". date('Y', strtotime($date_to));
            $leave_card->date_used = $display_date;
            $leave_card->vl_bal = $leave_card->vl_bal + $deduction - $new_deduction;
            $leave_card->sl_bal = $leave_card->sl_bal + $deduction - $new_deduction;
            $leave_card->particulars = "UT (".$new_days." min(s). - ". $new_deduction.")";
            $leave_card->status = 1;
            $leave_card->save();
        }else{
            $old_days = $leave_card->vl_earned;
            if($action == 'update'){
                $leave_card->particulars = $new_days == 0? 'No Absences' : 'No. of Absences ('.$new_days.')';
                $credit_earned = $new_days == 0? 1.25 : 1.25 - round($new_days * 0.04167, 3);
                $leave_card->vl_earned = $credit_earned;
                $leave_card->sl_earned = $credit_earned;
                $leave_card->vl_bal = $leave_card->vl_bal - $old_days + $credit_earned;
                $leave_card->sl_bal = $leave_card->sl_bal - $old_days + $credit_earned;
                $leave_card->save();
                foreach ($all_card as $row){
                    $row->vl_bal = ($row->vl_bal != null)?$row->vl_bal - $old_days + $credit_earned :'';
                    $row->sl_bal = ($row->vl_bal != null)?$row->sl_bal - $old_days + $credit_earned:'';
                    $row->save();
                }

                $pis->vacation_balance = $pis->vacation_balance - $old_days + $credit_earned;;
                $pis->sick_balance = $pis->sick_balance - $old_days + $credit_earned;;
                $pis->save();

            }
        }

        return Redirect::back();

    }

    public function get_leave_view($id){
        $info = InformationPersonal::where('userid', $id)->first();
        $division = Division::where('id', '=', $info->division_id)->select('description')->first();
        $section = Section::where('id', '=', $info->section_id)->select('description')->first();

        $perPage = 15;
        $totalRecords = LeaveCardView::where('userid', $id)->count();
        $lastPage = ceil($totalRecords / $perPage);

        if (!Input::has('page')) {
            return Redirect::to(Request::url() . '?page=' . $lastPage);
        }

        $card_details = LeaveCardView::where('userid', $id)
            ->paginate($perPage);

        return View::make('form.leave_card',[
            'division' => $section->description.'/'.$division->description,
            'card_details' => $card_details,
            'user' => $info->lname .', '. $info->fname.' '. $info->mname,
            'etd' => $info->entrance_of_duty ? date('F j, Y', strtotime($info->entrance_of_duty)) : "Data not available (please update PIS)",
            'id' => $id
        ]);
    }

    public function moveLeave($route_no){
        $leave = Leave::where('route_no', $route_no)->first();
        if($leave){
            $applied_dates = LeaveAppliedDates::where('leave_id', $leave->id)->whereNotIn('status', [1])->get();
            return Response::json($applied_dates);
        }
    }

}