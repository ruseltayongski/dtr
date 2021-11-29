<?php
/**
 * Created by Christine  (◕‿◕)
 */


class AreaAssignmentController extends BaseController{
    public function __construct(){
    }

    public function list(){
        $area = AreaAssignment::OrderBy('name', 'asc')->paginate(10);
        return View::make('area_assignment/area_assignment', ["area" => $area]);
    }

    public function viewAdd(){
        return View::make('area_assignment/add_new');
    }

    public function addArea(){
        $area = new AreaAssignment();
        $area->name = Input::get('areaName');
        $area->latitude = Input::get('latitude');
        $area->longitude = Input::get('longitude');
        $area->radius = Input::get('radius');
        $area->save();
        return Redirect::to("area-assignment")->with(['notif' => "Successfully added area!"]);
    }

    public function show($id){
        $area = AreaAssignment::where('id', $id)->get()->first();
        return View::make('area_assignment/info', ["area" => $area]);
    }

    public function update(){
        AreaAssignment::where('id', Input::get('id'))
                        ->update(['name' => Input::get('areaName'),
                                  'latitude' => Input::get('latitude'),
                                  'longitude' => Input::get('longitude'),
                                  'radius' => Input::get('radius')]);
        return Redirect::to("area-assignment")->with('notif', 'Successfully updated area');
    }

    public function delete() {
        AreaAssignment::where('id', Input::get('id_delete'))->delete();
        return Redirect::to("area-assignment")->with(["notif" => "Successfully deleted area!"]);
    }

    public function search(){
        $keyword = Input::get('keyword');
        if(isset($keyword)){
            $area = AreaAssignment::where('name', 'like', '%'.$keyword.'%')->OrderBy('name', 'asc')->paginate(20)
                            ->appends(["keyword" => $keyword]);
        }else{
            $area = AreaAssignment::OrderBy('name', 'asc')->paginate(20);   
        }
        return View::make('area_assignment/area_assignment', ["area" => $area]);
    }

    public function viewMap(){
        $id = Input::get('id');
        $area = AreaAssignment::where('id', $id)->get()->first();
        return View::make('area_assignment/view_map', ["area" => $area]);
    }
}