<?php
/**
 * Created by PhpStorm.
 * User: Lourence
 * Date: 1/6/2017
 * Time: 9:46 AM
 */


class PrintController extends Controller
{
    private $pdo;
    public function __construct()
    {
        $this->beforeFilter(function () {
            if(!Auth::check())
            {
                return Redirect::to('/');
            }
        });
    }

    public function home(Request $request)
    {
        return view('print.monthly');
    }

    public function print_monthly(Request $request)
    {
        if($request->isMethod('get')) {
            return view('print.monthly');
        }
    }
    public function print_pdf()
    {
        return "Printing";
        $display = view('pdf.jo_monthly')->with('lists',$lists);
        $pdf = App::make('dompdf.wrapper');
        $pdf->setPaper('A4', 'portrait');
        $pdf->loadHTML($display);
        return $pdf->stream();
    }
    public function print_employee(Request $request) {
        if($request->isMethod('get')){
            return view('print.employee');
        }
    }
}
?>
