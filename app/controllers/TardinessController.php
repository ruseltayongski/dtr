<?php

class TardinessController extends Controller
{
    public function __construct()
    {

    }

    public function tardiness()
    {
        return View::make("tardiness.tardiness_form");
    }

    public function tardiness_count(){
        $employee = Users::join("pis.personal_information","personal_information.userid","=","users.userid")
                    ->get();
        return View::make("tardiness.tardiness_count",["employee" => $employee]);
    }

    public function tardiness_report()
    {
        return Redirect::to('tardiness_count');
    }

    public function tardiness_generate(){

        $personal_information = InformationPersonal::
            leftJoin("dohdtr.work_sched","work_sched.id","=","personal_information.sched")
            ->where("personal_information.userid","!=","admin")
            ->where("personal_information.sched","!="," ")
            ->orderBy("personal_information.id")
            ->get([
                "personal_information.userid",
                "personal_information.fname",
                "personal_information.mname",
                "personal_information.lname",
                "personal_information.designation_id",
                "personal_information.division_id",
                "personal_information.section_id",
                "personal_information.job_status",
                "work_sched.am_in",
                "work_sched.pm_in",
            ]);

        foreach($personal_information as $pi ){
            $countdays = 0;
            $am_final_am = 0;
            $am_final_pm = 0;
            for($day=1; $day<=31; $day++ ){
                $countdays_flag = true;
                $datein = date('Y-m-d',strtotime(Input::get('year').'-'.Input::get('month').'-'.$day));


                $first_am = DB::table('edited_logs')
                    ->select('time')
                    ->where("userid","=",$pi->userid)
                    ->where("datein","=",$datein)
                    ->where("event","=","in")
                    ->where("time","<","12:00:00");

                $second_am = DB::table('dtr_file')
                    ->select('time')
                    ->where("userid","=",$pi->userid)
                    ->where("datein","=",$datein)
                    ->where("event","=","in")
                    ->where("time","<","12:00:00");

                $dtr_all_am = $first_am->union($second_am)->orderby('time','asc')->first();

                if($dtr_all_am) {
                    if($dtr_all_am->time > substr_replace(substr_replace($pi->am_in, "5", 6,1),"9",7,1)){
                        $work_sched1_am = strtotime(substr_replace(substr_replace($pi->am_in, "5", 6,1),"9",7,1));
                        $work_sched2_am = strtotime($dtr_all_am->time);
                        $am_get_am = round(abs($work_sched1_am - $work_sched2_am) / 60,2);
                        $am_final_am += $am_get_am;
                        $countdays++;
                        $countdays_flag = false;
                    }
                }

                $first_pm = DB::table('edited_logs')
                    ->select('time')
                    ->where("userid","=",$pi->userid)
                    ->where("datein","=",$datein)
                    ->where("event","=","in")
                    ->where("time",">=","12:00:00")
                    ->where("time","<","17:00:00");

                $second_pm = DB::table('dtr_file')
                    ->select('time')
                    ->where("userid","=",$pi->userid)
                    ->where("datein","=",$datein)
                    ->where("event","=","in")
                    ->where("time",">=","12:00:00")
                    ->where("time","<","17:00:00");

                $dtr_all_pm = $first_pm ->union($second_pm)->orderby('time','asc')->first();

                if($dtr_all_pm){
                    if($dtr_all_pm->time > substr_replace(substr_replace($pi->pm_in, "5", 6,1),"9",7,1)){
                        $work_sched1_pm = strtotime(substr_replace(substr_replace($pi->pm_in, "5", 6,1),"9",7,1));
                        $work_sched2_pm = strtotime($dtr_all_pm->time);
                        $am_get_pm = round(abs($work_sched1_pm - $work_sched2_pm) / 60,2);
                        $am_final_pm += $am_get_pm;
                        if($countdays_flag)
                            $countdays++;
                    }
                }

                $tardiness_final = $am_final_am + $am_final_pm;
            }

            if(
                !$tardiness_record = Tardiness::where("userid","=",$pi->userid)
                                                ->where("year","=",Input::get("year"))
                                                ->where("month","=",Input::get("month"))->first()
            ) {
                $tardiness_record = new Tardiness();
            }

            if($position = Position::find($pi->designation_id)){
                $userPosition = $position->description;
            } else {
                $userPosition = "No Position";
            }
            if($division = Division::find($pi->division_id)){
                $userDivision = $division->description;
            } else {
                $userDivision = "No Division";
            }
            if($section = Section::find($pi->section_id)){
                $userSection = $section->description;
            } else {
                $userSection = "No Section";
            }
            if($pi->job_status){
                $employee_status = $pi->job_status;
            } else {
                $employee_status = "No Status";
            }

            if($pi->mname){
                $mname = ucfirst($pi->mname)[0].'.';
            } else {
                $mname = '';
            }

            $tardiness_record->userid = $pi->userid;
            $tardiness_record->name = str_replace('\' ', '\'', ucwords(str_replace('\'', '\' ', strtolower($pi->fname)))).' '.$mname.' '.str_replace('\' ', '\'', ucwords(str_replace('\'', '\' ', strtolower($pi->lname))));
            $tardiness_record->position = $userPosition;
            $tardiness_record->division = $userDivision;
            $tardiness_record->section = $userSection;
            $tardiness_record->employee_status = $employee_status;
            $tardiness_record->year = Input::get("year");
            $tardiness_record->month = Input::get("month");
            $tardiness_record->tardiness_min = $tardiness_final;
            $tardiness_record->tardiness_day = $countdays;
            $tardiness_record->save();
        }

        return View::make("tardiness.tardiness_content",[
            "yearAppend" => Input::get("year"),
            "monthAppend" => Input::get("month")
        ]);

    }


}