<?php
/**
 * Created by Christine \^_^/
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
        $area->name = $_POST["areaName"];
        $area->latitude = $_POST["latitude"];
        $area->longitude = $_POST["longitude"];
        $area->radius = $_POST["radius"];
        $area->save();

        return Redirect::to("area-assignment");
    }

    public function show($id){
        $area = AreaAssignment::where('id', $id)->get()->first();
        return View::make('area_assignment/info', ["area" => $area]);
    }

    public function update(){
        AreaAssignment::where('id', $_POST['id'])
                        ->update(['name' => $_POST['areaName'],
                                  'latitude' => $_POST['latitude'],
                                  'longitude' => $_POST['longitude'],
                                  'radius' => $_POST['radius']]);
        return Redirect::to("area-assignment");
    }

    public function delete(){
        AreaAssignment::where('id', $_POST['id_delete'])->delete();
        return Redirect::to("area-assignment");
    }

    public function search(){
        $keyword = $_POST['keyword'];
        if(isset($keyword)){
            $area = AreaAssignment::where('name', 'like', '%'.$keyword.'%')->OrderBy('name', 'asc')->paginate(20)
                            ->appends(["keyword" => $keyword]);
        }else{
            $area = AreaAssignment::OrderBy('name', 'asc')->paginate(20);   
        }
        return View::make('area_assignment/area_assignment', ["area" => $area]);
    }
}