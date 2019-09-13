<?php

class MobileControllerV2 extends BaseController
{
    public function login()
    {
        $imei = Input::get('imei');

        $result = User::where('imei','=',$imei)
            ->first(['userid', 'fname', 'lname','authority']);

        if (count($result) > 0) {
            return [
                "code" => 200,
                "response" => $result
            ];
        }

        return [
            "code" => 201,
            "response" => [
                "userid" => null,
                "fname" => null,
                "lname" => null,
                "authority" => null
            ]
        ];
    }

    public function getCurrentVersion()
    {
        return [
            "code" => 200,
            "response" => [
                "code_version" => "2.1.0",
                "features" => ["1. Daily notification every 12:45 PM", "2. Cool Material design", "3. Improve Upload Performance"]
            ]
        ];

    }

    public function add_logs()
    {
        try{
            $json_object = json_decode(Input::get('data'), true);
            foreach ($json_object['logs'] as $value) {
                $userid = $value['userid'];
                $time = $value['time'];
                $event = $value['event'];
                $date = $value['date'];
                $lat = $value['latitude'];
                $long = $value['longitude'];
                $remark = $value['remark'];
                $edited = $value['edited'];
                $base = $value['image'];
                $posted_filename = explode('_',$value['filename'])[1];
                $picture_type = explode('_',$value['filename'])[0];

                $binary = base64_decode($base);
                if (!file_exists(public_path().'/logs_imageV2'.'/'.$userid)) {
                    mkdir(public_path().'/logs_imageV2'.'/'.$userid, 0777, true);
                    mkdir(public_path().'/logs_imageV2'.'/'.$userid.'/screenshot', 0777, true);
                    mkdir(public_path().'/logs_imageV2'.'/'.$userid.'/timelog', 0777, true);
                }
                file_put_contents(public_path().'/logs_imageV2'.'/'.$userid.'/'.$picture_type.'/'.$posted_filename, $binary);

                $pdo = DB::connection()->getPdo();

                $query1 = "INSERT IGNORE INTO dtr_file(userid, datein, time, event,remark, created_at, updated_at,log_image,edited,latitude,longitude) VALUES";
                $query1 .= "('" . $userid . "','" . $date . "','" . $time . "','" . $event . "','$remark',NOW(),NOW(),'$posted_filename','$edited','$lat','$long')";

                $st = $pdo->prepare($query1);
                $st->execute();
            }

            return [
                "code" => 200,
                "response" => "Successfully uploaded"
            ];
        } catch (Exception $e){
            return [
                "code" => 200,
                "response" => $e->getMessage()
            ];
        }


    }

    public function add_cdo()
    {
        $json_object = json_decode(Input::get('data'), true);
        foreach ($json_object['cdo'] as $key => $value) {
            $daterange = $value['daterange'];

            $temp1 = explode('-', $daterange);

            $from = date('Y-m-d', strtotime($temp1[0]));
            $end_date = date('Y-m-d', strtotime($temp1[1]));

            DB::table('cdo_logs')->where('userid', '=', $json_object['userid'])
                ->whereBetween('datein', array($from, $end_date))->delete();

            $f = new DateTime($from . ' ' . '24:00:00');
            $t = new DateTime($end_date . ' ' . '24:00:00');

            $interval = $f->diff($t);


            $f_from = explode('-', $from);
            $startday = $f_from[2];
            $j = 0;
            while ($j <= $interval->days) {

                $datein = $f_from[0] . '-' . $f_from[1] . '-' . $startday;

                $details = new CdoLogs();
                $details->userid = $json_object['userid'];
                $details->datein = $datein;
                $details->time = '08:00:00';
                $details->event = 'IN';
                $details->remark = 'CTO';
                $details->edited = '1';
                $details->time_type = 'WH';
                $details->holiday = '006';

                $details->save();

                $details = new CdoLogs();
                $details->userid = $json_object['userid'];
                $details->datein = $datein;
                $details->time = '12:00:00';
                $details->event = 'OUT';
                $details->remark = 'CTO';
                $details->edited = '1';
                $details->time_type = 'WH';
                $details->holiday = '006';

                $details->save();

                $details = new CdoLogs();
                $details->userid = $json_object['userid'];
                $details->datein = $datein;
                $details->time = '13:00:00';
                $details->event = 'IN';
                $details->remark = 'CTO';
                $details->edited = '1';
                $details->time_type = 'WH';
                $details->holiday = '006';

                $details->save();

                $details = new CdoLogs();
                $details->userid = $json_object['userid'];
                $details->datein = $datein;
                $details->time = '17:00:00';
                $details->event = 'OUT';
                $details->remark = 'CTO';
                $details->edited = '1';
                $details->time_type = 'WH';
                $details->holiday = '006';

                $details->save();

                $startday = $startday + 1;
                $j++;
            }

        }

        return [
            "code" => 200,
            "response" => "Successfully uploaded"
        ];
    }

