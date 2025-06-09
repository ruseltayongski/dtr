<?php
/**
 * Created by Christine  (◕‿◕)
 */


class AreaAssignmentController extends BaseController{
    public function __construct(){
    }

    public function index($province) {
        $area = AreaAssignment::Where('province',$province)->OrderBy('name', 'asc')->paginate(20);
        return View::make('area_assignment/area_assignment', [
                    "area" => $area,
                    "province" => $province
            ]);
    }

    public function viewAdd($province) {
        return View::make('area_assignment/add_new',[
            "province" => $province
        ]);
    }

    public function addArea() {
        $area = new AreaAssignment();
        $area->name = Input::get('areaName');
        $area->latitude = Input::get('latitude');
        $area->longitude = Input::get('longitude');
        $area->radius = Input::get('radius');
        $area->province = Input::get('province');
        $area->save();
        return Redirect::to("area-assignment"."/".Input::get('province'))->with(['notif' => "Successfully added area!"]);
    }

    public function show($id,$province) {
        $area = AreaAssignment::where('id', $id)->get()->first();
        return View::make('area_assignment/info', [
                "area" => $area,
                "province" => $province
            ]);
    }

    public function update(){
        AreaAssignment::where('id', Input::get('id'))
                        ->update([
                                  'name' => Input::get('areaName'),
                                  'latitude' => Input::get('latitude'),
                                  'longitude' => Input::get('longitude'),
                                  'radius' => Input::get('radius'),
                                  'province' => Input::get('province')
                                  ]);
        return Redirect::to("area-assignment"."/".Input::get('province'))->with('notif', 'Successfully updated area');
    }

    public function delete($province) {
        AreaAssignment::where('id', Input::get('id_delete'))->delete();
        return Redirect::to("area-assignment"."/".$province)->with(["notif" => "Successfully deleted area!"]);
    }

    public function search($province){
        $keyword = Input::get('keyword');
        if(isset($keyword)){
            $area = AreaAssignment::where('name', 'like', '%'.$keyword.'%')->OrderBy('name', 'asc')->paginate(20)
                            ->appends(["keyword" => $keyword]);
        }else{
            $area = AreaAssignment::OrderBy('name', 'asc')->paginate(20);   
        }
        return View::make('area_assignment/area_assignment', [
                "area" => $area,
                "province" => $province
            ]);
    }

    public function viewMap(){
        $id = Input::get('id');
        $area = AreaAssignment::where('id', $id)->get()->first();
        return View::make('area_assignment/view_map', [
            "area" => $area,
            "province" => Input::get("province")
        ]);
    }

    public function viewUserMap($userid) {
        $areas = Users::where('users.userid','=',$userid)
            ->join('area_assigned','area_assigned.userid','=','users.userid')
            ->join('area_of_assignment','area_of_assignment.id','=','area_assigned.area_of_assignment_id')
            ->select("area_of_assignment.name","area_of_assignment.latitude","area_of_assignment.longitude","area_of_assignment.radius")->get();

        if($areas && $areas[0]->area_assignment_reset == 1){
            Users::where('userid', $userid)->update(['area_assignment_reset' => 0]);
        }

        return View::make('area_assignment/user_area_of_assignment', [
            "areas" => $areas,
            "latitude" => Input::get("latitude"),
            "longitude" => Input::get("longitude"),
            "userid" => $userid
        ]);
    }

}