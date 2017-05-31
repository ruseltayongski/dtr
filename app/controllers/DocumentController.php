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

        $this->beforeFilter('personal');
    }

    public function index()
    {
        $user = Auth::user();
        $id = $user->id;
        $keyword = Session::get('keyword');

        $data['documents'] = Tracking::where('prepared_by',$id)
            ->where(function($q) use ($keyword){
                $q->where('route_no','like',"%$keyword%")
                    ->orwhere('description','like',"%$keyword%");
            })
            ->orderBy('id','desc')
            ->paginate(15);
        $data['access'] = $this->middleware('access');
        return View::make('document.list',$data);

    }

    public function search(Request $request){
        Session::put('keyword',Input::keyword);
        return self::index();
    }

    public  function leave()
    {

        if(Request::method() == 'GET'){

            $user = Users::where('userid','=',Auth::user()->userid)->first();
            return View::make('form.form_leave')->with('user',$user);
        }
        if(Request::method() == 'POST') {


            $route_no = date('Y-') . Auth::user()->userid . date('mdHis');


            $doc_type = 'LEAVE';
            $prepared_date = Input::get('prepared_date');
            $prepared_by =  Auth::user()->userid;
            $description = Input::get('subject');

            
            
            $leave = new Leave();


            $leave->userid = Auth::user()->userid;
            $leave->office_agency = Input::get('office_agency');
            $leave->lastname = Input::get('lastname');
            $leave->firstname = Input::get('firstname');
            $leave->middlename = Input::get('middlename');
            $date_filling = explode('/', Input::get('date_filling'));

            $leave->date_filling = date('Y-m-d',strtotime(Input::get('date_filling')));


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



            $route_no = date('Y-') . Auth::user()->userid . date('mdHis');


            $doc_type = 'LEAVE';
            $prepared_date = Input::get('prepared_date');
            $prepared_by =  Auth::user()->userid;
            $description = "Application for leave";

            $this->insert_tracking_master($route_no,$doc_type,$prepared_date,$prepared_by,$description);

            //ADD TRACKING DETAILS
            $date_in = $prepared_date;
            $received_by = $prepared_by;
            $delivered_by = $prepared_by;
            $action = $description;
            $this->insert_tracking_details($route_no,$date_in,$received_by,$delivered_by,$action);

            //ADD SYSTEM LOGS
            $user_id = $prepared_by;
            $name = Auth::user()->fname.' '.Auth::user()->mname.' '.Auth::user()->lname;
            $activity = 'CREATED';
            $this->insert_system_logs($user_id,$name,$activity);
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

    public function save_edit_leave()
    {

        $leave = Leave::where('id', Input::get('id'))->first();
        if(isset($leave) and count($leave) > 0) {
            $leave->userid = Auth::user()->id;
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
        $leaves = Leave::paginate(15);
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
        $prepared_by =  pdoController::user_search(Auth::user()->userid)['id'];
        $route_no = Session::get('route_no');

        OfficeOrders::where('route_no',$route_no)->delete();
        InclusiveNames::where('route_no',$route_no)->delete();
        Calendars::where('route_no',$route_no)->delete();

        pdoController::delete_tracking_master($route_no);
        pdoController::delete_tracking_details($route_no);
        //$this->delete_tracking_release($route_no);

        //ADD SYSTEM LOGS
        $user_id = $prepared_by;
        $name = Auth::user()->fname.' '.Auth::user()->mname.' '.Auth::user()->lname;
        $activity = 'Deleted';
        pdoController::insert_system_logs($user_id,$name,$activity,$route_no);
        Session::put('deleted',true);

        return Redirect::to('form/so_list');
    }

    public function so()
    {
        Session::put('my_id',Auth::user()->id);
        if(Request::method() == 'GET'){
            $users = User::all();
            return View::make('form.office_order',['users'=>$users]);
        }
        if(Request::method() == 'POST'){

        }
    }
    public function so_view()
    {
        Session::put('my_id',Auth::user()->id);
        if(Request::method() == 'GET'){
            $users = User::all();
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
        Session::put('my_id',Auth::user()->id);
        $users = $this->users();
        $office_order = OfficeOrders::where('route_no',Session::get('route_no'))->get()->first();
        $inclusive_name = InclusiveNames::where('route_no',Session::get('route_no'))->get();
        $inclusive_date = Calendars::where('route_no',Session::get('route_no'))->get();
        $display = View::make('form.office_order_pdf',['users'=>$users,'office_order'=>$office_order,'inclusive_date'=>$inclusive_date,'inclusive_name'=>$inclusive_name]);

        $pdf = App::make('dompdf');
        $pdf->loadHTML($display)->setPaper('a4','portrait');

        if(Session::get('route_no'))
            return $pdf->stream();
        else
            return Redirect::to('/');
    }
    public function inclusive_name(){
        $inclusive_name = InclusiveNames::where('route_no',Session::get('route_no'))->get();
        foreach($inclusive_name as $row){
            $name[] = $row['user_id'];
        }
        return $name;
    }
    public function so_list(){

        Session::put('keyword',Input::get('keyword'));
        $keyword = Session::get('keyword');
        $office_order = OfficeOrders::where('prepared_by',pdoController::user_search(Auth::user()->userid)['id'])
            ->where(function($q) use ($keyword){
                $q->where('route_no','like',"%$keyword%")
                    ->orwhere('subject','like',"%$keyword%");
            })
            ->orderBy('id','desc')
            ->paginate(10);
        return View::make('form.office_order_list')->with('office_order',$office_order);
    }

    public function sov1()
    {
        $inclusive_name = $this->inclusive_name_page();
        $users = pdoController::users();
        return View::make('form.office_orderv1',['users'=>$users,'inclusive_name'=>$inclusive_name]);
    }

    public function inclusive_name_page(){
        $name[] = pdoController::user_search(Auth::user()->userid)['id'];
        return $name;
    }

    public function inclusive_name_view(){
        $inclusive_name = inclusiveNames::where('route_no',Session::get('route_no'))->get();
        foreach($inclusive_name as $row){
            $name[] = $row['user_id'];
        }
        return $name;
    }

    public function so_append(){
        return View::make('form.office_order_append');
    }

    public function so_addv1(){
        $route_no = date('Y-') . pdoController::user_search(Auth::user()->userid)['id'] . date('mdHis');
        $doc_type = 'OFFICE_ORDER';
        $prepared_date = date('Y-m-d',strtotime(Input::get('prepared_date'))).' '.date('H:i:s');
        $prepared_by =  pdoController::user_search(Auth::user()->userid)['id'];
        $description = Input::get('subject');

        //ADD OFFICE ORDER
        $office_order = new OfficeOrders();
        $office_order->route_no = $route_no;
        $office_order->doc_type = $doc_type;
        $office_order->subject = Input::get('subject');
        $office_order->prepared_by = $prepared_by;
        $office_order->prepared_date = $prepared_date;
        $office_order->version = 1;
        $office_order->save();

        //ADD INCLUSIVE NAME
        $count = 0;
        foreach(Input::get('inclusive_name') as $row){
            $inclusive_name = new inclusiveNames();
            $inclusive_name->route_no = $route_no;
            $inclusive_name->user_id = Input::get('inclusive_name')[$count];
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

    public function so_updatev1(){
        $route_no = Session::get('route_no');
        $doc_type = 'OFFICE_ORDER';
        $prepared_date = date('Y-m-d',strtotime(Input::get('prepared_date'))).' '.date('H:i:s');
        $prepared_by =  pdoController::user_search(Auth::user()->userid)['id'];
        $description = Input::get('subject');

        //update office order
        OfficeOrders::where('route_no',$route_no)->update(['subject' => Input::get('subject')]);

        //delete
        InclusiveNames::where('route_no',$route_no)->delete();
        //
        //ADD INCLUSIVE NAME
        $count = 0;
        foreach(Input::get('inclusive_name') as $row){
            $inclusive_name = new InclusiveNames();
            $inclusive_name->route_no = $route_no;
            $inclusive_name->user_id = Input::get('inclusive_name')[$count];
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

        return Redirect::to('form/so_list');
    }

    public static function check_calendar()
    {
        return InclusiveNames::where('user_id',Auth::user()->userid)->get();
    }

    public function show($route_no,$doc_type=null){
        Session::put('route_no',$route_no);
        if($doc_type == 'office_order'){
            $users = pdoController::users();
            $info = OfficeOrders::where('route_no',$route_no)->get()->first();
            $inclusive_date = Calendars::where('route_no',$route_no)->get();
            return View::make('document.info',['users'=>$users,'info'=>$info,'inclusive_date'=>$inclusive_date]);
        } else {
            $cdo = cdo::where('route_no',$route_no)->get()->first();
            if(Auth::user()->usertype)
                $name = pdoController::user_search1($cdo->prepared_name);
            else
                $name = pdoController::user_search(Auth::user()->userid);

            $position = pdoController::designation_search($name['designation'])['description'];
            $section = pdoController::search_section($name['section'])['description'];
            $division = pdoController::search_division($name['division'])['description'];
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
                "name" => $name['fname'].' '.$name['mname'].' '.$name['lname'],
                "position" => $position,
                "section" => $section,
                "division" => $division,
                "section_head" => $section_head,
                "division_head" => $division_head
            );
            return View::make('cdo.cdo_view',['data' => $data]);
        }
    }
    public function track($route_no){

        $document = pdoController::search_tracking_details($route_no);
        Session::put('route_no',$route_no);
        return View::make('document.track',['document' => $document]);
    }


}