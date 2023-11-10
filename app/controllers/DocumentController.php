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
//        return Auth::user()->userid;
        if(Request::method() == 'GET'){
            $user = InformationPersonal::select("personal_information.lname","personal_information.fname","personal_information.mname","designation.description as designation","work_experience.monthly_salary")
                                        ->leftJoin("dts.designation","designation.id","=","personal_information.designation_id")
                                        ->leftJoin('pis.work_experience','work_experience.userid','=','personal_information.userid')
                                        ->where('pis.work_experience.date_to','=','Present')
                                        ->where('personal_information.userid','=',Auth::user()->userid)
                                        ->groupBy('work_experience.userid')
                                        ->first();
            $leave_type = LeaveTypes::get();
            return View::make('form.form_leave',[
                "user" => $user,
                "leave_type" => $leave_type
            ]);
        }
        if(Request::method() == 'POST') {
            if(Auth::check() AND Auth::user()->usertype == 0){
                if(Auth::user()->pass_change == NULL){
                    return Redirect::to('resetpass')->with('pass_change','You must change your password for security after your first log in or resseting password');
                }
            }
            $route_no = date('Y-') . Auth::user()->userid . date('mdHis');

            $inclusive_dates = $_POST['inclusive_dates1'];

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
            $leave->leave_details = Input::get('leave_details');
            $leave->leave_specify = Input::get('for_text_input');
            $leave->applied_num_days = Input::get('applied_num_days');
            $leave->credit_used = Input::get('leave_type');
            $leave->status = 'PENDING';

            $last_date = end($inclusive_dates);
            $last_date = array_slice($inclusive_dates, -1)[0];

            $temp1 = explode('-',$last_date);

            $date_from = date('Y-m-d',strtotime($temp1[0]));
            $date_to = date('Y-m-d',strtotime($temp1[1]));

            $leave->inc_from = $date_from;
            $leave->inc_to = $date_to;
            $leave->commutation = Input::get('com_requested');
            $leave->credit_date =  date('Y-m-d',strtotime(Input::get('credit_date')));

            $pis = InformationPersonal::where ('userid', Auth::user()->userid)->first();
            $addtnl_leave = AditionalLeave::where('userid', Auth::user()->userid)->first();

            $leave->vacation_total = $pis->vacation_balance;
            $leave->sick_total = $pis->sick_balance;
            $leave->SPL_total = $addtnl_leave->SPL;
            $leave->FL_total = $addtnl_leave->FL;
            $leave->approved_for = Input::get('approved_for');
            $leave->for_others = Input :: get('others_type');

            $leave->save();

            foreach ($inclusive_dates as $index => $date_range) {
//                return $date_range;
                $temp = explode('-', $date_range);
                $start_date = date('Y-m-d', strtotime($temp[0]));
                $end_date = date('Y-m-d', strtotime($temp[1]));

                $leave_applied_dates = new LeaveAppliedDates();
                $leave_applied_dates->leave_id = $leave->id;
                $leave_applied_dates->startdate = $start_date;
                $leave_applied_dates->enddate = $end_date;

                $leave_applied_dates->save();
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

        $leave = Leave::where('id', Input::get('id'))->first();

//        if(isset($leave) and count($leave) > 0) {
        if(isset($leave)) {
            $leave->userid = Auth::user()->userid;
            $leave->office_agency = Input::get('office_agency');
            $leave->lastname = Input::get('lastname');
            $leave->firstname = Input::get('firstname');
            $leave->middlename = Input::get('middlename');

            $leave->date_filling = Input::get('date_filling');
            $leave->position = Input::get('position');
            $leave->salary = Input::get('salary');
            $leave->leave_type = Input::get('leave_type');
            $leave->leave_details = Input::get('leave_details');
            $leave->leave_specify = Input::get('for_text_input');
            $leave->applied_num_days = Input::get('applied_num_days');

            $inclusive_dates = $_POST['inclusive_dates1'];

            $last_date = end($inclusive_dates);
            $last_date = array_slice($inclusive_dates, -1)[0];

            $temp1 = explode('-',$last_date);

            $date_from = date('Y-m-d',strtotime($temp1[0]));
            $date_to = date('Y-m-d',strtotime($temp1[1]));

            $leave->inc_from = $date_from;
            $leave->inc_to = $date_to;

            $leave->credit_date = Input::get('credit_date');
            $leave->vacation_total = Input::get('vacation');
            $leave->sick_total = Input::get('sick');
//            $leave->over_total = Input::get('over_total');
            $leave->commutation = Input::get('com_requested');
            $leave->for_others = Input::get('for_others');
            $leave->recommendation = Input::get('reco_approval');
            $leave->reco_reason = Input::get('reco_disaprove_due_to');
            $leave->approved_for= Input::get('approved_for');

            $leave->save();

             LeaveAppliedDates::where('leave_id', $leave->id)->delete();
            foreach ($inclusive_dates as $index => $date_range) {
                $temp = explode('-', $date_range);
                $start_date = date('Y-m-d', strtotime($temp[0]));
                $end_date = date('Y-m-d', strtotime($temp[1]));

                $lv = new LeaveAppliedDates();
                $lv->leave_id = $leave->id;
                $lv->startdate = $start_date;
                $lv->enddate = $end_date;

                $lv->save();
            }

            return Redirect::to('form/leave/all')->with('message','Application for leave updated.');
        }
        return Redirect::to('form/leave/all');
    }

    public function all_leave()
    {
        return "Leave is under development!";
        $userid = Auth::user()->userid;
        $pis = InformationPersonal::where("userid","=",$userid)->first();
        $division = Division::where('id', $pis->division_id)->first();
        $designation = Designation:: where('id', $pis->designation_id)->first();
        $leave_card = LeaveCardView::where('userid', $userid)->get();
        $leave = AditionalLeave::where('userid', $userid)->first();
//        return $leave;
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
            "leaves" => $leaves,
            "leave" => $leave,
            "division" => $division,
            "designation" => $designation,
            "leave_card" => $leave_card,
            "filter_range" => Input::get("filter_range")
        ]);
    }

    public function get_leave($id)
    {
        $leave = Leave::
                    select('leave.*','personal_information.vacation_balance','personal_information.sick_balance')
                    ->where('leave.id','=',$id)
                    ->leftJoin('pis.personal_information','personal_information.userid','=','leave.userid')
                    ->first();
        $leaveTypes = LeaveTypes::get();
        $leave_dates = LeaveAppliedDates::where('leave_id', $id)->get();
        return View::make('form.leave')->with(['leave' => $leave, 'leaveTypes' => $leaveTypes, 'leave_dates'=>$leave_dates]);

//        $leave = Leave::select('leave.*', 'personal_information.vacation_balance', 'personal_information.sick_balance')
//            ->where('leave.id', '=', $id)
//            ->leftJoin('pis.personal_information', 'personal_information.userid', '=', 'leave.userid')
//            ->first();
//
//        $leaveTypes = LeaveTypes::get();

    }

    public function print_leave($id)
    {

        $leave = Leave::find($id);
        $display = View::make('pdf.leave_update')->with('leave', $leave);
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
            $cdo = cdo::where('route_no',$route_no)->get()->first();
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
            foreach(pdoController::section() as $row){
                $section_head[] = pdoController::user_search1($row['head']);
            }
            foreach(pdoController::division() as $row){
                $division_head[] = pdoController::user_search1($row['head']);
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
                "bbalance_cto" => $personal_information->bbalance_cto,
                "inclusiveDates"=> $inclusiveDates
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

}