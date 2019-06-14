<?php

class MobileControllerV2 extends BaseController
{
    public function add_logs()
    {
        $json_object = json_decode(Input::get('data'),true);
        foreach($json_object['logs'] as $key => $value){
            $userid = $value['userid'];
            $time = $value['time'];
            $event = $value['event'];
            $date = $value['date'];
            $lat = $value['latitude'];
            $long = $value['longitude'];
            $remark = $value['remark'];
            $edited = $value['edited'];
            $base= $value['image'];
            $posted_filename = $value['filename'];

            $binary=base64_decode($base);
            file_put_contents(public_path().'/logs_image/'.$posted_filename,$binary);

            $pdo = DB::connection()->getPdo();

            $query1 = "INSERT IGNORE INTO dtr_file(userid, datein, time, event,remark, created_at, updated_at,log_image,edited,latitude,longitude) VALUES";
            $query1 .= "('" . $userid. "','". $date ."','" . $time . "','" . $event . "','$remark',NOW(),NOW(),'$posted_filename','$edited','$lat','$long')";

            $st = $pdo->prepare($query1);
            $st->execute();
        }

        return [
            "code" => 200,
            "response" => [
                "message" => "Success!"
            ]
        ];

    }

    public function add_cto()
    {
        $json_object = json_decode(Input::get('data'),true);
        foreach($json_object['cto'] as $key => $value){
            $daterange = $value['daterange'];

            $temp1 = explode('-',$daterange);

            $from = date('Y-m-d',strtotime($temp1[0]));
            $end_date = date('Y-m-d',strtotime($temp1[1]));

            DB::table('cdo_logs')->where('userid','=',$value['userid'])
                ->whereBetween('datein',array($from,$end_date))->delete();

            $f = new DateTime($from.' '. '24:00:00');
            $t = new DateTime($end_date.' '. '24:00:00');

            $interval = $f->diff($t);


            $f_from = explode('-',$from);
            $startday = $f_from[2];
            $j = 0;
            while($j <= $interval->days) {

                $datein = $f_from[0].'-'.$f_from[1] .'-'. $startday;

                $details = new CdoLogs();
                $details->userid = $value['userid'];
                $details->datein = $datein;
                $details->time = '08:00:00';
                $details->event = 'IN';
                $details->remark = 'CTO';
                $details->edited = '1';
                $details->time_type = 'WH';
                $details->holiday = '006';

                $details->save();

                $details = new CdoLogs();
                $details->userid =  $value['userid'];
                $details->datein = $datein;
                $details->time = '12:00:00';
                $details->event = 'OUT';
                $details->remark = 'CTO';
                $details->edited = '1';
                $details->time_type = 'WH';
                $details->holiday = '006';

                $details->save();

                $details = new CdoLogs();
                $details->userid =  $value['userid'];
                $details->datein = $datein;
                $details->time = '13:00:00';
                $details->event = 'IN';
                $details->remark = 'CTO';
                $details->edited = '1';
                $details->time_type = 'WH';
                $details->holiday = '006';

                $details->save();

                $details = new CdoLogs();
                $details->userid =  $value['userid'];
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
            return 1;
        }


    }




    public function get_logs(){
        return DtrDetails::limit(10)->get();
    }
}