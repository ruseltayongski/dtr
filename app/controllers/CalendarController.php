<?php

class CalendarController extends BaseController
{
    public function __construct()
    {
        //$this->beforeFilter('auth');
    }

    public function calendar()
    {
        //return \DB::connection('mysql')->select("call calendar(0454)");
        return View::make('calendar.calendar');
    }

    public function calendar_holiday()
    {
        if(Auth::user()->usertype){
            return Calendars::where("status","=",1)->get();
        } else {
            $userid = Auth::user()->userid;
            return \DB::connection('mysql')->select("call calendar($userid)");
        }

    }

    public function calendarEvent($userid){
        $event = \DB::connection('mysql')->select("call calendar_mobile($userid)");
        foreach($event as $row){

            $period = new DatePeriod(
                new DateTime($row->start),
                new DateInterval('P1D'),
                new DateTime($row->end."+1 day")
            );

            foreach ($period as $key => $value) {
                $data[$value->format('Y-m-d')]["events"][] = $row;
            }

        }

        $count = 0;
        foreach($data as $row){
            $result[] = [
                "dates" => array_keys($data)[$count],
                "events" => $row["events"]
            ];
            $count++;
        }

        return $result;
    }

    public function calendar_delete($event_id){
        if(Auth::user()->usertype == "0")
        {
            return;
        }
        $calendar = Calendars::where('event_id',$event_id)->first();
        $details = EditedLogs::where('holiday','=', 'B')
            ->whereBetween('datein',array($calendar->start,$calendar->end));
        $details->delete();
        $calendar->delete();
    }

    public function calendar_mobile_save(){
        $calendar = new Calendars();
        $calendar->event_id = Input::get('event_id');
        $calendar->title = Input::get('title');
        $calendar->start = Input::get('start');

        $enddate = date_create(date('Y-m-d',strtotime(Input::get('end'))));
        date_add($enddate, date_interval_create_from_date_string('1days'));
        $end_date = date_format($enddate, 'Y-m-d');

        $calendar->end = $end_date;
        $calendar->status = 6;
        $calendar->type = 6;
        $calendar->save();
    }

    public function AddIndividualTask(){
        try{
            $json_object = json_decode(Input::get('data'), true);

            $userid = $json_object['userid'];
            $title = $json_object['title'];
            $start = $json_object['start'];
            $end = $json_object['end'];
            $status = $json_object['status'];

            $pdo = DB::connection()->getPdo();

            $query1 = "INSERT IGNORE INTO calendar(userid, title, start, end, status, created_at, updated_at) VALUES";
            $query1 .= "('" . $userid . "','" . $title . "','" . $start . "','" . $end . "','" . $status . "',NOW(),NOW() )";

            $st = $pdo->prepare($query1);
            $st->execute();

            return "Successfully added";
        } catch (Exception $e){
            return $e->getMessage();
        }
    }

    public function DeleteIndividualTask(){
        $calendar_id = Input::get("calendar_id");
        Calendars::where('id',$calendar_id)->first()->delete();
        return "Successfully deleted";
    }

