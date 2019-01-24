<?php

class MobileController extends BaseController {

    public function login(){
        $imei = Input::get('imei');

        $result = DB::table('users')
                    ->where('imei','=',$imei)
                    ->first(['userid','fname','lname']);
        
        if(count($result) > 0){
            return json_encode($result);
        }
        return 0;
    }

    public function loginPis(){
        $username = Input::get("username");
        $password = Input::get("password");

        $user = Users::where('username', '=', $username)->first();
        if(count($user) > 0){
            if(Auth::attempt(array('username' => $username, 'password' => $password)))
                return InformationPersonal::where('userid','=',$username)->first();
            else
                return "Invalid Account";
        } else {
            return "Invalid Account";
        }
    }

    public function add_logs(){
        
        $pdo = DB::connection()->getPdo();

        $userid = Input::get('userid');
        $time = Input::get('time');
        $event = Input::get('event');
        $date = Input::get('date');
        
            
            $base= $_POST['image'];
            $posted_filename = $_POST['filename'];
            $binary=base64_decode($base);

           // $filename = $date."_".$event.$userid."_".date('Y-m-d mi');         
            file_put_contents(public_path().'/logs_image/'.$posted_filename,$binary);
            
           // fwrite($file, $binary);
            //fclose($file);

            $query1 = "INSERT IGNORE INTO dtr_file(userid, datein, time, event,remark, created_at, updated_at,log_image,edited) VALUES";
            $query1 .= "('" . $userid. "','". $date ."','" . $time . "','" . $event . "','MOBILE',NOW(),NOW(),'$posted_filename','0')";
            
            $st = $pdo->prepare($query1);
            $ok = $st->execute();
          
        
        if($ok){
            return 1;
        }
        return 0;
    }
    public function add_cto()
    {
        $daterange = Input::get('daterange');
        
        $temp1 = explode('-',$daterange);
        
        $from = date('Y-m-d',strtotime($temp1[0]));
        $end_date = date('Y-m-d',strtotime($temp1[1]));
        
        DB::table('cdo_logs')->where('userid','=',Input::get('userid'))
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
            $details->userid = Input::get('userid');
            $details->datein = $datein;
            $details->time = '08:00:00';
            $details->event = 'IN';
            $details->remark = 'CTO';
            $details->edited = '1';
            $details->time_type = 'WH';
            $details->holiday = '006';

            $details->save();

            $details = new CdoLogs();
            $details->userid =  Input::get('userid');
            $details->datein = $datein;
            $details->time = '12:00:00';
            $details->event = 'OUT';
            $details->remark = 'CTO';
            $details->edited = '1';
            $details->time_type = 'WH';
            $details->holiday = '006';

            $details->save();

            $details = new CdoLogs();
            $details->userid =  Input::get('userid');
            $details->datein = $datein;
            $details->time = '13:00:00';
            $details->event = 'IN';
            $details->remark = 'CTO';
            $details->edited = '1';
            $details->time_type = 'WH';
            $details->holiday = '006';
            
            $details->save();

            $details = new CdoLogs();
            $details->userid =  Input::get('userid');
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
    public function add_so(){
        
        $daterange = Input::get('daterange');
        
        $temp1 = explode('-',$daterange);
        
        $so_no = Input::get('so');

        $from = date('Y-m-d',strtotime($temp1[0]));
        $end_date = date('Y-m-d',strtotime($temp1[1]));

        

        DB::table('so_logs')->where('userid','=',Input::get('userid'))
        ->whereBetween('datein',array($from,$end_date))->delete();


        $f = new DateTime($from.' '. '24:00:00');
        $t = new DateTime($end_date.' '. '24:00:00');

        $interval = $f->diff($t);


        $f_from = explode('-',$from);
        $startday = $f_from[2];
        $j = 0;
        while($j <= $interval->days) {

            $datein = $f_from[0].'-'.$f_from[1] .'-'. $startday;
                        
            $details = new SoLogs();
            $details->userid = Input::get('userid');
            $details->datein = $datein;
            $details->time = '08:00:00';
            $details->event = 'IN';
            $details->remark = $so_no;
            $details->edited = '1';
            $details->time_type = 'WH';
            $details->holiday = '003';

            $details->save();

            $details = new SoLogs();
            $details->userid =  Input::get('userid');
            $details->datein = $datein;
            $details->time = '12:00:00';
            $details->event = 'OUT';
            $details->remark = $so_no;
            $details->edited = '1';
            $details->holiday = '003';
            $details->time_type = 'WH';
            $details->save();

            $details = new SoLogs();
            $details->userid =  Input::get('userid');
            $details->datein = $datein;
            $details->time = '13:00:00';
            $details->event = 'IN';
            $details->remark = $so_no;
            $details->edited = '1';
            $details->time_type = 'WH';
            $details->holiday = '003';

            $details->save();

            $details = new SoLogs();
            $details->userid =  Input::get('userid');
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
        return 1;
    }

    public function add_leave()
    {
        $daterange = Input::get('daterange');
        $temp1 = explode('-',$daterange);
        $leave_type = Input::get('leave_type');

        $from = date('Y-m-d',strtotime($temp1[0]));
        $end_date = date('Y-m-d',strtotime($temp1[1]));

        DB::table('leave_logs')->where('userid','=',Input::get('userid'))
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
            $details->userid = Input::get('userid');
            $details->datein = $datein;
            $details->time = '08:00:00';
            $details->event = 'IN';
            $details->remark = strtoupper($leave_type);
            $details->edited = '1';
            $details->holiday = '007';

            $details->save();

            $details = new LeaveLogs();
            $details->userid =  Input::get('userid');
            $details->datein = $datein;
            $details->time = '12:00:00';
            $details->event = 'OUT';
            $details->remark = strtoupper($leave_type);
            $details->edited = '1';
            $details->holiday = '007';

            $details->save();

            $details = new LeaveLogs();
            $details->userid =  Input::get('userid');
            $details->datein = $datein;
            $details->time = '13:00:00';
            $details->event = 'IN';
            $details->remark = strtoupper($leave_type);
            $details->edited = '1';
            $details->holiday = '007';

            $details->save();

            $details = new LeaveLogs();
            $details->userid =  Input::get('userid');
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
        return 1;
    }
}

?>