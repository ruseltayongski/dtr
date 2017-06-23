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
        if(Auth::check())
        {
            return Redirect::to('/');
        }
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
            $user = Users::where('username', '=', $username)
                        ->where('password', '=', $password)
                        ->first();

            if(isset($user) and count($user) > 0) {
                if (Auth::loginUsingId($user->id)) {
                    if (Auth::user()->usertype == '1') {
                        return Redirect::to('home');
                    } else {
                        return Redirect::to('personal/index');
                    }
                } else {
                    return Redirect::to('/')->with('ops', 'Invalid Login');
                }
            } else {
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
    }

    public function home()
    {
        $users = DB::table('users')
            ->leftJoin('work_sched', function($join){
                $join->on('users.sched','=','work_sched.id');
            })
            ->orderBy('fname', 'ASC')
            ->paginate(20);
        return View::make('home')->with('users',$users);
    }

    public function list_jo()
    {
        $users = DB::table('users')
                    ->leftJoin('work_sched', function($join){
                        $join->on('users.sched','=','work_sched.id');
                    })
                    ->orderBy('fname', 'ASC')
                    ->where('emptype','=','JO')
                    ->paginate(20);

        return View::make('users.users')->with('users',$users);
    }

    public function search_jo()
    {

        if(Input::has('search')) {
            $search = Input::get('search');

            $users = DB::table('users')
                    ->leftJoin('work_sched', function($join){
                        $join->on('users.sched','=','work_sched.id');
                    })
                    ->where('users.userid', 'LIKE', "%$search%")
                    ->orWhere('users.fname', 'LIKE', "%$search%")
                    ->orWhere('users.lname', 'LIKE', "%$search%")
                    ->orderBy('users.fname', 'DESC')
                    ->paginate(20);

            return View::make('users.users')->with('users', $users);
        }
        return Redirect::to('list/job-order');
    }

    public function search()
    {
        if(Input::has('search')) {
            $keyword = Input::get('search');
            $users = DB::table('users')
                ->leftJoin('work_sched', function($join){
                    $join->on('users.sched','=','work_sched.id');
                })
                ->where(function($q) use ($keyword){
                    $q->where('fname','like',"%$keyword%")
                        ->orwhere('lname','like',"%$keyword%")
                        ->orwhere('userid','like',"%$keyword%");
                })
                ->where('usertype','=', '0')
                ->orderBy('fname', 'ASC')
                ->paginate(20);
            return View::make('home')->with('users',$users);
        }
        return Redirect::to('index');
    }

    public function search_regular()
    {
        if(Input::has('search')) {
            $search = Input::get('search');
            $regulars = DB::table('users')
                    ->leftJoin('work_sched', function($join){
                        $join->on('users.sched','=','work_sched.id');
                    })
                    ->where('users.userid', 'LIKE', "%$search%")
                    ->orWhere('users.fname', 'LIKE', "%$search%")
                    ->orWhere('users.lname', 'LIKE', "%$search%")
                    ->orderBy('users.fname', 'DESC')
                    ->paginate(20);
            return View::make('users.regular')->with('users', $regulars);
        }
    }


    public function list_regular()
    {
        $regulars = DB::table('users')
            ->leftJoin('work_sched', function($join){
                $join->on('users.sched','=','work_sched.id');
            })
            ->orderBy('fname','ASC')
            ->where('emptype','=','REG')
            ->paginate(20);
        return View::make('users.regular')->with('regulars',$regulars);
    }


    public function change_schedule()
    {
        if(Request::method() == "GET") {
            $sched = WorkScheds::all();
            if(Input::has('id')){
                Session::forget('sched_id');
                Session::put('sched_id',Input::get('id'));
                $user = Users::where('userid','=', Session::get('sched_id'))->first();
                return View::make('users.change_sched')->with('sched',$sched)->with('user',$user);

            } else {
                return "<strong>No employee ID is sent.</strong>";
            }
        }

        if(Request::method() == "POST") {
            $user = Users::where('userid', '=', Session::get('sched_id'))->first();
            $sched = WorkScheds::where('id', '=' , Input::get('schedule_id'))->first();
            if(isset($user) and count($user) > 0) {
                $user->sched = Input::get('schedule_id');
                $user->save();
                if($user->emptype == "REG") {
                    return Redirect::to('list/regular')->with('msg_sched',"Employee $user->fname $user->lname working schedule is change to $sched->description");
                } else {
                    return Redirect::to('list/job-order')->with('msg_sched',"Employee $user->fname $user->lname working schedule is change to $sched->description");

                }
            }
        }
    }

    public function adduser()
    {
        if(Request::method() == "GET") {
            $sched = WorkScheds::all();
            return View::make('users.adduser')->with('scheds',$sched);
        }
        $user = new Users();
        $user->userid = Input::get('userid');
        $user->fname = Input::get('fname');
        $user->lname = Input::get('lname');
        $user->sched = Input::get('sched');
        $user->username = Input::get('userid');
        $user->password = Input::get('userid');
        $user->emptype = Input::get('emptype');
        $user->unique_row = Input::get('userid');
        $user->save();
        return Redirect::to('/');
    }

    public function flexi_group()
    {
        $scheds = WorkScheds::all();
        Session::put('sched', $scheds[0]['id']);
        if(isset($scheds) and count($scheds) > 0) {
            $users = DB::table('users')
                ->leftJoin('work_sched', function($join){
                    $join->on('users.sched','=','work_sched.id');
                })
                ->where('users.sched', '=', Session::get('sched'))
                ->orderBy('fname', 'ASC')
                ->paginate(20);
            Session::forget('sched');
            return View::make('users.flixe')->with('scheds',$scheds)->with('users',$users);
        }
    }
    public function filter_flixe()
    {
        if(Input::has('sched') and Input::get('sched')) {
            Session::put('sched', Input::get('sched'));
        }

        if(Session::has('sched')) {
            $scheds = WorkScheds::all();
            $sched = Session::get('sched');
            $users = DB::table('users')
                ->leftJoin('work_sched', function ($join) {
                    $join->on('users.sched', '=', 'work_sched.id');
                })
                ->where('users.sched', '=',$sched)
                ->orderBy('fname', 'ASC')
                ->paginate(20);
            return View::make('users.flixe')->with('scheds', $scheds)->with('users', $users);
        }
    }
}