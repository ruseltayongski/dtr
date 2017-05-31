<?php

class cdoController extends BaseController
{
    public function __construct()
    {
        $this->beforeFilter('personal');
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
            $pdf = App::make('dompdf.wrapper');
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

    public function cdo_updatev1(Request $request){
        $route_no = Session::get('route_no');
        $date = date('Y-m-d',strtotime($request->get('date'))).' '.date('H:i:s');
        $name = pdoController::user_search($request->user()->userid)['id'];
        $str = $request->input('inclusive_dates');
        $temp1 = explode('-',$str);
        $temp2 = array_slice($temp1, 0, 1);
        $tmp = implode(',', $temp2);
        $start_date = date('Y-m-d',strtotime($tmp));

        $temp3 = array_slice($temp1, 1, 1);
        $tmp = implode(',', $temp3);
        $enddate = date_create(date('Y-m-d',strtotime($tmp)));
        date_add($enddate, date_interval_create_from_date_string('1days'));
        $end_date = date_format($enddate, 'Y-m-d');
        $subject = $request->input('subject');
        $working_days = floor(strtotime($end_date) / (60 * 60 * 24)) - floor(strtotime($start_date) / (60 * 60 * 24)) - 1;

        //UPDATE CDO
        cdo::where("route_no",$route_no)->update([
            "subject" => $subject,
            "date" => $date,
            "working_days" => $working_days,
            "start" => $start_date,
            "end" => $end_date
        ]);

        //UPDATE TRACKING MASTER
        pdoController::update_tracking_master($date,$subject,$route_no);

        //UPDATE TRACKING DETAILS
        pdoController::update_tracking_details($subject,$route_no);

        //ADD SYSTEM LOGS
        $user_id = $name;
        $name = $request->user()->fname.' '.$request->user()->mname.' '.$request->user()->lname;
        $activity = 'Updated';
        pdoController::insert_system_logs($user_id,$name,$activity,$route_no);

        Session::put('updated',true);
        return redirect()->back();
    }

    public function cdo_delete(Request $request){
        $name = pdoController::user_search($request->user()->userid)['id'];
        $route_no = Session::get('route_no');
        cdo::where('route_no',$route_no)->delete();

        pdoController::delete_tracking_master($route_no);
        pdoController::delete_tracking_details($route_no);

        //ADD SYSTEM LOGS
        $user_id = $name;
        $name = $request->user()->fname.' '.$request->user()->mname.' '.$request->user()->lname;
        $activity = 'Deleted';
        pdoController::insert_system_logs($user_id,$name,$activity,$route_no);

        Session::put('deleted',true);
        return redirect()->back();
    }

    public function cdo_pending(Request $request){
        Session::put('keyword',$request->keyword);
        $keyword = Session::get('keyword');
        $cdo = cdo::where('name',pdoController::user_search($request->user()->userid)['id'])
            ->where(function($q) use ($keyword){
                $q->where("route_no","like","%$keyword%");
            })
            ->orderBy('id','desc')
            ->paginate(10);

        return view('cdo.cdo_pending',["cdo" => $cdo]);
    }

    public function cdo_view(Request $request){
        return view('cdo.cdo_view');
    }
}
