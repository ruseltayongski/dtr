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

        $enddate = date_create(date('Y-m-d',strtotime(Input::get('end'))));
        date_add($enddate, date_interval_create_from_date_string('1days'));
        $end_date = date_format($enddate, 'Y-m-d');

        $calendar->end = $end_date;
        $calendar->backgroundColor = Input::get('backgroundColor');
        $calendar->borderColor = Input::get('borderColor');
        $calendar->status = 1;
        $calendar->save();
    }

    public function calendar_update(Request $request)
    {
        $request_start = Input::get('start');
        $calendar = Calendars::where('event_id',Input::get('event_id'))->first();
        $difference = strtotime($calendar->end) - strtotime($calendar->start);
        $day_range = floor($difference / (60 * 60 * 24));
        $end = date_create($request_start);
        date_add($end, date_interval_create_from_date_string($day_range.'days'));
        $day_end = date_format($end, 'Y-m-d');
        if($request->get('type') == 'drop') {
            return Calendar::where('event_id', Input::get('event_id'))
                ->update(['start' => $request_start,'end' => $day_end]);
        }
        else
            return Calendar::where('event_id',Input::get('event_id'))
                ->update(['end' => Input::get('end')]);
    }

}