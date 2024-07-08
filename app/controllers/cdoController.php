<?php

class cdoController extends BaseController
{
    public function __construct()
    {
        //$this->beforeFilter('personal');
    }

    public function leave_list(){
//        return 2;

        Session::put('keyword',Input::get('keyword'));
        $keyword = Session::get('keyword');

        if( Input::get('type') ){
            $type = Input::get('type');
        }
        else {
            $type = 'pending';
        }
        $leave["count_cancelled"] = Leave::where('status',"CANCELLED")
            ->where(function($q) use ($keyword){
                $q->where("route_no","like","%$keyword%")
                    ->orWhere("subject","like","%$keyword%")
                    ->orWhere("lastname", "like", "%$keyword%");
            })->get();
        $cdo["count_pending"] = Leave::where('status',"PENDING")
            ->where(function($q) use ($keyword){
                $q->where("route_no","like","%$keyword%")
                    ->orWhere("subject","like","%$keyword%")
                    ->orWhere("lastname", "like", "%$keyword%");
            })->get();
        $cdo["count_approve"] = Leave::where('status',"APPROVED")
            ->where(function($q) use ($keyword){
                $q->where("route_no","like","%$keyword%")
                    ->orWhere("subject","like","%$keyword%")
                    ->orWhere("lastname", "like", "%$keyword%");
            })->get();
        $cdo["count_all"] = Leave::where(function($q) use ($keyword){
            $q->where("route_no","like","%$keyword%")
                ->orWhere("subject","like","%$keyword%")
                ->orWhere("lastname", "like", "%$keyword%");
            })->get();

        $cdo['paginate_cancelled'] = Leave::where('status',"CANCELLED")
            ->where(function($q) use ($keyword){
                $q->where("route_no","like","%$keyword%")
                    ->orWhere("subject","like","%$keyword%")
                    ->orWhere("lastname", "like", "%$keyword%");
            })
            ->orderBy('id','desc')
            ->paginate(10);

        $cdo['paginate_pending'] =Leave::where('status','PENDING')
            ->where(function($q) use ($keyword){
                $q->where("route_no","like","%$keyword%")
                    ->orWhere("subject","like","%$keyword%")
                    ->orWhere("lastname", "like", "%$keyword%");
            })

            ->orderBy('id','desc')
            ->paginate(10);

        $cdo['paginate_approve'] = Leave::where('status','APPROVE')
            ->where(function($q) use ($keyword){
                $q->where("route_no","like","%$keyword%")
                    ->orWhere("subject","like","%$keyword%")
                    ->orWhere("lastname", "like", "%$keyword%");
            })
            ->orderBy('id','desc')
            ->paginate(10);

        $cdo['paginate_all'] = Leave::where(function($q) use ($keyword){
                $q->where("route_no","like","%$keyword%")
                    ->orWhere("subject","like","%$keyword%")
                    ->orWhere("lastname", "like", "%$keyword%");
            })
            ->orderBy('id','desc')
            ->paginate(10);

        if (Request::ajax() ) {

            $view = 'form.form_'.$type;
            Session::put('page_'.$type,Input::get('page'));

            return View::make($view,[
                "leave" => $leave,

                "type" => $type,
                "count_cancelled" => count($leave["count_cancelled"]),
                "count_pending" => count($leave["count_pending"]),
                "count_approve" => count($leave["count_approve"]),
                "count_all" => count($leave["count_all"]),
                "paginate_cancelled" => $leave["paginate_cancelled"],
                "paginate_pending" => $leave["paginate_pending"],
                "paginate_approve" => $leave["paginate_approve"],
                "paginate_all" => $leave["paginate_all"]
            ]);
        }
//        return $cdo["count_pending"];
        return View::make('form.all_leave',[
            "leave" => $leave,
            "type" => $type,
            "paginate_cancelled" => $leave["paginate_cancelled"],
            "paginate_pending" => $leave["paginate_pending"],
            "paginate_approve" => $leave["paginate_approve"],
            "paginate_all" => $leave["paginate_all"]
        ]);
    }

    public function cdo_list(){
        Session::put('keyword',Input::get('keyword'));
        $keyword = Session::get('keyword');

        if( Input::get('type') ){
            $type = Input::get('type');
        }
        else {
            $type = 'pending';
        }
        $cdo["count_cancelled"] = InformationPersonal::join('dohdtr.cdo', 'personal_information.userid', '=', 'cdo.prepared_name')
            ->where('status',3)
            ->where(function($q) use ($keyword){
                $q->where("route_no","like","%$keyword%")
                    ->orWhere("subject","like","%$keyword%")
                    ->orWhere("lname", "like", "%$keyword%");
            })->whereDate('prepared_date', '>', '2023-08-02')->get();
        $cdo["count_pending"] = InformationPersonal::join('dohdtr.cdo', 'personal_information.userid', '=', 'cdo.prepared_name')
            ->where('approved_status',0)
            ->where(function($q) use ($keyword){
                $q->where("route_no","like","%$keyword%")
                    ->orWhere("subject","like","%$keyword%")
                    ->orWhere("lname", "like", "%$keyword%");
            })->whereDate('prepared_date', '>', '2023-08-02')->get();
        $cdo["count_approve"] = InformationPersonal::join('dohdtr.cdo', 'personal_information.userid', '=', 'cdo.prepared_name')
            ->where('approved_status',1)
            ->where(function($q) use ($keyword){
                $q->where("route_no","like","%$keyword%")
                    ->orWhere("subject","like","%$keyword%")
                    ->orWhere("lname", "like", "%$keyword%");
            })->whereDate('prepared_date', '>', '2023-08-02')->get();
        $cdo["count_all"] = InformationPersonal::join('dohdtr.cdo', 'personal_information.userid', '=', 'cdo.prepared_name')
            ->where(function($q) use ($keyword){
                $q->where("route_no","like","%$keyword%")
                    ->orWhere("subject","like","%$keyword%")
                    ->orWhere("lname", "like", "%$keyword%");
            })->whereDate('prepared_date', '>', '2023-08-02')->get();

        $cdo['paginate_cancelled'] = InformationPersonal::join('dohdtr.cdo', 'personal_information.userid', '=', 'cdo.prepared_name')
            ->where('status',3)
            ->where(function($q) use ($keyword){
                $q->where("route_no","like","%$keyword%")
                    ->orWhere("subject","like","%$keyword%")
                    ->orWhere("lname", "like", "%$keyword%");
            })
            ->whereDate('prepared_date', '>', '2023-08-02')
            ->orderBy('cdo.id','desc')
            ->paginate(10);

        $cdo['paginate_pending'] = InformationPersonal::join('dohdtr.cdo', 'personal_information.userid', '=', 'cdo.prepared_name')
            ->where('approved_status',0)
            ->where(function($q) use ($keyword){
                $q->where("route_no","like","%$keyword%")
                    ->orWhere("subject","like","%$keyword%")
                    ->orWhere("lname", "like", "%$keyword%");
            })
            ->whereDate('prepared_date', '>', '2023-08-02')
            ->orderBy('cdo.id','desc')
            ->paginate(10);

        $cdo['paginate_approve'] = InformationPersonal::join('dohdtr.cdo', 'personal_information.userid', '=', 'cdo.prepared_name')
            ->where('approved_status',1)
            ->where(function($q) use ($keyword){
                $q->where("route_no","like","%$keyword%")
                    ->orWhere("subject","like","%$keyword%")
                    ->orWhere("lname", "like", "%$keyword%");
            })
            ->whereDate('prepared_date', '>', '2023-08-02')
            ->orderBy('cdo.id','desc')
            ->paginate(10);

        $cdo['paginate_all'] = InformationPersonal::join('dohdtr.cdo', 'personal_information.userid', '=', 'cdo.prepared_name')
            ->where(function($q) use ($keyword){
                $q->where("route_no","like","%$keyword%")
                    ->orWhere("subject","like","%$keyword%")
                    ->orWhere("lname", "like", "%$keyword%");
            })
            ->whereDate('prepared_date', '>', '2023-08-02')
            ->orderBy('cdo.id','desc')
            ->paginate(10);

        if (Request::ajax() ) {

            $view = 'cdo.cdo_'.$type;
            Session::put('page_'.$type,Input::get('page'));

            return View::make($view,[
                "cdo" => $cdo,

                "type" => $type,
                "count_cancelled" => count($cdo["count_cancelled"]),
                "count_pending" => count($cdo["count_pending"]),
                "count_approve" => count($cdo["count_approve"]),
                "count_all" => count($cdo["count_all"]),
                "paginate_cancelled" => $cdo["paginate_cancelled"],
                "paginate_pending" => $cdo["paginate_pending"],
                "paginate_approve" => $cdo["paginate_approve"],
                "paginate_all" => $cdo["paginate_all"]
            ]);
        }
//        return $cdo["count_pending"];
        return View::make('cdo.cdo_roles',[
            "cdo" => $cdo,
            "type" => $type,
            "paginate_cancelled" => $cdo["paginate_cancelled"],
            "paginate_pending" => $cdo["paginate_pending"],
            "paginate_approve" => $cdo["paginate_approve"],
            "paginate_all" => $cdo["paginate_all"]
        ]);
    }

