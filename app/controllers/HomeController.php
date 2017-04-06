<?php


class HomeController extends BaseController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->beforeFilter(function () {
            if(!Auth::check())
            {
                return Redirect::to('/');
            }
        });
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
       if($request->user()->usertype == "1") {
           return redirect('home');
       }
       if($request->user()->usertype == "0") {
           return redirect('personal/home');
       }
    }
}