    public function calendar_save(){
        try
        {
            $calendar = new Calendars();
            $calendar->event_id = Input::get('event_id');
            $calendar->title = Input::get('title');
            $calendar->start = Input::get('start');

            $enddate = date_create(date('Y-m-d',strtotime(Input::get('end'))));
            date_add($enddate, date_interval_create_from_date_string('1days'));
            $end_date = date_format($enddate, 'Y-m-d');

            $calendar->end = $end_date;
            $calendar->backgroundColor = Input::get('backgroundColor');
            $calendar->borderColor = Input::get('borderColor');
            $calendar->status = Input::get('status');
            $calendar->type = 1;
            $calendar->save();

            $from = date('Y-m-d',strtotime(Input::get('start')));
            $end_date = date('Y-m-d',(strtotime (Input::get('end')) ) );

            $f = new DateTime($from.' '. '24:00:00');
            $t = new DateTime($end_date.' '. '24:00:00');

            $interval = $f->diff($t);

            $datein = '';
            $f_from = explode('-',$from);
            $startday = $f_from[2];
            $j = 0;
            while($j <= $interval->days) {

                $datein = $f_from[0].'-'.$f_from[1] .'-'. $startday;

                $details = new EditedLogs();
                $details->userid = '001';
                $details->datein = $datein;
                $details->time = '08:00:00';
                $details->event = 'IN';
                $details->remark = 'HOLIDAY';
                $details->edited = '1';
                $details->holiday = "B";
                
                $details->save();

                $details = new EditedLogs();
                $details->userid = '001';
                $details->datein = $datein;
                $details->time = '12:00:00';
                $details->event = 'OUT';
                $details->remark = 'HOLIDAY';
                $details->edited = '1';
                $details->holiday = "B";

                $details->save();

                $details = new EditedLogs();
                $details->userid = '001';
                $details->datein = $datein;
                $details->time = '13:00:00';
                $details->event = 'IN';
                $details->remark = 'HOLIDAY';
                $details->edited = '1';
                $details->holiday = "B";

                $details->save();

                $details = new EditedLogs();
                $details->userid = '001';
                $details->datein = $datein;
                $details->time = '18:00:00';
                $details->event = 'OUT';
                $details->remark = 'HOLIDAY';
                $details->edited = '1';
                $details->holiday = "B";

                $details->save();

                $startday = $startday + 1;
                $j++;
            }
        }catch(\Whoops\Exception\ErrorException $ex)
        {
            return json_encode(array('ok' => false));
        }

        return json_encode(array('ok' => true));
    }

