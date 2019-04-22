<?php

class TimeLogController extends Controller
{
    public function filterTimeLog(){
        Session::put("filter_dates",Input::get('filter_dates'));
        $userid = Auth::user()->userid;
        $filter_date = explode(' - ',Input::get("filter_dates"));
        $date_from = date("Y-m-d",strtotime($filter_date[0]));
        $date_to = (string)date("Y-m-d",strtotime($filter_date[1]));

        return DB::connection('mysql')->select("call getLogs2('$userid','$date_from','$date_to')");
    }

    public function timeLog(){
        return View::make("timelog.timelog");
    }
}