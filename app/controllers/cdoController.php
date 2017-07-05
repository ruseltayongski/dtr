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
            $cdo["count_disapprove"] = cdo::where('approved_status',0)
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

            $cdo['paginate_disapprove'] = cdo::where('approved_status',0)
                ->where(function($q) use ($keyword){
                    $q->where("route_no","like","%$keyword%")
                        ->orWhere("subject","like","%$keyword%");
                })
                ->orderBy('id','desc')
                ->paginate(2);
            $cdo['paginate_approve'] = cdo::where('approved_status',1)
                ->where(function($q) use ($keyword){
                    $q->where("route_no","like","%$keyword%")
                        ->orWhere("subject","like","%$keyword%");
                })
                ->orderBy('id','desc')
                ->paginate(2);
            $cdo['paginate_all'] = cdo::where(function($q) use ($keyword){
                $q->where("route_no","like","%$keyword%")
                    ->orWhere("subject","like","%$keyword%");
            })
                ->orderBy('id','desc')
                ->paginate(2);
            $type = "pending";

            if (Request::ajax()) {
                if(Input::get('type') == 'approve') {
                    $view = 'cdo.cdo_approve';
                    Session::put('page_approve',Input::get('page'));
                }
                elseif(Input::get('type') == 'disapprove') {
                    $view = 'cdo.cdo_disapprove';
                    Session::put('page_disapprove',Input::get('page'));
                }
                elseif(Input::get('type') == 'all') {
                    $view = 'cdo.cdo_all';
                    Session::put('page_all',Input::get('page'));
                }
                return Response::json(array(
                    "count_disapprove" => count($cdo["count_disapprove"]),
                    "count_approve" => count($cdo["count_approve"]),
                    "count_all" => count($cdo["count_all"]),
                    "paginate_disapprove" => $cdo["paginate_disapprove"],
                    "paginate_approve" => $cdo["paginate_approve"],
                    "paginate_all" => $cdo["paginate_all"],
                    "view" => View::make($view,["cdo" => $cdo,"type" => $type])->render()
                ));
            }

            return View::make('cdo.cdo_list',["cdo" => $cdo,"type" => $type]);

        } else {
            $cdo['my_cdo'] = cdo::where('prepared_name',pdoController::user_search(Auth::user()->userid)['id'])
                ->where(function($q) use ($keyword){
                    $q->where("route_no","like","%$keyword%")
                        ->orWhere("subject","like","%$keyword%");
                })
                ->orderBy('id','desc')
                ->paginate(2);
            return View::make('cdo.cdo_list',["cdo" => $cdo]);
        }
    }

    public function cdov1($pdf = null){
        $cdo = cdo::where('route_no',Session::get('route_no'))->first();
        if($pdf == 'pdf') {
            $name = pdoController::user_search1($cdo->prepared_name);
        }
        else {
            $name = pdoController::user_search(Auth::user()->userid);
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
        $working_days = floor(strtotime($end_date) / (60 * 60 * 24)) - floor(strtotime($start_date) / (60 * 60 * 24));

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

    public function click_all($type=null){
        if($type == 'approve') {
            $view = 'cdo.cdo_approve';
            $status = 0;
            $update = 1;
            $cdo['approve'] = cdo::where("approved_status",$status)->update(["approved_status" => $update]);
        }
        elseif($type == 'disapprove') {
            $view = 'cdo.cdo_disapprove';
            $status = 1;
            $update = 0;

            $cdo['disapprove'] = cdo::where("approved_status",$status)->update(["approved_status" => $update]);
        }
        $cdo_count['disapprove'] = cdo::where('approved_status',0)->get();
        $cdo_count['approve'] = cdo::where('approved_status',1)->get();

        if($type == 'approve'){
            foreach($cdo_count['approve'] as $row){
                $this->dtr_file($row->start,$row->end,$row->prepared_name);
            }
        } elseif($type == 'disapprove') {
            foreach($cdo_count['disapprove'] as $row){
                DtrDetails::where('holiday','=', '002')
                    ->whereBetween('datein',array($row->start,$row->end))
                    ->delete();
            }
        }

        return Response::json(array(
            "disapprove" => count($cdo_count['disapprove']),
            "approve" => count($cdo_count['approve']),
            "view" => View::make($view,["cdo" => 0])->render()
        ));

    }

    public function dtr_file($start_date,$end_date,$prepared_name){
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
                $details->userid = pdoController::user_search1($prepared_name)['username'];
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
    public function dtr_delete_cto($start_date,$end_date){
        $dtr_enddate  = date('Y-m-d',(strtotime ( '-1 day' , strtotime ($end_date))));
        DtrDetails::where('holiday','=', '002')
            ->whereBetween('datein',array($start_date,$dtr_enddate))
            ->delete();
    }
    public function cdo_updatev1($id = null,$type = null){
        if($id){
            $cdo = cdo::where('id',$id)->first();
            //delete dtr file
            $this->dtr_delete_cto($cdo->start,$cdo->end);

            if($cdo->approved_status){
                $cdo->approved_status = 0;
            } else {
                $cdo->approved_status = 1;
                $this->dtr_file($cdo->start,$cdo->end,$cdo->prepared_name);
            }
            $cdo->save();
            $keyword = '';

            $cdo["count_disapprove"] = cdo::where('approved_status',0)->get();
            $cdo["count_approve"] = cdo::where('approved_status',1)->get();
            $cdo["count_all"] = cdo::all();

            $cdo["paginate_disapprove"] = cdo::where('approved_status',0)
                ->where(function($q) use ($keyword){
                    $q->where("route_no","like","%$keyword%")
                        ->orWhere("subject","like","%$keyword%");
                })
                ->orderBy('id','desc')
                ->paginate(2);
            $cdo["paginate_approve"] = cdo::where('approved_status',1)
                ->where(function($q) use ($keyword){
                    $q->where("route_no","like","%$keyword%")
                        ->orWhere("subject","like","%$keyword%");
                })
                ->orderBy('id','desc')
                ->paginate(2);
            $cdo["paginate_all"] = cdo::where(function($q) use ($keyword){
                $q->where("route_no","like","%$keyword%")
                    ->orWhere("subject","like","%$keyword%");
            })
                ->orderBy('id','desc')
                ->paginate(2);

            if(Request::ajax()) {
                if($type == 'approve') {
                    $view = 'cdo.cdo_approve';
                }
                elseif($type == 'disapprove') {
                    $view = 'cdo.cdo_disapprove';
                }
                elseif($type == 'all') {
                    $view = 'cdo.cdo_all';
                }
                return Response::json(array(
                    "count_disapprove" => count($cdo["count_disapprove"]),
                    "count_approve" => count($cdo["count_approve"]),
                    "count_all" => count($cdo["count_all"]),
                    "paginate_disapprove" => count($cdo["paginate_disapprove"]),
                    "paginate_approve" => count($cdo["paginate_approve"]),
                    "paginate_all" => count($cdo["paginate_all"]),
                    "view" => View::make($view,["cdo" => $cdo,"type" => $type])->render()
                ));
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
                //delete dtr file para ilisan og bag o
                $this->dtr_delete_cto($info->start,$info->end);

                $approved_status = 1;
                $this->dtr_file($start_date,$end_date,$info->prepared_name);
            }
            elseif(Input::get('disapproval')) {
                $approved_status = 0;
                //delete dtr file
                $this->dtr_delete_cto($info->start,$info->end);
            }
            else{
                //STANDAR USER
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
    }

    public function cdo_delete(){
        if(Auth::user()->usertype)
            $id = 'HRIS-ADMIN';
        else
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

}
