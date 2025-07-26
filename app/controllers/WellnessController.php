<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Response;

class WellnessController extends BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	
	public function index()
	{
		$user = Auth::user();

		$userRecord = DB::table('dts.users')
			->where('username', $user->userid)
			->first();

		if (!$userRecord) {
			return View::make('wellness.requests', [
				'wellness' => []
			]);
		}

		$userId = $userRecord->id;

		$isSectionHead = DB::table('dts.section')
			->where('head', $userId)
			->exists();

		$isDivisionHead = DB::table('dts.division')
			->where('head', $userId)
			->exists();

		$wellness = [];

		if ($isSectionHead) {
			$sectionRequests = DB::table('wellness')
				->join('dts.users as u', 'u.username', '=', 'wellness.userid')
				->join('dts.section as s', 's.id', '=', 'u.section')
				->where('s.head', $userId)
				->where('u.id', '!=', $userId)
				->select(
					'wellness.*',
					DB::raw("CONCAT(u.fname, ' ', u.lname) as user_name")
				)
				->get();

			$wellness = array_merge($wellness, is_array($sectionRequests) ? $sectionRequests : $sectionRequests->all());
		}

		if ($isDivisionHead) {
			$divisionRequests = DB::table('wellness')
				->join('dts.users as u', 'u.username', '=', 'wellness.userid')
				->join('dts.section as s', 's.id', '=', 'u.section')
				->join('dts.division as d', 'd.id', '=', 's.division')
				->where('d.head', $userId)
				->whereRaw('s.head = u.id') // this ensures the request is from a section head
				->select(
					'wellness.*',
					DB::raw("CONCAT(u.fname, ' ', u.lname) as user_name")
				)
				->get();

			$wellness = array_merge($wellness, is_array($divisionRequests) ? $divisionRequests : $divisionRequests->all());
		}

		return View::make('wellness.requests', [
			'wellness' => $wellness
		]);
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
				$validator = Validator::make(Input::all(), array(
				'userid' => 'required|string',
				'type_of_request' => 'required|string',
				'scheduled_date' => 'required|date',
				'unique_code' => 'unique:wellness,unique_code'
			));

			if ($validator->fails()) {
					return [
					"code" => 0,
					"response" => 'error'
				];
			}

			$wellness = new Wellness();
			$wellness->userid = Input::get('userid');
			$wellness->type_of_request = Input::get('type_of_request');
			$wellness->scheduled_date = Input::get('scheduled_date');
			$wellness->unique_code = Input::get('unique_code');
			$wellness->status = 'pending';
			$wellness->remarks = Input::get('remarks'); // optional field
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
	public function update($id)
	{
		try {
			$action = Input::get('action'); // Get which button was clicked
			$user = Auth::user();
			
			if (!in_array($action, array('approve', 'decline'))) {
				return Redirect::back()->with('error', 'Invalid action.');
			}
			
			$wellness = Wellness::findOrFail($id);
			
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
			$unique_code = Input::get('unique_code');
			$remarks = Input::get('remarks');
			$logs = Input::get('logs');

			$wellness = Wellness::where('unique_code','=',$unique_code)->first();

			if (!$wellness) {
				return Response::json([
					'code' => 0,
					'response' => 'No wellness entry found for the given unique code.'
				], 404);
			}

			$wellness->remarks = $remarks;
			$wellness->save();

			if (!$unique_code || !is_array($logs) || !$remarks) {
				return Response::json([
					'code' => 0,
					'response' => 'Invalid input. `unique_code` and `logs` array are required.'
				], 400);
			}

			foreach ($logs as $logData) {
				if (!isset($logData['time_start'], $logData['time_end'], $logData['time_consumed'])) {
					continue; // skip invalid item
				}

				$log = new WellnessLogs();
				$log->wellness_id = $wellness->id;
				$log->time_start = Carbon::parse($logData['time_start']);
				$log->time_end = Carbon::parse($logData['time_end']);
				$log->time_consumed = $logData['time_consumed'];
				$log->save();
			}

			return Response::json([
				'code' => 200,
				'response' => 'Logs saved successfully.'
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
}
