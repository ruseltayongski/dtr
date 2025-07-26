<?php
//FOR ADMIN ROUTE GROUP

Route::get('logout', function(){
	Auth::logout();
	Session::flush();
	return Redirect::to('/');

});

Route::get('login', 'AdminController@login');

Route::get('dtr/{id}', 'GenerateDTRController@download_dtr');

Route::match(array('GET','POST'),'/', 'AdminController@index');
Route::match(array('GET','POST'),'home',array('before' => 'admin','uses' => 'AdminController@home'));

Route::get('rpchallenge', 'PasswordController@change_password');

Route::match(array('GET','POST'), 'admin/upload', 'DtrController@upload');
Route::post('admin/uploadv2', 'DtrController@UploadV2');
Route::post('admin/uploadv3', 'DtrController@UploadV3_accessmanager');
Route::match(array('GET','POST'), 'add/attendance', 'DtrController@create_attendance');
Route::get('employees','AdminController@list_all');
Route::match(array('GET','POST'),'beginning_balance','cdoController@beginning_balance');
Route::match(array('GET','POST'),'update_bbalance','cdoController@update_bbalance');
//manual process
Route::match(array('GET','POST'),'process_pending','cdoController@process_pending');
Route::match(array('GET', 'POST'), 'cancel_dates', 'cdoController@cancel_dates');
Route::get('list/regular', 'AdminController@list_regular');
Route::match(array('GET','POST'), 'change/work-schedule', 'AdminController@change_schedule');
Route::match(array('GET','POST'), 'print/individual', 'AdminController@print_individual');
Route::get('/search/user/j','AdminController@search_jo');
Route::get('/search/user/r','AdminController@search_regular');
Route::get('/search','AdminController@search');
Route::match(['GET','POST'],'add/user', 'AdminController@adduser');
Route::get('schedule/flixe', 'AdminController@flexi_group');
Route::get('datatables', 'AdminController@datatables');
Route::get('filter/flixe','AdminController@filter_flixe');
Route::get('work-schedule/group', 'AdminController@show_group');
Route::post('delete/attendance', 'AdminController@delete');
Route::match(['GET','POST'], 'reset/password', 'PasswordController@reset_password');
Route::post('user/delete', 'AdminController@delete_user');
Route::match(['GET','POST'],'user/edit', 'AdminController@user_edit');
Route::get('print/user/logs','AdminController@print_user_logs');
Route::post('print/mobile/logs','AdminController@print_mobile_logs');
Route::match(['GET','POST'],'leave/credits','AdminController@leave_credits');
Route::post('leave/credits/save','AdminController@updateLeaveBalance');
Route::get('get/regular/employee','AdminController@get_regular_emp');
Route::get('add_leave_table','AdminController@add_leave_table');
Route::match(array('GET','POST'), 'print-monthly', 'PrintController@print_monthly');
Route::get('print-monthly/attendance', 'PrintController@print_pdf');
Route::match(array('GET','POST'), 'print/employee-attendance', 'PrintController@print_employee');

Route::get('leave/card-view/{id}/{page}','AdminController@get_leave_view');

//manual process
Route::match(array('GET','POST'),'leave_card','cdoController@leave_card');
Route::get('leave_print/{route_no}', 'DocumentController@leave_print');

Route::get('work-schedule' ,'HoursController@create');
Route::match(array('GET','POST'), 'create/work-schedule', 'HoursController@work_schedule');
Route::match(array('GET','POST') , 'edit/work-schedule/{id}' ,'HoursController@edit_schedule');
Route::match(array('GET','POST') , 'edit/attendance/{id?}', 'DtrController@edit_attendance');
Route::get('delete/edited/logs/{userid}/{datein}/{time}/{event}','PersonalController@delete_logs');



Route::get('attendance','DtrController@attendance');
Route::get('attendance/q', 'DtrController@filter_attendance');
Route::match(array('GET','POST'),'resetpass', 'PasswordController@change_password');
//Route::post('/', 'PasswordController@save_changes');

//LEAVE PROCCESS

