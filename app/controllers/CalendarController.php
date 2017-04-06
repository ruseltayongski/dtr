<?php


class CalendarController extends BaseController
{
    public function __construct()
    {
        $this->beforeFilter(function () {
            if(!Auth::check())
            {
                return Redirect::to('/');
            }
        });
    }

    public function calendar()
    {
        return View::make('calendar.calendar');
    }

    public function calendar_event()
    {
        return Calendar::all();
    }
}