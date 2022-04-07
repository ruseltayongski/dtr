<?php

class MobileControllerV3 extends BaseController{

    public function getAreaAssignment(){
        $areas = Users::where('users.userid','=',Input::get("userid"))
            ->join('area_assigned','area_assigned.userid','=','users.userid')
            ->join('area_of_assignment','area_of_assignment.id','=','area_assigned.area_of_assignment_id')
            ->select("area_of_assignment.name","area_of_assignment.latitude","area_of_assignment.longitude","area_of_assignment.radius")->get();
        return $areas;
    }
}