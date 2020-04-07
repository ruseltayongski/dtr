<?php

class TimeLogController extends Controller
{
    public function timeLog($supervisor = null){
        if(empty($supervisor)){
            $userid = Auth::user()->userid;
        } else {
            $userid = Session::get('supervise_id');
        }

        if(Request::method() == 'POST'){
            Session::put("filter_dates",Input::get('filter_dates'));
            $filter_date = explode(' - ',Input::get("filter_dates"));
            $date_from = date("Y-m-d",strtotime($filter_date[0]));
            $date_to = date("Y-m-d",strtotime($filter_date[1]));
            //C# API
            $this->csharpApi($userid,$date_from,$date_to);
            //C# API END
        } else {
            if(Session::get("filter_dates")){
                $filter_date = explode(' - ',Session::get("filter_dates"));
                $date_from = date("Y-m-d",strtotime($filter_date[0]));
                $date_to = date("Y-m-d",strtotime($filter_date[1]));
            } else {
                Session::put("filter_dates",date("m/01/Y - m/d/Y"));
                $date_from = date("Y-m-01");
                $date_to = date("Y-m-d");
            }
            //C# API
            $this->csharpApi($userid,$date_from,$date_to);
            //C# API END
        }
        if(Session::get("job_status") == 'Permanent')
            $timeLog = DB::connection('mysql')->select("call Gliding_2020('$userid','$date_from','$date_to')");
        else
            $timeLog = DB::connection('mysql')->select("call getLogs2('$userid','$date_from','$date_to')");

        return View::make("timelog.timelog",[
            "timeLog" => $timeLog,
            "userid" => $userid,
            "supervisor" => $supervisor
        ]);
    }

    public function csharpApi($userid,$date_from,$date_to){
        $url = "http://192.168.81.7/dtr_api/logs/GetLogs/".$userid;
        $data = [
            "userid" => $userid,
            "df" => $date_from,
            "dt" => $date_to
        ];
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        curl_close($curl);

        $logs = json_decode($response);

        foreach($logs as $log)
        {
            $check = DtrDetails::where('userid',$log->userid)
                ->where('datein',$log->date)
                ->where('time',$log->time)
                ->where('event',$log->event_type)
                ->first();
            if(!$check){
                $dtr_file = new DtrDetails();
                $dtr_file->userid = $log->userid;
                $dtr_file->datein = $log->date;
                $dtr_file->time = $log->time;
                $dtr_file->event = $log->event_type;
                $dtr_file->remark = "#FP";
                $dtr_file->edited = 0;
                $dtr_file->save();
            }
        }
    }

    public function append(){
        return View::make("timelog.append_timelog",[
            "elementId" => Input::get('elementId'),
            "am_in" => Input::get("am_in"),
            "am_out" => Input::get("am_out"),
            "pm_in" => Input::get("pm_in"),
            "pm_out" => Input::get("pm_out")
        ]);
    }

