<?php



/**
 * Created by PhpStorm.
 * User: Lourence
 * Date: 1/12/2017
 * Time: 10:03 AM
 */

ini_set('max_execution_time', 0);
ini_set('memory_limit','1000M');
ini_set('max_input_time','300000');
class PersonalController extends Controller
{
    private $userid;
    public function __construct()
    {
        $this->beforeFilter('personal');
    }

    public function index()
    {
        $information = InformationPersonal::where("userid","=",Auth::user()->userid)->first();
        Session::put('region',$information->region);
        Session::put('job_status',$information->job_status);

        $comments = Comments::Select("comment.*","personal_information.picture","personal_information.lname","personal_information.fname")
                    ->LeftJoin("pis.personal_information","personal_information.userid","=","comment.userid")
                    ->orderBy("id","desc")
                    ->get();
        return View::make('employee.index',[
            "comments" => $comments,
            "information" => $information
        ]);


    }
    public function search() {

        if(Input::has('filter_range1')) {
            $str = explode('-',Input::get('filter_range1'));
            $date_from = date("Y-m-d", strtotime($str[0]));
            $date_to = date("Y-m-d", strtotime($str[1]));

            Session::put('from',$date_from);
            Session::put('to', $date_to);
        }



        if(Session::has('from') and Session::has('to')) {


            $f_from = Session::get('from');
            $f_to = Session::get('to');



            $lists = DB::table('dtr_file')
                ->leftJoin('users', function($join){
                    $join->on('dtr_file.userid', '=', 'users.userid')
                        ->where('users.userid', '<>', '1')
                        ->where('users.userid', '<>', '--');
                })
                ->where('dtr_file.userid', '=', Auth::user()->userid)
                ->whereBetween('datein', array($f_from,$f_to))
                ->orderBy('dtr_file.datein', 'ASC')
                ->orderBy('dtr_file.time', 'ASC')
                ->paginate(20);

            return View::make('employee.index')->with('lists',$lists);
        }
    }

    public function personal_dtrlist()
    {

        if(Request::method() == "GET"){
            $lists = PdfFiles::where('is_filtered','<>', '1')
                ->where('type', '=', Auth::user()->emptype)
                ->orderBy('id', 'DESC')
                ->paginate(20);
            return View::make('dtr.personal_list')->with('lists', $lists);
        }
        if(Request::method('POST')) {

            if(Input::has('filter_range')) {
                $str = $_POST['filter_range'];
                $temp1 = explode('-',$str);
                $temp2 = array_slice($temp1, 0, 1);
                $tmp = implode(',', $temp2);
                $date_from = date('Y-m-d',strtotime($tmp));
                $temp3 = array_slice($temp1, 1, 1);
                $tmp = implode(',', $temp3);
                $date_to = date('Y-m-d',strtotime($tmp));

                $lists = DB::table('generated_pdf')
                    ->whereBetween('date_from',array($date_from,$date_to))
                    ->whereBetween('date_to' ,array($date_from,$date_to))
                    ->where('type','=',Auth::user()->emptype)
                    ->orderBy('id', 'DESC')
                    ->paginate(20);
                return View::make('dtr.personal_list')->with('lists', $lists);

            } else {
                return Redirect::to('personal/dtr/list');
            }
        } else {
            return Redirect::to('personal/dtr/list');
        }
    }


    public  function search_filter()
    {

        if(Input::has('filter_range')){


            $str = Input::get('filter_range');
            $temp1 = explode('-',$str);
            $temp2 = array_slice($temp1, 0, 1);
            $tmp = implode(',', $temp2);
            $f_from = date('Y-m-d',strtotime($tmp));
            $temp3 = array_slice($temp1, 1, 1);
            $tmp = implode(',', $temp3);
            $f_to = date('Y-m-d',strtotime($tmp));


            Session::put('from',$f_from);
            Session::put('to', $f_to);
        }

        if(Session::has('from') and Session::has('to')) {

            $f_from = Session::get('from');
            $f_to = Session::get('to');
            $lists = DtrDetails::where('userid', Auth::user()->userid)
                ->where('datein', '>=', $f_from)
                ->where('datein', '<=', $f_to)
                ->orderBy('datein', 'ASC')
                ->paginate(10);

            return View::make('employee.index')->with('lists',$lists);
        }
    }
    public function print_monthly()
    {
        return View::make('print.personal');
    }

