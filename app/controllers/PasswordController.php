<?php
/**
 * Created by PhpStorm.
 * User: Lourence
 * Date: 11/11/2016
 * Time: 12:42 PM
 */


class PasswordController extends BaseController
{
    public function __construct()
    {
        $this->beforeFilter(function () {
            if(!Auth::check())
            {
                return Redirect::to('/');
            }
        });
    }


    public function change_password(){
        if(Request::method() == 'GET')
        {
            return View::make('auth.passwords.reset');
        }
        if(Request::method() == 'POST')
        {
            $validator = Validator::make(
                array(
                    'current_password' => Input::get('current_password'),
                    'password' => Input::get('password'),
                    'password_confirmation' => Input::get('password_confirmation')
                ),
                array(
                    'current_password' => 'required',
                    'password' => 'required|max:15',
                    'password_confirmation' => 'same:password'
                )
            );
            if($validator->fails()){
                return Redirect::to('resetpass')->with('error', $validator->messages());
            }
            $user = User::find(Auth::user()->id);
            if(Hash::check(Input::get('current_password'),$user->password)){
                $user->password = Hash::make(Input::get('password_confirmation'));
                $user->save();
                Session::flush();
                return Redirect::to('/')->with(
                    'ok', 'Password succesfully changed. Login now to your account.');
            } else {
                if(Input::get('current_password') == $user->password) {
                    $user->password = Hash::make(Input::get('password_confirmation'));
                    $user->save();
                    Session::flush();
                    return Redirect::to('/')->with(
                        'ok', 'Password succesfully changed. Login now to your account.');
                }
            }
            return Redirect::to('resetpass')->with('not_match','Current password invalid');
        }
    }
}