    public function cdo_user(){
        Session::put('keyword',Input::get('keyword'));
        $keyword = Session::get('keyword');

        $cdo['my_cdo'] = cdo::where('prepared_name',Auth::user()->userid)
            ->where(function($q) use ($keyword){
                $q->where("route_no","like","%$keyword%")
                    ->orWhere("subject","like","%$keyword%");
            })
            ->orderBy('id','desc')
            ->paginate(10);

        $card_view = CardView::where('userid', Auth:: user()->userid)->get();
        return View::make('cdo.cdo_user')->with(["cdo" => $cdo, "card_view"=>$card_view]);
//        return View::make('cdo.beginning_balance')->with(['pis'=>$pis, 'card_view'=>$card_view]);
    }

    //GENERATE PDF FILE...
    public function cdov1($pdf=null){
//        return 1;
        if($pdf == 'pdf') {
            $cdo = cdo::where('route_no',Session::get('route_no'))->first();
            $personal_information = InformationPersonal::where('userid','=',$cdo->prepared_name)->first();
        }
        else {

            $cdo = cdo::where('route_no','dummy')->first();
            // $inclusiveDates = [];
            $personal_information = InformationPersonal::where('userid','=',Auth::user()->userid)->first();
        }
        $position = pdoController::designation_search($personal_information->designation_id)['description'];
        $section = pdoController::search_section($personal_information->section_id)['description'];
        $division = pdoController::search_division($personal_information->division_id)['description'];

        if($pdf == 'pdf'){
            $section_head = pdoController::user_search1($cdo['immediate_supervisor']);
            $division_head = pdoController::user_search1($cdo['division_chief']);
        } else{
            $id_list = [];
            $manually_added = [985329, 273, 11, 93053, 986445, 984538, 985950, 80, 976017, 466];

            foreach(pdoController::section() as $row) {
                if ($row['acronym'] !== null || in_array($row['head'], [37, 72, 243, 614, 110, 5, 163, 648384, 985698, 160, 985950, 830744])) {
                    if(!in_array($row['head'], [172, 173, 96, 53, 114, 442, 155, 91])){
                        if(!in_array($row['head'], $id_list)){
                            $id_list[]=$row['head'];
                        }
                    }
                }
            }
            $list = array_merge($id_list,$manually_added);
//            $section_head[] = pdoController::user_search1(985329);
//            return implode(', ', $list);
            // return pdoController::user_search1(2691);
            foreach ($list as $data_list){
                $section_head[] = pdoController::user_search1($data_list);
            }


            foreach(pdoController::division() as $row) {
                if($row['ppmp_used'] == null){
                    $division_head[] = pdoController::user_search1($row['head']);
                }
            }
        }

        $data = array(
            "cdo" => $cdo,
            "cdo_applied_dates" => cdo::join('cdo_applied_dates', 'cdo.id', '=', 'cdo_applied_dates.cdo_id')
                ->where('cdo.route_no', Session::get('route_no'))
                ->get(),
            "type" => "add",
            "asset" => asset('cdo_addv1'),
            "name" => $personal_information->fname.' '.$personal_information->mname.' '.$personal_information->lname,
            "position" => $position,
            "section" => $section,
            "division" => $division,
            "section_head" => $section_head,
            "division_head" => $division_head,
            "bbalance_cto" => $personal_information->bbalance_cto
        );


        if($pdf == 'pdf') {
            $display = View::make('cdo.cdo_pdf', ["data" => $data]);
            // return $display;
            $pdf = App::make('dompdf');
            $pdf->loadHTML($display)->setPaper('a4', 'portrait');
            return $pdf->stream();
        }
        else
            return View::make("cdo.cdo_view",["data" => $data]);
    }

    public function cdo_addv1()
    {
//        $results = Tracking_Master::paginate(10); // Retrieve 10 records per page
//        return $results;
        $server_date = date('Y-m-d');
        $client_date = Input::get('client');

        if($server_date != $client_date){

            Session::put("cdo_falsification", true);

            $falsify = new Falsification();
            $falsify->userid = Auth::user()->userid;
            $falsify->client_date = $client_date;
            $falsify->server_date = $server_date;
            $falsify->save();

            return Redirect::to('form/cdo_user');
        }

        $route_no = date('Y-') . pdoController::user_search(Auth::user()->userid)['id'] . date('mdHis');
    
        $doc_type = "TIME_OFF";
        $prepared_date = date('Y-m-d', strtotime(Input::get('prepared_date'))) . ' ' . date('H:i:s');
        $prepared_name = pdoController::user_search(Auth::user()->userid)['id'];

        //if (isset($_POST['inclusive_dates']) && isset($_POST['cdo_hours'])) {
        $inclusive_dates = $_POST['inclusive_dates'];
        $cdo_hours = $_POST['cdo_hours'];

        $last_inclusive_dates = end($inclusive_dates);
        $last_inclusive_dates = array_slice($inclusive_dates, -1)[0];
        $last_cdo_hour= end($cdo_hours);
        $last_cdo_hour=array_slice($cdo_hours, -1)[0];

        $temp1 = explode('-', $last_inclusive_dates);
        $temp2 = array_slice($temp1, 0, 1);
        $tmp = implode(',', $temp2);
        $start_date = date('Y-m-d', strtotime($tmp));

        $temp3 = array_slice($temp1, 1, 1);
        $tmp = implode(',', $temp3);
        $enddate = date_create(date('Y-m-d', strtotime($tmp)));
        date_add($enddate, date_interval_create_from_date_string('1days'));
        $end_date = date_format($enddate, 'Y-m-d');
        $subject = Input::get('subject');
        $inclusive_dates_string = implode(',', $inclusive_dates);

        $working_days=0;
        foreach ($inclusive_dates as $date_range) {
            // return $inclusive_dates;
            $temp = explode('-', $date_range);
            $start_date = date('Y-m-d', strtotime($temp[0]));
            $enddate = date_create(date('Y-m-d', strtotime($temp[1])));
            $enddate -> add(new DateInterval('P1D'));
            $end_date =$enddate->format('Y-m-d');

            $working_days += floor(strtotime($end_date) / (60 * 60 * 24)) - floor(strtotime($start_date) / (60 * 60 * 24));
        }

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
        $cdo->cdo_hours = $last_cdo_hour;
        $cdo->immediate_supervisor = Input::get('immediate_supervisor');
        $cdo->division_chief = Input::get('division_chief');
        $cdo->applied_dates = $inclusive_dates_string;
        $cdo->save();
        //Saving applied_dates in clone rows into cdo_applied_dates
        foreach ($inclusive_dates as $index => $date_range) {
            $cdo_hourss=$cdo_hours[$index];

            $temp = explode('-', $date_range);
            $start_date = date('Y-m-d', strtotime($temp[0]));
            $enddate = date_create(date('Y-m-d', strtotime($temp[1])));
            $enddate -> add(new DateInterval('P1D'));
            $end_date =$enddate->format('Y-m-d');

            $cdo_applied_dates = new CdoAppliedDate();
            $cdo_applied_dates->cdo_id = $cdo->id;
            $cdo_applied_dates->start_date = $start_date;
            $cdo_applied_dates->end_date = $end_date;
            $cdo_applied_dates->cdo_hours = $cdo_hourss;
            $cdo_applied_dates->save();

            //check falsification

            $date = new DateTime();
            $name = $date->format('l');
            if($name == 'Friday'){
                $date->modify('+3 days');

            }else{
                $date->modify('+2 days');
            }

            $twoDaysAhead = $date->format('Y-m-d');

            $selectedDateTime = DateTime::createFromFormat('Y-m-d', $start_date);
            $twoDaysAheadTime = DateTime::createFromFormat('Y-m-d', $twoDaysAhead);

            $privilege = PrivilegeEmployee::where('userid', Auth::user()->userid)->first();
            if(!$privilege || $privilege->status == 1){

                if($selectedDateTime == $twoDaysAheadTime){
                }else if($selectedDateTime < $twoDaysAheadTime){
                    $selectedDateTimeString = $selectedDateTime->format('Y-m-d H:i:s');

                    $falsify = new Falsification();
                    $falsify->userid = Auth::user()->userid;
                    $falsify->client_date = $client_date;
                    $falsify->server_date = $server_date;
                    $falsify->remarks = "The selected date is outside the permitted range - ".$selectedDateTimeString;
                    $falsify->save();

                    Session::put("cdo_falsification", true);

                    CdoAppliedDate::where('cdo_id', $cdo->id)->delete();
                    cdo::where('route_no', $cdo->route_no)->delete();
                    return Redirect::to('form/cdo_user');
                }
            }
        }

        //ADD TRACKING MASTER
        $tracking_master = new Tracking_Master();
        $tracking_master->route_no = $route_no;
        $tracking_master->doc_type = $doc_type;
        $tracking_master->prepared_date = $prepared_date;
        $tracking_master->prepared_by = $prepared_name;
        $tracking_master->description = $subject;
        $tracking_master->save();
        $updated_route = date('Y').'-'.$tracking_master->id;
        $cdo->route_no = $updated_route;
        $cdo->save();
        $tracking_master->route_no = $updated_route;
        $tracking_master->save();

        //privilege logs
        $privilege= PrivilegeEmployee::where('userid', '=', $cdo->prepared_name)->first();
        if($privilege){
            $privilege->status=1;
            $privilege->save();

            $p_logs = new PrivilegeLogs();
            $p_logs->cdo_id = $cdo->id;
            $p_logs->route_no = $cdo->route_no;
            $p_logs->save();
        }

        //ADD TRACKING DETAILS
        $tracking_details = new Tracking_Details();
        $tracking_details->route_no = $updated_route;
        $tracking_details->date_in = $prepared_date;
        $tracking_details->received_by = $prepared_name;
        $tracking_details->delivered_by = $prepared_name;
        $tracking_details->action = $subject;
        $tracking_details->save();

        //ADD SYSTEM LOGS
        $user_id = $prepared_name;
        $name = Auth::user()->fname . ' ' . Auth::user()->mname . ' ' . Auth::user()->lname;
        $activity = 'Created';
        pdoController::insert_system_logs($user_id, $name, $activity, $updated_route);

        Session::put('added', true);

        if (Auth::user()->usertype == 1)
            return Redirect::to('form/cdo_list');

        return Redirect::to('form/cdo_user');
    }