Route::match(['GET','POST'],'leave/roles','AdminController@track_leave');
Route::match(['GET', 'POST'],'leave/approved/{route_no}','AdminController@approved_leave');
Route::match(['GET', 'POST'], 'leave/disapproved/{route_no}','AdminController@disapproved_leave');
Route::post('leave/pending','AdminController@pending_leave');
Route::get('leave/delete/{id}','AdminController@delete_leave');
//Route::get('leave/update/{id}', 'AdminController@edit_leave');
Route::get('leave/cancel/{route_no}','AdminController@cancel_leave');
Route::match(array('GET', 'POST'), 'move_dates', 'AdminController@move_dates');
Route::match(array('GET', 'POST'), 'remarks', 'AdminController@remarks');
Route::get('search/leave','AdminController@search_leave');
Route::match(array('GET','POST'), 'form/leave_list', 'cdoController@leave_list');
Route::get('leave/balance/{userid}','AdminController@get_balance');
Route::post('leave/update_balance','AdminController@update_balance');
Route::post('update_absence','AdminController@update_absence');

//DTR
Route::get('dtr/list/jo', 'GenerateDTRController@list_jo_dtr');
Route::get('search/jo','GenerateDTRController@search_jo_dtr');
Route::get('dtr/list/regular', 'GenerateDTRController@list_regular_dtr');
Route::get('search/regular', 'GenerateDTRController@search_reg_dtr');
Route::get('dtr/download/{id}', 'GenerateDTRController@download_dtr');
Route::match(['GET','POST'],'/personal/dtr/list', 'PersonalController@personal_dtrlist');
Route::get('/ab','PersonalController@personal_filter_dtrlist');

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

Route::match(['GET','POST'],'personal/index',array('before' => 'standard-user','uses' => 'PersonalController@index'));

Route::get('personal/search', 'PersonalController@search');
Route::get('/personal/search/filter', 'PersonalController@search_filter');
Route::get('personal/print/monthly', 'PersonalController@print_monthly');
Route::post('personal/print/filter' ,'PersonalController@filter');
Route::post('personal/filter', 'PersonalController@emp_filtered');
Route::post('personal/filter/save', 'PersonalController@save_filtered');
Route::match(['get','post'], 'edit/personal/attendance/{id?}', 'PersonalController@edit_attendance');
Route::match(array('GET','POST'),'/personal/add/logs', 'PersonalController@add_logs');
Route::match(['GET','POST'],'create/absent/description', 'PersonalController@absent_description');
Route::post('delete/user/created/logs','PersonalController@delete_created_logs');
Route::match(['GET', 'POST'],'personal/excel/{id}','DocumentController@timelogs_excel');

//DOCUMENTS
Route::match(array('GET','POST'),'form/leave','DocumentController@leave');
Route::match(array('GET','POST'),'form/leave/all', 'DocumentController@all_leave');
Route::get('leave/get/{id}','DocumentController@get_leave');
Route::get('leave/print/{id}', 'DocumentController@print_leave');
Route::get('leave/print/a/{id}', 'DocumentController@print_a');
Route::post('leave/update/save', 'DocumentController@save_edit_leave');

//ADMIN TRACKED DOCUMENTS
Route::get('tracked/so', 'DocumentController@so_tracking');

Route::get('list/pdf', 'DocumentController@list_print');

