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

        $result = User::where('users.imei','=',$imei)
            ->leftJoin("pis.personal_information","personal_information.userid","=","users.userid")
            ->first(['users.userid','users.fname','users.lname','users.authority','personal_information.section_id as section']);

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
                "authority" => null,
                "section" => null
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

    public function appVersionView(){
        $app_version_api = AppAPI::first();

        return View::make('api.app_version',[
            "app_version_api" => $app_version_api
        ]);
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
        $app_version_api->code = Input::get("code");
        $app_version_api->latest_version = Input::get("latest_version");
        $app_version_api->save();

        Session::put("app_version_post",true);
        return Redirect::back();
    }

    public function announcementAPI(){
        $announcement_api = AnnouncementAPI::first();
        if($announcement_api->code == 0)
            return false;

        return [
            "code" => $announcement_api->code,
            "message" => $announcement_api->message
        ];
    }

    public function appVersionAPI(){
        $app_version_api = AppAPI::first();
        return [
            "code" => $app_version_api->code,
            "latest_version" => $app_version_api->latest_version
        ];
    }

    public function add_logs()
    {
        try{
            $json_object = json_decode(Input::get('data'), true);
            $check_userid = $json_object[0]['userid'];
            $check_remark = $json_object[0]['remark'];
            $check_dmo = UserRoles::select('users_roles.id','users_claims.claim_type','users_claims.claim_value','users_claims.id as claims_id')
                ->where('users_roles.userid','=',$check_userid)
                ->where('users_roles.claims_id','=','4')
                ->LeftJoin('users_claims','users_claims.id','=','users_roles.claims_id')
                ->first();
            if($check_remark == 'MOBILE' && !$check_dmo)
                return false;

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
                "code" => 0,
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