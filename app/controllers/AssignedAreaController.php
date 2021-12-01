<?php
/**
 * Created by Christine \^_^/
 */


class AssignedAreaController extends BaseController{
    public function __construct(){
    }

    public function list(){
        $area = AssignedArea::OrderBy('userid', 'asc')->paginate(10);
        return View::make('area_assignment/sample', ["area" => $area]);
    }
}