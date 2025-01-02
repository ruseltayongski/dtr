<?php

class CalendarLoginMobile {
    public function __construct($login_info,$user_under)
    {
        $this->login_info = $login_info;
        $this->under_section = $user_under;
    }
}

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

    public function login1()
    {
        $imei = Input::get('imei');
        $user = User::where('users.imei','=',$imei);

        $dmo_roles = 0;
        $area_of_assignment_roles = 0;
        if($user->first()) {
            $user_roles = UserRoles::where('userid',$user->first()->userid);
            if($user_roles->where('claims_id',4)->first())
                $dmo_roles = 1;

            $user_roles = UserRoles::where('userid',$user->first()->userid); //na declare balik kay dile ma apply directly ang variable
            if($user_roles->where('claims_id',5)->first())
                $area_of_assignment_roles = 1;
        }

        $user = User::where('users.imei','=',$imei)->leftJoin("pis.personal_information","personal_information.userid","=","users.userid")
            ->select([
                'users.userid',
                'users.fname',
                'users.lname',
                'users.authority',
                'personal_information.section_id as section',
                \Illuminate\Support\Facades\DB::raw("$dmo_roles as dmo_roles"),
                \Illuminate\Support\Facades\DB::raw("$area_of_assignment_roles as area_of_assignment_roles"),
                'users.region as region'
            ])
            ->orderBy("users.id", "desc")
            ->first();


        if(count((array)$user) > 0){
            return [
                "code" => 200,
                "response" => $user
            ];    
        }

        return [
            "code" => 201,
            "response" => [
                "userid" => null,
                "fname" => null,
                "lname" => null,
                "authority" => null,
                "section" => null,
                "dmo_roles" => null,
                "region" => null
            ]
        ];
    }

    public function LoginCalendar()
    {
        $username = Input::get("username");
        $password = Input::get("password");

        $login_info = InformationPersonal::
        select("personal_information.userid","personal_information.section_id",
            \DB::raw("concat(personal_information.fname,' ',personal_information.lname) as fullname"),
            \DB::raw("if(users.id=section.head,'Yes','No') as head"),
            "pis_user.password"
        )
            ->leftJoin("dts.users","users.username","=","personal_information.userid")
            ->leftJoin("dts.section","section.id","=","personal_information.section_id")
            ->leftJoin("pis.users as pis_user","pis_user.username","=","personal_information.userid")
            ->where('personal_information.userid', '=', $username)
            ->first();

        if (Hash::check($password,$login_info->password)){
            $login_info = InformationPersonal::
            select("personal_information.userid","personal_information.section_id",
                \DB::raw("concat(personal_information.fname,' ',personal_information.lname) as fullname"),
                \DB::raw("if(users.id=section.head,'Yes','No') as head"),
                "dtr_user.region"
            )
                ->leftJoin("dts.users","users.username","=","personal_information.userid")
                ->leftJoin("dts.section","section.id","=","personal_information.section_id")
                ->leftJoin("dohdtr.users as dtr_user","dtr_user.userid","=","personal_information.userid")
                ->where('personal_information.userid', '=', $username)
                ->first();

            $login_info->head == 'Yes' ?
                $under_section = InformationPersonal::
                select(
                    "personal_information.userid",
                    "personal_information.section_id",
                    \DB::raw("concat(personal_information.fname,' ',personal_information.lname) as name_under"),
                    "dtr_user.region"
                )
                    ->leftJoin("dohdtr.users as dtr_user","dtr_user.userid","=","personal_information.userid")
                    ->where("personal_information.section_id","=",$login_info->section_id)
                    ->where("dtr_user.region","=",$login_info->region)
                    ->orderBy("personal_information.fname","asc")
                    ->get()
                :
                $under_section = [];

            unset($login_info["password"]);

            $data = new CalendarLoginMobile($login_info,$under_section);
            return json_encode($data);
        }
        else
            return "{}";

    }

    public function getCurrentVersionField()
    {
        return [
            "code" => 200,  
            "response" => [
                "code_version" => "2.7.0",
                "features" => ["2.2.0","\t\t1. Cool Material design",
                                "\t\t2. Improve Upload Performance",
                                "\t\t3.Outdated logs can now be deleted by swiping.",
                                "\n2.3.0",
                                "\t\t1.Deleting CTO/SO/LEAVE has now confirmation",
                                "\t\t2.User ID number and installed MobileDTR version are now displayed",
                                "\n2.4.0",
                                "\t\t1.Optimize upload performance",
                                "\n2.5.0",
                                "\t\t1.Fixed minor bugs",
                            ]
            ]
        ];

    }

    public function getCurrentVersionOffice()
    {
        return [
            "code" => 200,
            "response" => [
                "code_version" => "1.3.0",
                "features" => [
                    ""
                ]
            ]
        ];

    }

    public function announcementView(){
        $announcement_api = AnnouncementAPI::first();

        return View::make('api.announcement',[
            "announcement_api" => $announcement_api
        ]);
    }

    public function appVersionView($type) {
        $app_version_api = AppAPI::where('device_type', $type)->first();
        if($app_version_api) {
            return View::make('api.app_version', [
                "app_version_api" => $app_version_api
            ]);
        }else{
            return 'No app version found for this device!';
        }
    }

    public function forceUpdate(){
        $app_version = AppAPI::where('device_type', 'ios')->orderBy('latest_version', 'desc')->first();

        return [
            'id' => $app_version->id,
            'code' => $app_version->code,
            'latest_version' => $app_version->latest_version,
            'message' => $app_version->message,
            'force_update' => $app_version->force_update,
            'force_update_title' => $app_version->force_update_title,
            'force_update_btn' => $app_version->force_update_btn,
            'device_type' => $app_version->device_type,
            'announcement_status' => $app_version->announcement_status,
            'incremental_updates' => $app_version->incremental_updates
        ];
    }

    public function announcementPost(){
        $announcement_api = AnnouncementAPI::first();
        $announcement_api->code = Input::get("code");
        $announcement_api->message = Input::get("message");
        $announcement_api->save();

        Session::put("announcement_post",true);
        return Redirect::back();
    }

    public function appVersionPost(){
        $app_version_api = AppAPI::first();
        $app_version_api->message = Input::get("message");
        $app_version_api->code = Input::get("code");
        $app_version_api->latest_version = Input::get("latest_version");
        $app_version_api->save();

        Session::put("app_version_post",true);
        return Redirect::back();
    }

    public function announcementAPI(){
        $announcement_api = AnnouncementAPI::first();

        return [
            "code" => $announcement_api->code,
            "message" => $announcement_api->message
        ];
    }

    public function appVersionAPIOld(){
        $app_version_api = AppAPI::first();
        return [
            "code" => $app_version_api->code,
            "latest_version" => $app_version_api->latest_version
        ];
    }

    public function appVersionAPINew($device_type){
        $app_version_api = AppAPI::where('device_type', $device_type)->first();
        return [
            "message" => $app_version_api->message,
            "code" => $app_version_api->code,
            "latest_version" => $app_version_api->latest_version
        ];
    }

    public function add_logs()
    {
        try {
            $json_object = json_decode(Input::get('data'), true);
            $check_userid = $json_object['logs'][0]['userid'];
            $check_remark = $json_object['logs'][0]['remark'];
            $check_dmo = UserRoles::select('users_roles.id','users_claims.claim_type','users_claims.claim_value','users_claims.id as claims_id')
                ->where('users_roles.userid','=',$check_userid)
                ->where('users_roles.claims_id','=','4')
                ->LeftJoin('users_claims','users_claims.id','=','users_roles.claims_id')
                ->first();

            // to enable this uncomment line 258 to 263
            // if($check_userid === '') { //doc 
            //    return [
            //        "code" => 0,
            //        "response" => "error"
            //     ];
            // }    

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
                $version = $value['app_version'];
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

                if(isset($value['mocked_created_at'])) {
                    $mocked_created_at = $value['mocked_created_at'];
                    $query1 = "INSERT IGNORE INTO dtr_file(userid, datein, time, event,remark, created_at, updated_at,log_image,edited,latitude,longitude,mocked_created_at,version) VALUES";
                    $query1 .= "('" . $userid . "','" . $date . "','" . $time . "','" . $event . "','$remark',NOW(),NOW(),'$posted_filename','$edited','$lat','$long','$mocked_created_at','$version')";
                }
                else {
                    $query1 = "INSERT IGNORE INTO dtr_file(userid, datein, time, event,remark, created_at, updated_at,log_image,edited,latitude,longitude,version) VALUES";
                    $query1 .= "('" . $userid . "','" . $date . "','" . $time . "','" . $event . "','$remark',NOW(),NOW(),'$posted_filename','$edited','$lat','$long','$version')";
                }

                $st = $pdo->prepare($query1);
                $st->execute();
            }

            return [
                "code" => 200,
                //"response" => $version
                "response" => "Successfully uploaded"
            ];

        } catch (Exception $e){
            return [
                "code" => 0,
                "response" => $e->getMessage()
            ];
        }
    }

    public function add_flags()
    {
        try {
            $json_object = json_decode(Input::get('data'), true);
            $check_userid = $json_object['logs'][0]['userid'];
            $check_remark = $json_object['logs'][0]['remark'];
            $check_dmo = UserRoles::select('users_roles.id','users_claims.claim_type','users_claims.claim_value','users_claims.id as claims_id')
                ->where('users_roles.userid','=',$check_userid)
                ->where('users_roles.claims_id','=','4')
                ->LeftJoin('users_claims','users_claims.id','=','users_roles.claims_id')
                ->first();

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
                    mkdir(public_path().'/logs_imageV2'.'/'.$userid.'/flag', 0777, true);
                }
                if(!file_exists(public_path().'/logs_imageV2'.'/'.$userid.'/flag')) {
                    mkdir(public_path().'/logs_imageV2'.'/'.$userid.'/flag', 0777, true);
                }
                file_put_contents(public_path().'/logs_imageV2'.'/'.$userid.'/'.$picture_type.'/'.$posted_filename, $binary);

                $pdo = DB::connection()->getPdo();

                if(isset($value['mocked_created_at'])) {
                    $mocked_created_at = $value['mocked_created_at'];
                    $query1 = "INSERT IGNORE INTO edited_logs(userid, datein, time, event,remark, created_at, updated_at,log_image,edited,latitude,longitude,mocked_created_at) VALUES";
                    $query1 .= "('" . $userid . "','" . $date . "','" . $time . "','" . $event . "','$remark',NOW(),NOW(),'$posted_filename','$edited','$lat','$long','$mocked_created_at')";
                }
                else {
                    $query1 = "INSERT IGNORE INTO edited_logs(userid, datein, time, event,remark, created_at, updated_at,log_image,edited,latitude,longitude) VALUES";
                    $query1 .= "('" . $userid . "','" . $date . "','" . $time . "','" . $event . "','$remark',NOW(),NOW(),'$posted_filename','$edited','$lat','$long')";
                }

                $st = $pdo->prepare($query1);
                $st->execute();
            }

            return [
                "code" => 200,
                "response" => "Successfully uploaded"
            ];

        } catch (Exception $e){
            return [
                "code" => 0,
                "response" => $e->getMessage()
            ];
        }
    }

    public function add_cdo()
    {
        $json_object = json_decode(Input::get('data'), true);
        $userid = $json_object['userid'];
        foreach ($json_object['cdo'] as $key => $value) {
            $daterange = $value['daterange'];

            $temp1 = explode('-', $daterange);

            $from = date('Y-m-d', strtotime($temp1[0]));
            $end_date = date('Y-m-d', strtotime($temp1[1]));

            DB::table('cdo_logs')->where('userid', '=', $userid)
                ->whereBetween('datein', array($from, $end_date))->delete();

            $f = new DateTime($from . ' ' . '24:00:00');
            $t = new DateTime($end_date . ' ' . '24:00:00');

            $interval = $f->diff($t);


            $f_from = explode('-', $from);
            $startday = $f_from[2];
            $days_m = cal_days_in_month(CAL_GREGORIAN, $f_from[1], $f_from[0]);
            $j = 0;
            while ($j <= $interval->days) {

                $datein = $f_from[0] . '-' . $f_from[1] . '-' . $startday;

                $details = new CdoLogs();
                $details->userid = $userid;
                $details->datein = $datein;
                $details->time = '08:00:00';
                $details->event = 'IN';
                $details->remark = 'CTO';
                $details->edited = '1';
                $details->time_type = 'WH';
                $details->holiday = '006';

                $details->save();

                $details = new CdoLogs();
                $details->userid = $userid;
                $details->datein = $datein;
                $details->time = '12:00:00';
                $details->event = 'OUT';
                $details->remark = 'CTO';
                $details->edited = '1';
                $details->time_type = 'WH';
                $details->holiday = '006';

                $details->save();

                $details = new CdoLogs();
                $details->userid = $userid;
                $details->datein = $datein;
                $details->time = '13:00:00';
                $details->event = 'IN';
                $details->remark = 'CTO';
                $details->edited = '1';
                $details->time_type = 'WH';
                $details->holiday = '006';

                $details->save();

                $details = new CdoLogs();
                $details->userid = $userid;
                $details->datein = $datein;
                $details->time = '17:00:00';
                $details->event = 'OUT';
                $details->remark = 'CTO';
                $details->edited = '1';
                $details->time_type = 'WH';
                $details->holiday = '006';

                $details->save();

                if($startday == $days_m){
                $f_from[1] +=1;
                $startday = 0;
                }   
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
            $days_m = cal_days_in_month(CAL_GREGORIAN, $f_from[1], $f_from[0]);
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

                if($startday == $days_m){
                $f_from[1] +=1;
                $startday = 0;
                }   
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
        $userid = $json_object['userid'];
        foreach ($json_object['so'] as $key => $value) {
            $daterange = $value['daterange'];

            $temp1 = explode('-', $daterange);

            $so_no = $value['so_no'];

            $from = date('Y-m-d', strtotime($temp1[0]));
            $end_date = date('Y-m-d', strtotime($temp1[1]));  

            DB::table('so_logs')->where('userid', '=', $userid)
                ->whereBetween('datein', array($from, $end_date))->delete();

            $f = new DateTime($from . ' ' . '24:00:00');
            $t = new DateTime($end_date . ' ' . '24:00:00');

            $interval = $f->diff($t); 

            $f_from = explode('-', $from);
            $startday = $f_from[2];
            $days_m = cal_days_in_month(CAL_GREGORIAN, $f_from[1], $f_from[0]);
            $j = 0;

            while ($j <= $interval->days) {

                $datein = $f_from[0] . '-' . $f_from[1] . '-' . $startday;

                $details = new SoLogs();
                $details->userid = $userid;
                $details->datein = $datein;
                $details->time = '08:00:00';
                $details->event = 'IN';
                $details->remark = $so_no;
                $details->edited = '1';
                $details->time_type = 'WH';
                $details->holiday = '003';
                $details->save();    
              
                $details = new SoLogs();
                $details->userid = $userid;
                $details->datein = $datein;
                $details->time = '12:00:00';
                $details->event = 'OUT';
                $details->remark = $so_no;
                $details->edited = '1';
                $details->holiday = '003';
                $details->time_type = 'WH';
                $details->save();
            
                $details = new SoLogs();
                $details->userid = $userid;
                $details->datein = $datein;
                $details->time = '13:00:00';
                $details->event = 'IN';
                $details->remark = $so_no;
                $details->edited = '1';
                $details->time_type = 'WH';
                $details->holiday = '003';
                $details->save();
           
                $details = new SoLogs();
                $details->userid = $userid;
                $details->datein = $datein;
                $details->time = '17:00:00';
                $details->event = 'OUT';
                $details->remark = $so_no;
                $details->edited = '1';
                $details->time_type = 'WH';
                $details->holiday = '003';
                $details->save();   
            
                if($startday == $days_m){
                $f_from[1] +=1;
                $startday = 0;
                }   
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

    public function info($userid){
        $info = InformationPersonal::where('userid', $userid)->first();
        if($info){
            return [
                'First name:' => $info->fname,
                'Middle name:' => $info->mname,
                'Last name:' => $info->lname
            ];
        }else{
            return 'Data not found';
        }
    }

    public function appstoreUpdate(){
        $notificationData = Input::all();
        $appstore = new Appstore();
        $appstore->description = json_encode($notificationData);
        $appstore->save();
        return Response::json(['status' => 'success'], 200);

    }

    public function privacyPolicy(){
        return View::make('dtr.dtr_policy');
    }

    public function server_time(){
        // return now('Asia/Manila')->format('Y-m-d\TH:i:s.uP');
        return date('Y-m-d\TH:i:s.uP');
    }
}