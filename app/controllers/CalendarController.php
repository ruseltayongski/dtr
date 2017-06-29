<?php

class CalendarController extends BaseController
{
    public function __construct()
    {
        $this->beforeFilter('auth');
    }

    public function calendar()
    {

        return View::make('calendar.calendar');
    }

    public function calendar_holiday()
    {
        return Calendars::where('status','=',1)->get();
    }

    public function calendar_delete($event_id){
        if(Auth::user()->usertype == "0")
        {
            return;
        }
        $calendar = Calendars::where('event_id',$event_id)->first();
        $details = DtrDetails::where('holiday','=', '001')
            ->whereBetween('datein',array($calendar->start,$calendar->end));
        $details->delete();
        $calendar->delete();
    }

    public function calendar_save(){
        if(Auth::user()->usertype == "0")
        {
            return;
        }
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
            $calendar->status = 1;
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

                $details = new DtrDetails();
                $details->userid = '001';
                $details->datein = $datein;
                $details->time = '08:00:00';
                $details->event = 'IN';
                $details->remark = Input::get('title');
                $details->edited = '1';
                $details->holiday = '001';

                $details->save();

                $details = new DtrDetails();
                $details->userid = '001';
                $details->datein = $datein;
                $details->time = '12:00:00';
                $details->event = 'OUT';
                $details->remark = Input::get('title');
                $details->edited = '1';
                $details->holiday = '001';

                $details->save();

                $details = new DtrDetails();
                $details->userid = '001';
                $details->datein = $datein;
                $details->time = '13:00:00';
                $details->event = 'IN';
                $details->remark = Input::get('title');
                $details->edited = '1';
                $details->holiday = '001';

                $details->save();

                $details = new DtrDetails();
                $details->userid = '001';
                $details->datein = $datein;
                $details->time = '18:00:00';
                $details->event = 'OUT';
                $details->remark = Input::get('title');
                $details->edited = '1';
                $details->holiday = '001';

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

        $details = DtrDetails::where('holiday','=', '001')
            ->whereBetween('datein',array($calendar->start,$calendar->end));
        $details->delete();

        if(Input::get('type') == 'drop') {

            //RUSEL
            $calendar = Calendars::where('event_id',Input::get('event_id'))->first();
            $calendar->start = $start_date;
            $calendar->end = $end_date;
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

                $details = new DtrDetails();
                $details->userid = '001';
                $details->datein = $datein;
                $details->time = '08:00:00';
                $details->event = 'IN';
                $details->remark = $calendar->title;
                $details->edited = '1';
                $details->holiday = '001';

                $details->save();

                $details = new DtrDetails();
                $details->userid = '001';

                $details->datein = $datein;
                $details->time = '12:00:00';
                $details->event = 'OUT';
                $details->remark = $calendar->title;
                $details->edited = '1';
                $details->holiday = '001';

                $details->save();

                $details = new DtrDetails();
                $details->userid = '001';

                $details->datein = $datein;
                $details->time = '13:00:00';
                $details->event = 'IN';
                $details->remark = $calendar->title;
                $details->edited = '1';
                $details->holiday = '001';

                $details->save();

                $details = new DtrDetails();
                $details->userid = '001';

                $details->datein = $datein;
                $details->time = '18:00:00';
                $details->event = 'OUT';
                $details->remark = $calendar->title;
                $details->edited = '1';
                $details->holiday = '001';

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

                    $details = new DtrDetails();
                    $details->userid = '001';
                    $details->datein = $datein;
                    $details->time = '08:00:00';
                    $details->event = 'IN';
                    $details->remark = $calendar->title;
                    $details->edited = '1';
                    $details->holiday = '001';

                    $details->save();

                    $details = new DtrDetails();
                    $details->userid = '001';

                    $details->datein = $datein;
                    $details->time = '12:00:00';
                    $details->event = 'OUT';
                    $details->remark = $calendar->title;
                    $details->edited = '1';
                    $details->holiday = '001';

                    $details->save();

                    $details = new DtrDetails();
                    $details->userid = '001';

                    $details->datein = $datein;
                    $details->time = '13:00:00';
                    $details->event = 'IN';
                    $details->remark = $calendar->title;
                    $details->edited = '1';
                    $details->holiday = '001';

                    $details->save();

                    $details = new DtrDetails();
                    $details->userid = '001';

                    $details->datein = $datein;
                    $details->time = '18:00:00';
                    $details->event = 'OUT';
                    $details->remark = $calendar->title;
                    $details->edited = '1';
                    $details->holiday = '001';

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

}