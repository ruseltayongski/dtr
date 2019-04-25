<?php

class TimeLogController extends Controller
{
    public function timeLog(){
        $timeLog = '';
        if(Request::method() == 'POST'){

            Session::put("filter_dates",Input::get('filter_dates'));
            $userid = Auth::user()->userid;
            $filter_date = explode(' - ',Input::get("filter_dates"));
            $date_from = date("Y-m-d",strtotime($filter_date[0]));
            $date_to = (string)date("Y-m-d",strtotime($filter_date[1]));
            //C# API
            $url = "http://192.168.100.81/dtr_api/logs/GetLogs";
            $data = [
                "userid" => Auth::user()->userid,
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
            //C# API END

            $timeLog = DB::connection('mysql')->select("call getLogs2('$userid','$date_from','$date_to')");
        }
        return View::make("timelog.timelog",[
            "timeLog" => $timeLog
        ]);
    }

    public function append($id){
        return View::make("timelog.append_timelog",[
            "id" => $id
        ]);
    }

}