<?php
/**
 * Created by PhpStorm.
 * User: Lourence
 * Date: 1/10/2017
 * Time: 4:40 PM
 */


class HoursController extends BaseController
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

    public function create()
    {
        $hours = WorkScheds::paginate(10);
        return View::make('hour.worksched')->with('hours',$hours);
    }

    public function work_schedule() {

        if(Request::method() == 'GET') {
            return View::make('hour.form-hour');
        }
        if(Request::method() == 'POST') {

            $work_sched = new WorkScheds();
            $work_sched->description = Input::get('description');
            $work_sched->am_in = Input::get('am_in');
            $work_sched->am_out = Input::get('am_out');
            $work_sched->pm_in = Input::get('pm_in');
            $work_sched->pm_out = Input::get('pm_out');
            $work_sched->save();
            return Redirect::to('work-schedule')->with('new_hour','New working schedule created.');
        }
    }
    public function edit_schedule($id)
    {
        if(Request::method() == 'GET'){
            $sched = WorkScheds::where('id',$id)->first();
            return View::make('hour.update_hour')->with('sched',$sched);
        }
        if(Request::method() == 'POST') {
            $sched = WorkScheds::where('id',$id)->first();
            if(isset($sched) and count($sched) > 0) {
                $sched->description = Input::get('description');
                $sched->am_in = Input::get('am_in');
                $sched->am_out = Input::get('am_out');
                $sched->pm_in = Input::get('pm_in');
                $sched->pm_out = Input::get('pm_out');
                $sched->save();
                return Redirect::to('work-schedule')->with('new_hour','Working schedule successfully updated.');
            } else {
                return Redirect::to('work-schedule');
            }
        }
    }
}