<?php


class CalendarController extends BaseController
{
    public function __construct()
    {

    }

    public function calendar()
    {
        return view('calendar.calendar');
    }

    public function calendar_event()
    {
        return Calendar::all();
    }
}