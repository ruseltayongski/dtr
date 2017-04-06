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

    public function list_jo_dtr()
    {
        $lists = PdfFiles::where('type','JO')
                                ->where('is_filtered','!=','1')
                                ->orderBy('date_created', 'ASC')
                                ->paginate(20);
        return View::make('dtr.dtr_list_jo')->with('lists', $lists);
    }

    public function list_regular_dtr()
    {
        $lists = PdfFiles::where('type','REG')
                ->orderBy('date_created','ASC')
                ->paginate(20);
        return View::make('dtr.dtr_list_regular')->with('lists',$lists);
    }

    public function personal_dtrlist()
    {
        $lists = PdfFiles::where('is_filtered','<>', '1')
                                ->orderBy('date_created', 'ASC')
                                ->paginate(20);
        return View::make('dtr.personal_list')->with('lists', $lists);
    }

    public function personal_filter_dtrlist()
    {
        $lists = PdfFiles::where('is_filtered','1')
                            ->orderBy('date_created','ASC')
                            ->paginate(20);
        return View::make('dtr.personal_filter_list')->with('lists',$lists);
    }
}