    public function click_all($type=null){
        if($type == 'approve') {
            $view = 'cdo.cdo_approve';
            $status = 0;
            $update = 1;
            $cardStatus=3;
            $cdo_approve= cdo::where("approved_status", 0)->get();

            foreach ($cdo_approve as $row){
                $userid=$row->prepared_name;
//                    $cdo=cdo::where('prepared_name', '=', $userid);
                $personal_information = InformationPersonal::where('userid','=',$userid)->first();
                $cdoAppliedDate= CdoAppliedDate::where('cdo_id',$row->id)->get();

                InformationPersonal::where('userid',$userid)->update([
                    "bbalance_cto" => (float)$personal_information->bbalance_cto - (float)$row->less_applied_for
                ]);
                $balance=(float)$personal_information->bbalance_cto - (float)$row->less_applied_for;

                $cardViewCheck= CardView::where('userid', $userid)->get();

                if($cardViewCheck ->isEmpty()){
                    $card_view2= new CardView();
                    $card_view2->userid=$userid;
                    $balance1= $personal_information->bbalance_cto;
                    $card_view2->status = 7;
                    $card_view2->bal_credits= (!empty($balance1) ? $balance1 : 0);
                    $card_view2->save();
                }

                $card_view = new CardView();
                $card_id = $row->prepared_name;
                $hours_used= $row->less_applied_for;
                $date_used = $row->applied_dates;
                $card_view->userid=$card_id;
                $card_view->hours_used=$hours_used;
                $card_view->date_used=$date_used;
                $card_view->bal_credits=$balance;
                $card_view->status=4;

                $card_view->save();


                foreach($cdoAppliedDate as $cdoApplied){
                    $this->dtr_file($cdoApplied->start_date,$cdoApplied->end_date,$row->prepared_name,$cdoApplied->cdo_hours);
                }
            }
            $cdo['approve'] = cdo::where("approved_status",$status)->update(["approved_status" => $update]);
//            $cdo['approve'] = CardView::where("status",$cardStatus)->update(["status" => 4]);
        }
        elseif($type == 'pending') {
            $view = 'cdo.cdo_pending';
            $status = 1;
            $update = 0;
            $cardStatus=4;
            $cdo_approve= cdo::where("approved_status", 1)->get();
            foreach ($cdo_approve as $row){
                $userid=$row->prepared_name;
//                    $cdo=cdo::where('prepared_name', '=', $userid);
                $personal_information = InformationPersonal::where('userid','=',$userid)->first();

                InformationPersonal::where('userid',$userid)->update([
                    "bbalance_cto" => (float)$personal_information->bbalance_cto + (float)$row->less_applied_for
                ]);
                $balance=(float)$personal_information->bbalance_cto + (float)$row->less_applied_for;

                $cardViewCheck= CardView::where('userid', $userid)->get();

                if($cardViewCheck ->isEmpty()){
                    $card_view2= new CardView();
                    $card_view2->userid=$userid;
                    $balance1= $personal_information->bbalance_cto;
                    $card_view2->status = 7;
                    $card_view2->bal_credits= (!empty($balance1) ? $balance1 : 0);
                    $card_view2->save();
                }

                $card_view = new CardView();
                $card_id = $row->prepared_name;
                $hours_used= $row->less_applied_for;
                $date_used = $row->applied_dates;
                $card_view->userid=$card_id;
                $card_view->hours_used=$hours_used;
                $card_view->date_used=$date_used;
                $card_view->bal_credits=$balance;
                $card_view->status=3;

                $card_view->save();
            }
            $cdo['pending'] = cdo::where("approved_status",$status)->update(["approved_status" => $update]);
//            $cdo['approve'] = CardView::where("status",$cardStatus)->update(["status" => 3]);
        }
        $cdo_count['pending'] = cdo::where('approved_status',0)->get();
        $cdo_count['approve'] = cdo::where('approved_status',1)->get();
//        return $cdo_count['pending'];

        if($type == 'pending') {
            foreach($cdo_count['pending'] as $row){
                DtrDetails::where('holiday','=', '002')
                    ->whereBetween('datein',array($row->start,$row->end))
                    ->delete();
                $this->dtr_delete_cto($row->start,$row->end);
//                fdsfdfdf;
            }
        }

        return Response::json(array(
            "pending" => count($cdo_count['pending']),
            "approve" => count($cdo_count['approve']),
            "view" => View::make($view,["cdo" => 0])->render()
        ));
    }

