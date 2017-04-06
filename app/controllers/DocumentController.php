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
        $this->beforeFilter(function () {
            if(!Auth::check())
            {
                return Redirect::to('/');
            }
        });
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
        Session::put('keyword',$request->keyword);
        return self::index();
    }

    public  function leave()
    {
        if(Request::method() == 'GET'){
            $user = Users::where('userid','=',Auth::user()->userid)->first();
            return View::make('form.form_leave')->with('user',$user);
        }
        if(Request::method() == 'POST') {


            $leave = new Leave();




            $leave->userid = Auth::user()->userid;
            $leave->office_agency = Input::get('office_agency');
            $leave->lastname = Input::get('lastname');
            $leave->firstname = Input::get('firstname');
            $leave->middlename = Input::get('middlename');
            $date_filling = explode('/', Input::get('date_filling'));
            $leave->date_filling = $date_filling[2].'-'.$date_filling[0].'-'.$date_filling[1];


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
            $temp2 = array_slice($temp1, 0, 1);
            $tmp = implode(',', $temp2);
            $date_from = date('Y-m-d',strtotime($tmp));

            $temp3 = array_slice($temp1, 1, 1);
            $tmp = implode(',', $temp3);
            $date_to = date('Y-m-d',strtotime($tmp));

            $leave->inc_from = $date_from;
            $leave->inc_to = $date_to;


            $leave->com_requested = Input::get('com_requested');
            $credit_date = explode('/', Input::get('credit_date'));
            $leave->credit_date = $credit_date[2].'-'.$credit_date[0].'-'.$credit_date[1];
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
            $temp2 = array_slice($temp1, 0, 1);
            $tmp = implode(',', $temp2);
            $date_from = date('Y-m-d',strtotime($tmp));

            $temp3 = array_slice($temp1, 1, 1);
            $tmp = implode(',', $temp3);
            $date_to = date('Y-m-d',strtotime($tmp));

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
        $display = View::make('pdf.leave')->with('leave', $leave);
        $pdf = App::make('dompdf');
        $pdf->setPaper('LEGAL', 'portrait');
        $pdf->loadHTML($display);
        return $pdf->stream();
    }

    public function list_print()
    {
        $display = view('pdf.personal_dtr');
        $pdf = App::make('dompdf.wrapper');
        $pdf->setPaper('A4', 'portrait');
        $pdf->loadHTML($display);
        return $pdf->stream();
    }

    ///RUSEL
    //PDO
    public function connect()
    {
        return new PDO("mysql:host=localhost;dbname=dtsv3.0",'root','');
    }
    public function users()
    {
        $db=$this->connect();
        $sql="SELECT * FROM USERS ORDER BY FNAME ASC";
        $pdo = $db->prepare($sql);
        $pdo->execute();
        $row = $pdo->fetchAll();
        $db = null;

        return $row;
    }
    public function division()
    {
        $db=$this->connect();
        $sql="SELECT * FROM DIVISION";
        $pdo = $db->prepare($sql);
        $pdo->execute();
        $row = $pdo->fetchAll();
        $db = null;

        return $row;
    }
    public function division_head($head)
    {
        $db=$this->connect();
        $sql="SELECT * FROM DIVISION where head = ?";
        $pdo = $db->prepare($sql);
        $pdo->execute(array($head));
        $row = $pdo->fetch();
        $db = null;

        return $row;
    }

    public function insert_tracking_master($route_no,$doc_type,$prepared_date,$prepared_by,$description)
    {
        $db=$this->connect();
        $sql="INSERT INTO TRACKING_MASTER(route_no,doc_type,prepared_date,prepared_by,description) values(?,?,?,?,?)";
        $pdo = $db->prepare($sql);
        $pdo->execute(array($route_no,$doc_type,$prepared_date,$prepared_by,$description));
        $db=null;
    }

    public function insert_tracking_details($route_no,$date_in,$received_by,$delivered_by,$action)
    {
        $db=$this->connect();
        $sql="INSERT INTO TRACKING_DETAILS(route_no,date_in,received_by,delivered_by,action) values(?,?,?,?,?)";
        $pdo = $db->prepare($sql);
        $pdo->execute(array($route_no,$date_in,$received_by,$delivered_by,$action));
        $db=null;
    }

    public function insert_system_logs($user_id,$name,$activity)
    {
        $db=$this->connect();
        $sql="INSERT INTO SYSTEMLOGS(user_id,name,activity) values(?,?,?)";
        $pdo = $db->prepare($sql);
        $pdo->execute(array($user_id,$name,$activity));
        $db=null;
    }

    //OFFICE ORDER
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
            $inclusive_date = Calendar::where('route_no',Session::get('route_no'))->get();
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
        $office_order = office_order::where('route_no',Session::get('route_no'))->get()->first();
        $inclusive_name = inclusive_name::where('route_no',Session::get('route_no'))->get();
        $inclusive_date = Calendar::where('route_no',Session::get('route_no'))->get();
        $display = View::make('form.office_order_pdf',['users'=>$users,'office_order'=>$office_order,'inclusive_date'=>$inclusive_date,'inclusive_name'=>$inclusive_name]);

        $pdf = App::make('dompdf');
        $pdf->loadHTML($display)->setPaper('a4','portrait');

        if(Session::get('route_no'))
            return $pdf->stream();
        else
            return Redirect::to('/');
    }
    public function inclusive_name(){
        $inclusive_name = inclusive_name::where('route_no',Session::get('route_no'))->get();
        foreach($inclusive_name as $row){
            $name[] = $row['user_id'];
        }
        return $name;
    }
    public function so_list(){
        $office_order = OfficeOrders::orderBy('id','desc')->paginate(10);
        return View::make('form.office_order_list',['office_order' => $office_order]);
    }
    public function so_append(){
        return View::make('form.office_order_append');
    }
    public function so_add(){
        $route_no = date('Y-') . Auth::user()->id . date('mdHis');
        $doc_type = 'OFFICE_ORDER';
        $prepared_date = Input::get('prepared_date');
        $prepared_by =  Auth::user()->id;
        $description = Input::get('subject');

        //ADD OFFICE ORDER
        $office_order = new OfficeOrders();
        $office_order->route_no = $route_no;
        $office_order->subject = Input::get('subject');
        $office_order->header_body = Input::get('header_body');
        $office_order->footer_body = Input::get('footer_body');
        $office_order->approved_by = Input::get('approved_by');
        $office_order->save();

        //ADD INCLUSIVE NAME
        foreach(Input::get('inclusive_name') as $row){
            $inclusive_name = new inclusive_name();
            $inclusive_name->route_no = $route_no;
            $inclusive_name->user_id = $row;
            $inclusive_name->status = 0;
            $inclusive_name->save();
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

            $so = new Calendar();
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

        return Redirect::to('form/so_list');
    }

    public static function check_calendar()
    {
        return inclusive_name::where('user_id',Auth::user()->userid)->get();
    }

    public function show($route_no){
        $info = OfficeOrders::where('route_no',$route_no)->first();

        Session::put('route_no', $route_no);
        return View::make('document.info',['info' => $info]);
    }

    public function getTest()
    {
        /*$test = new Test();
        $test->setConnection('mysql1');
        $connection = $test->find('users');

        return $connection;*/

        /*$db_ext = DB::connection('mysql1');
        $user = $db_ext->table('tracking_master')->get();
        return $user;*/
        return $inclusive_date = Calendar::where('route_no',Session::get('route_no'))->get();
    }
}