    public function edit(){
        $userid = Input::get("userid");
        $datein = Input::get("datein");
        $time = str_replace("-",":",Input::get("time"));
        $edited_display = Input::get("edited_display");
        $log_status = Input::get("log_status");
        $log_status_change = Input::get("log_status_change");
        $log_type = Input::get("log_type");

        switch ($log_status){ //REMOVE
            case "so":
                SoLogs::where("userid",$userid)
                    ->where("datein",$datein)
                    ->where("time",$time)
                    ->where("event",explode("_",$log_type)[1])
                    ->delete();
                break;
            case "cdo":
                CdoLogs::where("userid",$userid)
                    ->where("datein",$datein)
                    ->where("time",$time)
                    ->where("event",explode("_",$log_type)[1])
                    ->delete();
                break;
            case "leave":
                LeaveLogs::where("userid",$userid)
                    ->where("datein",$datein)
                    ->where("time",$time)
                    ->where("event",explode("_",$log_type)[1])
                    ->delete();
                break;
            case "edited":
                EditedLogs::where("userid",$userid)
                    ->where("datein",$datein)
                    ->where("time",$time)
                    ->where("edited",1)
                    ->where("event",explode("_",$log_type)[1])
                    ->delete();
                break;
            case 'jobreak':
                EditedLogs::where("userid",$userid)
                    ->where("datein",$datein)
                    ->where("time",$time)
                    ->where("edited",2)
                    ->where("remark","JO BREAK")
                    ->where("event",explode("_",$log_type)[1])
                    ->delete();
            break;
            case 'to':
                EditedLogs::where("userid",$userid)
                    ->where("datein",$datein)
                    ->where("time",$time)
                    ->where("edited",3)
                    ->where("event",explode("_",$log_type)[1])
                    ->delete();
                break;
            case 'mo':
                EditedLogs::where("userid",$userid)
                    ->where("datein",$datein)
                    ->where("time",$time)
                    ->where("edited",4)
                    ->where("event",explode("_",$log_type)[1])
                    ->delete();
                break;
        }

        $time_display = '';
        switch ($log_status_change){ //INSERT
            case "so_change":
                $so = new SoLogs();
                $so->userid = $userid;
                $so->datein = $datein;
                if($log_type == "AM_IN"){
                    $so->time = "08:00:00";
                    $time_display = "08:00:00";
                }
                elseif($log_type == "AM_OUT"){
                    $so->time = "12:00:00";
                    $time_display = "12:00:00";
                }
                elseif($log_type == "PM_IN"){
                    $so->time = "13:00:00";
                    $time_display = "13:00:00";
                }
                elseif($log_type == "PM_OUT"){
                    $so->time = "18:00:00";
                    $time_display = "18:00:00";
                }
                $so->event = explode("_",$log_type)[1];
                $so->remark = explode("#",$edited_display)[1];
                $so->edited = 1;
                $so->holiday = 003;
                $so->save();

                return [
                    "notification" => "info",
                    "message" => "Successfully added SO",
                    "display_time" => $time_display
                ];
                break;
            case "cdo_change":
                $cdo = new CdoLogs();
                $cdo->userid = $userid;
                $cdo->datein = $datein;
                if($log_type == "AM_IN"){
                    $cdo->time = "08:00:00";
                    $time_display = "08:00:00";
                }
                elseif($log_type == "AM_OUT"){
                    $cdo->time = "12:00:00";
                    $time_display = "12:00:00";
                }
                elseif($log_type == "PM_IN"){
                    $cdo->time = "13:00:00";
                    $time_display = "13:00:00";
                }
                elseif($log_type == "PM_OUT"){
                    $cdo->time = "18:00:00";
                    $time_display = "18:00:00";
                }
                $cdo->event = explode("_",$log_type)[1];
                $cdo->remark = "CTO";
                $cdo->edited = 1;
                $cdo->holiday = 006;
                $cdo->save();

                return [
                    "notification" => "info",
                    "message" => "Successfully added CDO",
                    "display_time" => $time_display
                ];
                break;
            case "leave_change":
                $leave = new LeaveLogs();
                $leave->userid = $userid;
                $leave->datein = $datein;
                if($log_type == "AM_IN"){
                    $leave->time = "08:00:00";
                    $time_display = "08:00:00";
                }
                elseif($log_type == "AM_OUT"){
                    $leave->time = "12:00:00";
                    $time_display = "12:00:00";
                }
                elseif($log_type == "PM_IN"){
                    $leave->time = "13:00:00";
                    $time_display = "13:00:00";
                }
                elseif($log_type == "PM_OUT"){
                    $leave->time = "18:00:00";
                    $time_display = "18:00:00";
                }
                $leave->event = explode("_",$log_type)[1];
                $leave->remark = $edited_display;
                $leave->edited = 1;
                $leave->holiday = 007;
                $leave->save();

                return [
                    "notification" => "info",
                    "message" => "Successfully added LEAVE",
                    "display_time" => $time_display
                ];
                break;
            case "edited_change":
                $edited = new EditedLogs();
                $edited->userid = $userid;
                $edited->datein = $datein;
                $edited->time = $edited_display;
                $time_display = $edited_display;
                $edited->event = explode("_",$log_type)[1];
                $edited->remark = "WEB CREATED";
                $edited->edited = 1;
                $edited->holiday = 'A';
                $edited->save();

                return [
                    "notification" => "info",
                    "message" => "Successfully added LOG",
                    "display_time" => $time_display
                ];
                break;
            case "jobreak_change":
                $jo_break = new EditedLogs();
                $jo_break->userid = $userid;
                $jo_break->datein = $datein;
                if($log_type == "AM_IN"){
                    $jo_break->time = "08:00:00";
                    $time_display = "08:00:00";
                }
                elseif($log_type == "AM_OUT"){
                    $jo_break->time = "12:00:00";
                    $time_display = "12:00:00";
                }
                elseif($log_type == "PM_IN"){
                    $jo_break->time = "13:00:00";
                    $time_display = "13:00:00";
                }
                elseif($log_type == "PM_OUT"){
                    $jo_break->time = "18:00:00";
                    $time_display = "18:00:00";
                }
                $jo_break->event = explode("_",$log_type)[1];
                $jo_break->remark = $edited_display;
                $jo_break->edited = 2;
                $jo_break->save();

                return [
                    "notification" => "info",
                    "message" => "Successfully added JO BREAK",
                    "display_time" => $time_display
                ];
                break;
            case "to_change":
                $so = new EditedLogs();
                $so->userid = $userid;
                $so->datein = $datein;
                if($log_type == "AM_IN"){
                    $so->time = "08:00:00";
                    $time_display = "08:00:00";
                }
                elseif($log_type == "AM_OUT"){
                    $so->time = "12:00:00";
                    $time_display = "12:00:00";
                }
                elseif($log_type == "PM_IN"){
                    $so->time = "13:00:00";
                    $time_display = "13:00:00";
                }
                elseif($log_type == "PM_OUT"){
                    $so->time = "18:00:00";
                    $time_display = "18:00:00";
                }
                $so->event = explode("_",$log_type)[1];
                $so->remark = explode("#",$edited_display)[1];
                $so->edited = 3;
                $so->holiday = 003;
                $so->save();

                return [
                    "notification" => "info",
                    "message" => "Successfully added travel order",
                    "display_time" => $time_display
                ];
                break;
            case "mo_change":
                $so = new EditedLogs();
                $so->userid = $userid;
                $so->datein = $datein;
                if($log_type == "AM_IN"){
                    $so->time = "08:00:00";
                    $time_display = "08:00:00";
                }
                elseif($log_type == "AM_OUT"){
                    $so->time = "12:00:00";
                    $time_display = "12:00:00";
                }
                elseif($log_type == "PM_IN"){
                    $so->time = "13:00:00";
                    $time_display = "13:00:00";
                }
                elseif($log_type == "PM_OUT"){
                    $so->time = "18:00:00";
                    $time_display = "18:00:00";
                }
                $so->event = explode("_",$log_type)[1];
                $so->remark = explode("#",$edited_display)[1];
                $so->edited = 4;
                $so->holiday = 003;
                $so->save();

                return [
                    "notification" => "info",
                    "message" => "Successfully added memorandum order",
                    "display_time" => $time_display
                ];
                break;
            case "empty":
                return [
                    "notification" => "warning",
                    "message" => "Log set empty",
                    "display_time" => $time_display
                ];
                break;
        }

        return Input::get();
    }

}