    public function add_leave()
    {
        $json_object = json_decode(Input::get('data'), true);
        $userid = $json_object['userid'];
        foreach ($json_object['leave'] as $key => $value) {
            $daterange = $value['daterange'];
            $temp1 = explode('-',$daterange);
            $leave_type = $value['leave_type'];

            $from = date('Y-m-d',strtotime($temp1[0]));
            $end_date = date('Y-m-d',strtotime($temp1[1]));

            DB::table('leave_logs')->where('userid','=',$userid)
                ->whereBetween('datein',array($from,$end_date))->delete();

            $f = new DateTime($from.' '. '24:00:00');
            $t = new DateTime($end_date.' '. '24:00:00');

            $interval = $f->diff($t);


            $f_from = explode('-',$from);
            $startday = $f_from[2];
            $j = 0;
            while($j <= $interval->days) {

                $datein = $f_from[0].'-'.$f_from[1] .'-'. $startday;

                $details = new LeaveLogs();
                $details->userid =$userid;
                $details->datein = $datein;
                $details->time = '08:00:00';
                $details->event = 'IN';
                $details->remark = strtoupper($leave_type);
                $details->edited = '1';
                $details->holiday = '007';

                $details->save();

                $details = new LeaveLogs();
                $details->userid = $userid;
                $details->datein = $datein;
                $details->time = '12:00:00';
                $details->event = 'OUT';
                $details->remark = strtoupper($leave_type);
                $details->edited = '1';
                $details->holiday = '007';

                $details->save();

                $details = new LeaveLogs();
                $details->userid =  $userid;
                $details->datein = $datein;
                $details->time = '13:00:00';
                $details->event = 'IN';
                $details->remark = strtoupper($leave_type);
                $details->edited = '1';
                $details->holiday = '007';

                $details->save();

                $details = new LeaveLogs();
                $details->userid = $userid;
                $details->datein = $datein;
                $details->time = '17:00:00';
                $details->event = 'OUT';
                $details->remark = strtoupper($leave_type);
                $details->edited = '1';
                $details->holiday = '007';

                $details->save();

                $startday = $startday + 1;
                $j++;
            }

        }

        return [
            "code" => 200,
            "response" => "Successfully uploaded"
        ];
    }


    public function add_so()
    {
        $json_object = json_decode(Input::get('data'), true);
        foreach ($json_object['so'] as $key => $value) {
            $daterange = $value['daterange'];

            $temp1 = explode('-', $daterange);

            $so_no = $value['so_no'];

            $from = date('Y-m-d', strtotime($temp1[0]));
            $end_date = date('Y-m-d', strtotime($temp1[1]));


            DB::table('so_logs')->where('userid', '=', $json_object['userid'])
                ->whereBetween('datein', array($from, $end_date))->delete();


            $f = new DateTime($from . ' ' . '24:00:00');
            $t = new DateTime($end_date . ' ' . '24:00:00');

            $interval = $f->diff($t);


            $f_from = explode('-', $from);
            $startday = $f_from[2];
            $j = 0;
            while ($j <= $interval->days) {

                $datein = $f_from[0] . '-' . $f_from[1] . '-' . $startday;

                $details = new SoLogs();
                $details->userid = $json_object['userid'];
                $details->datein = $datein;
                $details->time = '08:00:00';
                $details->event = 'IN';
                $details->remark = $so_no;
                $details->edited = '1';
                $details->time_type = 'WH';
                $details->holiday = '003';

                $details->save();

                $details = new SoLogs();
                $details->userid = $json_object['userid'];
                $details->datein = $datein;
                $details->time = '12:00:00';
                $details->event = 'OUT';
                $details->remark = $so_no;
                $details->edited = '1';
                $details->holiday = '003';
                $details->time_type = 'WH';
                $details->save();

                $details = new SoLogs();
                $details->userid = $json_object['userid'];
                $details->datein = $datein;
                $details->time = '13:00:00';
                $details->event = 'IN';
                $details->remark = $so_no;
                $details->edited = '1';
                $details->time_type = 'WH';
                $details->holiday = '003';

                $details->save();

                $details = new SoLogs();
                $details->userid = $json_object['userid'];
                $details->datein = $datein;
                $details->time = '17:00:00';
                $details->event = 'OUT';
                $details->remark = $so_no;
                $details->edited = '1';
                $details->time_type = 'WH';
                $details->holiday = '003';

                $details->save();

                $startday = $startday + 1;
                $j++;
            }
        }

        return [
            "code" => 200,
            "response" => "Successfully uploaded"
        ];

    }

    public function add_so1(){
        if (!file_exists(public_path().'/logs_imageV2/0618')) {
            mkdir(public_path().'/logs_imageV2/0618/screenshot', 0777, true);
            mkdir(public_path().'/logs_imageV2/0618/timelog', 0777, true);
        }
    }

    public function imei(){
        $user = Users::where("userid",'=',Input::get('userid'))->first();
        if($user){
            $user->imei = Input::get('imei');
            $user->save();
            return [
                "code" => 200,
                "response" => "Successfully IMEI"
            ];
        } else {
            return [
                "code" => 201,
                "response" => "Failed!"
            ];
        }
    }


    public function get_logs(){
        return DtrDetails::limit(10)->get();
    }
}