Route::get('clear', function(){
	Session::flush();
	return Redirect::to('/');
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
////OFFICE ORDER
Route::match(array('GET','POST'), 'form/so', 'DocumentController@so');
Route::match(array('GET','POST'), 'form/so_view', 'DocumentController@so_view');
Route::match(array('GET','POST'), 'form/so_list', 'DocumentController@so_list');
Route::match(array('GET','POST'), 'form/sov1', 'DocumentController@sov1');
Route::get('inclusive_name_page', 'DocumentController@inclusive_name_page');
Route::get('inclusive_name_view', 'DocumentController@inclusive_name_view');
Route::post('so_add','DocumentController@so_add');
Route::post('so_delete','DocumentController@so_delete');
Route::post('so_updatev1','DocumentController@so_updatev1');
Route::post('so_update','DocumentController@so_update');
Route::get('so_pdf','DocumentController@so_pdf');

Route::match(['get','post'], 'form/track/{route_no}', 'DocumentController@track');
Route::get('form/so_pdf','DocumentController@so_pdf');
Route::get('inclusive_name', 'DocumentController@inclusive_name');
Route::get('so_append','DocumentController@so_append');
Route::get('form/info/{route}/{doc_type}', 'DocumentController@show');

//////CDO
Route::get('card/certificate/{ids}','cdoController@genCertificate');
Route::get('cdo/applied-dates/{route_no}','cdoController@appliedDates');
Route::post('cdo/transfer','cdoController@transfer');
Route::match(array('GET','POST'), 'form/cdo_list', 'cdoController@cdo_list');
Route::match(array('GET','POST'), 'form/cdo_user', 'cdoController@cdo_user');
Route::match(array("GET","POST"), "form/cdov1/{pdf}","cdoController@cdov1");
Route::post('cdo_addv1','cdoController@cdo_addv1');
Route::post('cdo_updatev1','cdoController@cdo_updatev1');
Route::post('cdo_updatev1/{id}/{type}','cdoController@cdo_updatev1');
Route::match(array('GET','POST'),'click_all/{type}','cdoController@click_all');
Route::post('cdo_delete','cdoController@cdo_delete');
///////CDO-PRIVILEGE
Route::post('privilege/add','cdoController@superviseEmployee');
Route::post('privilege/list','cdoController@superviseList');
Route::get('privilege/list','cdoController@superviseList');

/////////CALENDAR
Route::get('calendar','CalendarController@calendar');
Route::get('calendar_holiday','CalendarController@calendar_holiday');
Route::get('calendarEvent/{userid}','CalendarController@calendarEvent');
Route::post('calendar_save','CalendarController@calendar_save');
Route::get('calendar_delete/{event_id}','CalendarController@calendar_delete');
Route::post('calendar_update','CalendarController@calendar_update');
Route::post('calendar/add-individual-task','CalendarController@AddIndividualTask');
Route::post('calendar/delete-individual-task','CalendarController@DeleteIndividualTask');
Route::post('calendar/track/holiday','CalendarController@trackHoliday');

Route::get('manual','PersonalController@manual');
Route::get('print/employee', 'AdminController@print_employees');
/////////PDF
Route::get('pdf/v1/{size}', function($size){
	$display = View::make("pdf.pdf",['size'=>$size]);
	$pdf = App::make('dompdf');
	$pdf->loadHTML($display);
	return $pdf->setPaper($size, 'portrait')->stream();
});
Route::get('pdf/track', function(){
	$display = View::make("pdf.track");
	$pdf = App::make('dompdf');
	$pdf->loadHTML($display);
	return $pdf->stream();
});
////// ABSENT
Route::match(array('GET','POST'), 'form/absent', 'DocumentController@absent');
Route::get('open/reset','RessetPasswordController@reset');

//TEST ROUTES
Route::get('phpinfo', function() {
	return json_encode(phpinfo());
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

Route::get('ajax',function(){
	return View::make('ajax');
});

Route::get('ajax1',function(){
	if(Request::ajax()){
		return "Ajax request";
	} else {
		return "Not ajax";
	}
});

Route::get('sologs', function(){
	return SoLogs::all();
});

Route::get('search/id',function(){
	if(!Auth::check()){
		$keyword = Input::get('q');
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
		return View::make('auth.login',['users' => $users]);
	} else {
		return Redirect::to('/');
	}
});


//MOBILE URL
Route::post('mobile/login','MobileController@login');
Route::post('mobile/login/calendar','MobileControllerV2@LoginCalendar');
Route::post('mobile/add-logs','MobileController@add_logs');
Route::post('mobile/add-cto','MobileController@add_cto');
Route::post('mobile/add-so','MobileController@add_so');
Route::post('mobile/add-leave','MobileController@add_leave');
Route::match(['GET','POST'],'mobile/get-login','MobileController@getLogin');
Route::get('intranet/protected-data', array('before' => 'auth.token', 'uses' => 'MobileController@getLogin1'));
Route::get('mobile/getCurrentVersion','MobileController@getCurrentVersion');
Route::post('mobile/imei','MobileController@imei');
Route::post('mobile/reset_password','MobileControllerV3@resetPassword');
Route::post('mobile/check_username','MobileControllerV3@checkUsername');
//MOBILE URL version 2 in controller
Route::post('mobileV2/login','MobileControllerV2@login');
Route::post('mobileV2/login1','MobileControllerV2@login1');

Route::get('mobileV2/getCurrentVersion','MobileControllerV2@getCurrentVersionField');
Route::get('mobileV2/getCurrentVersion/office','MobileControllerV2@getCurrentVersionOffice');
Route::post('mobileV2/add-logs','MobileControllerV2@add_logs');
Route::post('mobileV2/add-flags','MobileControllerV2@add_flags');
Route::post('mobileV2/add-cdo','MobileControllerV2@add_cdo');
Route::get('mobileV2/get-logs','MobileControllerV2@get_logs');
Route::post('mobileV2/add-so','MobileControllerV2@add_so');
Route::post('mobileV2/add-leave','MobileControllerV2@add_leave');
Route::post('mobileV2/imei','MobileControllerV2@imei');

Route::get('mobile/office/announcement','MobileControllerV2@announcementAPI');
Route::get('mobile/get/version','MobileControllerV2@appVersionAPIOld'); // changed from office to get
Route::get('mobile/get/version/{device_type}','MobileControllerV2@appVersionAPINew');
Route::get('mobile/office/announcement/view','MobileControllerV2@announcementView');
Route::get('mobile/office/version/view/{type}','MobileControllerV2@appVersionView');
Route::post('mobile/office/announcement/post','MobileControllerV2@announcementPost');
Route::post('mobile/office/version/post','MobileControllerV2@appVersionPost');
Route::get('mobile/office/force-update/ios','MobileControllerV2@forceUpdate');
Route::get('mobile/office/time','MobileControllerV2@server_time');
Route::get('mobile/office/area-assignment/reset/{userid}','MobileControllerV2@areaAssignmentReset');

Route::post('mobile/appstore/update','MobileControllerV2@appstoreUpdate');
Route::get('mobile/privacy-policy','MobileControllerV2@privacyPolicy');

Route::match(['GET','POST'],'mobileV3/area_of_assignment', 'MobileControllerV3@getAreaAssignment');


//SUB ADMIN - NEGROS AND BOHOL
Route::get('subHome',array('before' => 'sub','uses' => 'SubController@subHome'));
Route::post('sub/upload', 'SubController@upload');

//GIT
Route::get('git_pull','GitController@git_pull');
Route::get('git_push','GitController@git_push');
Route::get('git_add','GitController@git_add');
Route::get('git_commit','GitController@git_commit');

//TIMELOG
Route::match(['POST','GET'],'logs/timelogs','TimeLogController@timelog');
Route::match(['POST','GET'],'logs/timelogs/{supervisor}','TimeLogController@timelog');
Route::post('logs/timelog/edit','TimeLogController@edit');
Route::post('logs/timelog/check_all/edit','TimeLogController@allEdit');
Route::match(['POST', 'GET'],'logs/timelog/append','TimeLogController@append');

//COMMENT
Route::post('faq/comment_append','FaqController@comment_append');
Route::post('faq/reply_append','FaqController@reply_append');

//SUPERVISOR
Route::post('supervise/add','SupervisorController@superviseEmployee');
Route::post('supervise/list','SupervisorController@superviseList');
Route::get('supervise/list','SupervisorController@superviseList');
Route::post('supervise/individual','SupervisorController@superviseIndividual');

//LOCATION
Route::match(['GET','POST'],'location/roles','SupervisorController@location');

//report
Route::match(['GET','POST'],'report/roles','SupervisorController@Report');

Route::get('map/{am_in_lat}/{am_in_lon}/{am_in_time}/{am_out_lat}/{am_out_lon}/{am_out_time}/{pm_in_lat}/{pm_in_lon}/{pm_in_time}/{pm_out_lat}/{pm_out_lon}/{pm_out_time}','TimeLogController@map');

//AREA OF ASSIGNMENT
Route::get('area-assignment/{province}', 'AreaAssignmentController@index');
Route::post('area-assignment/add/{province}', 'AreaAssignmentController@viewAdd');
Route::post('area-assignment/add-area', 'AreaAssignmentController@addArea');
Route::get('area-assignment/info/{id}/{province}', 'AreaAssignmentController@show');
Route::post('area-assignment/update', 'AreaAssignmentController@update');
Route::post('area-assignment/delete/{province}', 'AreaAssignmentController@delete');
Route::post('area-assignment/search/{province}', 'AreaAssignmentController@search');
Route::get('area-assignment_map/view_map', 'AreaAssignmentController@viewMap');
Route::get('get/user/area_of_assignment/{userid}', 'AreaAssignmentController@viewUserMap');
Route::get('download_apk',function(){

    return View::make('download_apk',[
    		"version" => AppAPI::where('device_type', "android")->first()
    ]);
});

//GENERATE FLAG ATTENDANCE
Route::post('generate/flag/attendance', 'AdminController@generateFlagAttendance');

//GENERATE FOR A NEED OF CCTV
Route::post('generate/cctv/logs', 'AdminController@generateCCTVLogs');

//API for JWT
Route::get('info/{userid}','MobileControllerV2@info');

//API for Wellness
Route::post('wellness/save-wellness','WellnessController@store'); 
Route::get('wellness/get-wellness','WellnessController@index'); 
Route::get('wellness/status','WellnessController@getStatus');
Route::post('wellness/get-wellness/{wellness_id}','WellnessController@update');
Route::post('wellness/save-logs','WellnessController@save_logs'); 
?>