    public static function day_name($datein)
    {

        return date('D', strtotime($datein));
    }

    public function personal_filter_dtrlist()
    {
        return View::make('dtr.print_individual');
    }
    public function save_filtered()
    {
        
        $pdf = new PdfFiles();
        $pdf->date_from = Input::get('date_from');
        $pdf->date_to = Input::get('date_to');
        $pdf->type = Auth::user()->emptype;
        $pdf->empid = Auth::user()->userid;
        $pdf->is_filtered = "1";
        $pdf->date_created =   date("Y-m-d");
        $pdf->time_created = date("h:i:sa");

        $pdf->save();

        return Redirect::to('personal/dtr/filter/list');
    }

    public function add_logs()
    {
        if(Request::method() == "GET") {
            return View::make('dtr.add_time_log');
        }
        if(Request::method() == "POST") {
            
            $date = explode('/', Input::get('datein'));
            $date = $date[2] . '-' . $date[0] . '-' . $date[1];
            
            DB::table('edited_logs')->where('datein','=',$date)
                ->where('userid','=',Auth::user()->userid)
                ->where('holiday','=','A')
                ->delete();
            
            if(Input::has('am_in')) {
                $dtr = new EditedLogs();
                $dtr->userid = Auth::user()->userid;
                $dtr->datein = $date;
                $dtr->time = Input::get('am_in');
                $dtr->event = "IN";
                $dtr->edited = "1";
                $dtr->holiday = "A";
                $dtr->remark = "WEB CREATED";
                $dtr->save();
            }

            if(Input::has('am_out')) {
                $dtr = new EditedLogs();
                $dtr->userid = Auth::user()->userid;
                $dtr->datein = $date;
                $dtr->time = Input::get('am_out');
                $dtr->event = "OUT";
                $dtr->edited = "1";
                $dtr->holiday = "A";
                $dtr->remark = "WEB CREATED";
                $dtr->save();
            }

            if(Input::has('pm_in')) {
                $dtr = new EditedLogs();
                $dtr->userid = Auth::user()->userid;
                $dtr->datein = $date;
                $dtr->time = Input::get('pm_in');
                $dtr->event = "IN";
                $dtr->holiday = "A";
                $dtr->edited = "1";
                $dtr->remark = "WEB CREATED";
                $dtr->save();
            }

            if(Input::has('pm_out')) {
                $dtr = new EditedLogs();
                $dtr->userid = Auth::user()->userid;
                $dtr->datein = $date;
                $dtr->time = Input::get('pm_out');
                $dtr->event = "OUT";
                $dtr->holiday = "A";
                $dtr->edited = "1";
                $dtr->remark = "WEB CREATED";
                $dtr->save();
            }

            return Redirect::to('/');
        }
    }

    public function delete_logs($userid,$datein,$time,$event)
    {
        $pdo = DB::connection()->getPdo();
        $st = $pdo->prepare("DELETE FROM dtr_file WHERE userid=? AND datein=? AND time=? AND event=? AND edited = 1");
        $st->execute(array(
            $userid,
            $datein,
            $time,
            $event
        ));
        return Redirect::to('personal/index');
    }
    
    public function absent_description()
    {
        $remarks = null;
        if(Request::method() == "GET"){
            Session::put('type', Input::get('t'));
            return View::make('employee.absent');
        }

        if(Request::method() == "POST") {
            $type = Session::get('type');
            if($type == "SO"){
                $this->insert_so(Input::get('date_range'),Input::get('so'));
            } elseif($type == "LEAVE") {

                $this->insert_leave(Input::get('date_range'),Input::get('leave_type'));
            } elseif($type == "CTO") {
                $this->insert_cto(Input::get('date_range'),'CTO');
            }
            return Redirect::to('personal/index')->with('msg','New absences created');
        }
    }
    
