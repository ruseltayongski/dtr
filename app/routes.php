<?php


//FOR ADMIN ROUTE GROUP

Route::match(array('GET','POST'),'/', 'AdminController@index');
Route::get('logout', function(){
	Auth::logout();
	Session::flush();
	return Redirect::to('/');
});

Route::get('home', function(){
	Session::forget('f_from');
	Session::forget('f_to');
	Session::forget('lists');
	return Redirect::to('index');
});
Route::get('index',array('before' => 'auth','uses' => 'AdminController@home'));

Route::get('rpchallenge', 'PasswordController@change_password');

Route::match(array('GET','POST'), 'admin/upload', 'DtrController@upload');
Route::match(array('GET','POST'),'search', 'DtrController@search');
Route::match(array('GET','POST'), 'add/attendance', 'DtrController@create_attendance');
Route::get('list/job-order','AdminController@list_jo');
Route::get('list/regular', 'AdminController@list_regular');
Route::match(array('GET','POST'), 'change/work-schedule', 'AdminController@change_schedule');
Route::match(array('GET','POST'), 'print/individual', 'AdminController@print_individual');


Route::match(array('GET','POST'), 'print-monthly', 'PrintController@print_monthly');
Route::get('print-monthly/attendance', 'PrintController@print_pdf');
Route::match(array('GET','POST'), 'print/employee-attendance', 'PrintController@print_employee');

Route::get('work-schedule' ,'HoursController@create');
Route::match(array('GET','POST'), 'create/work-schedule', 'HoursController@work_schedule');
Route::match(array('GET','POST') , 'edit/work-schedule/{id}' ,'HoursController@edit_schedule');
Route::match(array('GET','POST') , 'edit/attendance/{id?}', 'DtrController@edit_attendance');
Route::post('delete/attendance','DtrController@delete');
Route::match(array('GET','POST'),'resetpass', 'PasswordController@change_password');
//Route::post('/', 'PasswordController@save_changes');


//DTR

Route::get('dtr/list/jo', 'GenerateDTRController@list_jo_dtr');
Route::get('dtr/list/regular', 'GenerateDTRController@list_regular_dtr');
Route::get('dtr/download/{id}', 'GenerateDTRController@download_dtr');
Route::get('/personal/dtr/list', 'GenerateDTRController@personal_dtrlist');
Route::get('/personal/dtr/filter/list','PersonalController@personal_filter_dtrlist');
//FOR PERSONAL ROUTE GROUP

Route::get('personal/home', function() {
	Session::forget('f_from');
	Session::forget('f_to');
	Session::forget('lists');
	return Redirect::to('personal/index');
});
Route::get('personal/monthly',function() {
	Session::forget('filter_list');
	return Redirect::to('personal/print/monthly');
});

Route::get('personal/index', 'PersonalController@index');
Route::get('/personal/search/filter', 'PersonalController@search_filter');
Route::get('personal/print/monthly', 'PersonalController@print_monthly');
Route::post('personal/print/filter' ,'PersonalController@filter');
Route::post('personal/filter', 'PersonalController@emp_filtered');
Route::post('personal/filter/save', 'PersonalController@save_filtered');
Route::match(['get','post'], 'edit/personal/attendance/{id?}', 'PersonalController@edit_attendance');
Route::match(array('GET','POST'),'/personal/add/logs', 'PersonalController@add_logs');

//DOCUMENTS
Route::match(array('GET','POST'),'form/leave','DocumentController@leave');
Route::get('form/leave/all', 'DocumentController@all_leave');
Route::get('leave/get/{id}','DocumentController@get_leave');
Route::get('leave/print/{id}', 'DocumentController@print_leave');
Route::get('leave/update/{id}', 'DocumentController@edit_leave');
Route::post('leave/update/save', 'DocumentController@save_edit_leave');

Route::get('list/pdf', 'DocumentController@list_print');

Route::get('clear', function(){
	Session::flush();
});

Route::get('modal',function(){
	return view('users.modal');
});

Route::get('errorupload', function(){
	return view('errorupload');
});

Route::get('test/form', function(){
	return view('test.form');
});
Route::post('test/form',function(\Illuminate\Http\Request $request){
	return $request->all();
});

Route::get('pdf/leave',function() {

	$display = view("pdf.leave");
	$pdf = App::make('dompdf.wrapper');
	$pdf->loadHTML($display);
	return $pdf->stream();
});

/////////RUSEL
Route::match(array('GET','POST'), 'form/so', 'DocumentController@so');
Route::match(array('GET','POST'), 'form/so_view', 'DocumentController@so_view');
Route::match(array('GET','POST'), 'form/so_list', 'DocumentController@so_list');
Route::get('form/so_pdf','DocumentController@so_pdf');
Route::get('inclusive_name', 'DocumentController@inclusive_name');
Route::get('so_append','DocumentController@so_append');
Route::post('so_add','DocumentController@so_add');
Route::get('form/info/{route}', 'DocumentController@show');
/////////CALENDAR
Route::get('calendar', 'CalendarController@calendar');
Route::get('calendar_event', 'CalendarController@calendar_event');
Route::get('example','DocumentController@check_calendar');

//TEST ROUTES
Route::get('phpinfo', function() {
	return phpinfo();
});


Route::get('fpdf', 'PersonalController@rdr_home');

Route::get('emptype', function() {
	Schema::create('generated_pdf', function (Blueprint $table) {
		$table->increments('id');
		$table->string('filename')->nullable();
		$table->date('date_from')->nullable();
		$table->date('date_to')->nullable();
		$table->date('date_created');
		$table->time('time_created');
		$table->string('generated',10)->nullable();
		$table->rememberToken();
		$table->timestamps();
	});
});


?>