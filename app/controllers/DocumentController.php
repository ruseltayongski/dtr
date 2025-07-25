<?php
/**
 * Created by PhpStorm.
 * User: Lourence
 * Date: 1/23/2017
 * Time: 9:41 AM
 */

class DocumentController extends BaseController
{
    public function __construct()
    {

        //$this->beforeFilter('personal');
    }

    public  function leave(){
//        return 'leave';
//       return "not yet ready";
        if(Request::method() == 'GET'){
            $user = InformationPersonal::select("personal_information.lname","personal_information.fname","personal_information.mname","designation.description as designation","work_experience.monthly_salary",
                "personal_information.vacation_balance", "personal_information.sick_balance")
                ->leftJoin("dts.designation","designation.id","=","personal_information.designation_id")
                ->leftJoin('pis.work_experience','work_experience.userid','=','personal_information.userid')
                ->where('pis.work_experience.date_to','=','Present')
                ->where('personal_information.userid','=',Auth::user()->userid)
                ->groupBy('work_experience.userid')
                ->first();
            $leave_type = LeaveTypes::get();
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
                if($row['ppmp_used'] == null){
                    $division_head[] = pdoController::user_search1($row['head']);
                }
            }

            return View::make('form.form_leave',[
                "user" => $user,
                "leave_type" => $leave_type,
                "spl" => $spl,
                "officer" =>  $section_head
            ]);
        }
        if(Request::method() == 'POST') {
            if(Auth::check() AND Auth::user()->usertype == 0){
                if(Auth::user()->pass_change == NULL){
                    return Redirect::to('resetpass')->with('pass_change','You must change your password for security after your first log in or resseting password');
                }
            }
            $pis = InformationPersonal::where ('userid', Auth::user()->userid)->first();
            $route_no = date('Y-') . Auth::user()->userid . date('mdHis');
            $l_type = Input::get('leave_type');

            $leave = new Leave();

            $leave->userid = Auth::user()->userid;
            $leave->route_no = $route_no;
            $leave->office_agency = Input::get('office_agency');
            $leave->lastname = Input::get('lastname');
            $leave->firstname = Input::get('firstname');
            $leave->middlename = Input::get('middlename');
            $leave->date_filling = Input::get('date_filling');
            $leave->position = Input::get('position');
            $leave->salary = Input::get('salary');
            $leave->leave_type = Input::get('leave_type');
            $leave->leave_details = (Input::get('leave_details') != null)?Input::get('leave_details'):'None' ;
            $leave->leave_specify = (Input::get('for_text_input') != null)?Input::get('for_text_input'):'None' ;
            $leave->credit_used = (Input::get('leave_type') != null)?Input::get('leave_type'):'None' ;
            $leave->status = 0;
            $leave->remarks = 0;
            $leave->commutation = Input::get('com_requested');
            $leave->with_pay = (Input::get('with_pay') != null)?(int) filter_var(Input::get('with_pay'), FILTER_SANITIZE_NUMBER_INT):0;
            $leave->without_pay = (Input::get('without_pay') != null)?(int) filter_var(Input::get('without_pay'), FILTER_SANITIZE_NUMBER_INT):0;
            $leave->applied_num_days = Input::get('applied_num_days');
            $leave->as_of = date('Y-m-d',strtotime(Input::get('as_of')));
            $leave->vacation_total = $pis->vacation_balance ? $pis->vacation_balance:0;
            $leave->sick_total = $pis->sick_balance ? $pis->sick_balance : 0;

            $spl_leave = AditionalLeave::where('userid', Auth::user()->userid)->first();

            if($l_type == "SPL"){
                $leave->SPL_total = $spl_leave->SPL - Input::get('applied_num_days');
            }else if($l_type == "FL"){
                $leave->FL_total = $spl_leave->FL - Input::get('applied_num_days');
            }

            if(Input::get('com_requested') == 2){
                $inclusive_dates = $_POST['inclusive_dates1'];
                $last_date = end($inclusive_dates);
                $last_date = array_slice($inclusive_dates, -1)[0];
                $temp1 = explode('-',$last_date);
                $date_from = date('Y-m-d',strtotime($temp1[0]));
                $date_to = date('Y-m-d',strtotime($temp1[1]));
                $leave->inc_from = $date_from;
                $leave->inc_to = $date_to;
            }

            $leave->for_others = Input :: get('others_type');
            $leave->officer_1 = Input::get('certification_officer');
            $leave->officer_2 = Input::get('recommendation_officer');
            $leave->officer_3 = Input::get('approved_officer');
            $leave->vl_deduct = Input::get('vl_less');
            $leave->sl_deduct = Input::get('sl_less');
            $leave->save();


            if(Input::get('com_requested') == 2){

                foreach ($inclusive_dates as $index => $date_range) {

                    $temp = explode('-', $date_range);
                    $start_date = date('Y-m-d', strtotime($temp[0]));
                    $end_date = date('Y-m-d', strtotime($temp[1]));

                    $leave_applied_dates = new LeaveAppliedDates();
                    $leave_applied_dates->leave_id = $leave->id;
                    $leave_applied_dates->startdate = $start_date;
                    $leave_applied_dates->enddate = $end_date;

                    $leave_applied_dates->save();
                }
            }

            if($leave->leave_type == "SL"){
                $rem_dates = $_POST['s_dates'];
                $remarks = $_POST['date_remarks'];
                foreach ($rem_dates as $index => $date){
                    $sl = new SLRemarks();
                    $sl->date = date('Y-m-d', strtotime($date));
                    $sl->remarks = $remarks[$index];
                    $sl->leave_id = $leave->id;
                    $sl->save();
                }
            }


            $doc_type = 'APP_LEAVE';
            $prepared_date = date('Y-m-d',strtotime(date('Y-m-d'))).' '.date('H:i:s');
            $dts_user = DB::connection('dts')->select("SELECT id FROM users WHERE username = ? LIMIT 1",array(Auth::user()->userid));

            $prepared_by = $dts_user[0]->id;
            $description = "Application for leave";

            //ADD TRACKING DETAILS
            $date_in = $prepared_date;
            $received_by = $prepared_by;
            $delivered_by = $prepared_by;
            $action = $description;

            $data = array($route_no,$doc_type,$prepared_date,$prepared_by,$description);
            DB::connection('dts')->insert("INSERT INTO TRACKING_MASTER(route_no,doc_type,prepared_date,prepared_by,description,created_at,updated_at) values(?,?,?,?,?,now(),now())",$data);
            $tracking_master = Tracking_Master::where('route_no', $route_no)->first();
            $route_no = date('Y-').$tracking_master->id;
            $leave->route_no = $route_no;
            $leave->save();
            $tracking_master->route_no = $route_no;
            $tracking_master->save();


            $data = array($route_no,$date_in,$received_by,$delivered_by,$action);
            $sql="INSERT INTO TRACKING_DETAILS(route_no,date_in,received_by,delivered_by,action,created_at,updated_at) values(?,?,?,?,?,now(),now())";
            DB::connection('dts')->insert($sql,$data);

            $user_id = $prepared_by;
            $name = Auth::user()->fname.' '.Auth::user()->mname.' '.Auth::user()->lname;
            $activity = 'CREATED';

            $data = array($user_id,$name,$activity,$route_no);
            $sql="INSERT INTO SYSTEMLOGS(user_id,name,activity,description,created_at,updated_at) values(?,?,?,?,now(),now())";
            DB::connection('dts')->insert($sql,$data);

            Session::put('added',true);

            return Redirect::to('form/leave/all')->with('message','New application for leave created.');
        }
    }

    public function save_edit_leave()
    {
//        return 1;
//        return (Input::get('leave_type') != null)?Input::get('leave_type'):'None' ;
        $leave = Leave::where('id', Input::get('id'))->first();
//        return Input::get('id');
//        return (int) filter_var(Input::get('with_pay');
        if($leave){
            $pis = InformationPersonal::where('userid', $leave->userid)->first();
            $l_type = Input::get('leave_type');
            $leave->userid = Auth::user()->userid;
            $leave->office_agency = Input::get('office_agency');
            $leave->lastname = Input::get('lastname');
            $leave->firstname = Input::get('firstname');
            $leave->middlename = Input::get('middlename');
            $leave->date_filling = Input::get('date_filling');
            $leave->position = Input::get('position');
            $leave->salary = Input::get('salary');
            $leave->leave_type = Input::get('leave_type');
            $leave->leave_details = (Input::get('leave_details') != null)?Input::get('leave_details'):'None' ;
            $leave->leave_specify = (Input::get('for_text_input') != null)?Input::get('for_text_input'):'None' ;
            $leave->credit_used = (Input::get('leave_type') != null)?Input::get('leave_type'):'None' ;
            $leave->status = 0;
            $leave->remarks = 0;
            $leave->commutation = Input::get('com_requested');
            $leave->with_pay = (Input::get('with_pay') != null)?(int) filter_var(Input::get('with_pay'), FILTER_SANITIZE_NUMBER_INT):0;
            $leave->without_pay = (Input::get('without_pay') != null)?(int) filter_var(Input::get('without_pay'), FILTER_SANITIZE_NUMBER_INT):0;
            $leave->applied_num_days = Input::get('applied_num_days');
            $leave->as_of = date('Y-m-d', strtotime(Input::get('as_of')));
            $leave->vacation_total = $pis->vacation_balance;
            $leave->sick_total = $pis->sick_balance;

            $spl_leave = AditionalLeave::where('userid', Auth::user()->userid)->first();

            if($l_type == "SPL"){
                $leave->SPL_total = $spl_leave->SPL - Input::get('applied_num_days');
            }else if($l_type == "FL"){
                $leave->FL_total = $spl_leave->FL - Input::get('applied_num_days');
            }

            if(Input::get('com_requested') == 2){
                $inclusive_dates = $_POST['inclusive_dates1'];
                $last_date = end($inclusive_dates);
                $last_date = array_slice($inclusive_dates, -1)[0];
                $temp1 = explode('-',$last_date);
                $date_from = date('Y-m-d',strtotime($temp1[0]));
                $date_to = date('Y-m-d',strtotime($temp1[1]));
                $leave->inc_from = $date_from;
                $leave->inc_to = $date_to;
            }

            $leave->for_others = Input :: get('others_type');
            $leave->officer_1 = Input::get('certification_officer');
            $leave->officer_2 = Input::get('recommendation_officer');
            $leave->officer_3 = Input::get('approved_officer');
            $leave->vl_deduct = Input::get('vl_less');
            $leave->sl_deduct = Input::get('sl_less');
            $leave->save();

            if(Input::get('com_requested') == 2){

                LeaveAppliedDates::where('leave_id', $leave->id)->delete();

                foreach ($inclusive_dates as $index => $date_range) {

                    $temp = explode('-', $date_range);
                    $start_date = date('Y-m-d', strtotime($temp[0]));
                    $end_date = date('Y-m-d', strtotime($temp[1]));

                    $leave_applied_dates = new LeaveAppliedDates();
                    $leave_applied_dates->leave_id = $leave->id;
                    $leave_applied_dates->startdate = $start_date;
                    $leave_applied_dates->enddate = $end_date;

                    $leave_applied_dates->save();
                }
            }


            if($leave->leave_type == "SL" && isset($_POST['s_dates'])){
                SLRemarks::where('leave_id', $leave->id)->delete();

                $rem_dates = $_POST['s_dates'];
                $remarks = $_POST['date_remarks'];

                foreach ($rem_dates as $index => $date){
                    $sl = new SLRemarks();
                    $sl->date = date('Y-m-d', strtotime($date));
                    $sl->remarks = $remarks[$index];
                    $sl->leave_id = $leave->id;
                    $sl->save();
                }
            }

            return Redirect::to('form/leave/all')->with('message','Application for leave updated.');
        }else{
            return Redirect::to('form/leave/all')->with('message','Leave document does not exist.');
        }
    }

    public function all_leave()
    {
//        return 'all leave';
        if(Auth::user()->userid != "0190046" and Auth::user()->userid != "198600029" ){
            return "still under development";
        }
        // return "still under development";

        $userid = Auth::user()->userid;
        $pis = InformationPersonal::where("userid","=",$userid)->first();
        $division = Division::where('id', $pis->division_id)->first();
        $section = Section::where('id', '=', $pis->section_id)->select('description')->first();

        $designation = Designation:: where('id', $pis->designation_id)->first();
        $leave_card = LeaveCardView::where('userid', $userid)->get();
        $leave = AditionalLeave::where('userid', $userid)->first();

        if(Request::method() == 'POST'){//        return $division; // track designation

            $filter_range = explode(" - ",Input::get("filter_range"));
            $date_start = date("Y-m-d",strtotime($filter_range[0]));
            $date_end = date("Y-m-d",strtotime($filter_range[1]));

            $leaves = Leave::where('userid', $userid)
                ->whereBetween("date_filling",[$date_start,$date_end])
                ->orderBy("created_at","desc")
                ->paginate(20);
        } else {

            $leaves = Leave::where('userid','=', $userid)
                ->orderBy("created_at","desc")
                ->paginate(20);
        }

        Session::put("vacation_balance",$pis->vacation_balance);
        Session::put("sick_balance",$pis->sick_balance);

        return View::make('form.list_leave',[
            "pis" => $pis,
            "etd" => $pis->entrance_of_duty ? date('F j, Y', strtotime($pis->entrance_of_duty)) : "No Data Available (please update PIS)",
            "leaves" => $leaves,
            "leave" => $leave,
            "division" => $division,
            "designation" => $designation,
            "leave_card" => $leave_card,
            "filter_range" => Input::get("filter_range"),
            'section_division' => $section->description.'/'.$division->description,

        ]);
    }

    public function get_leave($id)
    {
        $leave = Leave::
                    select('leave.*','personal_information.vacation_balance','personal_information.sick_balance')
                    ->where('leave.id','=',$id)
                    ->leftJoin('pis.personal_information','personal_information.userid','=','leave.userid')
                    ->with('sl_remarks')
                    ->first();
        $leaveTypes = LeaveTypes::get();
        $leave_dates = LeaveAppliedDates::where('leave_id', $id)->where('status', '!=', 1)->get();
        $user = InformationPersonal::where('userid', $leave->userid)->first();
        $id_list = [];
        $manually_added = [985329, 273, 11, 93053, 986445, 984538, 985950, 80, 976017, 466];
        $spl = AditionalLeave::where('userid', Auth::user()->userid)->first();

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


        $dates = [];
        $length = count($leave_dates);
        $check=[];

        if ($length > 0) {
            $start = ($leave_dates[0]['status'] != 2)?$leave_dates[0]['startdate']: $leave_dates[0]['from_date'];
            $initial_date = ($leave_dates[0]['status'] != 2)?$leave_dates[0]['startdate']: $leave_dates[0]['from_date'];

            foreach ($leave_dates as $index => $date) {
                $start_date = ($date['status'] != 2)?$date['startdate']:$date['from_date'];
                $end_date = ($date['status'] != 2)?$date['enddate']:$date['to_date'];

                if ($start_date == $end_date) {
                    if ($index + 1 != $length) {
                        $current_date = new DateTime($initial_date);
                        $next_date = ($leave_dates[$index + 1]['status'] != 2)? new DateTime($leave_dates[$index + 1]['startdate']) : new DateTime($leave_dates[$index + 1]['from_date']);
                        $diff = $next_date->diff($current_date)->days;

                        if ($diff == 1) {
                            $start_date = $current_date->format('Y-m-d');
                            $end_date = $next_date->format('Y-m-d');
                            $initial_date = ($date['status'] != 2)?$leave_dates[$index + 1]['startdate'] :$leave_dates[$index + 1]['from_date'];
                            $check[] = 'check1 '.$diff. $start_date .$end_date;
                        } else {
                            $dates[] = $start . ' - ' . $end_date;
                            $start = ($leave_dates[$index + 1]['status'] != 2)?$leave_dates[$index + 1]['startdate'] :$leave_dates[$index + 1]['from_date'];
                            $initial_date = ($leave_dates[$index + 1]['status'] != 2)?$leave_dates[$index + 1]['startdate'] :$leave_dates[$index + 1]['from_date'];
                            $check[] = 'check2 '.$diff . $start. $initial_date.'---'.$date['status'];

                        }
                    } else {
                        $dates[] = $start . ' - ' . $end_date;
                    }
                } else {
                    $dates[] = $start_date . ' - ' . $end_date;
                }
            }
        }
        return View::make('form.leave')->with([
            'leave' => $leave,
            'leave_type' => $leaveTypes,
            'leave_dates'=>$leave_dates,
            'date_list' => $dates,
            'officer' => $section_head,
            'user' => $user,
            'spl' => $spl
            ]);

//        $leave = Leave::select('leave.*', 'personal_information.vacation_balance', 'personal_information.sick_balance')
//            ->where('leave.id', '=', $id)
//            ->leftJoin('pis.personal_information', 'personal_information.userid', '=', 'leave.userid')
//            ->first();
//
//        $leaveTypes = LeaveTypes::get();

    }
    //    public function leave_pdf(){
