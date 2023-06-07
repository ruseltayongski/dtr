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

        if(Auth::attempt(array('username' => $username, 'password' => $password)))
            return InformationPersonal::where('userid','=',$username)->first(["userid","fname","mname","lname","name_extension","section_id"]);
        else
            return "{}";
    }

     public function getLogin(){
       $username = Input::get("username");
       $password = Input::get("password");
        
       if(Auth::attempt(array('username' => $username, 'password' => $password))){
            $result = DB::table('users')
                ->where('userid','=',$username)
                ->first(["userid","fname","mname","lname"]);    
       } 
        if(isset($result)){
            return json_encode($result);
        }   
        return 0;
    }


    public function add_logs(){
        $pdo = DB::connection()->getPdo();

        $userid = Input::get('userid');
        $time = Input::get('time');
        $event = Input::get('event');
        $date = Input::get('date');
        $lat = Input::get('latitude');
        $long = Input::get('longitude');
        $version = Input::get('app_version')

        $base= $_POST['image'];
        $posted_filename = $_POST['filename'];
        $binary=base64_decode($base);

        file_put_contents(public_path().'/logs_image/'.$posted_filename,$binary);

        $query1 = "INSERT IGNORE INTO dtr_file(userid, datein, time, event,remark, created_at, updated_at,log_image,edited,latitude,longitude,version) VALUES";
        $query1 .= "('" . $userid. "','". $date ."','" . $time . "','" . $event . "','MOBILE',NOW(),NOW(),'$posted_filename','0','$lat','$long','$version')";

        $st = $pdo->prepare($query1);
        $ok = $st->execute();
        return 1;
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

    public function getCurrentVersion(){
        return "1.0";
    }

    public function imei(){
        $user = Users::where("userid",'=',Input::get('userid'))->first();
        if($user){
            $user->imei = Input::get('imei');
            $user->save();
            return 1;
        } else {
            return 0;
        }
    }

    public function strip_tags_content($text) {
        return preg_replace('@<(\w+)\b.*?>.*?</\1>@si', '', $text);
    
    }

    public function removeHtmlTags($html_string, $html_tags) 
    {
        $tagStr = "";
      
            foreach($html_tags as $key => $value) 
        { 
                $tagStr .= $key == count($html_tags)-1 ? $value : "{$value}|"; 
            }
      
        $pat_str= array("/(<\s*\b({$tagStr})\b[^>]*>)/i", "/(<\/\s*\b({$tagStr})\b\s*>)/i");
        $result = preg_replace($pat_str, "", $html_string);
        return $result;
    }


}

?>