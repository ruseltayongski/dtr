<?php

class MobileControllerV3 extends BaseController{

    public function getAreaAssignment(){
        $areas = Users::where('users.userid','=',Input::get("userid"))
            ->join('area_assigned','area_assigned.userid','=','users.userid')
            ->join('area_of_assignment','area_of_assignment.id','=','area_assigned.area_of_assignment_id')
            ->select("area_of_assignment.name","area_of_assignment.latitude","area_of_assignment.longitude","area_of_assignment.radius","users.area_assignment_reset")->get();

        if($areas && $areas[0]->area_assignment_reset == 1){
            Users::where('userid', Input::get("userid"))->update(['area_assignment_reset' => 0]);
        }

        return $areas;
    }

    public function checkUsername() {
        $user = Users::where("userid",'=',Input::get('reset_userid'))->first();
        if($user) {
            $name = $user->lname.','.$user->fname;
            return Response::json($name);
        }
        return null;
    }

    public function resetPassword() {
        $authority_check = Users::where("userid",'=',Input::get('userid'))->first()->authority; //user nga ni login
        $user = Users::where("userid",'=',Input::get('reset_userid'))->first(); //user nga i reset
        if($authority_check == "reset_password"){
            if($user){
                $user->password = Hash::make('123');
                $user->pass_change = NULL;
                $user->save();
                $name = $user->lname.', '.$user->fname;
                return Response::json($name);
            } else {
                return null;
            }
        }

        return 2;
    }
}