    public function dtr_file($start_date,$end_date,$prepared_name,$cdo_hours = null) {
        $dtr_enddate  = date('Y-m-d',(strtotime ( '-1 day' , strtotime ($end_date))));

        $f = new DateTime($start_date.' '. '00:00:00');
        $t = new DateTime($dtr_enddate.' '. '00:00:00');

        $interval = $f->diff($t);


        $f_from = explode('-',$start_date);
        $startday = $f_from[2];
        $days_m = cal_days_in_month(CAL_GREGORIAN, $f_from[1], $f_from[0]);

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
                    $time = array('08:00:00','12:00:00','13:00:00','17:00:00');
                    $type = 'WH';
                }
            }else {
                $time = array('08:00:00','12:00:00','13:00:00','17:00:00');
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

                $checkCdoLogs = CdoLogs::where("userid",$userid)->where("datein",$datein)->where("time",$time[$i])->where("event",$event)->first();

                if(!isset($checkCdoLogs)) {
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
                }


            endfor;

//            $startday++;
//            $j++;
            if($startday == $days_m){
                $f_from[1] +=1;
                $startday = 0;
            }
            $startday = $startday + 1;
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
            $cdoAppliedDate= CdoAppliedDate::where('cdo_id',$cdo->id)->get();
            $userid = $cdo->prepared_name;
            $personal_information = InformationPersonal::where('userid','=',$userid)->first();
            $card_view = new CardView();
            $card_view2 = new CardView();
            $balance=(float)$personal_information->bbalance_cto - (float)$cdo->less_applied_for;
            $card_view->bal_credits= $balance;

            if($cdo->approved_status){
                InformationPersonal::where('userid',$userid)->update([
                    "bbalance_cto" => (float)$personal_information->bbalance_cto + (float)$cdo->less_applied_for
                ]);
                $cdo->approved_status = 0;

                $card_view->bal_credits= (float)$personal_information->bbalance_cto + (float)$cdo->less_applied_for;
                $card_view->status=3;

                foreach($cdoAppliedDate as $cdoApplied){
                    //delete dtr file
                    $this->dtr_delete_cto($cdoApplied->start_date,$cdoApplied->end_date);
                }

            } else {

                $cdo->beginning_balance = $personal_information->bbalance_cto;
                $cdo->remaining_balance = $personal_information->bbalance_cto - $cdo->less_applied_for;
                InformationPersonal::where('userid',$userid)->update([
                    "bbalance_cto" => (float)$personal_information->bbalance_cto - (float)$cdo->less_applied_for
                ]);

                $cdo->approved_status = 1;

                $card_view->bal_credits= (float)$personal_information->bbalance_cto - (float)$cdo->less_applied_for;
                $card_view->status=4;

                foreach($cdoAppliedDate as $cdoApplied){
                    $this->dtr_file($cdoApplied->start_date,$cdoApplied->end_date,$cdo->prepared_name,$cdoApplied->cdo_hours);
                }
            }
            $cardViewCheck= CardView::where('userid', $userid)->get();

            $cdo->save();

            $card_id = $cdo->prepared_name;

            if($cardViewCheck ->isEmpty()){

                $card_view2->userid=$card_id;
                $balance1= $personal_information->bbalance_cto;
                $card_view2->status = 7;
                $card_view2->bal_credits= (!empty($balance1) ? $balance1 : 0);
                $card_view2->save();
            }

            $datelist = [];
            $dates = CdoAppliedDate::where('cdo_id', $cdo->id)->get();

            if ($dates) {
                foreach ($dates as $date) {

                    $diff = (strtotime($date->start_date) - strtotime($date->end_date)) / (60 * 60 * 24) ;
                    $diff = -($diff);
                    if ($diff<=1) {
                        $date_2 =date('F j, Y', strtotime($date->start_date));

                        if ($date->cdo_hours == "cdo_am") {
                            $date_2 = date('F j, Y', strtotime($date->start_date)).' (AM)';
                        } elseif ($date->cdo_hours == "cdo_pm") {
                            $date_2 = date('F j, Y', strtotime($date->start_date)).' (PM)';
                        }
                    } else {
                        $date_2 = date('F j, Y', strtotime($date->start_date)). ' - ' . date('F j, Y', strtotime('-1 day', strtotime($date->end_date)));
                        if ($date->cdo_hours == "cdo_am") {
                            $date_2 = date('F j, Y', strtotime($date->start_date)). ' - ' . date('F j, Y', strtotime('-1 day', strtotime($date->end_date))).' (AM)';
                        } elseif ($date->cdo_hours == "cdo_pm") {
                            $date_2 = date('F j, Y', strtotime($date->start_date)). ' - ' . date('F j, Y', strtotime('-1 day', strtotime($date->end_date))).' (PM) ';
                        }
                    }
                    $datelist[] = $date_2;
                }
            }
            $datelist= implode('$', $datelist);
            $dateUsedJSON = str_replace(['[', ']', '"'], '',json_encode($datelist));
            $hours_used= $cdo->less_applied_for;
            $card_view->userid=$card_id;
            $card_view->hours_used=$hours_used;
            $card_view->date_used=$dateUsedJSON;
            $card_view->save();

            $keyword = '';
            $cdo["count_cancelled"] = cdo::where('status',3)->get();
            $cdo["count_pending"] = cdo::where('approved_status',0)->get();
            $cdo["count_approve"] = cdo::where('approved_status',1)->where('status', '!=', 3)->get();
            $cdo["count_all"] = cdo::all();

            $cdo["paginate_cancelled"] = cdo::where('status',3)
                ->where(function($q) use ($keyword){
                    $q->where("route_no","like","%$keyword%")
                        ->orWhere("subject","like","%$keyword%");
                })
                ->orderBy('id','desc')
                ->paginate(10);

            $cdo["paginate_pending"] = cdo::where('approved_status',0)
                ->where(function($q) use ($keyword){
                    $q->where("route_no","like","%$keyword%")
                        ->orWhere("subject","like","%$keyword%");
                })
                ->orderBy('id','desc')
                ->paginate(10);
            $cdo["paginate_approve"] = cdo::where('approved_status',1)
                ->where('status', '!=', 3)
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
                    "paginate_cancelled" => $cdo["paginate_cancelled"],
                    "paginate_all" => $cdo["paginate_all"]
                ]);

            }

            $balance=(float)$personal_information->bbalance_cto - (float)$cdo->less_applied_for;
            dd("balance", $balance);

        } else {

            $route_no = Session::get('route_no');
            //return $route_no;
            $prepared_date = date('Y-m-d',strtotime(Input::get('prepared_date'))).' '.date('H:i:s');
            $info = cdo::where('route_no',$route_no)->first();

            if (isset($_POST['inclusive_dates'])) {
                $inclusive_dates = $_POST['inclusive_dates'];
                $cdo_hours = $_POST['cdo_hours'];

                $last_inclusive_dates = end($inclusive_dates);
                $last_inclusive_dates = array_slice($inclusive_dates, -1)[0];
                $last_cdo= reset($cdo_hours);

                $temp1 = explode('-', $last_inclusive_dates);
                $temp2 = array_slice($temp1, 0, 1);
                $tmp = implode(',', $temp2);
                $start_date = date('Y-m-d', strtotime($tmp));

                $temp3 = array_slice($temp1, 1, 1);
                $tmp = implode(',', $temp3);
                $enddate = date_create(date('Y-m-d', strtotime($tmp)));
                date_add($enddate, date_interval_create_from_date_string('1days'));
                $end_date = date_format($enddate, 'Y-m-d');
                $subject = Input::get('subject');
                $applied_dates = $inclusive_dates;
                $inclusive_dates_string = implode(',', $inclusive_dates);

                $working_days = 0;
                foreach ($inclusive_dates as $date_range) {
                    $temp1 = explode('-', $date_range);
                    $temp2 = array_slice($temp1, 0, 1);
                    $tmp = implode(',', $temp2);
                    $start_date = date('Y-m-d', strtotime($tmp));

                    $temp3 = array_slice($temp1, 1, 1);
                    $tmp = implode(',', $temp3);
                    $enddate = date_create(date('Y-m-d', strtotime($tmp)));
                    date_add($enddate, date_interval_create_from_date_string('1days'));
                    $end_date = date_format($enddate, 'Y-m-d');
                    $working_days += floor(strtotime($end_date) / (60 * 60 * 24)) - floor(strtotime($start_date) / (60 * 60 * 24));
                }

                $beginning_balance = Input::get('beginning_balance');
                $less_applied = Input::get('less_applied');
                $remaining_balance = Input::get('remaining_balance');
                $cdo_hours = $last_cdo;

                $cdo = cdo::where('route_no', $route_no)->first();
                $cdoId = $cdo->id;
            }

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
                "applied_dates" => $inclusive_dates_string,
            ]);

            if (isset($_POST['inclusive_dates'])) {
                $inclusive_dates = $_POST['inclusive_dates'];
                $cdo_hours = $_POST['cdo_hours'];
            }

            $existingCdoDates = CdoAppliedDate::where('cdo_id', $cdoId)->get();

            $dateRangesArray = array();
            $datesId= array();

            foreach ($existingCdoDates as  $dateObject) {
                $startDate=$dateObject->start_date;
                $endDate=$dateObject->end_date;
                $id= $dateObject->id;
                $dateRange = $startDate . " - " . $endDate;
                $idList = $id;
                $dateRangesArray[] = $dateRange;
                $datesId[]=$idList;
            }

            $savedLength=count($dateRangesArray);
            $newLength=count($inclusive_dates);

            if ($savedLength > $newLength) {
                $rowsToDelete = $savedLength - $newLength;

                $existingCdoDates = CdoAppliedDate::where('cdo_id', $cdoId)
                    ->orderBy('id', 'desc')
                    ->limit($rowsToDelete)
                    ->get();

                foreach ($existingCdoDates as $dateObject) {
                    $dateObject->delete();
                }
            }

            foreach ($inclusive_dates as $index => $date_range) {
                // return $inclusive_dates;
                $cdo_hourss = $cdo_hours[$index];
                $temp1 = explode('-', $date_range);
                $temp2 = array_slice($temp1, 0, 1);
                $tmp = implode(',', $temp2);
                $start_date = date('Y-m-d', strtotime($tmp));

                $temp3 = array_slice($temp1, 1, 1);
                $tmp = implode(',', $temp3);
                $enddate = date_create(date('Y-m-d', strtotime($tmp)));
                date_add($enddate, date_interval_create_from_date_string('1days'));
                $end_date = date_format($enddate, 'Y-m-d');

                //check falsification

                $date = new DateTime();
                $name = $date->format('l');
                if($name == 'Friday'){
                    $date->modify('+3 days');

                }else{
                    $date->modify('+2 days');
                }

                $twoDaysAhead = $date->format('Y-m-d');

                $selectedDateTime = DateTime::createFromFormat('Y-m-d', $start_date);
                $twoDaysAheadTime = DateTime::createFromFormat('Y-m-d', $twoDaysAhead);

                $server_date = date('Y-m-d');
                $client_date = Input::get('client');

                $privilege = PrivilegeEmployee::where('userid', Auth::user()->userid)->first();
                if(!$privilege || $privilege->status == 1){
                    if($selectedDateTime == $twoDaysAheadTime){
                    }else if($selectedDateTime < $twoDaysAheadTime){
                        $selectedDateTimeString = $selectedDateTime->format('Y-m-d H:i:s');

                        $falsify = new Falsification();
                        $falsify->userid = Auth::user()->userid;
                        $falsify->client_date = $client_date;
                        $falsify->server_date = $server_date;
                        $falsify->remarks = "The selected date is outside the permitted range - ".$selectedDateTimeString;
                        $falsify->save();

                        Session::put("cdo_falsification", true);
                        return Redirect::to('form/cdo_user');
                    }
                }

                $cdoAppliedDate = CdoAppliedDate::where("cdo_id", $cdoId)->skip($index)->first();

                if ($cdoAppliedDate) {
                    $cdoAppliedDate->start_date = $start_date;
                    $cdoAppliedDate->end_date = $end_date;
                    $cdoAppliedDate->cdo_hours = $cdo_hourss;
                    $cdoAppliedDate->save();

                } else {
                    $cdo_applied_dates = new CdoAppliedDate();
                    $cdo_applied_dates->cdo_id = $cdoId;
                    $cdo_applied_dates->start_date = $start_date;
                    $cdo_applied_dates->end_date = $end_date;
                    $cdo_applied_dates->cdo_hours = $cdo_hourss;
                    $cdo_applied_dates->save();

                }
            }


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
            return Redirect::to('form/cdo_user');
        }

    }

    public function cdo_delete(){
//        if(Auth::user()->usertype == 1)
//            return "Cannot delete admin!";

        $route_no = Session::get('route_no');

        //delete cdo and dtr file
        $cdo = cdo::where('route_no',$route_no)->first();
        if($cdo){
            $cdo_Id= $cdo->id;
            $details = CdoLogs::whereBetween('datein',array($cdo->start,$cdo->end));
            $details->delete();
            $cdo->delete();
            //return $cdo_Id;
            $cdo_applied_dates = CdoAppliedDate::where('cdo_id', $cdo_Id);
            $cdo_applied_dates->delete();
        }

        pdoController::delete_tracking_master($route_no);
        pdoController::delete_tracking_details($route_no);

        //ADD SYSTEM LOGS

        $userSearchResult = pdoController::user_search(Auth::user()->userid);

        if ($userSearchResult !== false) {
            $id = $userSearchResult['id'];
            $user_id = $id;
            $name = Auth::user()->fname.' '.Auth::user()->mname.' '.Auth::user()->lname;
            $activity = 'Deleted';
            pdoController::insert_system_logs($user_id, $name, $activity, $route_no);
        }

        Session::put('deleted',true);

        if(Auth::user()->usertype == 1)
            return Redirect::to('form/cdo_list');

        return Redirect::to('form/cdo_user');
    }

    public function beginning_balance(){

        //        $pis_FR = InformationPersonal::get();
//        foreach ($pis_FR as $pis_first) {
//            $userid_F = $pis_first->userid;
//            $userExistsInCardView = CardView::where('userid', $userid_F)->exists();
//
//            if (!$userExistsInCardView) {
//                //set the bbalance from pis to user's first view in card
//                $bal = $pis_first->bbalance_cto;
//                $card_view = new CardView();
//                $card_view->userid = $userid_F;
//                $card_view->bal_credits = $bal;
//                $card_view->status = 7;
//                $card_view->save();
//
//            }else{
//            }
//        }
//return 1;
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
        if(Input::get('keyword')){
//            return Input::get('keyword') ;
        }else{

        }
        $card_view= CardView::get();
        $today = intval(date('m'));
        $year = intval(date('Y'));
        $date = $today-1;
        $card1= CardView::whereMonth('ot_date',"=",$date)->whereYear('ot_date', "=", $year)->where('status', '=',0)->get();
        $array = [];
        if($card1){
            foreach ($card1 as $cardP){
                $id= $cardP->id;
                $card2= CardView::where('userid', $cardP->userid)->where('id', '>=', $id)->whereNotIn('status', [6,5,2])->get();

                foreach ($card2 as $card_Filter){
                    $cardMonth = date('m', strtotime($card_Filter->ot_date));
                    $cardYear = date('Y', strtotime($card_Filter->ot_date));
                    $cardView2 = CardView::where('userid', $card_Filter->userid) -> where('id', $card_Filter->id)->whereMonth('ot_date', '=',  $cardMonth)->whereYear('ot_date', '=', $cardYear)
                        ->whereIn('status', [1, 11])->whereNotIn('status', [0,5,6,2])->get();
                    $totalRef = $cardView2->sum('ot_credits');

                    $prevbal = CardView::where('userid', $card_Filter->userid)->where('id', '<', $card_Filter->id)->orderBy('id', 'desc')->first();
                    $cprevbal = $prevbal ? ($prevbal->bal_credits != null ? $prevbal->bal_credits :0) :0;

                    $bal = InformationPersonal::where('userid', $card_Filter->userid)->first();

                    if($card_Filter->status == 4) {
                        CardView::where('id', $card_Filter->id)->update(["bal_credits" => $cprevbal - $card_Filter->hours_used]);
                        InformationPersonal::where('userid', $card_Filter->userid)->update(["bbalance_cto" => $cprevbal - $card_Filter->hours_used]);
                    }elseif($card_Filter->status == 3  ){
                        CardView::where('id', $card_Filter->id)->update(["bal_credits" => $cprevbal + $card_Filter->hours_used]);
                        InformationPersonal::where('userid', $card_Filter->userid)->update(["bbalance_cto" => $cprevbal + $card_Filter->hours_used]);
                    }elseif(in_array($card_Filter->status, ["2", "5", "6"])){
                        CardView::where('id', $card_Filter->id)->update(["bal_credits" => $cprevbal]);
                        InformationPersonal::where('userid', $card_Filter->userid)->update(["bbalance_cto" => $cprevbal]);
                    }else {
                        $array[]=$totalRef;
                        $cred=($card_Filter->ot_rate) * ($card_Filter->ot_hours);
                        $totalCheck = $totalRef + $cred; //36 + 12 = 48
                        $proBal = $cred + $cprevbal;
                        $forA1 = $totalCheck-40;  //48 - 40
                        $forCred = $cred - $forA1; // 12 - 8 = 4 =
                        if ($cprevbal < 120) {

                            if ($proBal <= 120) {
                                if ($totalRef < 40) {
                                    if ($totalCheck <= 40) {
                                        CardView::where('id', $card_Filter->id)->update(["bal_credits" => $proBal, "ot_credits" => $cred, "status" => 1]);
                                        InformationPersonal::where('userid', $card_Filter->userid)->update(["bbalance_cto" => $proBal]);
                                    } else {
                                        CardView::where('id', $card_Filter->id)->update(["bal_credits" => $bal->bbalance_cto + $forCred, "ot_credits" => $cred, "status" => $totalRef]);
                                        InformationPersonal::where('userid', $card_Filter->userid)->update(["bbalance_cto" => $bal->bbalance_cto + $forCred]);
                                    }
                                } else {
                                    $balance = InformationPersonal::where('userid', $card_Filter->userid)->first();
                                    CardView::where('id', $card_Filter->id)->update(["bal_credits" => ($balance) ? $balance->bbalance_cto : 0, "status" => 9]);
                                }
                            } else {

                                $checkpoint = 120 - $cprevbal;
                                $display = ($forCred >= $checkpoint) ? $checkpoint : $forCred;
                                if ($totalRef < 40) {
                                    if ($totalCheck <= 40) {
                                        CardView::where('id', $card_Filter->id)->update(["bal_credits" => $cprevbal + $display, "ot_credits" => $cred, "status" => 1]);
                                        InformationPersonal::where('userid', $card_Filter->userid)->update(["bbalance_cto" => $cprevbal ]);
                                    } else {
                                        CardView::where('id', $card_Filter->id)->update(["bal_credits" => $cprevbal + $display, "ot_credits" => $cred, "status" => 22]);
                                        InformationPersonal::where('userid', $card_Filter->userid)->update(["bbalance_cto" => $cprevbal + $display]);
                                    }
                                } else {
                                    InformationPersonal::where('userid', $card_Filter->userid)->update(["bbalance_cto" => $cprevbal]);
                                    CardView::where('id', $card_Filter->id)->update(["bal_credits" => $cprevbal, "status" => 9]);
                                }
                                break;
                            }
                        } else {
                            InformationPersonal::where('userid', $card_Filter->userid)->update(["bbalance_cto" => $cprevbal]);
                            CardView::where('id', $card_Filter->id)->update(["bal_credits" => $cprevbal, "status" => 9]);
                        }
                    }
                }
            }
        }else{
            $idd = null;
        }
        return View::make('cdo.beginning_balance')->with(['pis'=>$pis, 'card_view'=>$card_view]);
    }

    public function process_pending(){

            $userid = Input::get('id_to_process');
            $card= CardView::where('userid', $userid)->where('status', '=',0)->first();
            $for_checking = [];
            if($card) {
                $card1 = CardView::where('id', '>=', $card->id)->where('userid', $userid)->get();

                $array = [];

                if ($card1->count() > 0) {
                    $count = 0;

                    foreach ($card1 as $card_Filter) {

                        $for_checking[] = $card_Filter;
                        $cardMonth = date('m', strtotime($card_Filter->ot_date));
                        $cardYear = date('Y', strtotime($card_Filter->ot_date));

                        $prevbal = CardView::where('userid', $card_Filter->userid)->where('id', '<', $card_Filter->id)->orderBy('id', 'desc')->first();

                        $cprevbal = $prevbal ? ($prevbal->bal_credits != null ? $prevbal->bal_credits : 0) : 0;

                        $bal = InformationPersonal::where('userid', $card_Filter->userid)->first();

                        if ($card_Filter->status == 4) {
                            CardView::where('id', $card_Filter->id)->update(["bal_credits" => $cprevbal - $card_Filter->hours_used]);
                            InformationPersonal::where('userid', $card_Filter->userid)->update(["bbalance_cto" => $cprevbal - $card_Filter->hours_used]);
                        } elseif ($card_Filter->status == 3) {
                            CardView::where('id', $card_Filter->id)->update(["bal_credits" => $cprevbal + $card_Filter->hours_used]);
                            InformationPersonal::where('userid', $card_Filter->userid)->update(["bbalance_cto" => $cprevbal + $card_Filter->hours_used]);
                        } elseif (in_array($card_Filter->status, ["2", "5", "6"])) {
                            CardView::where('id', $card_Filter->id)->update(["bal_credits" => $cprevbal]);
                            InformationPersonal::where('userid', $card_Filter->userid)->update(["bbalance_cto" => $cprevbal]);
                        } else {
                            $cardView2 = CardView::where('userid', $card_Filter->userid)->whereMonth('ot_date', '=', $cardMonth)->whereYear('ot_date', '=', $cardYear)
                                ->whereIn('status', [1, 11])->whereNotIn('status', [0, 5, 6, 2, 3, 4])->get();
                            $totalRef = $cardView2->sum('ot_credits');
                            $array[] = $totalRef;
                            $cred = $card_Filter->ot_credits;
                            $totalCheck = $totalRef + $cred; //36 + 12 = 48
                            $proBal = $cred + $cprevbal;
                            $forA1 = $totalCheck - 40;
                            $forCred = $cred - $forA1;
                            if ($cprevbal < 120) {

                                if ($proBal <= 120) {
                                    if ($totalRef < 40) {
                                        if ($totalCheck <= 40) {
                                            CardView::where('id', $card_Filter->id)->update(["bal_credits" => $proBal, "ot_credits" => $cred, "status" => 1]);
                                            InformationPersonal::where('userid', $card_Filter->userid)->update(["bbalance_cto" => $proBal]);
                                        } else {
                                            CardView::where('id', $card_Filter->id)->update(["bal_credits" => $bal->bbalance_cto + $forCred, "ot_credits" => $cred, "status" => $totalRef]);
                                            InformationPersonal::where('userid', $card_Filter->userid)->update(["bbalance_cto" => $bal->bbalance_cto + $forCred]);
                                        }
                                    } else {
                                        $balance = InformationPersonal::where('userid', $card_Filter->userid)->first();
                                        CardView::where('id', $card_Filter->id)->update(["bal_credits" => ($balance) ? $balance->bbalance_cto : 0, "status" => 9]);
                                    }
                                } else {

                                    $checkpoint = 120 - $cprevbal;
                                    $display = ($forCred >= $checkpoint) ? $checkpoint : $forCred;
                                    if ($totalRef < 40) {
                                        if ($totalCheck <= 40) {
                                            CardView::where('id', $card_Filter->id)->update(["bal_credits" => $cprevbal + $display, "ot_credits" => $cred, "status" => 1]);
                                            InformationPersonal::where('userid', $card_Filter->userid)->update(["bbalance_cto" => $cprevbal + $display]);
                                        } else {
                                            CardView::where('id', $card_Filter->id)->update(["bal_credits" => $cprevbal + $display, "ot_credits" => $cred, "status" => 22]);
                                            InformationPersonal::where('userid', $card_Filter->userid)->update(["bbalance_cto" => $cprevbal + $display]);
                                        }
                                    } else {
                                        InformationPersonal::where('userid', $card_Filter->userid)->update(["bbalance_cto" => $cprevbal]);
                                        CardView::where('id', $card_Filter->id)->update(["bal_credits" => $cprevbal, "status" => 9]);
                                    }
                                }
                            } else {
                                InformationPersonal::where('userid', $card_Filter->userid)->update(["bbalance_cto" => $cprevbal]);
                                CardView::where('id', $card_Filter->id)->update(["bal_credits" => $cprevbal, "status" => 9]);
                            }
                        }
                    }
                }
            }

        return Redirect::back();
    }

    public function update_bbalance()
    {
        // to be removed once HR is done//
        if (Input::get('check') == "second") {
            $userid = Input::get('id_id');
            $beginning_balance = Input::get('balances');
            InformationPersonal::where('userid', $userid)->update([
                "bbalance_cto" => $beginning_balance
            ]);
            return Redirect::back();
        }
        // until here//
        else {

            $userid = Input::get('userid');
            $action = Input:: get('action');
            $row = Input:: get('row_id');
            $total_total = floatval(Input::get('total_total'));
            $beginning_balance = Input::get('cto_total');
            $informationPersonal = InformationPersonal::where('userid', $userid)->first();
            $current_bbcto = (!empty($informationPersonal->bbalance_cto)) ? $informationPersonal->bbalance_cto : 0;
            $todayMonth = date('m');
            $todayYear = date('Y');
            $ot_date = date('Y-m-d', strtotime(Input:: get('overtime_date'))) . ' ' . date('H:i:s');
            $otDateM = date('m', strtotime($ot_date));
            $otDateY = date('Y', strtotime($ot_date));
            $ot_hours = Input:: get('ot_hours');
            $ot_rate = floatval(Input:: get('ot_weight'));
            $card_view = new CardView();
            $totalBal = 0;
            $cardcheckstat = CardView::where('id', '=', $row)->where('userid', $userid)->first();

            $cardView = CardView::where('userid', $userid)->get();

            if ($cardView->isEmpty()) {
                $card_view2 = new CardView();
                $card_view2->userid = $userid;
                $card_view2->bal_credits = ($current_bbcto != null) ? $current_bbcto : 0;
                $card_view2->status = 7;
                $card_view2->save();
            }
            if ($action == 'update') {
//                return "update";
                if ($total_total == 0) {
                    $card_view->status = ($otDateY == $todayYear && $otDateM == $todayMonth) ? 1 : 0;
                } else {
                    $update = CardView::where('id', $row)->where('userid', $userid)->first();

                    CardView::where('id', $row)->where('userid', $userid)->update(["status" => 2, "bal_credits" => $update->bal_credits - $update->ot_credits, "ot_credits" => $cardcheckstat->ot_hours * $cardcheckstat->ot_rate]);
                    $stat = $cardcheckstat->status;
                    if ($stat != null && $stat == 0) {
                    } else {
                        $ch = CardView::where('id', '=', $row)->where('userid', $userid)->first();
                        CardView::where('id', '=', $row)->where('userid', $userid)->update(["status" => 2, "remarks" => Input:: get('remarks'), "bal_credits" => $update->bal_credits - $update->ot_credits, "ot_credits" => $ch->ot_rate * $ch->ot_hours]);
                        $card2 = CardView::where('id', '>', $row)->where('userid', $userid)->get();
                        $array = [];
                        foreach ($card2 as $card) {

                                $thiscardMonth = date('m', strtotime($card->ot_date));
                                $thiscardYear = date('Y', strtotime($card->ot_date));
                                $id_s = $card->id;

                                $cardView2 = CardView::where('userid', $userid)->where('id', '<', $id_s)->whereMonth('ot_date', '=', $thiscardMonth)
                                    ->whereYear('ot_date', '=', $thiscardYear)->whereNotIn('status', [0, 5, 6, 2])->whereIn('status', [1, 11])->get();
                                $totalRef = $cardView2->sum('ot_credits');
                                $prevbal = CardView::where('userid', $userid)->where('id', '<', $card->id)->whereNotNull('bal_credits')->orderBy('id', 'desc')->first();
                                $cprevbal = $prevbal ? ($prevbal->bal_credits !== null ? $prevbal->bal_credits : 0) : 0;

                                if ($card->status == 4) {
                                    CardView::where('id', $card->id)->update(["bal_credits" => $cprevbal - $card->hours_used]);
                                    InformationPersonal::where('userid', $userid)->update(["bbalance_cto" => $cprevbal - $card->hours_used]);
                                } elseif ($card->status == 3) {
                                    CardView::where('id', $card->id)->update(["bal_credits" => $cprevbal + $card->hours_used]);
                                    InformationPersonal::where('userid', $userid)->update(["bbalance_cto" => $cprevbal + $card->hours_used]);
                                }elseif(in_array($card->status, [0,2,5,6])){
                                    CardView::where('id', $card->id)->update(["bal_credits" => $cprevbal]);
                                    InformationPersonal::where('userid', $userid)->update(["bbalance_cto" => $cprevbal]);
                                } else {

                                    $cred = ($card->ot_rate) * ($card->ot_hours);
                                    $totalCheck = $totalRef + $cred;
                                    $proBal = $cred + $cprevbal;
                                    $forA1 = $totalCheck - 40;  //36+12 = 48 - 40 = 8 12 -8= 4
                                    $forCred = $cred - $forA1;
                                    if ($cprevbal < 120) {

                                        if ($proBal <= 120) {
                                            if ($totalRef < 40) {
                                                if ($totalCheck <= 40) {
                                                    CardView::where('id', $card->id)->update(["bal_credits" => $proBal, "ot_credits" => $cred, "status" => 1]);
                                                    InformationPersonal::where('userid', $userid)->update(["bbalance_cto" => $proBal]);
                                                } else {
                                                    CardView::where('id', $card->id)->update(["bal_credits" => $cprevbal + $forCred, "ot_credits" => $cred, "status" => 11]);
                                                    InformationPersonal::where('userid', $userid)->update(["bbalance_cto" => $cprevbal + $forCred]);
                                                }
                                            } else {
                                                $balance = InformationPersonal::where('userid', $userid)->first();
                                                CardView::where('id', $card->id)->update(["status" => 9, "bal_credits" => ($balance)?$balance->bbalance_cto : 0]);
                                            }
                                        } else {
                                            $check_120 = 120 - $cprevbal; // 130- 120 = 10
                                            $display = ($forCred >= $check_120) ? $check_120 : $forCred;
                                            if ($totalRef < 40) {
                                                if ($totalCheck <= 40) {
                                                    CardView::where('id', $card->id)->update(["bal_credits" => $cprevbal + $display, "ot_credits" => $cred, "status" => 1]);
                                                    InformationPersonal::where('userid', $userid)->update(["bbalance_cto" => $cprevbal + $display]);
                                                } else {
                                                    CardView::where('id', $card->id)->update(["bal_credits" => $cprevbal + $display, "ot_credits" => $cred, "status" => 11]);
                                                    InformationPersonal::where('userid', $userid)->update(["bbalance_cto" => $cprevbal + $display]);
                                                }
                                            } else {
                                                InformationPersonal::where('userid', $userid)->update(["bbalance_cto" => $cprevbal]);
                                                CardView::where('id', $card->id)->update(["status" => 9, "bal_credits" => $cprevbal]);
                                            }
                                        }
                                    } else {
                                        InformationPersonal::where('userid', $userid)->update(["bbalance_cto" => $cprevbal]);
                                        CardView::where('id', $card->id)->update(["status" => 9, "bal_credits" => $cprevbal]);
                                    }
                                }
                        }
                    }
                }

                //for newly updated month
                $informationPersonal = InformationPersonal::where('userid', $userid)->first();
                $balance = (!empty($informationPersonal->bbalance_cto)) ? $informationPersonal->bbalance_cto : 0;

                $cardViewForDate = CardView::where('userid', $userid)->whereMonth('ot_date', '=', $otDateM)->whereYear('ot_date', '=', $otDateY)->whereIn('status', [1, 11])->get();
                $totalBal = $cardViewForDate->sum('ot_credits');
//                foreach ($cardViewForDate as $card) {
//                    $rate = $card->ot_rate;
//                    $hours = $card->ot_hours;
//                    $bal = $rate * $hours;
//                    $totalBal += $bal;
//                }


                if ($otDateY == $todayYear && $otDateM == $todayMonth) {

                    $card_view->ot_credits = $beginning_balance;
                    $card_view->bal_credits = $balance;
                    $card_view->status = 0;
                } else {

                    if($cardcheckstat){

                        $prev_date= $cardcheckstat->ot_date;
                        $thisotMonth = date('m', strtotime($prev_date));
                        $thisotYear = date('Y', strtotime($prev_date));
                        if($todayMonth == $thisotMonth && $todayYear == $thisotYear){
                            $balance = $balance;
                        }else{
                            $balance = $balance;
                        }
                    }else{
                        if($total_total==0){
                        }else{
                            $balance = $balance-$total_total;
                        }
                    }
                    if ($balance < 120) {

                        $check = $balance + $beginning_balance;
                        if ($check < 120) {

                            if ($totalBal < 40) {

                                $total1 = $totalBal + $beginning_balance;
                                if ($total1 <= 40) {

                                    $card_view->ot_credits = $beginning_balance;
                                    $card_view->bal_credits = $balance + $beginning_balance;
                                    $card_view->status = 1;
                                    InformationPersonal::where('userid', $userid)->update(["bbalance_cto" => $balance + $beginning_balance]);
                                } else {
                                    $total2 = $total1 - 40;

                                    $card_view->ot_credits = $beginning_balance;
                                    $card_view->bal_credits = ($balance + $beginning_balance) - $total2;
                                    $card_view->status = 11;
                                    InformationPersonal::where('userid', $userid)->update(["bbalance_cto" => ($balance + $beginning_balance) - $total2]);
                                }
                            } else {

                                $card_view->ot_credits = $beginning_balance;
                                $card_view->bal_credits = $balance;
                                $card_view->status = 9;
                            }
                        } else {

                            $fill = $check - 120;
                            $fcheck = ($fill > $beginning_balance) ? $beginning_balance : $beginning_balance - $fill;

                            if ($totalBal < 40) {

                                $total1 = $totalBal + $fcheck;
                                if ($total1 <= 40) {
                                    $card_view->ot_credits = $beginning_balance;
                                    $card_view->bal_credits = $fcheck + $balance;
                                    $card_view->status = 1;
                                    InformationPersonal::where('userid', $userid)->update(["bbalance_cto" => $fcheck + $balance]);
                                } else {
                                    $total2 = $total1 - 40;
                                    $card_view->ot_credits = $beginning_balance;
                                    $card_view->bal_credits = ($fcheck + $balance) - $total2; // 15+105= 120 - 10 = 110
                                    $card_view->status = 11;
                                    InformationPersonal::where('userid', $userid)->update(["bbalance_cto" => ($fcheck + $balance) - $total2]);
                                }
                            } else {
                                $card_view->ot_credits = $beginning_balance;
                                $card_view->bal_credits = $balance;
                                $card_view->status = 9;
                            }
                        }
                    } else {

                        $card_view->ot_credits = $beginning_balance;
                        $card_view->bal_credits = $balance;
                        $card_view->status = 9;
                    }
                }
                $card_view->userid = $userid;
                $card_view->ot_hours = $ot_hours;
                $card_view->ot_rate = $ot_rate;
                $card_view->ot_date = $ot_date;
                $card_view->remarks = Input:: get('remarks');
                $card_view->save();

            } else { //for deletion
                $check_card_status = CardView::where('id', $row)->first();
                if($check_card_status->status == 0){
                    CardView::where('id', $row)->where('userid', $userid)->update(["status" => 5]);
                }else{
                    CardView::where('id', $row)->where('userid', $userid)->update(["status" => 5, "bal_credits" => $cardcheckstat->bal_credits - $cardcheckstat->ot_credits, "ot_credits" => $cardcheckstat->ot_hours * $cardcheckstat->ot_rate]);
                }
                
                $stat = $cardcheckstat->status;
                if ($stat != null && $stat == 0) {
                } else {
                    $card2 = CardView::where('id', '>', $row)->where('userid', $userid)->get();
                    foreach ($card2 as $card) {
                        if ($card) {
                            $thiscardMonth = date('m', strtotime($card->ot_date));
                            $thiscardYear = date('Y', strtotime($card->ot_date));
                            $id_s = $card->id;

                            $cardView2 = CardView::where('userid', $userid)->where('id', '<', $id_s)->whereMonth('ot_date', '=', $thiscardMonth)
                                ->whereYear('ot_date', '=', $thiscardYear)->whereNotIn('status', [0, 5, 6, 2])->whereIn('status', [1, 11])->get();
                            $totalRef = $cardView2->sum('ot_credits');
                            $prevbal = CardView::where('userid', $userid)->where('id', '<', $card->id)->whereNotNull('bal_credits')->orderBy('id', 'desc')->first();
                            $cprevbal = $prevbal ? ($prevbal->bal_credits !== null ? $prevbal->bal_credits : 0) : 0;

                            if ($card->status == 4) {
                                CardView::where('id', $card->id)->update(["bal_credits" => $cprevbal - $card->hours_used]);
                                InformationPersonal::where('userid', $userid)->update(["bbalance_cto" => $cprevbal - $card->hours_used]);
                            } elseif ($card->status == 3) {
                                CardView::where('id', $card->id)->update(["bal_credits" => $cprevbal + $card->hours_used]);
                                InformationPersonal::where('userid', $userid)->update(["bbalance_cto" => $cprevbal + $card->hours_used]);
                            }elseif ($card->status == 0 || $card->status == 2 || $card->status == 5 || $card->status == 6 ) {
                                CardView::where('id', $card->id)->update(["bal_credits" => $cprevbal]);
                                InformationPersonal::where('userid', $userid)->update(["bbalance_cto" => $cprevbal]);
                            } else {

                                $cred = ($card->ot_rate) * ($card->ot_hours);
                                $totalCheck = $totalRef + $cred; // 48
                                $proBal = $cred + $cprevbal;
                                $forA1 = $totalCheck - 40; // 48 - 40 = 8
                                $forCred = $cred - $forA1; // 24 - 8 = 16
                                if ($cprevbal < 120) {
                                    if ($proBal <= 120) {
                                        if ($totalRef < 40) {
                                            if ($totalCheck <= 40) {
                                                CardView::where('id', $card->id)->update(["bal_credits" => $proBal, "ot_credits" => $cred, "status" => 1]);
                                            } else {
                                                CardView::where('id', $card->id)->update(["bal_credits" => $cprevbal + $forCred, "ot_credits" => $cred, "status" => 11]);
                                            }
                                        } else {
                                            CardView::where('id', $card->id)->update(["status" => 9, "bal_credits" => $cprevbal]);
                                        }
                                    } else {

                                        $check_120 = 120 - $cprevbal; // 114 + 24 = 134 -120 = 14 ; //check 120 - 4 < forcred = 16 = // 120-114 = 6 = 114 + 16 - 130 - 6 =124 //114 + 6
                                        $display = ($forCred>=$check_120)?$check_120 : $forCred; //

                                        if ($totalRef < 40) {
                                            if ($totalCheck <= 40) {
//                                                return $display; //114
                                                CardView::where('id', $card->id)->update(["bal_credits" => $cprevbal + $display, "ot_credits" => $cred, "status" => 1]);
                                                InformationPersonal::where('userid', $userid)->update(["bbalance_cto" => $cprevbal + $display]);
                                            } else {
                                                CardView::where('id', $card->id)->update(["bal_credits" => $cprevbal + $display, "ot_credits" => $cred, "status" => 11]);
                                                InformationPersonal::where('userid', $userid)->update(["bbalance_cto" => $cprevbal + $display]);
                                            }
                                        } else {
                                            CardView::where('id', $card->id)->update(["status" => 9, "bal_credits" => $cprevbal]);
                                        }
                                    }
                                } else {
                                    CardView::where('id', $card->id)->update(["status" => 9, "bal_credits" => $cprevbal]);
                                }
                            }
                        }
                    }
                }
            }
            $lastrow = CardView::where('userid', $userid)->where('bal_credits', '<>', 0)->orderBy('id', 'desc')->first();

            if ($lastrow != null) {
                $overall = $lastrow->bal_credits;
                InformationPersonal::where('userid', $userid)->update(["bbalance_cto" => $overall]);
            }
            return Redirect::back();
        }
    }

    public function cancel_dates(){
        $type = Input::get('cancel_type');
        $cdo_hours = explode(',', Input::get('all_hours'));
        $selected_hours = explode(',', Input::get('cdo_hours'));
        $dates= explode(',', Input::get('dates'));
        $route = Input::get('route');
        $selected = explode(',', Input::get('selected_date'));
        if ($type == "cto"){
            $cancelled = cdo::where('route_no', '=', $route)->first();
            $pis = InformationPersonal::where('userid', $cancelled->prepared_name)->first();
            $applied = CdoAppliedDate::where('cdo_id', $cancelled->id)->get();

            $datelist=[];

            if ($applied) {
                foreach ($applied as $date) {

                    $diff = (strtotime($date->start_date) - strtotime($date->end_date)) / (60 * 60 * 24) ;
                    $diff = -($diff);
                    if ($diff<=1) {
                        $date_2 =date('F j, Y', strtotime($date->start_date));

                        if ($date->cdo_hours == "cdo_am") {
                            $date_2 = date('F j, Y', strtotime($date->start_date)).' (AM)';
                        } elseif ($date->cdo_hours == "cdo_pm") {
                            $date_2 = date('F j, Y', strtotime($date->start_date)).' (PM)';
                        }
                    } else {
                        $date_2 = date('F j, Y', strtotime($date->start_date)). ' - ' . date('F j, Y', strtotime('-1 day', strtotime($date->end_date)));
                        if ($date->cdo_hours == "cdo_am") {
                            $date_2 = date('F j, Y', strtotime($date->start_date)). ' - ' . date('F j, Y', strtotime('-1 day', strtotime($date->end_date))).' (AM)';
                        } elseif ($date->cdo_hours == "cdo_pm") {
                            $date_2 = date('F j, Y', strtotime($date->start_date)). ' - ' . date('F j, Y', strtotime('-1 day', strtotime($date->end_date))).' (PM) ';
                        }
                    }
                    $datelist[] = $date_2;
                }
            }

            $datelist= implode('$', $datelist);
            $dateUsedJSON = str_replace(['[', ']', '"'], '',json_encode($datelist));

            if(in_array("cancel_all", $selected)){
                $cancelled->status= 3;
                $cancelled->save();
                $card = new CardView();
                $card->userid = $cancelled->prepared_name;
                $card->hours_used = $cancelled->less_applied_for;
                $card->date_used = $dateUsedJSON;
                $card->bal_credits = $pis->bbalance_cto + $cancelled->less_applied_for;
                $card->status= 3;
                $pis->bbalance_cto = $pis->bbalance_cto + $cancelled->less_applied_for;
                $pis->save();
                $card->save();
            }else{
                if($cancelled){
                    foreach ($applied as $apply){
                        $apply->delete();
                    }
                    $date_list = array_map('trim', $dates);
                    $date_time = array_map('trim', $cdo_hours);
                    $selected = array_map('trim', $selected);
                    $selected_hours = array_map('trim', $selected_hours);

                    foreach ($date_list as $index=> $date){

                        $timestamp = strtotime($date);
                        $new_applied = new CdoAppliedDate();
                        $date_here = [];

                        if(in_array($date, $selected)){
                            $f = array_search($date, $selected);
                            $card = new CardView();
                            $card->userid = $cancelled->prepared_name;
                            $card->status = 3;
                            if($selected_hours[$f] == $cdo_hours[$index]){
                                $new_applied->cdo_hours = $date_time[$index];
                                $new_applied->status = 1;
                                if($selected_hours[$f] == "cdo_wholeday"){
                                    $cancelled->less_applied_for = $cancelled->less_applied_for - 8;
                                    $pis->bbalance_cto = $pis->bbalance_cto + 8;
                                    $card->hours_used = 8;
                                    $card->date_used = date('F j, Y', strtotime($date));
                                }else{
                                    $card->hours_used = 4;
                                    $card->bal_credits = $pis->bbalance_cto + 4;
                                    if($selected_hours[$f] == "cdo_am"){
                                        $card->date_used = date('F j, Y', strtotime($date)).' (AM)';
                                    }else{
                                        $card->date_used = date('F j, Y', strtotime($date)).' (PM)';
                                    }
                                    $cancelled->less_applied_for = $cancelled->less_applied_for - 4;
                                    $pis->bbalance_cto = $pis->bbalance_cto + 4;
                                }
                            }else{
                                $cancelled->less_applied_for = $cancelled->less_applied_for - 4;
                                $pis->bbalance_cto = $pis->bbalance_cto + 4;
                                $new_applied->status = 11;
                                $date_here[]=$date_list[$index];
                                if($selected_hours[$f] == "cdo_wholeday"){
                                    $card->date_used = date('F j, Y', strtotime($date)).' (Wholeday)';
                                    $card->hours_used = 8;
                                }else{
                                    $card->hours_used = 4;
                                    if ($selected_hours[$f] == "cdo_am" && $date_time[$index] == "cdo_wholeday"){
                                        $card->date_used = date('F j, Y', strtotime($date)).' (AM)';
                                        $new_applied->cdo_hours = "cdo_pm";
                                    }else if($selected_hours[$f] == "cdo_pm" && $date_time[$index] == "cdo_wholeday"){
                                        $card->date_used = date('F j, Y', strtotime($date)).' (PM)';
                                        $new_applied->cdo_hours = "cdo_am";
                                    }
                                }
                            }
                            $pis->save();
                            $card->bal_credits = $pis->bbalance_cto;
                            $card->save();
                        }else{
                            $date_here[]=$date_list[$index];
                            $new_applied->cdo_hours = $date_time[$index];
                        }
                        $new_applied->start_date = date('Y-m-d', $timestamp);
                        $new_applied->end_date = date('Y-m-d', strtotime('+1 Day', $timestamp));
                        $new_applied->cdo_id = $cancelled->id;
                        $new_applied->save();
                        $cancelled->save();
                    }
                }
            }
        }else{
            $leave = Leave::where('route_no', $route)->first();
            $leave->status = 1;
            $leave->save();
            $leave_dates = LeaveAppliedDates::where('leave_id', $leave->id)->get();
            $pis2 = InformationPersonal::where('userid', $leave->userid)->first();

            $dateList = [];
            if($leave_dates){
                foreach ($leave_dates as $date){
                    if ($date->startdate == $date->enddate){
                        $dateList[] = date('F j, Y', strtotime($date->startdate));
                    }else{
                        $dateList[] = date('F j, Y', strtotime($date->startdate)).' - '. date('F j, Y', strtotime($date->startdate));
                    }
                }
            }
            $dateList = implode(',', $dateList);

            if(in_array("cancel_all", $selected)){
                $leave->status= "CANCELLED";
                $leave->save();
                $card = new LeaveCardView();
                $card->leave_id = $leave->id;
                $card->userid = $leave->userid;
                $card->particulars = $leave->leave_type;
                if($leave->approved_for == 1){
                    $card->vl_abswp = $leave->applied_num_days;
                }else{
                    $card->vl_abswop = $leave->applied_num_days;
                }
                $card->vl_bal = $pis2->vacation_balance + $leave->applied_num_days;
                $card->date_used = str_replace(['[', ']', '"'], '', json_encode($dateList));
                $pis2->vacation_balance = $pis2->vacation_balance + $leave->applied_num_days;
                $pis2->save();
                $card->save();
            }else{
                foreach ($leave_dates as $apply){
                    $apply->delete();
                }
                $date_list = array_map('trim', $dates);
                $selected = array_map('trim', $selected);

                foreach ($date_list as $index=> $date){

                    $timestamp = strtotime($date);
                    $new_applied = new LeaveAppliedDates();

                    if(in_array($date, $selected)){
                        $card = new LeaveCardView();
                        $card->userid = $leave->userid;
                        $new_applied->status = 1;
                        $pis2->vacation_balance = $pis2->vacation_balance + $leave->applied_num_days;
                        $pis2->save();
                        $card->vl_bal = $pis2->vacation_balance;
                        $card->save();
                    }
                    $new_applied->startdate = date('Y-m-d', $timestamp);
                    $new_applied->enddate = date('Y-m-d', $timestamp);
                    $new_applied->leave_id = $leave->id;
                    $new_applied->save();
                    $leave->save();
                }
            }
        }

        return Redirect::back();
    }

    public function superviseEmployee(){
        $prev_supervise = PrivilegeEmployee::where('supervisor_id','=',Input::get('supervisor_id'));
        if(count((array)$prev_supervise) >= 1)
            $prev_supervise->delete();
        $foruser_id= Auth::user()->fname;
        if(Input::get('privilege_employee')){
            foreach(Input::get('privilege_employee') as $row){
                $privilege_employee = new PrivilegeEmployee();
                $privilege_employee->supervisor_id = Input::get('supervisor_id');
                $privilege_employee->userid = $row;
                $privilege_employee->status = 0;
                $privilege_employee->save();
            }
        }
        Session::put("privilegeAdd",true);
        return Redirect::back();
    }
    public function superviseList(){
        $supervised_employee = [];
        foreach(PrivilegeEmployee::where('status', '=', '0')->get(['userid']) as $row){
            $supervised_employee[] = $row->userid;
        }
        return View::make('cdo.employee_select',[
            'supervised_employee' => json_encode($supervised_employee)
        ]);
    }
}
