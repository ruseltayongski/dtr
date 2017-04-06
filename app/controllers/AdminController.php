<?php
/**
 * Created by PhpStorm.
 * User: Lourence
 * Date: 1/12/2017
 * Time: 11:18 AM
 */

ini_set('max_execution_time', 0);
ini_set('memory_limit','1000M');
ini_set('max_input_time','300000');
class AdminController extends BaseController
{
    public function __construct()
    {

    }
    public function index()
    {
        if(Auth::check()){
            if(Auth::user()->usertype == '1')
            {
                return Redirect::to('home');
            } else {
                return Redirect::to('personal/index');
            }
        }
        if(!Auth::check() and Request::method() == 'GET') {
            return View::make('auth.login');
        }

        if(Request::method() == 'POST') {
            $username = Input::get('username');
            $password = Input::get('password');
           if(Auth::attempt(array('username' => $username, 'password' => $password))) {
               if(Auth::user()->usertype == '1') {
                   return Redirect::to('home');
               } else {
                   return Redirect::to('personal/index');
               }
           } else {
               return Redirect::to('/')->with('ops','Invalid Login');
           }
        }
    }

    public function home()
    {
        $lists = DtrDetails::paginate(20);
        return View::make('home')->with('lists',$lists);
    }
}