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
        Calendars::where('event_id',$event_id)->delete();
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

            $from = date('Y-m-d',strtotime(Input::get('start')));
            $end_date = date('Y-m-d',(strtotime (Input::get('end')) ) );



            $calendar->end = $end_date;
            $calendar->backgroundColor = Input::get('backgroundColor');
            $calendar->borderColor = Input::get('borderColor');
            $calendar->status = 1;
            $calendar->save();

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
                $details->event = 'IN';
                $details->remark = $calendar->title;
                $details->edited = '0';
                $details->holiday = '001';

                $details->save();

                $details = new DtrDetails();
                $details->userid = '001';

                $details->datein = $datein;

                $details->event = 'OUT';
                $details->remark = $calendar->title;
                $details->edited = '0';
                $details->holiday = '001';

                $details->save();

                $details = new DtrDetails();
                $details->userid = '001';

                $details->datein = $datein;

                $details->event = 'IN';
                $details->remark = $calendar->title;
                $details->edited = '0';
                $details->holiday = '001';

                $details->save();

                $details = new DtrDetails();
                $details->userid = '001';

                $details->datein = $datein;

                $details->event = 'OUT';
                $details->remark = $calendar->title;
                $details->edited = '0';
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
        if(Auth::user()->usertype == "0")
        {
            return;
        }
        $request_start = Input::get('start');
        $calendar = Calendars::where('event_id',Input::get('event_id'))->first();


        if(Input::get('type') == 'drop') {

            return Input::all();

        }
        else
            try{

                $start_date = date('Y-m-d',strtotime (Input::get('start')));
                $calendar_end_date = date('Y-m-d',strtotime (Input::get('end')));
                $end_date = date('Y-m-d',(strtotime ( '-1 day' , strtotime (Input::get('end')) ) ));


                $calendar = Calendars::where('event_id',Input::get('event_id'))->first();

                $ca_from = $calendar->start;

                $ca_to = date('Y-m-d',(strtotime ( '-1 day' , strtotime ($calendar->end))));

                $calendar->start = $start_date;
                $calendar->end = $calendar_end_date;
                $calendar->save();



                $details = DtrDetails::where('holiday','=', '001')
                    ->whereBetween('datein',[$ca_from,$ca_to]);
                $details->delete();



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

            }catch(\Whoops\Exception\ErrorException $ex)
            {
                return json_encode(array('ok', false));
            }
        return  json_encode(array('ok', true));
    }

}