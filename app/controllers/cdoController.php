<?php

class cdoController extends BaseController
{
    public function __construct()
    {
        //$this->beforeFilter('personal');
    }

    public function cdo_list(){
        Session::put('keyword',Input::get('keyword'));
        $keyword = Session::get('keyword');

        if(Auth::user()->usertype){
            $cdo = cdo::where(function($q) use ($keyword){
                $q->where("route_no","like","%$keyword%")
                    ->orWhere("subject","like","%$keyword%");
            })
                ->orderBy('id','desc')
                ->paginate(10);
            $type = "pending";
        } else {
            $cdo = cdo::where('prepared_name',pdoController::user_search(Auth::user()->userid)['id'])
                ->where(function($q) use ($keyword){
                    $q->where("route_no","like","%$keyword%")
                        ->orWhere("subject","like","%$keyword%");
                })
                ->orderBy('id','desc')
                ->paginate(10);
            $type = "list";
        }

        return View::make('cdo.cdo_list',["cdo" => $cdo,"type" => $type]);
    }

    public function cdov1($pdf = null){
        $cdo = cdo::where('route_no',Session::get('route_no'))->first();
        if($pdf == 'pdf')
            $name = pdoController::user_search1($cdo->prepared_name);
        else
            $name = pdoController::user_search(Auth::user()->userid);

        $position = pdoController::designation_search($name['designation'])['description'];
        $section = pdoController::search_section($name['section'])['description'];
        $division = pdoController::search_division($name['division'])['description'];
        foreach(pdoController::section() as $row){
            $section_head[] = pdoController::user_search1($row['head']);
        }
        foreach(pdoController::division() as $row){
            $division_head[] = pdoController::user_search1($row['head']);
        }
        $data = array(
            "cdo" => $cdo,
            "type" => "add",
            "asset" => asset('cdo_addv1'),
            "name" => $name['fname'].' '.$name['mname'].' '.$name['lname'],
            "position" => $position,
            "section" => $section,
            "division" => $division,
            "section_head" => $section_head,
            "division_head" => $division_head
        );
        if($pdf == 'pdf') {
            $display = View::make('cdo.cdo_pdf', ["data" => $data]);
            $pdf = App::make('dompdf');
            $pdf->loadHTML($display)->setPaper('a4', 'portrait');
            return $pdf->stream();
        }
        else
            return View::make("cdo.cdo_view",["data" => $data]);
    }

    public function cdo_addv1(){
        $route_no = date('Y-') . pdoController::user_search(Auth::user()->userid)['id'] . date('mdHis');
        $doc_type = "TIME_OFF";
        $prepared_date = date('Y-m-d',strtotime(Input::get('prepared_date'))).' '.date('H:i:s');
        $prepared_name = pdoController::user_search(Auth::user()->userid)['id'];

        $str = Input::get('inclusive_dates');
        $temp1 = explode('-',$str);
        $temp2 = array_slice($temp1, 0, 1);
        $tmp = implode(',', $temp2);
        $start_date = date('Y-m-d',strtotime($tmp));

        $temp3 = array_slice($temp1, 1, 1);
        $tmp = implode(',', $temp3);
        $enddate = date_create(date('Y-m-d',strtotime($tmp)));
        date_add($enddate, date_interval_create_from_date_string('1days'));
        $end_date = date_format($enddate, 'Y-m-d');
        $subject = Input::get('subject');
        $working_days = floor(strtotime($end_date) / (60 * 60 * 24)) - floor(strtotime($start_date) / (60 * 60 * 24)) - 1;

        //ADD CDO
        $cdo = new cdo();
        $cdo->route_no = $route_no;
        $cdo->subject = $subject;
        $cdo->doc_type = $doc_type;
        $cdo->prepared_date = $prepared_date;
        $cdo->prepared_name = $prepared_name;
        $cdo->working_days = $working_days;
        $cdo->start = $start_date;
        $cdo->end = $end_date;
        $cdo->immediate_supervisor = Input::get('immediate_supervisor');
        $cdo->division_chief = Input::get('division_chief');
        $cdo->save();

        //ADD TRACKING MASTER
        pdoController::insert_tracking_master($route_no,$doc_type,$prepared_date,$prepared_name,$subject);

        //ADD TRACKING DETAILS
        pdoController::insert_tracking_details($route_no,$prepared_date,$prepared_name,$prepared_name,$subject);

        //ADD SYSTEM LOGS
        $user_id = $prepared_name;
        $name = Auth::user()->fname.' '.Auth::user()->mname.' '.Auth::user()->lname;
        $activity = 'Created';
        pdoController::insert_system_logs($user_id,$name,$activity,$route_no);

        Session::put('added',true);
        return Redirect::to('form/cdo_list');
    }

