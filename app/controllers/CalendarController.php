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
        Calendars::where('event_id',$event_id)->delete();
    }

    public function calendar_save(){

        $calendar = new Calendars();
        $calendar->event_id = Input::get('event_id');
        $calendar->title = Input::get('title');
        $calendar->start = Input::get('start');

        $from = date('Y-m-d',strtotime(Input::get('start')));
        $to =  date('Y-m-d',strtotime(Input::get('end')));

        $end_date = date('Y-m-d',(strtotime (Input::get('end')) ) );
        //$enddate = date_create(date('Y-m-d',strtotime(Input::get('end'))));
        //date_add($enddate, date_interval_create_from_date_string('1days'));
        //$end_date = date_format($enddate, 'Y-m-d');

        return $end_date;
        $calendar->end = $end_date;
        $calendar->backgroundColor = Input::get('backgroundColor');
        $calendar->borderColor = Input::get('borderColor');
        $calendar->status = 1;
        $calendar->save();

        return Input::all();
        $f = new DateTime($from.' '. '24:00:00');
        $t = new DateTime($to.' '. '24:00:00');


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
            $details->remark = $calendar->title;
            $details->edited = '0';
            $details->holiday = '001';

            $details->save();

            $details = new DtrDetails();
            $details->userid = '001';

            $details->datein = $datein;
            $details->time = '12:00:00';
            $details->event = 'OUT';
            $details->remark = $calendar->title;
            $details->edited = '0';
            $details->holiday = '001';

            $details->save();

            $details = new DtrDetails();
            $details->userid = '001';

            $details->datein = $datein;
            $details->time = '13:00:00';
            $details->event = 'IN';
            $details->remark = $calendar->title;
            $details->edited = '0';
            $details->holiday = '001';

            $details->save();

            $details = new DtrDetails();
            $details->userid = '001';

            $details->datein = $datein;
            $details->time = '18:00:00';
            $details->event = 'OUT';
            $details->remark = $calendar->title;
            $details->edited = '0';
            $details->holiday = '001';

            $details->save();

            $startday = $startday + 1;
            $j++;
        }

    }

    public function calendar_update()
    {
        return Input::all();
        $request_start = Input::get('start');
        $calendar = Calendars::where('event_id',Input::get('event_id'))->first();
        $difference = strtotime($calendar->end) - strtotime($calendar->start);
        $day_range = floor($difference / (60 * 60 * 24));
        $end = date_create($request_start);
        date_add($end, date_interval_create_from_date_string($day_range.'days'));
        $day_end = date_format($end, 'Y-m-d');
        if(Input::get('type') == 'drop') {
            return Calendars::where('event_id', Input::get('event_id'))
                ->update(['start' => $request_start,'end' => $day_end]);
        }
        else
            return Calendars::where('event_id',Input::get('event_id'))
                ->update(['end' => Input::get('end')]);
    }

}