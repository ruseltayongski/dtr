<?php

class SupervisorController extends Controller
{
    public function superviseEmployee(){
        $prev_supervise = SuperviseEmployee::where('supervisor_id','=',Input::get('supervisor_id'));
        if(count((array)$prev_supervise) >= 1)
            $prev_supervise->delete();
//        return Input::get('supervise_employee');
        if(Input::get('supervise_employee')){
            foreach(Input::get('supervise_employee') as $row){
                $supervise_employee = new SuperviseEmployee();
                $supervise_employee->supervisor_id = Input::get('supervisor_id');
                $supervise_employee->userid = $row;
                $supervise_employee->save();
            }
        }

        Session::put("superviseAdd",true);
        return Redirect::back();
    }
    public function superviseList(){
        $supervised_employee = [];
        foreach(SuperviseEmployee::where('supervisor_id',Input::get('supervisor_id'))->get(['userid']) as $row){
            $supervised_employee[] = $row->userid;
        }
        return View::make('roles.supervised_select',[
            'supervised_employee' => json_encode($supervised_employee)
        ]);
    }
    public function superviseIndividual(){
        Session::put('supervise_id',Input::get('supervise_id'));
        return Redirect::to('logs/timelogs/supervisor');
    }
    public function location(){
        $keyword = Input::get('search');

        $supervise_employee = SuperviseEmployee::
                            select(
                                DB::raw("concat(coalesce(users.lname,' '),', ',coalesce(users.fname,' '),' ',coalesce(users.mname,' ')) as name"),
                                'users.userid',
                                'personal_information.job_status',
                                DB::raw("coalesce(designation.description,'NO DESIGNATION') as designation"),
                                DB::raw("coalesce(division.description,'NO DIVISION') as division"),
                                DB::raw("coalesce(section.description,'NO SECTION') as section")
                            )
                            ->where(function($q) use ($keyword){
                                $q->where('users.fname','like',"%$keyword%")
                                    ->orWhere('users.lname','like',"%$keyword%")
                                    ->orWhere('users.userid','like',"%$keyword%");
                            })
                            ->leftJoin("users",'users.userid','=','supervise_employee.userid')
                            ->leftJoin("pis.personal_information",'personal_information.userid','=','supervise_employee.userid')
                            ->leftJoin("dts.designation",'designation.id','=','personal_information.designation_id')
                            ->leftJoin("dts.division",'division.id','=','personal_information.division_id')
                            ->leftJoin("dts.section","section.id","=",'personal_information.section_id')
                            ->where('supervise_employee.supervisor_id','=',Auth::user()->userid)
                            ->orderBy('users.lname','ASC')
                            ->paginate(15);
        return View::make('roles.location',[
            'supervise_employee' => $supervise_employee,
            'search' => $keyword
        ]);
    }

    public function Report(){
        return View::make('roles.report');
    }

}