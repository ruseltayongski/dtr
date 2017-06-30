<?php
/**
 * Created by PhpStorm.
 * User: Lourence
 * Date: 3/16/2017
 * Time: 4:27 PM
 */


class GenerateDTRController extends BaseController
{
    function __construct()
    {
        $this->beforeFilter(function () {
            if(!Auth::check())
            {
                return Redirect::to('/');
            }
        });
    }
    public function download_dtr($id) {

        $dtr = PdfFiles::find($id);
        if(!$dtr) return Redirect::to('/');
        $file =  public_path().'/pdf-files/'.$dtr->filename;
        return Response::make(file_get_contents($file), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="DTR.pdf"'
        ]);
    }
    public function list_jo_dtr()
    {
        $lists = DB::table('generated_pdf')
            ->where('type','=','JO')
            ->where('is_filtered','!=','1')
            ->orderBy('id', 'DESC')
            ->paginate(20);
        return View::make('dtr.dtr_list_jo')->with('lists', $lists);
    }

    public function search_jo_dtr() {

        if(Input::has('q')) {

            $str = explode('-',Input::get('q'));
            $date_from = date("Y-m-d", strtotime($str[0]));
            $date_to = date("Y-m-d", strtotime($str[1]));

            Session::put('date_from',$date_from);
            Session::put('date_to',$date_to);
        }
        if(Session::has('date_from') and Session::has('date_to')) {
            $date_from = Session::get('date_from');
            $date_to = Session::get('date_to');

            $lists = DB::table('generated_pdf')
                ->where('type', '=', 'JO')
                ->whereBetween('date_from',array($date_from,$date_to))
                ->whereBetween('date_to', array($date_from,$date_to))
                ->orderBy('date_created', 'ASC')
                ->paginate(20);

            return View::make('dtr.dtr_list_jo')->with('lists', $lists);
        }

    }
    public function list_regular_dtr()
    {
        $lists = DB::table('generated_pdf')
            ->where('type','=','REG')
            ->where('is_filtered','!=','1')
            ->orderBy('id','DESC')
            ->paginate(20);
        return View::make('dtr.dtr_list_regular')->with('lists',$lists);

    }

    public function search_reg_dtr() {

        if(Input::has('q')) {

            $str = explode('-', Input::get('q'));
            $date_from = date("Y-m-d", strtotime($str[0]));
            $date_to = date("Y-m-d", strtotime($str[1]));

            Session::put('date_from', $date_from);
            Session::put('date_to', $date_to);
        }
        if(Session::has('date_from') and Session::has('date_to')) {

            $date_from = Session::get('date_from');
            $date_to = Session::get('date_to');

            $lists = DB::table('generated_pdf')
                ->where('type', '=', 'REG')
                ->whereBetween('date_from',array($date_from,$date_to))
                ->whereBetween('date_to', array($date_from,$date_to))
                ->orderBy('date_created', 'ASC')
                ->paginate(2);

            return View::make('dtr.dtr_list_regular')->with('lists',$lists);
        }
    }
    public function personal_filter_dtrlist()
    {
        $lists = PdfFiles::where('is_filtered','1')
                            ->orderBy('date_created','ASC')
                            ->paginate(20);
        return View::make('dtr.personal_filter_list')->with('lists',$lists);
    }
}