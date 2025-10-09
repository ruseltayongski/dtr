<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Collection;

class WellnessController extends BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	
	// public function index()
	// {
	// 	$user = Auth::user();

	// 	$userRecord = DB::table('dts.users')
	// 		->where('username', $user->userid)
	// 		->first();

	// 	if (!$userRecord) {
	// 		return View::make('wellness.requests', [
	// 			// 'wellness' => []
	// 			'wellness' => Paginator::make([], 0, 15)
	// 		]);
	// 	}

	// 	$userId = $userRecord->id;

	// 	$isSectionHead = DB::table('dts.section')
	// 		->where('head', $userId)
	// 		->exists();

	// 	$isDivisionHead = DB::table('dts.division')
	// 		->where('head', $userId)
	// 		->exists();

	// 	$wellness = [];

	// 	if ($isSectionHead) {
	// 		$sectionRequests = DB::table('wellness')
	// 			->join('dts.users as u', 'u.username', '=', 'wellness.userid')
	// 			->join('dts.section as s', 's.id', '=', 'u.section')
	// 			->where('s.head', $userId)
	// 			->where('u.id', '!=', $userId)
	// 			->select(
	// 				'wellness.*',
	// 				DB::raw("CONCAT(u.fname, ' ', u.lname) as user_name")
	// 			)
	// 			->get();

	// 		$wellness = array_merge($wellness, is_array($sectionRequests) ? $sectionRequests : $sectionRequests->all());
	// 	}

	// 	if ($isDivisionHead) {
	// 		$divisionRequests = DB::table('wellness')
	// 			->join('dts.users as u', 'u.username', '=', 'wellness.userid')
	// 			->join('dts.section as s', 's.id', '=', 'u.section')
	// 			->join('dts.division as d', 'd.id', '=', 's.division')
	// 			->where('d.head', $userId)
	// 			->whereRaw('s.head = u.id') // this ensures the request is from a section head
	// 			->select(
	// 				'wellness.*',
	// 				DB::raw("CONCAT(u.fname, ' ', u.lname) as user_name")
	// 			)
	// 			->get();

	// 		$wellness = array_merge($wellness, is_array($divisionRequests) ? $divisionRequests : $divisionRequests->all());
	// 	}

	// 	foreach ($wellness as &$record) {
	// 		$record->logs = DB::table('wellness_logs')
	// 			->where('wellness_id', $record->id)
	// 			->orderBy('created_at', 'desc')
	// 			->get();
	// 	}
	// 	// Manual Pagination (Laravel 4.2 style)
	// 	$page = Input::get('page', 1);
	// 	$perPage = 15;
	// 	$offset = ($page - 1) * $perPage;
	// 	$pagedData = array_slice($wellness, $offset, $perPage);
	// 	$paginator = Paginator::make($pagedData, count($wellness), $perPage);

	// 	return View::make('wellness.requests', [
	// 		'wellness' => $paginator
	// 	]);
	// }

	// public function index()
	// {
	// 	$authUser = Auth::user();
	// 	$user_type = $authUser->usertype;

	// 	// Get full user record based on username
	// 	$userRecord = DB::table('users')
	// 		->where('username', $authUser->username)
	// 		->first();

	// 	if (!$userRecord) {
	// 		return View::make('wellness.requests', [
	// 			'wellness' => Paginator::make([], 0, 15)
	// 		]);
	// 	}

	// 	$supervisors = array_values(
	// 		DB::table('supervise_employee')->distinct()->lists('supervisor_id')
	// 	);

	// 	$superviseeUsernames = DB::table('supervise_employee')
	// 		->where('supervisor_id', $authUser->userid)
	// 		->lists('userid');

	// 	$filterRange = Input::get('filter_range');
	// 	$filter      = Input::get('filter');   // 'past' or 'upcoming'
	// 	$statuses    = array_filter((array) Input::get('status')); // remove empty values
	// 	$keyword     = Input::get('keyword');

	// 	$query = DB::table('wellness')
	// 		->join('users', 'users.username', '=', 'wellness.userid')
	// 		->select('wellness.*', DB::raw("CONCAT(users.fname, ' ', users.lname) as user_name"));

	// 	// Role-based filtering
	// 	if ($user_type === 1) {
	// 		// HR admin → show only supervisors
	// 		$query->whereIn('users.username', $supervisors);
	// 	} else {
	// 		// Supervisor → show only supervisees
	// 		$query->whereIn('users.username', $superviseeUsernames);
	// 	}

	// 	if (!empty($filterRange)) {
	// 		$filter = null;
	// 	}

	// 	// Date filtering
	// 	if (!empty($filterRange)) {
	// 		// Custom range filter overrides past/upcoming
	// 			$dates = explode(' - ', $filterRange);
	// 			if (count($dates) === 2) {
	// 				$startDate = Carbon::createFromFormat('m/d/Y', trim($dates[0]))->startOfDay();
	// 				$endDate   = Carbon::createFromFormat('m/d/Y', trim($dates[1]))->endOfDay();
	// 				$query->whereBetween('wellness.scheduled_date', [$startDate, $endDate]);

	// 				if (!empty($statuses)) {
	// 				$query->whereIn('wellness.status', $statuses);
	// 			}
	// 		}
	// 	} elseif ($filter === 'past') {
	// 		// Past 7 days
	// 		$query->whereBetween('wellness.scheduled_date', [
	// 			Carbon::now()->subWeek()->startOfDay(),
	// 			Carbon::now()->endOfDay(),
	// 		]);

	// 		if (!empty($statuses)) {
	// 			$query->whereIn('wellness.status', $statuses);
	// 		}
	// 	} elseif ($filter === 'upcoming') {
	// 		// Next 7 days
	// 		$query->whereBetween('wellness.scheduled_date', [
	// 			Carbon::now()->startOfDay(),
	// 			Carbon::now()->addWeek()->endOfDay(),
	// 		]);

	// 		if (!empty($statuses)) {
	// 			$query->whereIn('wellness.status', $statuses);
	// 		}
	// 	}

	// 	// Keyword search
	// 	if (!empty($keyword)) {
	// 		$query->where(function ($q) use ($keyword) {
	// 			$q->where('users.fname', 'like', "%{$keyword}%")
	// 			->orWhere('users.lname', 'like', "%{$keyword}%")
	// 			->orWhere('wellness.type_of_request', 'like', "%{$keyword}%");
	// 		});

	// 		Session::put('keyword', $keyword);
	// 	} else {
	// 		Session::forget('keyword');
	// 	}

	// 	// Fetch results
	// 	$wellness = $query->orderBy('scheduled_date', 'desc')->get();

	// 	foreach ($wellness as &$record) {
	// 		$record->logs = DB::table('wellness_logs')
	// 			->where('wellness_id', $record->id)
	// 			->orderBy('created_at', 'desc')
	// 			->get();
	// 	}

	// 	$logs = DB::table('wellness_logs')
	// 		->join('wellness', 'wellness_logs.wellness_id', '=', 'wellness.id')
	// 		->join('users', 'users.username', '=', 'wellness.userid')
	// 		->join('supervise_employee', 'supervise_employee.userid', '=', 'users.username')
	// 		->select(
	// 			'wellness_logs.*',
	// 			'wellness.*',
	// 			DB::raw("CONCAT(users.fname, ' ', users.lname) as user_name")
	// 		)
	// 		->where('supervise_employee.supervisor_id', $authUser->username)
	// 		->get();

	// 	// Pagination
	// 	$page     = Input::get('page', 1);
	// 	$perPage  = 15;
	// 	$offset   = ($page - 1) * $perPage;
	// 	$pagedData = array_slice($wellness, $offset, $perPage);
	// 	$paginator = Paginator::make($pagedData, count($wellness), $perPage);

	// 	if (Request::ajax()) {
	// 		return View::make('wellness.partials.results', [
	// 			'wellness' => $paginator,
	// 			'logs'     => $logs
	// 		])->render();
	// 	}

	// 	return View::make('wellness.requests', [
	// 		'wellness' => $paginator->appends(Input::except('page')),
	// 		'logs'     => $logs,
	// 		'filter' => $filter, //past or upcoming
	// 	]);
	// }
	public function index()
	{
		$authUser = Auth::user();
		$user_type = $authUser->usertype;

		$filterRange = Input::get('filter_range');
		$filter      = Input::get('filter'); // past or upcoming
		$allStatuses = ['pending', 'approved', 'declined'];
		$statuses    = (array) Input::get('status', $allStatuses);
		$keyword     = Input::get('keyword');

		$query = $this->wellnessQuery($authUser, $user_type, $filterRange, $filter, $statuses, $keyword);

		$wellness = $query->orderBy('scheduled_date', 'desc')->get();

		// Attach logs
		foreach ($wellness as &$record) {
			$record->logs = DB::table('wellness_logs')
				->where('wellness_id', $record->id)
				->orderBy('created_at', 'desc')
				->get();
		}

		$logs = DB::table('wellness_logs')
			->join('wellness', 'wellness_logs.wellness_id', '=', 'wellness.id')
			->join('users', 'users.username', '=', 'wellness.userid')
			->join('supervise_employee', 'supervise_employee.userid', '=', 'users.username')
			->select(
				'wellness_logs.*',
				'wellness.*',
				DB::raw("CONCAT(users.fname, ' ', users.lname) as user_name")
			)
			->where('supervise_employee.supervisor_id', $authUser->username)
			->get();

		// Manual pagination
		$page = Input::get('page', 1);
		$perPage = 15;
		$offset = ($page - 1) * $perPage;
		$pagedData = array_slice($wellness, $offset, $perPage);
		$paginator = Paginator::make($pagedData, count($wellness), $perPage);

		$paginator->appends([
			'filter' => $filter,
			'search' => $keyword,
			'status' => $statuses,  // 👈 force array into query string
		]);

		if (Request::ajax()) {
			return View::make('wellness.partials.results', [
				'wellness' => $paginator->appends(Input::except('page')),
				'logs'     => $logs,
				'statuses' => $statuses,
				'allStatuses' => $allStatuses,
				'filter'   => $filter, 
			])->render();
		}

		return View::make('wellness.requests', [
			'wellness' => $paginator->appends(Input::except('page')),
			'logs'     => $logs,
			'statuses' => $statuses,
			'allStatuses' => $allStatuses,
			'filter'   => $filter, 
		]);
	}

	public function report()
	{
		$authUser = Auth::user();
		$user_type = $authUser->usertype;

		$filterRange = Input::get('filter_range');
		$filter      = Input::get('filter');
		$statuses    = (array) Input::get('status');
		$keyword     = Input::get('keyword');

		$query = $this->wellnessQuery($authUser, $user_type, $filterRange, $filter, $statuses, $keyword);

		$wellness = $query->orderBy('scheduled_date', 'desc')->get();

		return View::make('wellness.report', [
			'wellness' => $wellness,
			'filterRange' => $filterRange,
		]);
	}

	public function exportReport($format)
	{
		$authUser = Auth::user();
		$user_type = $authUser->usertype;

		$filterRange = Input::get('filter_range');
		$filter      = Input::get('filter');
		$statuses    = (array) Input::get('status');
		$keyword     = Input::get('keyword');

		$query = $this->wellnessQuery($authUser, $user_type, $filterRange, $filter, $statuses, $keyword);
		$wellness = $query->orderBy('scheduled_date', 'desc')->get();

		if ($format === 'excel') {
			return Excel::create('wellness_report', function($excel) use ($wellness) {
				$excel->sheet('Report', function($sheet) use ($wellness) {
					$sheet->fromArray($wellness);
				});
			})->download('xlsx');
		}

		// if ($format === 'pdf') {

			// $html = view('wellness.partials.report-pdf', compact('wellness'))->render();
       		// $pdf = PDF::loadHTML($html);
			// $pdf = PDF::loadView('wellness.report_pdf', ['wellness' => $wellness]);
		// 	return $pdf->download('wellness_report.pdf');
		// }
		if ($format === 'pdf') {
		// Render Blade into HTML
		$html = View::make('wellness.partials.report', compact('wellness'))->render();

		// Use dompdf directly
		$pdf = \App::make('dompdf.wrapper'); // this is the IoC alias for dompdf
		$pdf->loadHTML($html)->setPaper('a4', 'portrait');

		// Return download instead of stream
		return $pdf->download('wellness_report.pdf');
	}


		abort(404);
	}




	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	 public function store() 
    {
		try {
				// return Input::get('scheduled_date');
				$validator = Validator::make(Input::all(), array(
				'userid' => 'required|string',
				'type_of_request' => 'required|string',
				'scheduled_date' => 'required|date',
				'unique_code' => 'unique:wellness,unique_code',
				'is_head' => 'required|integer'
			));

			if ($validator->fails()) {
					return [
					"code" => 0,
					"response" => 'error',
					"errors" => $validator->errors()
				];
			}

			$wellness = new Wellness();
			$wellness->userid = Input::get('userid');
			$wellness->type_of_request = Input::get('type_of_request');
			$wellness->scheduled_date = Input::get('scheduled_date');
			$wellness->unique_code = Input::get('unique_code');
			if (Input::get('is_head') == 1) {
				$wellness->status = 'approved';
			} else {
				$wellness->status = 'pending';
			}

			$wellness->save();

			return [
				"code" => 200,
				"response" => "Wellness record saved successfully",
				"status" => $wellness->status
			];
		} catch (Exception $e){
            return [
                "code" => 0,
                "response" => $e->getMessage()
            ];
        }
    }

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($wellness_id)
	{
		try {
			$action = Input::get('action'); // Get which button was clicked
			$user = Auth::user();
			
			if (!in_array($action, array('approve', 'decline'))) {
				return Redirect::back()->with('error', 'Invalid action.');
			}
			
			$wellness = Wellness::findOrFail($wellness_id);
			
			if ($action === 'approve') {
				$wellness->status = 'approved';
				$wellness->approved_by = $user->userid;
				$successMsg = 'Wellness request approved successfully!';
			} elseif ($action === 'decline') {
				$wellness->status = 'declined';
				$successMsg = 'Wellness request cancelled successfully!';
			} else {
				return Redirect::back()->with('error', 'Invalid or missing action. Status unchanged.');
			}
			
			$wellness->save();
			
			if (Request::ajax() || Request::wantsJson()) {
				return Response::json(array(
					'status' => 'success',
					'message' => $successMsg,
					'data' => array(
						'id' => $wellness->id,
						'status' => $wellness->status,
						'userid' => $wellness->userid,
						'type_of_request' => $wellness->type_of_request,
						'action_performed' => $action
					)
				), 200);
			}
			
			return Redirect::back()->with('success', $successMsg);
			
		} catch (Exception $e) {
			
			if (Request::ajax() || Request::wantsJson()) {
				return Response::json(array(
					'status' => 'error',
					'message' => 'Failed to update status.',
					'error' => $e->getMessage()
				), 500);
			}
			return Redirect::back()->with('error', 'Failed to update status.');
		}
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

	public function getStatus(){

		$uniqueCode = Input::get('unique_code');

		if (!$uniqueCode) {
			return [
				'code' => 0,
				'response' => 'Unique code is required'
			];
		}

		$wellness = Wellness::where('unique_code', $uniqueCode)->first();

		if (!$wellness) {
			return [
				'code' => 0,
				'response' => 'No record found'
			];
		}

		return [
			'code' => 200,
			'response' => $wellness->status
		];
	}

	public function save_logs(){
		try {
			// $unique_code = Input::get('unique_code');
			$logs = Input::get('logs');

			// Log::info('Received unique_code:', ['unique_code' => $unique_code]);
			Log::info('Received logs:', ['logs' => $logs]);

			if (!is_array($logs)) {
				return Response::json([
					'code' => 0,
					'response' => 'Invalid input. `unique_code` and `logs` array are required.'
				], 400);
			}

			foreach ($logs as $logData) {
				if (!isset($logData['time_start'], $logData['time_end'], $logData['time_consumed'], $logData['remarks'], $logData['unique_code'])) {
					continue; // skip invalid item
				}

				$wellness = Wellness::where('unique_code','=', $logData['unique_code'])->first();

					if (!$wellness) {
						return Response::json([
							'code' => 0,
							'response' => 'No wellness entry found for the given unique code.'
						], 404);
					}

				$log = new WellnessLogs();
				$log->wellness_id = $wellness->id;
				$log->time_start = Carbon::parse($logData['time_start']);
				$log->time_end = Carbon::parse($logData['time_end']);
				$log->time_consumed = $logData['time_consumed'];
				$log->remarks = $logData['remarks'];
				$log->save();
			}

			return Response::json([
				'code' => 200,
				'response' => 'Logs saved successfully.',
				'logs' => $log
			]);

		} catch (Exception $e) {
			return Response::json([
				'code' => 500,
				'response' => 'An error occurred while saving logs.',
				'error' => $e->getMessage()
			], 500);
		}
	}

	public function individualReport($unique_code, $year, $month)
	{
		$start = Carbon::create($year, $month)->startOfMonth();
		$end = Carbon::create($year, $month)->endOfMonth();

		$wellness = Wellness::where('unique_code', $unique_code)->firstOrFail();

		$logs = \DB::table('wellness_logs')
			->where('wellness_id', $wellness->id)
			->whereBetween('created_at', [$start, $end])
			->get();

		$pdf = new \FPDF();
		$pdf->AddPage();
		$pdf->SetFont('Arial', 'B', 14);
		$pdf->Cell(0, 10, "Wellness Report - " . $start->format('F Y'), 0, 1, 'C');

		// Basic Info
		$pdf->SetFont('Arial', '', 12);
		$pdf->Cell(0, 10, "Employee: " . $wellness->userid, 0, 1);
		$pdf->Cell(0, 10, "Unique Code: " . $wellness->unique_code, 0, 1);
		$pdf->Ln(5);

		// Table header
		$pdf->SetFont('Arial', 'B', 12);
		$pdf->Cell(10, 10, '#', 1);
		$pdf->Cell(40, 10, 'Time Start', 1);
		$pdf->Cell(40, 10, 'Time End', 1);
		$pdf->Cell(60, 10, 'Time Consumed', 1);
		$pdf->Ln();

		// Table rows
		$pdf->SetFont('Arial', '', 12);
		$totalSeconds = 0;
		foreach ($logs as $i => $log) {
			$pdf->Cell(10, 10, $i + 1, 1);
			$pdf->Cell(40, 10, $log->time_start, 1);
			$pdf->Cell(40, 10, $log->time_end, 1);
			$pdf->Cell(60, 10, $log->time_consumed, 1);
			$pdf->Ln();

			// Optional: convert string time_consumed into total seconds
			$totalSeconds += $this->convertToSeconds($log->time_consumed);
		}

		// Total
		$pdf->SetFont('Arial', 'B', 12);
		$pdf->Cell(90, 10, 'Total Time', 1);
		$pdf->Cell(60, 10, $this->formatDuration($totalSeconds), 1);
		$pdf->Ln();

		// $pdf->Output('D', "wellness_report_{$unique_code}_{$year}_{$month}.pdf");
		return Response::make($pdf->Output('S'), 200, [
			'Content-Type' => 'application/pdf',
			'Content-Disposition' => 'inline; filename="wellness_report_'.$unique_code.'_'.$year.'_'.$month.'.pdf"'
		]);
	}

	private function convertToSeconds($string)
	{
		// Handles formats like "1 hr 15 min", "45 minutes", "2 hours"
		// $total = 0;
		// if (preg_match('/(\d+)\s*hr/', $string, $h)) {
		// 	$total += ((int)$h[1]) * 3600;
		// }
		// if (preg_match('/(\d+)\s*min/', $string, $m)) {
		// 	$total += ((int)$m[1]) * 60;
		// }
		return ((int) $string) * 60; // 1 minute = 60 seconds
	}

	private function formatDuration($seconds)
	{
		$h = floor($seconds / 3600);
		$m = floor(($seconds % 3600) / 60);
		return "{$h} hr {$m} min";
	}

	public function monthlyReport($year, $month)
	{
		$start = Carbon::create($year, $month)->startOfMonth();
		$end = Carbon::create($year, $month)->endOfMonth();

		$report = DB::table('wellness_logs')
			->join('wellness', 'wellness_logs.wellness_id', '=', 'wellness.id')
			->select(
				'wellness.userid',
				'wellness.unique_code',
				DB::raw('COUNT(wellness_logs.id) as sessions'),
				// DB::raw('SUM(TIME_TO_SEC(wellness_logs.time_consumed)) as total_seconds')
				DB::raw('SUM(wellness_logs.time_consumed) as total_seconds')
			)
			->whereBetween('wellness_logs.created_at', [$start, $end])
			->groupBy('wellness.id')
			->get();

		// Start FPDF
		$pdf = new \FPDF();
		$pdf->AddPage();
		$pdf->SetFont('Arial', 'B', 16);
		$pdf->Cell(0, 10, "Wellness Monthly Report - " . $start->format('F Y'), 0, 1, 'C');

		$pdf->SetFont('Arial', 'B', 12);
		$pdf->Cell(10, 10, '#', 1);
		$pdf->Cell(50, 10, 'Employee Name', 1);
		// $pdf->Cell(40, 10, 'Unique Code', 1);
		$pdf->Cell(30, 10, 'Sessions', 1);
		$pdf->Cell(60, 10, 'Total Time Consumed', 1);
		$pdf->Ln();

		$pdf->SetFont('Arial', '', 12);
		foreach ($report as $index => $item) {
			$formattedTime = $this->formatDuration($item->total_seconds);
			$pdf->Cell(10, 10, $index + 1, 1);
			$pdf->Cell(50, 10, $item->userid, 1);
			// $pdf->Cell(40, 10, $item->unique_code, 1);
			$pdf->Cell(30, 10, $item->sessions, 1);
			$pdf->Cell(60, 10, $formattedTime, 1);
			$pdf->Ln();
		}

		return Response::make($pdf->Output('S'), 200, [
			'Content-Type' => 'application/pdf',
			'Content-Disposition' => 'inline; filename="wellness_monthly_report_'.$year.'_'.$month.'.pdf"'
		]);
	}

	public function checkSupervisor(){
		$userid = Input::get('userid');

		$userAsHead = DB::table('users')
			->leftJoin('dts.users as dts_users', 'dts_users.username', '=', 'users.username')
			->leftJoin('dts.section', 'dts.section.head', '=', 'dts_users.id')
			->leftJoin('dts.division', 'dts.division.head', '=', 'dts_users.id')
			->where('users.username', $userid) 
			->selectRaw("
				users.username as supervisor_id,
				CONCAT(users.fname, ' ', users.lname) as supervisor_name,
				dts.section.head IS NOT NULL as is_section_head,
				dts.division.head IS NOT NULL as is_division_head
			")
			->first();

		if ($userAsHead && ($userAsHead->is_section_head || $userAsHead->is_division_head)) {
			return Response::json([
				'code' => 200,
				'message' => 'User is a head and automatically assigned as supervisor.',
				'response' => [[
					'supervisor_id' => $userAsHead->supervisor_id,
					'supervisor_name' => $userAsHead->supervisor_name
       			 ]],
				'is_head' => 1
			]);
		}

		// If not a head, check for existing supervisor assignments
		$userData = DB::table('users') // main.users
			->join('supervise_employee', 'supervise_employee.supervisor_id', '=', 'users.username')
			->leftJoin('dts.users as dts_users', 'dts_users.username', '=', 'users.username')
			->leftJoin('dts.section', 'dts.section.head', '=', 'dts_users.id')
			->leftJoin('dts.division', 'dts.division.head', '=', 'dts_users.id')
			->where('supervise_employee.userid', $userid)
			->selectRaw("
				DISTINCT users.username as supervisor_id,
				CONCAT(users.fname, ' ', users.lname) as supervisor_name
			")
			->get();
		
		if (!empty($userData)) {
			return Response::json([
				'code' => 200,
				'message' => 'Supervisor already assigned.',
				'response' => $userData,
				'is_head' => 0
			]);
		} else {
			return Response::json([
				'code' => 404,
				'message' => 'No supervisor assigned.',
				'is_head' => 0
			]);
		}
	}

	public function searchApi()
	{
		$keyword = Input::get('keyword'); //search  by name or userid
		
		$supervisor = SuperviseEmployee::lists('supervisor_id');
		$query = Users::where('region', 'region_7');

		if ($keyword) {
			$query->where(function ($q) use ($keyword) {
				$q->where('fname', 'LIKE', "%$keyword%")
				->orWhere('lname', 'LIKE', "%$keyword%")
				->orWhere('username', 'LIKE', "%$keyword%");
			});
		}

		$supervisors = $query->get();

		if ($supervisors->isEmpty()) {
			return Response::json([
				'code' => 404,
				'message' => 'No users found.'
			]);
		}
		
		return Response::json([
			'code' => 200,
			'response' => $supervisors
		]);
	}

	public function updateSupervisees()
	{
		$supervisorIds = (array) Input::get('supervisor_id'); // accept array or single value
		$newSupervise = (array) Input::get('supervise_employee', []);
	
		$newSuperviseeIds = is_array($newSupervise) ? $newSupervise : [$newSupervise];

		foreach ($supervisorIds as $supervisorId) {
			$existingIds = SuperviseEmployee::where('supervisor_id', $supervisorId)
								->lists('userid');

			$combined = array_unique(array_merge($existingIds, $newSuperviseeIds));

			SuperviseEmployee::where('supervisor_id', $supervisorId)->delete();
			 	 	
			foreach ($combined as $userId) {
				$supervise = new SuperviseEmployee();
				$supervise->supervisor_id = $supervisorId;
				$supervise->userid = $userId;
				$supervise->save();
			}
		}

		$supervisors = DB::table('supervise_employee')
			->join('users', 'supervise_employee.supervisor_id', '=', 'users.username')
			->where('supervise_employee.userid', $newSupervise)
			->select(
				'supervise_employee.supervisor_id',
				DB::raw("CONCAT(users.fname, ' ', users.lname) as supervisor_name")
			)
			->get();

		return Response::json([
			'code' => 200,
			'response' => $supervisors,
		]);
	}

	public function deleteSupervisor() {
		$userid = Input::get('userid');

		if (!$userid) {
			return Response::json([
				'code' => 400,
				'message' => 'User ID is required.'
			]);
		}

		$deleted = DB::table('supervise_employee')
			->where('userid', $userid)
			->delete();

		if ($deleted) {
			return Response::json([
				'code' => 200,
				'message' => 'Supervisor(s) successfully removed.',
				'deleted_count' => $deleted
			]);
		} else {
			return Response::json([
				'code' => 404,
				'message' => 'No supervisors found for this user.'
			]);
		}
	}

	public function getEmployees(){
		$userid=Input::get('userid');
		$isHead= Input::get('isHead');

		$employees = DB::table('supervise_employee')
			->join('users', 'supervise_employee.userid', '=', 'users.username')
			->where('supervise_employee.supervisor_id', $userid)
			->select(
				'supervise_employee.userid',
				DB::raw("CONCAT(users.fname, ' ', users.lname) as employee_name")
			)
			->get();

		if ($isHead == "1") {
			return Response::json([
				'code' => 200,
				'message' => 'Employees are successfully retrieved.',
				'employees' => $employees
			]);
		} else {
			return Response::json([
				'code' => 404,
				'message' => 'No employees found for this supervisor.'
			]);
		}
	}

	private function wellnessQuery($authUser, $user_type, $filterRange, $filter, $statuses, $keyword)
	{
		$supervisors = array_values(
			DB::table('supervise_employee')->distinct()->lists('supervisor_id')
		);

		$superviseeUsernames = DB::table('supervise_employee')
			->where('supervisor_id', $authUser->userid)
			->lists('userid');

		$query = DB::table('wellness')
			->join('users', 'users.username', '=', 'wellness.userid')
			->select('wellness.*', DB::raw("CONCAT(users.fname, ' ', users.lname) as user_name"));

		// Role-based filtering
		if ($user_type === 1) {
			$query->whereIn('users.username', $supervisors);
		} else {
			$query->whereIn('users.username', $superviseeUsernames);
		}

		if (!empty($filterRange)) {
			// Always prioritize date range if set
			$dates = explode(' - ', $filterRange);
			if (count($dates) === 2) {
				$startDate = Carbon::createFromFormat('m/d/Y', trim($dates[0]))->startOfDay();
				$endDate   = Carbon::createFromFormat('m/d/Y', trim($dates[1]))->endOfDay();
				$query->whereBetween('wellness.scheduled_date', [$startDate, $endDate]);
			}
		} elseif ($filter === 'past') {
			// Past 7 days
			$startDate = Carbon::now()->subDays(6)->startOfDay();
			$endDate   = Carbon::now()->endOfDay();
			$query->whereBetween('wellness.scheduled_date', [$startDate, $endDate]);
		} elseif ($filter === 'upcoming') {
			// Upcoming 7 days
			$startDate = Carbon::now()->startOfDay();
			$endDate   = Carbon::now()->addDays(6)->endOfDay();
			$query->whereBetween('wellness.scheduled_date', [$startDate, $endDate]);
		}

		// Apply status filter (after date filtering)
		if (!empty($statuses)) {
			$query->whereIn('wellness.status', $statuses);
		}

		// Apply keyword filter
		if (!empty($keyword)) {
			$query->where(function ($q) use ($keyword) {
				$q->where('users.fname', 'like', "%{$keyword}%")
				->orWhere('users.lname', 'like', "%{$keyword}%")
				->orWhere('wellness.type_of_request', 'like', "%{$keyword}%");
			});
		}

		return $query;
	}
}