    public function calendar_update()
    {
        if(!Auth::user()->usertype) {
            return;
        }

        ///RUSEL
        $start_date = Input::get('start');
        $calendar = Calendars::where('event_id',Input::get('event_id'))->first();
        $difference = strtotime($calendar->end) - strtotime($calendar->start);
        $day_range = floor($difference / (60 * 60 * 24));
        $end = date_create($start_date);
        date_add($end, date_interval_create_from_date_string($day_range.'days'));
        $end_date = date_format($end, 'Y-m-d');
        ///END RUSEL

        $details = EditedLogs::where('holiday','=', 'B')
            ->whereBetween('datein',array($calendar->start,$calendar->end));
        $details->delete();

        if(Input::get('type') == 'drop') {

            //RUSEL
            $calendar = Calendars::where('event_id',Input::get('event_id'))->first();
            $calendar->start = $start_date;
            $calendar->end = $end_date;
            $calendar->type = 1;
            $calendar->save();
            //END RUSEL


            $end_date = date('Y-m-d',(strtotime ( '-1 day' , strtotime ($end_date) ) ));

            $f = new DateTime($start_date.' '. '00:00:00');
            $t = new DateTime($end_date.' '. '00:00:00');

            $interval = $f->diff($t);

            $datein = '';
            $f_from = explode('-',$start_date);
            $startday = $f_from[2];
            $j = 0;
            while($j <= $interval->days) {

                $datein = $f_from[0].'-'.$f_from[1] .'-'. $startday;

                $details = new EditedLogs();
                $details->userid = '001';
                $details->datein = $datein;
                $details->time = '08:00:00';
                $details->event = 'IN';
                $details->remark = 'HOLIDAY';
                $details->edited = '1';
                $details->holiday = "B";
                
                $details->save();

                $details = new EditedLogs();
                $details->userid = '001';
                $details->datein = $datein;
                $details->time = '12:00:00';
                $details->event = 'OUT';
                $details->remark = 'HOLIDAY';
                $details->edited = '1';
                $details->holiday = "B";

                $details->save();

                $details = new EditedLogs();
                $details->userid = '001';
                $details->datein = $datein;
                $details->time = '13:00:00';
                $details->event = 'IN';
                $details->remark = 'HOLIDAY';
                $details->edited = '1';
                $details->holiday = "B";

                $details->save();

                $details = new EditedLogs();
                $details->userid = '001';
                $details->datein = $datein;
                $details->time = '18:00:00';
                $details->event = 'OUT';
                $details->remark = 'HOLIDAY';
                $details->edited = '1';
                $details->holiday = "B";

                $details->save();

                $startday = $startday + 1;
                $j++;
            }


        }
        else
            try{
                //RUSEL
                $calendar = Calendars::where('event_id',Input::get('event_id'))->first();
                $calendar->end = Input::get('end');
                $calendar->type = 1;
                $calendar->save();
                //END RUSEL

                $end_date = date('Y-m-d',(strtotime ( '-1 day' , strtotime (Input::get('end')) ) ));

                $f = new DateTime($calendar->start.' '. '00:00:00');
                $t = new DateTime($end_date.' '. '00:00:00');

                $interval = $f->diff($t);

                $datein = '';
                $f_from = explode('-',$calendar->start);
                $startday = $f_from[2];
                $j = 0;
                while($j <= $interval->days) {

                    $datein = $f_from[0].'-'.$f_from[1] .'-'. $startday;

                    $details = new EditedLogs();
                $details->userid = '001';
                $details->datein = $datein;
                $details->time = '08:00:00';
                $details->event = 'IN';
                $details->remark = 'HOLIDAY';
                $details->edited = '1';
                $details->holiday = "B";
                
                $details->save();

                $details = new EditedLogs();
                $details->userid = '001';
                $details->datein = $datein;
                $details->time = '12:00:00';
                $details->event = 'OUT';
                $details->remark = 'HOLIDAY';
                $details->edited = '1';
                $details->holiday = "B";

                $details->save();

                $details = new EditedLogs();
                $details->userid = '001';
                $details->datein = $datein;
                $details->time = '13:00:00';
                $details->event = 'IN';
                $details->remark = 'HOLIDAY';
                $details->edited = '1';
                $details->holiday = "B";

                $details->save();

                $details = new EditedLogs();
                $details->userid = '001';
                $details->datein = $datein;
                $details->time = '18:00:00';
                $details->event = 'OUT';
                $details->remark = 'HOLIDAY';
                $details->edited = '1';
                $details->holiday = "B";

                $details->save();

                    $startday = $startday + 1;
                    $j++;
                }

            }catch(\Whoops\Exception\ErrorException $ex)
            {
                return json_encode(array('ok', false));
            }
        return  json_encode(array('ok', true));
    }

    public function getDatesFromRange($start, $end, $format = 'F d, Y') {
        $full_date = [];
        $count_holiday_days = 0;
        $interval = new DateInterval('P1D');

        $realEnd = new DateTime($end);
        $realEnd->add($interval);

        $period = new DatePeriod(new DateTime($start), $interval, $realEnd);

        foreach($period as $date) {
            if($date->format('l') != "Saturday" && $date->format('l') != "Sunday"){
                $count_holiday_days++;
                $full_date[] = $date->format($format);
            }
        }

        return $full_date;
    }

    public function trackHoliday(){
        $start_date = date("Y-m-d",strtotime(Input::get('start_date')));
        $end_date = date("Y-m-d",strtotime(Input::get('end_date')));

        $calendar = Calendars::where("start",">=",$start_date)->where("start","<",$end_date)->where("status","1")->get();
        $holiday = [];
        foreach($calendar as $row){
            $query_end = date('Y-m-d',(strtotime ( '-1 day' , strtotime ( $row->end) ) ));
            if($end_date <= $query_end)
                $set_end = $end_date;
            else
                $set_end = $query_end;

            foreach($this->getDatesFromRange($row->start, $set_end) as $full_date){
                $holiday[] = $full_date;
            }
        }

        return $holiday;
    }

}