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
    public function print_pdf(Request $request)
    {

        $pdo = DB::connection()->getPdo();
        if($request->has('filter')) {
            if($request->has('from') and $request->has('to')) {
                $_from = explode('/', $request->input('from'));
                $_to = explode('/', $request->input('to'));
                $f_from = $_from[2].'-'.$_from[0].'-'.$_from[1];
                $f_to = $_to[2].'-'.$_to[0].'-'.$_to[1];
                Session::put('f_from',$f_from);
                Session::put('f_to',$f_to);
                $query = "SELECT userid FROM users where usertype <> 1";
                $st = $pdo->prepare($query);
                $st->execute();
                $lists = $st->fetchAll(PDO::FETCH_ASSOC);

                $display = view('pdf.jo_monthly')->with('lists',$lists);
                $pdf = App::make('dompdf.wrapper');
                $pdf->setPaper('A4', 'portrait');
                $pdf->loadHTML($display);
                return $pdf->stream();

            }
        }
    }
    public function print_employee(Request $request) {
        if($request->isMethod('get')){
            return view('print.employee');
        }
    }
}
?>
