<?php

class TimeLogController extends Controller
{
    public function timeLog(){
        $timeLog = '';
        if(Request::method() == 'POST'){
            Session::put("filter_dates",Input::get('filter_dates'));
            $userid = Auth::user()->userid;
            $filter_date = explode(' - ',Input::get("filter_dates"));
            $date_from = date("Y-m-d",strtotime($filter_date[0]));
            $date_to = (string)date("Y-m-d",strtotime($filter_date[1]));
            $timeLog = DB::connection('mysql')->select("call getLogs2('$userid','$date_from','$date_to')");
        }
        return View::make("timelog.timelog",[
            "timeLog" => $timeLog
        ]);
    }

}