////        return 1;
//        $leave = Leave::where('route_no','2023-1986000291123103915')->first();
////            return $leave;
//
//        $display = View::make('form.leave_pdf', ["leave" => $leave]);
//        $pdf = App::make('dompdf');
//        $pdf->loadHTML($display)->setPaper('a4', 'portrait');
//        return $pdf->stream();
//    }

    public function leave_print($route_no)
    {

        $leave = InformationPersonal::join('dohdtr.leave', 'personal_information.userid', '=', 'leave.userid')
            ->where('leave.route_no', '=', $route_no)->first();
        $leaveTypes = LeaveTypes::get();
        $leave_dates = LeaveAppliedDates::where('leave_id','=', $leave->id)->get();
//        return $leave->id;
        $display = View::make('form.leave_pdf', ["leave" => $leave, "leaveTypes"=>$leaveTypes, "leave_dates"=>$leave_dates]);
        $pdf = App::make('dompdf');
        $pdf->loadHTML($display)->setPaper('a4', 'portrait');
        return $pdf->stream();
    }

    public function print_leave($id)
    {
        $leave = Leave::find($id);
        $display = View::make('form.print_leave_pdf')->with('leave', $leave);
        return PDF::load($display, 'LEGAL', 'portrait')->show();
    }

    public function print_a($id)
    {
        $leave = Leave::find($id);
        $display = View::make('pdf.test_pdf')->with('leave', $leave);
        return PDF::load($display, 'LEGAL', 'portrait')->show();
    }
    public function list_print()
    {
        $display = View::make('pdf.personal_dtr');
        $pdf = App::make('dompdf.wrapper');
        $pdf->setPaper('A4', 'portrait');
        $pdf->loadHTML($display);
        return $pdf->stream();
    }

    //RUSEL
    //OFFICE ORDER
    public function so_delete()
    {
      	$route_no = Session::get('route_no');
       	$prepared_by = pdoController::user_search1( OfficeOrders::where('route_no',$route_no)->first()->prepared_by )['id'];

        $inclusiveName = InclusiveNames::where('route_no',$route_no)->get();

        foreach ( $inclusiveName as $inName ) {
            $calendar = Calendars::where('route_no',$route_no)->get();
            foreach ( $calendar as $cal )
            {
                // delete so logs
                 SoLogs::where('userid','=',$inName->userid)->where('holiday','003')
                    ->whereBetween('datein',array($cal->start,$cal->end))->delete();
            }
        }
        pdoController::delete_tracking_master($route_no);
        pdoController::delete_tracking_details($route_no);
        //$this->delete_tracking_release($route_no);

        //delete office_order/calendar and inclusive name
        OfficeOrders::where('route_no',$route_no)->delete();
        Calendars::where('route_no',$route_no)->delete();
        InclusiveNames::where('route_no',$route_no)->delete();

        //ADD SYSTEM LOGS
        $user_id = $prepared_by;
        $name = Auth::user()->fname.' '.Auth::user()->mname.' '.Auth::user()->lname;
        $activity = 'Deleted';
        pdoController::insert_system_logs($user_id,$name,$activity,$route_no);
        Session::put('deleted',true);

        return Redirect::to('form/so_list');
    }

    public function so_view()
    {
        if(Request::method() == 'GET'){
            $users = pdoController::users();
            $office_order = OfficeOrders::where('route_no',Session::get('route_no'))->get()->first();
            $inclusive_date = Calendars::where('route_no',Session::get('route_no'))->get();
            return View::make('form.office_order_view',['users'=>$users,'office_order'=>$office_order,'inclusive_date'=>$inclusive_date]);
        }
        if(Request::method() == 'POST'){
            return Input::all();
        }
    }

    public function so_pdf()
    {
        $users = pdoController::users();
        $office_order = OfficeOrders::where('route_no',Session::get('route_no'))->first();
        $inclusive_dates = Calendars::where('route_no',Session::get('route_no'))->get();

        $name = InclusiveNames::where('inclusive_name.route_no',Session::get('route_no'))
                            ->join('pis.personal_information','personal_information.userid','=','inclusive_name.userid')
                            ->join('pis.work_experience','work_experience.userid','=','inclusive_name.userid')
                            ->where('pis.work_experience.date_to','=','Present')
                            ->groupBy('work_experience.userid')
                            ->orderBy('work_experience.monthly_salary','desc')
                            ->get(); // THE NULL WORK EXPERIENCE WILL NOT DISPLAY THE NAME

        $display = View::make('form.office_order_pdf',[
                                        'users'=>$users,
                                        'office_order'=>$office_order,
                                        'inclusive_dates'=>$inclusive_dates,
                                        'name'=>$name,
                                        'division'=>pdoController::division()
                                    ]);

        $pdf = App::make('dompdf');
        $pdf->loadHTML($display)->setPaper('a4','portrait');

        if(Session::get('route_no'))
            return $pdf->stream();
        else
            return redirect('/');
    }

    public function inclusive_name(){
        $inclusive_name = InclusiveNames::where('route_no',Session::get('route_no'))->get();
        foreach($inclusive_name as $row){
            $name[] = $row['user_id'];
        }
        return $name;
    }

    public function so_list(){
        $str = Input::get('filter_range');
        $temp1 = explode('-',$str);
        $temp2 = array_slice($temp1, 0, 1);
        $tmp = implode(',', $temp2);
        $startdate = date('Y-m-d H:i:s',strtotime($tmp));

        $temp3 = array_slice($temp1, 1, 1);
        $tmp = implode(',', $temp3);
        $enddate = date('Y-m-d H:i:s',strtotime($tmp));

        Session::put('keyword',Input::get('keyword'));
        $keyword = Session::get('keyword');
        if(Auth::user()->usertype == 1 || Auth::user()->usertype == 3 || Auth::user()->usertype == 5){
            $office_order = OfficeOrders::where(function($q) use ($keyword){
                    $q->where('route_no','like',"%$keyword%")
                        ->orwhere('subject','like',"%$keyword%");
                })
                ->orderBy('id','desc')
                ->paginate(10);
        } else {
            $office_order = OfficeOrders::where('prepared_by',Auth::user()->userid)
                ->where(function($q) use ($keyword){
                    $q->where('route_no','like',"%$keyword%")
                        ->orwhere('subject','like',"%$keyword%");
                })
                ->orderBy('id','desc')
                ->paginate(10);
        }

        return View::make('form.office_order_list',[
                            'office_order' => $office_order
                        ]);
    }

    public function sov1()
    {
        $prepared_by = Auth::user()->userid;
        $users = InformationPersonal::get();
        $section = Section::get();
        foreach($users as $row){
            $all_user[] = $row->userid;
        }
        return View::make('form.office_orderv1',[
            'users'=>$users,
            'prepared_by'=>json_encode($prepared_by),
            "all_user" => json_encode($all_user),
            'section' => $section
        ]);
    }

    public function so_append(){
        return View::make('form.office_order_append');
    }

    public function so_add(){

        $route_no = date('Y-') . pdoController::user_search(Auth::user()->userid)['id'] . date('mdHis');
        $doc_type = 'OFFICE_ORDER';
        $prepared_date = date('Y-m-d',strtotime(Input::get('prepared_date')) ).' '.date('H:i:s');
        $prepared_by =  pdoController::user_search(Auth::user()->userid)['id'];
        $description = Input::get('subject');

        //ADD OFFICE ORDER
        $office_order = new OfficeOrders();
        //$office_order->id = DB::table('office_order')->max('id')+1;
        $office_order->route_no = $route_no;
        $office_order->doc_type = $doc_type;
        $office_order->subject = Input::get('subject');
        $office_order->prepared_by = Auth::user()->userid;
        $office_order->prepared_date = $prepared_date;
        $office_order->version = Input::get('version');
        if(Input::get('version') == 2):
            $office_order->header_body = Input::get('header_body');
            $office_order->footer_body = Input::get('footer_body');
            $office_order->approved_by = Input::get('approved_by');
        endif;
        $office_order->approved_status = 0;
        $office_order->driver = Input::get('driver');
        $office_order->save();

        //ADD INCLUSIVE NAME
        $count = 0;
        foreach(Input::get('inclusive_name') as $row){
            $inclusive_name = new inclusiveNames();
            $inclusive_name->route_no = $route_no;
            $inclusive_name->user_id = pdoController::user_search(Input::get('inclusive_name')[$count])['id'];
            $inclusive_name->userid = Input::get('inclusive_name')[$count];
            $inclusive_name->status = 1;
            $inclusive_name->save();
            $count++;
        }

        //ADD CALENDAR
        $count = 0;
        foreach(Input::get('inclusive') as $result)
        {
            $str = $result;
            $temp1 = explode('-',$str);
            $temp2 = array_slice($temp1, 0, 1);
            $tmp = implode(',', $temp2);
            $start_date = date('Y-m-d',strtotime($tmp));

            $temp3 = array_slice($temp1, 1, 1);
            $tmp = implode(',', $temp3);
            $enddate = date_create(date('Y-m-d',strtotime($tmp)));
            //date_add($enddate, date_interval_create_from_date_string('1days'));
            $end_date = date_format($enddate, 'Y-m-d');

            $so = new Calendars();
            $so->route_no = $route_no;
            $so->title = Input::get('subject');
            $so->start = $start_date;
            $so->end = $end_date;
            $so->area = Input::get('area')[$count];
            $so->so_time = Input::get('so_time')[$count];
            $so->backgroundColor = 'rgb(216, 27, 96)';
            $so->borderColor = 'rgb(216, 27, 96)';
            $so->status = 0;
            $so->save();
            $count++;
        }

        //ADD TRACKING MASTER
        $tracking_master = new Tracking_Master();
        $tracking_master->route_no = $route_no;
        $tracking_master->doc_type = $doc_type;
        $tracking_master->prepared_date = $prepared_date;
        $tracking_master->prepared_by = $prepared_by;
        $tracking_master->description = $description;
        $tracking_master->save();

        //ADD TRACKING DETAILS
        $date_in = $prepared_date;
        $received_by = $prepared_by;
        $delivered_by = $prepared_by;
        $action = $description;

        $tracking_details = new Tracking_Details();
        $tracking_details->route_no = $route_no;
        $tracking_details->date_in = $date_in;
        $tracking_details->received_by = $received_by;
        $tracking_details->delivered_by = $delivered_by;
        $tracking_details->action = $action;
        $tracking_details->save();

        //ADD SYSTEM LOGS
        $user_id = $prepared_by;
        $name = Auth::user()->fname.' '.Auth::user()->mname.' '.Auth::user()->lname;
        $activity = 'Created';
        pdoController::insert_system_logs($user_id,$name,$activity,$route_no);
        Session::put('added',true);

        return Redirect::to('form/so_list');
    }

    public function so_update(){
        $route_no = Session::get('route_no');
        $doc_type = 'OFFICE_ORDER';
        $prepared_date = date('Y-m-d',strtotime(Input::get('prepared_date'))).' '.date('H:i:s');
        $prepared_by =  pdoController::user_search(Auth::user()->userid)['id'];
        $description = Input::get('subject');

        $header_body = '';
        $footer_body = '';
        $approved_by = '';
        if(Input::get('version') == 2):
            $header_body = Input::get('header_body');
            $footer_body = Input::get('footer_body');
            $approved_by = Input::get('approved_by');
        endif;
        //update office order
        OfficeOrders::where('route_no',$route_no)
            ->update([
                'prepared_date' => Input::get('prepared_date'),
                'subject' => Input::get('subject'),
                'header_body' => $header_body,
                'footer_body' => $footer_body,
                'approved_by' => $approved_by,
                'version' => Input::get('version'),
                'driver' => Input::get('driver')
            ]);
        //

        //delete
        InclusiveNames::where('route_no',$route_no)->delete();
        //
        //ADD INCLUSIVE NAME
        $count = 0;
        foreach(Input::get('inclusive_name') as $row){
            $inclusive_name = new InclusiveNames();
            $inclusive_name->route_no = $route_no;
            $inclusive_name->user_id = 'null';
            $inclusive_name->userid = Input::get('inclusive_name')[$count];
            $inclusive_name->status = 1;
            $inclusive_name->save();
            $count++;
        }

        //delete
        Calendars::where('route_no',$route_no)->delete();
        //
        //ADD CALENDAR
        $count = 0;
        foreach(Input::get('inclusive') as $result)
        {
            $str = $result;
            $temp1 = explode('-',$str);
            $temp2 = array_slice($temp1, 0, 1);
            $tmp = implode(',', $temp2);
            $start_date = date('Y-m-d',strtotime($tmp));

            $temp3 = array_slice($temp1, 1, 1);
            $tmp = implode(',', $temp3);
            $enddate = date_create(date('Y-m-d',strtotime($tmp)));
            //date_add($enddate, date_interval_create_from_date_string('1days'));
            $end_date = date_format($enddate, 'Y-m-d');

            $so = new Calendars();
            $so->route_no = $route_no;
            $so->title = Input::get('subject');
            $so->start = $start_date;
            $so->end = $end_date;
            $so->area = Input::get('area')[$count];
            $so->so_time = Input::get('so_time')[$count];
            $so->backgroundColor = 'rgb(216, 27, 96)';
            $so->borderColor = 'rgb(216, 27, 96)';
            $so->status = 0;
            $so->save();
            $count++;
        }
        //UPDATE TRACKING MASTER
        pdoController::update_tracking_master($prepared_date,$description,$route_no);
        //UPDATE TRACKING DETAILS
        pdoController::update_tracking_details($description,$route_no);

        //ADD SYSTEM LOGS
        $user_id = $prepared_by;
        $name = Auth::user()->fname.' '.Auth::user()->mname.' '.Auth::user()->lname;
        $activity = 'Updated';
        pdoController::insert_system_logs($user_id,$name,$activity,$route_no);
        Session::put('updated',true);


        return Redirect::back();
    }

    public static function check_calendar()
    {
        return InclusiveNames::where('user_id',Auth::user()->userid)->get();
    }


    public function inclusive_name_view(){
        foreach( inclusiveNames::where('route_no',Session::get('route_no') )->get() as $row){
            $inclusive_name[] = $row->userid;
        }
        return $inclusive_name;
    }

    public function show($route_no,$doc_type=null){
        Session::put('route_no',$route_no);
        if($doc_type == 'office_order'){
            $users = InformationPersonal::get();
            $inclusive_name = array();
            foreach(inclusiveNames::where('route_no',$route_no)->get() as $row){
                $inclusive_name[] = $row->userid;
            }
            foreach($users as $row){
                $all_user[] = $row->userid;
            }
            $info = OfficeOrders::where('route_no',$route_no)->get()->first();
            $inclusive_date = Calendars::where('route_no',$route_no)->get();
            $section = Section::get();
            return View::make('document.info',[
                'users'=>$users,
                'info'=>$info,
                'inclusive_date'=>$inclusive_date,
                'inclusive_name' => json_encode($inclusive_name),
                "all_user" => json_encode($all_user),
                "section" => $section
            ]);
        }
        else {
            $cdo = cdo::where('route_no',$route_no)->first();
            $inclusiveDates = CdoAppliedDate::where('cdo_id', $cdo->id)->get();

            if(Auth::user()->usertype)
                $personal_information = InformationPersonal::where('userid','=',$cdo->prepared_name)->first();
            else
                $personal_information = InformationPersonal::where('userid','=',Auth::user()->userid)->first();

            $position = pdoController::designation_search($personal_information->designation_id)['description'];
            $section = pdoController::search_section($personal_information->section_id)['description'];
            $division = pdoController::search_division($personal_information->division_id)['description'];
            $section_head[] = pdoController::user_search1($cdo['immediate_supervisor']);
            $division_head[] = pdoController::user_search1($cdo['division_chief']);
            $id_list = [];
            $manually_added = [985329, 273, 11, 93053, 986445, 984538, 985950, 80, 976017, 466, 534, 986944, 988121, 357, 988148, 988309, 142, 602];

            foreach(pdoController::section() as $row) {
                if ($row['acronym'] !== null || in_array($row['head'], [37, 72, 243, 614, 110, 163, 648384, 160, 985950, 830744, 51])) {
                    if(!in_array($row['head'], [172, 173, 96, 53, 114, 442, 155, 91, 6, 16, 986774, 51, 231, 160, 119])){
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

            $div = [27];
            foreach ($div as $data){
                $division_head[] = pdoController::user_search1($data);
            }

            $data = array(
                "cdo" => $cdo,
                "type" => "update",
                "asset" => asset('cdo_updatev1'),
                "name" => $personal_information->fname.' '.$personal_information->mname.' '.$personal_information->lname,
                "position" => $position,
                "section" => $section,
                "division" => $division,
                "section_head" => $section_head,
                "division_head" => $division_head,
                "rd" => pdoController::user_search1(988320),
                "bbalance_cto" => $personal_information->bbalance_cto,
                "inclusiveDates"=> $inclusiveDates,
                "server_date" => date('Y-m-d')
            );
//            return $inclusiveDates->cdo_hours;
            return View::make('cdo.cdo_view',['data' => $data]);
        }
    }

    public function track($route_no){
//        return pdoController::search_tracking_details($route_no);
        $document = pdoController::search_tracking_details($route_no);
        Session::put('route_no',$route_no);

        return View::make('document.track',['document' => $document]);
    }


    static function checkMinutes($start_date)
    {
        /* $start_date = "2018-11-16 11:24:33";
         $end_date = "2018-11-16 14:43:00";*/
        $global_end_date = date("Y-m-d H:i:s");
        $end_date = $global_end_date;

        $start_checker = date("Y-m-d",strtotime($start_date));
        $end_checker = date("Y-m-d",strtotime($end_date));
        $fhour_checker = date("H",strtotime($start_date));
        $lhour_checker = date("H",strtotime($end_date));
        $minutesTemp = 0;


        if($start_checker != $end_checker) return 100;

        if($fhour_checker <= 7 && $lhour_checker >= 8){
            $fhour_checker = 8;
            $start_date = $start_checker.' '.'08:00:00';
        }
        elseif($fhour_checker == 11 && $lhour_checker >= 12){
            $start_date = new DateTime($start_date);
            $end_date = $start_date->diff(new DateTime($start_checker." 12:00:00"));

            $minutes = $end_date->days * 24 * 60;
            $minutes += $end_date->h * 60;
            $minutes += $end_date->i;

            $start_date = $start_checker.' '.'13:00:00';
            $minutesTemp = $minutes;
            $end_date = $global_end_date;
        }
        elseif($fhour_checker == 12 && $lhour_checker >= 13){
            $fhour_checker = 13;
            $start_date = $start_checker.' '.'13:00:00';
        }
        elseif($fhour_checker >= 17 && $lhour_checker >= 17){
            $start_date = $start_checker.' '.'17:00:00';
            $end_date = $end_checker.' '.'17:00:00';
        }
        elseif($lhour_checker >= 17){
            $end_date = $end_checker.' '.'17:00:00';
        }

        if(
            ($fhour_checker >= 8 && $fhour_checker < 12)
            || ($fhour_checker >= 13)

            && ($lhour_checker >= 8 && $lhour_checker < 12)
            || ($lhour_checker >= 13)
        )
        {
            $start_date = new DateTime($start_date);
            $end_date = $start_date->diff(new DateTime($end_date));

            $minutes = $end_date->days * 24 * 60;
            $minutes += $end_date->h * 60;
            $minutes += $end_date->i;

            if($minutesTemp){
                $minutes += $minutesTemp;
            }
            return $minutes;
        }
        return 100;

    }

    static function duration($start_date,$end_date=null)
    {
        if(!$end_date){
            $end_date = date('Y-m-d H:i:s');
        }
        $now = new DateTime();
        $initialDate =  $start_date;    //start date and time in YMD format
        $finalDate = $end_date;    //end date and time in YMD format
        $calendar_start = date('Y-m-d',strtotime($initialDate));
        $calendar_end = date('Y-m-d',strtotime($finalDate));
        $holidays = Calendars::where('start','>=',$calendar_start)->where('end','<=',$calendar_end)->where('status','=',1)->get(['start']);
        /*$holidays = array(
            '2017-10-17','2017-10-16','2018-08-21'
        );*/   //holidays as array
        $noofholiday  = sizeof($holidays);     //no of total holidays
        //create all required date time objects
        $firstdate = $now::createFromFormat('Y-m-d H:i:s',$initialDate);
        $lastdate = $now::createFromFormat('Y-m-d H:i:s',$finalDate);
        if($lastdate > $firstdate)
        {
            $first = $firstdate->format('Y-m-d');
            $first = $now::createFromFormat('Y-m-d H:i:s',$first." 00:00:00" );
            $last = $lastdate->format('Y-m-d');
            $last = $now::createFromFormat('Y-m-d H:i:s',$last." 23:59:59" );
            $workhours = 0;   //working hours
            $count = 0;
            for ($i = $first;$i<=$last;$i->modify('+1 day') )
            {
                $holiday = false;
                for($k=0;$k<$noofholiday;$k++)   //excluding holidays
                {
                    $tmp = $i->format('Y-m-d');
                    if($tmp == $holidays[$k]->start)
                    {
                        $holiday = true;
                        break;
                    }
                }
                $day =  $i->format('l');
                if($day === 'Saturday' || $day === 'Sunday')  //excluding saturday, sunday
                    $holiday = true;
                if(!$holiday)
                {
                    $count++;
                    $ii = $i->format('Y-m-d');
                    $f = $firstdate->format('Y-m-d');
                    $l = $lastdate->format('Y-m-d');
                    if($l == $f )
                    {
                        $workhours +=self::sameday($firstdate,$lastdate);
                    }
                    else if( $ii===$f){
                        $workhours +=self::firstday($firstdate);
                    }
                    else if ($l ===$ii){
                        $workhours +=self::lastday($lastdate);
                    }
                    else {
                        $workhours +=8;
                    }

                }
            }
            //return $workhours;
            $obj = self::secondsToTime($workhours * 3600);
            $day = $obj['d'];
            $hour = $obj['h'];
            $min = $obj['m'];
            $result = '';
            if($hour > 24 || $day > 0){
                return $count-1 . ' days';
            }
            if($day!=0) {
                if($day == 1){
                    $result.=$day.' day ';
                }else{
                    $result.=$day.' days ';
                }
            }


            if($hour!=0) {
                if($hour == 1){
                    $result.=$hour.' hour ';
                }else{
                    $result.=$hour.' hours ';
                }
            }
            if($hour != 0 && $min > 0)
            {
                $result .= 'and ';
            }

            if($min!=0) {
                if($min == 1){
                    $result.=$min.' minute ';
                }else{
                    $result.=$min.' minutes ';
                }
            }

            if($min<1 && $hour==0){
                $result = 'Less than a minute';
            }

            return $result;

        }else{
            return 'Just now';
        }
    }

    static function timeDiffHours($start_date,$end_date){
        $start_time = strtotime($start_date);
        $end_time = strtotime($end_date);
        $difference = $end_time - $start_time;

        $seconds = $difference % 60;            //seconds
        $difference = floor($difference / 60);

        $min = $difference % 60;              // min
        $difference = floor($difference / 60);

        $hours = $difference % 24;  //hours
        $difference = floor($difference / 24);

        $days = $difference % 30;  //days
        $difference = floor($difference / 30);

        $month = $difference % 12;  //month
        $difference = floor($difference / 12);

        $data['hours'] = $hours;
        $data['days'] = $days;
        $data['min'] = $min;
        return $data;
    }

    static function sameday($firstdate,$lastdate)
    {
        $fmin = $firstdate->format('i');
        $fhour = $firstdate->format('H');
        $lmin = $lastdate->format('i');
        $lhour = $lastdate->format('H');
        if($fhour >=12 && $fhour <13)
            $fhour = 13;
        if($fhour < 8)
            $fhour = 8;
        if($fhour >= 17)
            $fhour =17;
        if($lhour<8)
            $lhour=8;
        if($lhour>=12 && $lhour<13)
            $lhour = 13;
        if($lhour>=17)
            $lhour = 17;
        if($lmin == 0)
            $min = ((60-$fmin)/60)-1;
        else {
            $min = ($lmin-$fmin)/60;
        }
        $left = ($lhour-$fhour) + $min;

        if($fhour >=8 && $fhour <=12 && $lhour >= 13 && $lhour <= 17){
            return $left-1;
        }
        return $left;
    }

    static function firstday($firstdate)   //calculation of hours of first day
    {
        $stmin = $firstdate->format('i');
        $sthour = $firstdate->format('H');
        if($sthour<8)   //time before morning 8
            $lochour = 8;
        else if($sthour>17)
            $lochour = 0;
        else if($sthour >=12 && $sthour<13)
            $lochour = 4;
        else
        {
            $lochour = 17-$sthour;
            if($sthour<=13)
                $lochour-=1;
            if($stmin == 0)
                $locmin =0;
            else
                $locmin = 1-( (60-$stmin)/60);   //in hours
            $lochour -= $locmin;
        }
        return $lochour;
    }

    static function lastday($lastdate)   //calculation of hours of last day
    {
        $stmin = $lastdate->format('i');
        $sthour = $lastdate->format('H');
        if ($sthour >= 17)   //time after 18
            $lochour = 8;
        else if ($sthour < 8)   //time before morning 8
            $lochour = 0;
        else if ($sthour >= 12 && $sthour < 13)
            $lochour = 4;
        else {
            $lochour = $sthour - 8;
            $locmin = $stmin / 60;   //in hours
            if ($sthour > 13)
                $lochour -= 1;
            $lochour += $locmin;
        }

        return $lochour;
    }

    static function secondsToTime($inputSeconds) {

        $secondsInAMinute = 60;
        $secondsInAnHour  = 60 * $secondsInAMinute;
        $secondsInADay    = 24 * $secondsInAnHour;

        // extract days
        $days = floor($inputSeconds / $secondsInADay);

        // extract hours
        $hourSeconds = $inputSeconds % $secondsInADay;
        $hours = floor($hourSeconds / $secondsInAnHour);

        // extract minutes
        $minuteSeconds = $hourSeconds % $secondsInAnHour;
        $minutes = floor($minuteSeconds / $secondsInAMinute);

        // extract the remaining seconds
        $remainingSeconds = $minuteSeconds % $secondsInAMinute;
        $seconds = ceil($remainingSeconds);

        // return the final array
        $obj = array(
            'd' => (int) $days,
            'h' => (int) $hours,
            'm' => (int) $minutes,
            's' => (int) $seconds,
        );
        return $obj;
    }

    public function absent(){
        if(Request::method() =='POST'){

            $str = Input::get('absent');
            $temp1 = explode('-',$str);
            $temp2 = array_slice($temp1, 0, 1);
            $tmp = implode(',', $temp2);
            $start_date = date('Y-m-d',strtotime($tmp));

            $temp3 = array_slice($temp1, 1, 1);
            $tmp = implode(',', $temp3);
            $enddate = date_create(date('Y-m-d',strtotime($tmp)));
            date_add($enddate, date_interval_create_from_date_string('1days'));
            $end_date = date_format($enddate, 'Y-m-d');


            $dtr_enddate  = date('Y-m-d',(strtotime ( '-1 day' , strtotime ($end_date))));

            $f = new DateTime($start_date.' '. '00:00:00');
            $t = new DateTime($dtr_enddate.' '. '00:00:00');

            $interval = $f->diff($t);

            $datein = '';
            $f_from = explode('-',$start_date);
            $startday = $f_from[2];
            $j = 0;
            while($j <= $interval->days) {
                $datein = $f_from[0].'-'.$f_from[1] .'-'. $startday;

                if(count(DtrDetails::where('userid',Auth::user()->userid)
                    ->where('datein',$datein)->get()) > 0) {
                    foreach (DtrDetails::where('userid', Auth::user()->userid)
                                 ->where('datein', $datein)
                                 ->get() as $details) {
                        $details->remark = 'ABSENT';
                        $details->holiday = '005';
                        $details->save();
                    }

                    $startday = $startday + 1;
                    $j++;
                } else {
                    $time = array('08:00:00','12:00:00','13:00:00','18:00:00');
                    for($i = 0; $i < count($time); $i++):
                        $details = new DtrDetails();
                        $details->userid = Auth::user()->userid;
                        $details->datein = $datein;
                        $details->time = $time[$i];
                        $details->event = 'IN';
                        $details->remark = 'CTO';
                        $details->edited = '1';
                        $details->holiday = '005';

                        $details->save();
                    endfor;
                }
            }
            Session::put('absent','true');
            return Redirect::back();

        }
        return View::make('form.absent');
    }

    public function timelogs_excel($id){
        $excel_range = explode(' - ',Input::get("excel_range"));
        $date_from = date("Y-m-d",strtotime($excel_range[0]));
        $date_to = date("Y-m-d",strtotime($excel_range[1]));

        $job_status = InformationPersonal::where('userid',$id)->first()->job_status;
        if($job_status == 'Permanent'){
            $timeLog = DB::connection('mysql')->select("call Gliding_2020('$id','$date_from','$date_to')");
        }else{
            $timeLog = DB::connection('mysql')->select("call getLogs2('$id','$date_from','$date_to')");
        }

        header("Content-Type: application/xls");
        header("Content-Disposition: attachment; filename=timelogs.xls");
        header("Pragma: no-cache");
        header("Expires: 0");
        $title = $id .' - '.$timeLog[0]->name;
        $table_body = "<tr>
                    <th>DATE IN</th>
                    <th>AM IN</th>
                    <th>AM OUT</th>
                    <th>PM IN</th>
                    <th>PM OUT</th>
                </tr>";
        foreach($timeLog as $row) {

            $am_in_time = isset(explode("_",explode('|',$row->time)[0])[0]) ? explode("_",explode('|',$row->time)[0])[0] : "empty";
            $am_out_time = isset(explode("_",explode('|',$row->time)[1])[0]) ? explode("_",explode('|',$row->time)[1])[0] : "empty";
            $pm_in_time = isset(explode("_",explode('|',$row->time)[2])[0]) ? explode("_",explode('|',$row->time)[2])[0] : "empty";
            $pm_out_time = isset(explode("_",explode('|',$row->time)[3])[0]) ? explode("_",explode('|',$row->time)[3])[0] : "empty";
            $date = date("F d, Y",strtotime($row->datein));
            $table_body .= "<tr style='text-align: center'>
                    <td style='width: 150px'>$date</td>
                    <td style='width: 150px'>$am_in_time</td>
                    <td style='width: 150px'>$am_out_time</td>
                    <td style='width: 150px'>$pm_in_time</td>
                    <td style='width: 150px'>$pm_out_time</td>
                </tr>";
        }
        $display =
            '<h2>'.$title.'</h2>'.
            '<table cellspacing="1" cellpadding="5" border="1">'.$table_body.'</table>';

        return $display;
    }

}