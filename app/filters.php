<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/


App::before(function($request)
{
	if ($request->getMethod() === 'POST' and !Request::ajax()) {
		if (Session::token() != Input::get('_token'))
		{
			//return Redirect::to('/');
		}
	}
});


App::after(function($request, $response)
{

	$response->headers->set('Cache-Control', 'nocache, no-store, max-age=0, must-revalidate');
	$response->headers->set('Pragma', 'no-cache');
	$response->headers->set('Expires', 'Fri, 01 Jan 1990 00:00:00 GMT');

	return $response;
});

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/

Route::filter('auth', function()
{
	if (Auth::guest())
	{
		if (Request::ajax())
		{
			return Response::make('Unauthorized', 401);
		}
		else
		{
			//return Redirect::secure(Request::path()); //force HTTPS
			return Redirect::guest('/');
		}
	}
});

Route::filter('admin' ,function(){
	if(Auth::check() && Auth::user()->usertype == 1) {
        if(Auth::user()->pass_change == NULL){
            return Redirect::to('resetpass')->with('pass_change','You must change your password for security after your first log in');
        }
	} else {
	    return Redirect::to('/');
    }
});

Route::filter('sub' ,function(){
    if(Auth::check() && Auth::user()->usertype == 5 || Auth::user()->usertype == 3) {
        if(Auth::user()->pass_change == NULL){
            return Redirect::to('resetpass')->with('pass_change','You must change your password for security after your first log in');
        }
    }
});

Route::filter('standard-user', function(){
    if(Auth::check() AND (Auth::user()->usertype == 0 || Auth::user()->usertype == 2 || Auth::user()->usertype == 4) ){
        if(Auth::user()->pass_change == NULL){
            return Redirect::to('resetpass')->with('pass_change','You must change your password for security after your first log in');
        }
    } else {
        return Redirect::to('/');
    }
});


Route::filter('auth.basic', function()
{
	return Auth::basic();
});


/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|
*/

Route::filter('guest', function()
{
	if (Auth::check()) return Redirect::to('/');
});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function()
{
	if (Session::token() != Input::get('_token'))
	{
		return Redirect::to('/');
		//throw new Illuminate\Session\TokenMismatchException;
	}
});

//intranet

Route::filter('auth.token', function($route, $request)
{
    $headers = apache_request_headers(); // or use Request::header() if available

    if (!isset($headers['Authorization'])) {
        return Response::json(['error' => 'Authorization header not found'], 401);
    }

    $authHeader = $headers['Authorization'];
    $token = str_replace('Bearer ', '', $authHeader);

    if ($token !== "Jp+r'6zI!8V=\"tHh:GmY|:=k;KLO}egquMl2sv}LpBFzeSl6'5A-HR;-v[pSmX]!") {
        return Response::json(['error' => 'Unauthorized'], 401);
    }
});

