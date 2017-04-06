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

    }
    public function change_password() {
        return view('auth.passwords.reset');
    }
    public function save_changes(Request $request){
        $validator = Validator::make(
            array(
                'current_password' => $request->input('current_password'),
                'password' => $request->input('password'),
                'password_confirmation' => $request->input('password_confirmation')
            ),
            array(
                'current_password' => 'required',
                'password' => 'required|max:15',
                'password_confirmation' => 'same:password'
            )
        );
        if($validator->fails()){
           return redirect('resetpass')->with('error', $validator->messages());
        }
        $user = User::find($request->user()->id);
        if(Hash::check($request->input('current_password'),$user->password)){
            $user->password = Hash::make($request->input('password_confirmation'));
            $user->save();
            Session::flush();
            return redirect('/')->with(
                'ok', 'Password succesfully changed. Login now to your account.');
        }
        return redirect('resetpass')->with('not_match','Current password invalid');
    }
}