    public function insert_cto($daterange,$remarks){
        $temp1 = explode('-',$daterange);

        $from = date('Y-m-d',strtotime($temp1[0]));
        $end_date = date('Y-m-d',strtotime($temp1[1]));
        
        DB::table('cdo_logs')->where('userid','=',Auth::user()->id)
                ->whereBetween('datein',array($from,$end_date))->delete();
        
        $f = new DateTime($from.' '. '24:00:00');
        $t = new DateTime($end_date.' '. '24:00:00');

        $interval = $f->diff($t);


        $f_from = explode('-',$from);
        $startday = $f_from[2];
        $j = 0;
        while($j <= $interval->days) {

            $datein = $f_from[0].'-'.$f_from[1] .'-'. $startday;

            $details = new CdoLogs();
            $details->userid = Auth::user()->userid;
            $details->datein = $datein;
            $details->time = '08:00:00';
            $details->event = 'IN';
            $details->remark = $remarks;
            $details->edited = '1';
            $details->time_type = 'WH';
            $details->holiday = '006';

            $details->save();

            $details = new CdoLogs();
            $details->userid =  Auth::user()->userid;
            $details->datein = $datein;
            $details->time = '12:00:00';
            $details->event = 'OUT';
            $details->remark = $remarks;
            $details->edited = '1';
            $details->time_type = 'WH';
            $details->holiday = '006';

            $details->save();

            $details = new CdoLogs();
            $details->userid =  Auth::user()->userid;
            $details->datein = $datein;
            $details->time = '13:00:00';
            $details->event = 'IN';
            $details->remark = $remarks;
            $details->edited = '1';
            $details->time_type = 'WH';
            $details->holiday = '006';

            $details->save();

            $details = new CdoLogs();
            $details->userid =  Auth::user()->userid;
            $details->datein = $datein;
            $details->time = '18:00:00';
            $details->event = 'OUT';
            $details->remark = $remarks;
            $details->edited = '1';
            $details->time_type = 'WH';
            $details->holiday = '006';

            $details->save();

            $startday = $startday + 1;
            $j++;
        }
    }
    public function insert_leave($daterange,$remarks){
        $temp1 = explode('-',$daterange);

        $from = date('Y-m-d',strtotime($temp1[0]));
        $end_date = date('Y-m-d',strtotime($temp1[1]));

        DB::table('leave_logs')->where('userid','=',Auth::user()->id)
        ->whereBetween('datein',array($from,$end_date))->delete();

        $f = new DateTime($from.' '. '24:00:00');
        $t = new DateTime($end_date.' '. '24:00:00');

        $interval = $f->diff($t);


        $f_from = explode('-',$from);
        $startday = $f_from[2];
        $j = 0;
        while($j <= $interval->days) {

            $datein = $f_from[0].'-'.$f_from[1] .'-'. $startday;

            $details = new LeaveLogs();
            $details->userid = Auth::user()->userid;
            $details->datein = $datein;
            $details->time = '08:00:00';
            $details->event = 'IN';
            $details->remark = $remarks;
            $details->edited = '1';
            $details->holiday = '007';

            $details->save();

            $details = new LeaveLogs();
            $details->userid =  Auth::user()->userid;
            $details->datein = $datein;
            $details->time = '12:00:00';
            $details->event = 'OUT';
            $details->remark = $remarks;
            $details->edited = '1';
            $details->holiday = '007';

            $details->save();

            $details = new LeaveLogs();
            $details->userid =  Auth::user()->userid;
            $details->datein = $datein;
            $details->time = '13:00:00';
            $details->event = 'IN';
            $details->remark = $remarks;
            $details->edited = '1';
            $details->holiday = '007';

            $details->save();

            $details = new LeaveLogs();
            $details->userid =  Auth::user()->userid;
            $details->datein = $datein;
            $details->time = '18:00:00';
            $details->event = 'OUT';
            $details->remark = $remarks;
            $details->edited = '1';
            $details->holiday = '007';

            $details->save();

            $startday = $startday + 1;
            $j++;
        }
    }
    public function insert_so($daterange,$remarks){
        $temp1 = explode('-',$daterange);

        $from = date('Y-m-d',strtotime($temp1[0]));
        $end_date = date('Y-m-d',strtotime($temp1[1]));

        DB::table('so_logs')->where('userid','=',Auth::user()->id)
        ->whereBetween('datein',array($from,$end_date))->delete();
        $f = new DateTime($from.' '. '24:00:00');
        $t = new DateTime($end_date.' '. '24:00:00');

        $interval = $f->diff($t);


        $f_from = explode('-',$from);
        $startday = $f_from[2];
        $j = 0;
        while($j <= $interval->days) {

            $datein = $f_from[0].'-'.$f_from[1] .'-'. $startday;

            $details = new SoLogs();
            $details->userid = Auth::user()->userid;
            $details->datein = $datein;
            $details->time = '08:00:00';
            $details->event = 'IN';
            $details->remark = $remarks;
            $details->edited = '1';
            $details->time_type = 'WH';
            $details->holiday = '003';

            $details->save();

            $details = new SoLogs();
            $details->userid =  Auth::user()->userid;
            $details->datein = $datein;
            $details->time = '12:00:00';
            $details->event = 'OUT';
            $details->remark = $remarks;
            $details->edited = '1';
            $details->holiday = '003';
            $details->time_type = 'WH';
            $details->save();

            $details = new SoLogs();
            $details->userid =  Auth::user()->userid;
            $details->datein = $datein;
            $details->time = '13:00:00';
            $details->event = 'IN';
            $details->remark = $remarks;
            $details->edited = '1';
            $details->time_type = 'WH';
            $details->holiday = '003';

            $details->save();

            $details = new SoLogs();
            $details->userid =  Auth::user()->userid;
            $details->datein = $datein;
            $details->time = '18:00:00';
            $details->event = 'OUT';
            $details->remark = $remarks;
            $details->edited = '1';
            $details->time_type = 'WH';
            $details->holiday = '003';

            $details->save();

            $startday = $startday + 1;
            $j++;
        }
    }
    public function delete_created_logs()
    {
        $temp1 = explode('-',Input::get('date_range'));
        $from = date('Y-m-d',strtotime($temp1[0]));
        $end_date = date('Y-m-d',strtotime($temp1[1]));

        DB::table('edited_logs')
                ->where('edited','=','1')
                ->where('userid','=',Auth::user()->userid)
                ->whereBetween('datein', array($from,$end_date))->delete();

        DB::table('so_logs')
            ->where('userid','=',Auth::user()->userid)
            ->whereBetween('datein', array($from,$end_date))->delete();

        DB::table('cdo_logs')
            ->where('userid','=',Auth::user()->userid)
            ->whereBetween('datein', array($from,$end_date))->delete();

        DB::table('cdo_logs')
            ->where('userid','=',Auth::user()->userid)
            ->whereBetween('datein', array($from,$end_date))->delete();

        DB::table('leave_logs')
            ->where('userid','=',Auth::user()->userid)
            ->whereBetween('datein', array($from,$end_date))->delete();

        $logs = DB::table('dtr_file')
            ->where('edited','=','1')
            ->where('userid','=',Auth::user()->userid)
            ->whereBetween('datein', array($from,$end_date))->delete();

        if(count($logs) > 0)
        {
            return Redirect::to('personal/index')->with('msg', "User created time logs between $from and $end_date successfully deleted");
        }
        return Redirect::to('personal/index');
    }
    public function manual()
    {
        return View::make('users.manual');
    }
}