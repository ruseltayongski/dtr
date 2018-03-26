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

            if( Input::get('type') ){
                $type = Input::get('type');
            }
            else {
                $type = 'pending';
            }


            $cdo["count_pending"] = cdo::where('approved_status',0)
                ->where(function($q) use ($keyword){
                    $q->where("route_no","like","%$keyword%")
                        ->orWhere("subject","like","%$keyword%");
                })->get();
            $cdo["count_approve"] = cdo::where('approved_status',1)
                ->where(function($q) use ($keyword){
                    $q->where("route_no","like","%$keyword%")
                        ->orWhere("subject","like","%$keyword%");
                })->get();
            $cdo["count_all"] = cdo::where(function($q) use ($keyword){
                $q->where("route_no","like","%$keyword%")
                    ->orWhere("subject","like","%$keyword%");
                })->get();

            $cdo['paginate_pending'] = cdo::where('approved_status',0)
                ->where(function($q) use ($keyword){
                    $q->where("route_no","like","%$keyword%")
                        ->orWhere("subject","like","%$keyword%");
                })
                ->orderBy('id','desc')
                ->paginate(10);
            $cdo['paginate_approve'] = cdo::where('approved_status',1)
                ->where(function($q) use ($keyword){
                    $q->where("route_no","like","%$keyword%")
                        ->orWhere("subject","like","%$keyword%");
                })
                ->orderBy('id','desc')
                ->paginate(10);
            $cdo['paginate_all'] = cdo::where(function($q) use ($keyword){
                $q->where("route_no","like","%$keyword%")
                    ->orWhere("subject","like","%$keyword%");
            })
                ->orderBy('id','desc')
                ->paginate(10);

            if (Request::ajax() ) {

                $view = 'cdo.cdo_'.$type;
                Session::put('page_'.$type,Input::get('page'));

                return View::make($view,[
                        "cdo" => $cdo,
                        "type" => $type,
                        "count_pending" => count($cdo["count_pending"]),
                        "count_approve" => count($cdo["count_approve"]),
                        "count_all" => count($cdo["count_all"]),
                        "paginate_pending" => $cdo["paginate_pending"],
                        "paginate_approve" => $cdo["paginate_approve"],
                        "paginate_all" => $cdo["paginate_all"]
                    ]);

            }

            return View::make('cdo.cdo_list',[
                "cdo" => $cdo,
                "type" => $type,
                "paginate_pending" => $cdo["paginate_pending"],
            ]);



        } else {
            $cdo['my_cdo'] = cdo::where('prepared_name',Auth::user()->userid)
                ->where(function($q) use ($keyword){
                    $q->where("route_no","like","%$keyword%")
                        ->orWhere("subject","like","%$keyword%");
                })
                ->orderBy('id','desc')
                ->paginate(10);
            return View::make('cdo.cdo_list',["cdo" => $cdo]);
        }
    }

    public function cdov1($pdf = null){
        
        if($pdf == 'pdf') {
            $cdo = cdo::where('route_no',Session::get('route_no'))->first();
            $name = pdoController::user_search1($cdo->prepared_name);
            $userid = $name['username'];
        }
        else {
            $cdo = cdo::where('route_no','dummy')->first();
            $name = pdoController::user_search(Auth::user()->userid);
            $userid = Auth::user()->userid;
        }

        $position = pdoController::designation_search($name['designation'])['description'];
        $section = pdoController::search_section($name['section'])['description'];
        $division = pdoController::search_division($name['division'])['description'];

        if($pdf == 'pdf'){
            $section_head = pdoController::user_search1($cdo['immediate_supervisor']);
            $division_head = pdoController::user_search1($cdo['division_chief']);
        } else{
            foreach(pdoController::section() as $row){
                $section_head[] = pdoController::user_search1($row['head']);
            }
            foreach(pdoController::division() as $row){
                $division_head[] = pdoController::user_search1($row['head']);
            }
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
            "division_head" => $division_head,
            "bbalance_cto" => InformationPersonal::where('userid',$userid)->first()->bbalance_cto
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
        $working_days = floor(strtotime($end_date) / (60 * 60 * 24)) - floor(strtotime($start_date) / (60 * 60 * 24));

        //ADD CDO
        $cdo = new cdo();
        $cdo->route_no = $route_no;
        $cdo->subject = $subject;
        $cdo->doc_type = $doc_type;
        $cdo->prepared_date = $prepared_date;
        $cdo->prepared_name = Auth::user()->userid;
        $cdo->working_days = $working_days;
        $cdo->start = $start_date;
        $cdo->end = $end_date;

        $cdo->beginning_balance = Input::get('beginning_balance');
        $cdo->less_applied_for = Input::get('less_applied');
        $cdo->remaining_balance = Input::get('remaining_balance');
        $cdo->cdo_hours = Input::get('cdo_hours');
    
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

    public function click_all($type=null){
        if($type == 'approve') {
            $view = 'cdo.cdo_approve';
            $status = 0;
            $update = 1;
            $cdo['approve'] = cdo::where("approved_status",$status)->update(["approved_status" => $update]);
        }
        elseif($type == 'pending') {
            $view = 'cdo.cdo_pending';
            $status = 1;
            $update = 0;

            $cdo['pending'] = cdo::where("approved_status",$status)->update(["approved_status" => $update]);
        }
        $cdo_count['pending'] = cdo::where('approved_status',0)->get();
        $cdo_count['approve'] = cdo::where('approved_status',1)->get();

        if($type == 'approve'){
            foreach($cdo_count['approve'] as $row){
                $this->dtr_file($row->start,$row->end,$row->prepared_name);
            }
        } elseif($type == 'pending') {
            foreach($cdo_count['pending'] as $row){
                DtrDetails::where('holiday','=', '002')
                    ->whereBetween('datein',array($row->start,$row->end))
                    ->delete();
            }
        }

        return Response::json(array(
            "pending" => count($cdo_count['pending']),
            "approve" => count($cdo_count['approve']),
            "view" => View::make($view,["cdo" => 0])->render()
        ));

    }

    public function dtr_file($start_date,$end_date,$prepared_name,$cdo_hours = null){
        $dtr_enddate  = date('Y-m-d',(strtotime ( '-1 day' , strtotime ($end_date))));

        $f = new DateTime($start_date.' '. '00:00:00');
        $t = new DateTime($dtr_enddate.' '. '00:00:00');

        $interval = $f->diff($t);


        $f_from = explode('-',$start_date);
        $startday = $f_from[2];
        
        $j = 0;
        $userid = null;
        $type = null;
        $time = null;
        
        while($j <= $interval->days) {
            if($j == $interval->days){
                if($cdo_hours == 'cdo_am'){
                    $time = array('08:00:00','12:00:00');
                    $type = 'AM';
                } 
                elseif($cdo_hours == 'cdo_pm') {
                    $time = array('13:00:00','17:00:00');
                    $type = 'PM';
                }
                else {
                    $time = array('08:00:00','12:00:00','13:00:00','18:00:00');
                    $type = 'WH';
                }
            }else {
                $time = array('08:00:00','12:00:00','13:00:00','18:00:00');
                $type = 'WH';
            }

            $event = null;
            $datein = $f_from[0].'-'.$f_from[1] .'-'. $startday;
            $userid = $prepared_name;
            
            for($i = 0; $i < count($time); $i++):
                if($i % 2 === 0)
                    $event = 'IN';
                else
                    $event = 'OUT';
                //$details = new DtrDetails();
                $details = new CdoLogs();
                $details->userid = $userid;
                $details->datein = $datein;
                $details->time = $time[$i];
                $details->event = $event;
                $details->remark = 'CTO';
                $details->edited = '1';
                $details->holiday = '002';
                $details->time_type = $type;

                $details->save();
            endfor;

            $startday++;
            $j++;

        }
    }
    public function dtr_delete_cto($start_date,$end_date){
        $dtr_enddate  = date('Y-m-d',(strtotime ( '-1 day' , strtotime ($end_date))));
        CdoLogs::where('holiday','=', '002')
            ->whereBetween('datein',array($start_date,$dtr_enddate))
            ->delete();
    }

    public function cdo_updatev1($id = null,$type = null){
       
        if($id){ //AJAX PROCESS
            $cdo = cdo::where('id',$id)->first();
            $userid = $cdo->prepared_name;
            
            if($cdo->approved_status){
                InformationPersonal::where('userid',$userid)->update([
                    "bbalance_cto" => (int)$cdo->remaining_balance + (int)$cdo->less_applied_for
                ]);
                $cdo->approved_status = 0;
                //delete dtr file
                $this->dtr_delete_cto($cdo->start,$cdo->end);
            } else {
                InformationPersonal::where('userid',$userid)->update([
                    "bbalance_cto" => (int)$cdo->beginning_balance - (int)$cdo->less_applied_for
                ]);
                
                $cdo->approved_status = 1;
                $this->dtr_file($cdo->start,$cdo->end,$cdo->prepared_name,$cdo->cdo_hours);
            }
            $cdo->save();

            $keyword = '';
            $cdo["count_pending"] = cdo::where('approved_status',0)->get();
            $cdo["count_approve"] = cdo::where('approved_status',1)->get();
            $cdo["count_all"] = cdo::all();

            $cdo["paginate_pending"] = cdo::where('approved_status',0)
                ->where(function($q) use ($keyword){
                    $q->where("route_no","like","%$keyword%")
                        ->orWhere("subject","like","%$keyword%");
                })
                ->orderBy('id','desc')
                ->paginate(10);
            $cdo["paginate_approve"] = cdo::where('approved_status',1)
                ->where(function($q) use ($keyword){
                    $q->where("route_no","like","%$keyword%")
                        ->orWhere("subject","like","%$keyword%");
                })
                ->orderBy('id','desc')
                ->paginate(10);
            $cdo["paginate_all"] = cdo::where(function($q) use ($keyword){
                $q->where("route_no","like","%$keyword%")
                    ->orWhere("subject","like","%$keyword%");
            })
                ->orderBy('id','desc')
                ->paginate(10);

            if(Request::ajax()) {

                $view = 'cdo.cdo_'.$type;

                return View::make($view,[
                    "cdo" => $cdo,
                    "type" => $type,
                    "paginate_pending" => $cdo["paginate_pending"],
                    "paginate_approve" => $cdo["paginate_approve"],
                    "paginate_all" => $cdo["paginate_all"]
                ]);

            }

        } else {
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
            $working_days = floor(strtotime($end_date) / (60 * 60 * 24)) - floor(strtotime($start_date) / (60 * 60 * 24));

            $beginning_balance = Input::get('beginning_balance');
            $less_applied = Input::get('less_applied');
            $remaining_balance = Input::get('remaining_balance');
            $cdo_hours = Input::get('cdo_hours');

            if( $info->approved_status ) {
                $approved_status = 1;
            }   
            else{
                $approved_status = 0;
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
                "cdo_hours" => $cdo_hours,
                "immediate_supervisor" => Input::get('immediate_supervisor'),
                "division_chief" => Input::get('division_chief'),
                "approved_status" => $approved_status,
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
    }

    public function cdo_delete(){
        if(Auth::user()->usertype)
            $id = 'HRIS-ADMIN';
        else
            $id = pdoController::user_search(Auth::user()->userid)['id'];

        $route_no = Session::get('route_no');

        //delete cdo and dtr file
        $cdo = cdo::where('route_no',$route_no)->first();
        $details = CdoLogs::whereBetween('datein',array($cdo->start,$cdo->end));
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

    public function beginning_balance(){
        Session::put('keyword',Input::get('keyword'));
        $keyword = Session::get('keyword');

        $pis = InformationPersonal::
            where('user_status','=','1')
            ->where(function($q) use ($keyword){
                $q->where('fname','like',"%$keyword%")
                    ->orWhere('mname','like',"%$keyword%")
                    ->orWhere('lname','like',"%$keyword%")
                    ->orWhere('userid','like',"%$keyword%");
            })
                ->orderBy('fname','asc')
                ->paginate(10);
        return View::make('cdo.beginning_balance')->with('pis',$pis);
    }

    public function update_bbalance(){
        $userid = Input::get('userid');
        $beginning_balance = Input::get('beginning_balance');

        InformationPersonal::where('userid',$userid)->update([
            "bbalance_cto" => $beginning_balance 
        ]);


        return Redirect::back();
    }

}
