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

    public  function leave()
    {

        if(Request::method() == 'GET'){

            $user = Users::where('userid','=',Auth::user()->userid)->first();
            return View::make('form.form_leave')->with('user',$user);
        }
        if(Request::method() == 'POST') {
            if(Auth::check() AND Auth::user()->usertype == 0){
                if(Auth::user()->pass_change == NULL){
                    return Redirect::to('resetpass')->with('pass_change','You must change your password for security after your first log in or resseting password');
                }
            }
            $route_no = date('Y-') . Auth::user()->userid . date('mdHis');

            
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
            $leave->leave_type_others_1 = Input::get('leave_type_others_1');
            $leave->leave_type_others_2 = Input::get('leave_type_others_2');
            $leave->vication_loc = Input::get('vication_loc');
            $leave->abroad_others = Input::get('abroad_others');
            $leave->sick_loc = Input::get('sick_loc');
            $leave->in_hospital_specify = Input::get('in_hospital_specify');
            $leave->out_patient_specify = Input::get('out_patient_specify');
            $leave->applied_num_days = Input::get('applied_num_days');


            $temp1 = explode('-',Input::get('inc_date'));

            $date_from = date('Y-m-d',strtotime($temp1[0]));
            $date_to = date('Y-m-d',strtotime($temp1[1]));


            $leave->inc_from = $date_from;
            $leave->inc_to = $date_to;


            $leave->com_requested = Input::get('com_requested');

            $leave->credit_date =  date('Y-m-d',strtotime(Input::get('credit_date')));


            $leave->vication_total = Input::get('vication_total');
            $leave->sick_total = Input::get('sick_total');
            $leave->over_total = Input::get('over_total');
            $leave->a_days_w_pay = Input::get('a_days_w_pay');
            $leave->a_days_wo_pay = Input::get('a_days_wo_pay');
            $leave->a_others = Input::get('a_others');
            $leave->reco_approval = Input::get('reco_approval');
            $leave->reco_disaprove_due_to = Input::get('reco_disaprove_due_to');
            $leave->disaprove_due_to = Input::get('disaprove_due_to');


            $leave->save();


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
    public function edit_leave($id)
    {

       $leave = Leave::where('id',$id)->first();
       if(isset($leave) and count($leave) > 0)  {
           return View::make('form.update_leave')->with('leave',$leave);
       }
       return Redirect::to('form/leave/all');
    }

    public function delete_leave($id) {
       $leave=  Leave::where('id', $id)->first();
       $leave->delete();

        return Redirect::to('form/leave/all')->with('message','Leave deleted.');
    }
    
    public function save_edit_leave()
    {

        $leave = Leave::where('id', Input::get('id'))->first();
        if(isset($leave) and count($leave) > 0) {
            $leave->userid = Auth::user()->userid;
            $leave->office_agency = Input::get('office_agency');
            $leave->lastname = Input::get('lastname');
            $leave->firstname = Input::get('firstname');
            $leave->middlename = Input::get('middlename');

            $leave->date_filling = Input::get('date_filling');
            $leave->position = Input::get('position');
            $leave->salary = Input::get('salary');
            $leave->leave_type = Input::get('leave_type');
            $leave->leave_type_others_1 = Input::get('leave_type_others_1');
            $leave->leave_type_others_2 = Input::get('leave_type_others_2');
            $leave->vication_loc = Input::get('vication_loc');
            $leave->abroad_others = Input::get('abroad_others');
            $leave->sick_loc = Input::get('sick_loc');
            $leave->in_hospital_specify = Input::get('in_hospital_specify');
            $leave->out_patient_specify = Input::get('out_patient_specify');
            $leave->applied_num_days = Input::get('applied_num_days');


            $temp1 = explode('-',Input::get('inc_date'));

            $date_from = date('Y-m-d',strtotime($temp1[0]));
            $date_to = date('Y-m-d',strtotime($temp1[1]));

            $leave->inc_from = $date_from;
            $leave->inc_to = $date_to;


            $leave->com_requested = Input::get('com_requested');
            $leave->credit_date = Input::get('credit_date');
            $leave->vication_total = Input::get('vication_total');
            $leave->sick_total = Input::get('sick_total');
            $leave->over_total = Input::get('over_total');
            $leave->a_days_w_pay = Input::get('a_days_w_pay');
            $leave->a_days_wo_pay = Input::get('a_days_wo_pay');
            $leave->a_others = Input::get('a_others');
            $leave->reco_approval = Input::get('reco_approval');
            $leave->reco_disaprove_due_to = Input::get('reco_disaprove_due_to');
            $leave->disaprove_due_to = Input::get('disaprove_due_to');

            $leave->save();
            return Redirect::to('form/leave/all')->with('message','Application for leave updated.');
        }
        return Redirect::to('form/leave/all');
    }

    public function all_leave()
    {
        $leaves = Leave::where('userid','=', Auth::user()->userid)->paginate(20);
        return View::make('form.list_leave')->with('leaves', $leaves);
    }

    public function get_leave($id)
    {
        $leave = Leave::find($id);
        return View::make('form.leave')->with('leave', $leave);
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
        $inclusive_date = Calendars::where('route_no',Session::get('route_no'))->get();

        $name = InclusiveNames::where('inclusive_name.route_no',Session::get('route_no'))
                            ->join('pis.personal_information','personal_information.userid','=','inclusive_name.userid')
                            ->join('pis.work_experience','work_experience.userid','=','inclusive_name.userid')
                            //->join('','section.id','=','personal_information.section_id')
                            ->groupBy('work_experience.userid')
                            ->orderBy('work_experience.monthly_salary','desc')
                            ->get();

        $display = View::make('form.office_order_pdf',[
                                        'users'=>$users,
                                        'office_order'=>$office_order,
                                        'inclusive_date'=>$inclusive_date,
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
        if(Auth::user()->usertype){
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
        $office_order->id = DB::table('office_order')->max('id')+1;
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
            date_add($enddate, date_interval_create_from_date_string('1days'));
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
        pdoController::insert_tracking_master($route_no,$doc_type,$prepared_date,$prepared_by,$description);

        //ADD TRACKING DETAILS
        $date_in = $prepared_date;
        $received_by = $prepared_by;
        $delivered_by = $prepared_by;
        $action = $description;
        pdoController::insert_tracking_details($route_no,$date_in,$received_by,$delivered_by,$action);

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
            date_add($enddate, date_interval_create_from_date_string('1days'));
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

        } else {
            $cdo = cdo::where('route_no',$route_no)->get()->first();
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
                "bbalance_cto" => $personal_information->bbalance_cto
            );
            return View::make('cdo.cdo_view',['data' => $data]);
        }
    }

    public function track($route_no){

        $document = pdoController::search_tracking_details($route_no);
        Session::put('route_no',$route_no);

        return View::make('document.track',['document' => $document]);
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