    public function cdo_updatev1(){
        $route_no = Session::get('route_no');
        $prepared_date = date('Y-m-d',strtotime(Input::get('prepared_date'))).' '.date('H:i:s');
        $info = cdo::where('route_no',$route_no)->first();

        $str = Input::get('inclusive_dates');
        $temp1 = explode('-',$str);
        $temp2 = array_slice($temp1, 0, 1);
        $tmp = implode(',', $temp2);
        $start_date = date('Y-m-d',strtotime($tmp));

        $temp3 = array_slice($temp1, 1, 1);
        $tmp = implode(',', $temp3);
        $enddate = date_create(date('Y-m-d',strtotime($tmp)));
        date_add($enddate, date_interval_create_from_date_string('1days'));
        $end_date = date_format($enddate, 'Y-m-d');
        $subject = Input::get('subject');
        $working_days = floor(strtotime($end_date) / (60 * 60 * 24)) - floor(strtotime($start_date) / (60 * 60 * 24)) - 1;

        if(Auth::user()->usertype){
            $beginning_balance = Input::get('beginning_balance');
            $less_applied = Input::get('less_applied');
            $remaining_balance = Input::get('remaining_balance');
        } else{
            $beginning_balance = $info->beginning_balance;
            $less_applied = $info->less_applied_for;
            $remaining_balance = $info->remaining_balance;
        }
        if(Auth::user()->usertype and Input::get('approval')) {

            //delete dtr file
            DtrDetails::where('holiday','=', '002')
                ->whereBetween('datein',array($info->start,$info->end))
                ->delete();

            $approved_status = 1;
            $dtr_enddate  = date('Y-m-d',(strtotime ( '-1 day' , strtotime ($end_date))));

            $f = new DateTime($start_date.' '. '00:00:00');
            $t = new DateTime($dtr_enddate.' '. '00:00:00');

            $interval = $f->diff($t);

            $datein = '';
            $f_from = explode('-',$start_date);
            $startday = $f_from[2];
            $j = 0;
            while($j <= $interval->days) {

                $time = array('08:00:00','12:00:00','13:00:00','18:00:00');
                $datein = $f_from[0].'-'.$f_from[1] .'-'. $startday;

                for($i = 0; $i < count($time); $i++):
                    $details = new DtrDetails();
                    $details->userid = pdoController::user_search1($info->prepared_name)['username'];
                    $details->datein = $datein;
                    $details->time = $time[$i];
                    $details->event = 'IN';
                    $details->remark = 'CTO';
                    $details->edited = '1';
                    $details->holiday = '002';

                    $details->save();
                endfor;

                $startday = $startday + 1;
                $j++;
            }
        }
        elseif(Input::get('disapproval')) {
            $approved_status = 0;
            //delete dtr file
            DtrDetails::where('holiday','=', '002')
                ->whereBetween('datein',array($info->start,$info->end))->delete();
        }

        //UPDATE CDO
        cdo::where("route_no",$route_no)->update([
            "subject" => $subject,
            "prepared_date" => $prepared_date,
            "working_days" => $working_days,
            "start" => $start_date,
            "end" => $end_date,
            "beginning_balance" => $beginning_balance,
            "less_applied_for" => $less_applied,
            "remaining_balance" => $remaining_balance,
            "immediate_supervisor" => Input::get('immediate_supervisor'),
            "division_chief" => Input::get('division_chief'),
            "approved_status" => $approved_status
        ]);

        //UPDATE TRACKING MASTER
        pdoController::update_tracking_master($prepared_date,$subject,$route_no);

        //UPDATE TRACKING DETAILS
        pdoController::update_tracking_details($subject,$route_no);

        //ADD SYSTEM LOGS
        $user_id = $info->prepared_name;
        $name = Auth::user()->fname.' '.Auth::user()->mname.' '.Auth::user()->lname;
        $activity = 'Updated';
        pdoController::insert_system_logs($user_id,$name,$activity,$route_no);

        Session::put('updated',true);
        return Redirect::to('form/cdo_list');
    }

    public function cdo_delete(){
        $id = pdoController::user_search(Auth::user()->userid)['id'];
        $route_no = Session::get('route_no');

        //delete cdo and dtr file
        $cdo = cdo::where('route_no',$route_no)->first();
        $details = DtrDetails::where('holiday','=', '002')
            ->whereBetween('datein',array($cdo->start,$cdo->end));
        $details->delete();
        $cdo->delete();

        pdoController::delete_tracking_master($route_no);
        pdoController::delete_tracking_details($route_no);

        //ADD SYSTEM LOGS
        $user_id = $id;
        $name = Auth::user()->fname.' '.Auth::user()->mname.' '.Auth::user()->lname;
        $activity = 'Deleted';
        pdoController::insert_system_logs($user_id,$name,$activity,$route_no);

        Session::put('deleted',true);
        return Redirect::to('form/cdo_list');
    }
    public function cdo_view(Request $request){
        return view('cdo.cdo_view');
    }
}
