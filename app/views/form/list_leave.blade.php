<style>
    .leave-status {
        list-style-type: none;
        padding-left: 0;
    }

    .leave-status li {
        margin-bottom: 6px;
    }

    .leave-status del {
        color: #888;
    }

    .diagonal {
        position: relative;
        display: inline-block;
    }

    .diagonal::after {
        content: '';
        position: absolute;
        left: 0;
        top: 50%;
        width: 100%;
        height: 1px;
        background: black;
        transform: rotate(-20deg); /* Adjust angle here */
        transform-origin: center;
    }

</style>

@extends('layouts.app')
@section('content')
    <h3 class="page-header">Leave Documents
    </h3>
    <div class="row">
        <div class="col-md-4">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading"><strong style="color: #f0ad4e;font-size:medium;">Option</strong></div>
                        <div class="panel-body">
                            <form class="form-inline" method="POST" action="{{ asset('form/leave/all') }}" id="searchForm">
                                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                <div class="table-responsive">
                                    <table class="table">
                                        <tr>
                                            <td class="col-sm-2" style="font-size: 12px;"><strong>Dates</strong></td>
                                            <td class="col-sm-1"> :</td>
                                            <td class="col-sm-9">
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-calendar"></i>
                                                    </div>
                                                    <input type="text" class="form-control" id="inclusive3" value="{{ $filter_range }}" name="filter_range" placeholder="Input date range here..." required>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <button type="submit"  class="btn-lg btn-success center-block col-sm-12" id="print" data-loading-text="<i class='fa fa-refresh fa-spin'></i> Printing DTR">
                                    <span class="glyphicon glyphicon-search" aria-hidden="true"></span> Search
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading"><strong style="color: #f0ad4e;font-size:medium;">Document list</strong></div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <a style="margin-right: 10px" href="{{ asset('form/leave') }}" class="btn btn-success center-block col-md-2">
                                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Create new
                                    </a>
                                    <button class="btn btn-info center-block col-md-2 leave_ledger2" href="#leave_ledger2" id="viewCard" name="viewCard" data-toggle="modal"
                                            data-target="#leave_ledger2"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>&nbsp;&nbsp;View Card</button>
                                    <?php
                                    if(!empty(Session::get("vacation_balance")) || Session::get('vacation_balance') != 0){
                                        $vacation_balance = Session::get("vacation_balance");
                                    } else {
                                        $vacation_balance = 0;
                                    }
                                    if(!empty(Session::get("sick_balance")) || Session::get('sick_balance') != 0){
                                        $sick_balance = Session::get("sick_balance");
                                    } else {
                                        $sick_balance = 0;
                                    }

                                    $fl_total = !Empty($leave->FL)? $leave->FL : 0;
                                    $spl_total = !Empty($leave->SPL)? $leave->SPL : 0;
                                    ?>
                                    <div style="text-align: right">
                                        <label class="text-success">VL Bal: <span class="badge bg-blue">{{ $vacation_balance }}</span></label>
                                        <label class="text-danger">SL Bal: <span class="badge bg-red">{{ $sick_balance }}</span></label>
                                        <label class="text-success">FL Bal: <span class="badge bg-blue">{{$fl_total}}</span></label>
                                        <label class="text-danger">SPL Bal: <span class="badge bg-red">{{ $spl_total }}</span></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    @if(isset($leaves) and count($leaves) >0)
                                        <div class="table-responsive">
                                            <table class="table table-list table-hover table-striped" style="font-size: 13.5px">
                                                <thead>
                                                    <tr style="background-color:grey;">
                                                        <th></th>
                                                        <th>Route #</th>
                                                        <th style="width:200px"><b>Date Applied</b></th>
                                                        <th style="width:150px"><b>Leave Type</b></th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($leaves as $leave)
                                                    <tr>
                                                        <td>
                                                            <a href="#track" data-link="/dtr/form/track/'.$leave->route_no" data-route="{{ $leave->route_no }}" data-toggle="modal" class="btn btn-sm btn-success col-sm-12" ><i class="fa fa-line-chart"></i> Track</a>
                                                        </td>
                                                        <td>
                                                            <a class="title-info" data-route="{{ $leave->route_no }}" data-id="{{ $leave->id }}" data-backdrop="static" data-link="/dtr/leave/get" href="#leave_info" data-toggle="modal">{{ $leave->route_no }}</a>
                                                        </td>
                                                        <td>
                                                            <ul class="leave-status">
                                                                @foreach($leave->appliedDates as $date)
                                                                    <li>
                                                                        @if($date->status == 1)
                                                                            <del>
                                                                                {{ $date->startdate == $date->enddate
                                                                                    ? date("F j, Y", strtotime($date->startdate))
                                                                                    : date("F j, Y", strtotime($date->startdate)) . ' - ' . date("F j, Y", strtotime($date->enddate))
                                                                                }}
                                                                            </del>
                                                                            <small class="text-danger" style="margin-left: 6px">cancelled</small>
                                                                        @elseif($date->status == 2)
                                                                            (<del>
                                                                                {{ $date->startdate == $date->enddate
                                                                                    ? date("F j, Y", strtotime($date->startdate))
                                                                                    : date("F j, Y", strtotime($date->startdate)) . ' - ' . date("F j, Y", strtotime($date->enddate))
                                                                                }}
                                                                            </del>)
                                                                                {{ $date->from_date == $date->to_date
                                                                                    ? date("F j, Y", strtotime($date->from_date))
                                                                                    : date("F j, Y", strtotime($date->from_date)) . ' - ' . date("F j, Y", strtotime($date->to_date))
                                                                                }}
                                                                        @else
                                                                            {{ $date->startdate == $date->enddate
                                                                                ? date("F j, Y", strtotime($date->startdate))
                                                                                : date("F j, Y", strtotime($date->startdate)) . ' - ' . date("F j, Y", strtotime($date->enddate))
                                                                            }}
                                                                        @endif
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        </td>
                                                        <td >{{ ($leave->leave_details == '8')?"Monetization" : $leave->type->desc  }}</td>
                                                        <td>
                                                            @if($leave->status == 0)
                                                                <small class="label label-primary">PENDING&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</small>
                                                            @elseif($leave->status == 3)
                                                                 <small class="label label-warning">CANCELLED&nbsp;&nbsp;&nbsp;&nbsp;</small>
                                                            @elseif($leave->status == 4)
                                                                <small class="label label-danger">DISAPPROVED :</small><br>
                                                                <p>{{ $leave->disapproval_remarks }}</p>
                                                            @else
                                                                 <small class="label label-success">PROCESSED&nbsp;&nbsp;&nbsp;&nbsp;</small>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        {{ $leaves->links() }}
                                    @else
                                        <div class="alert alert-danger" role="alert" style="color:white">Documents records are empty.</div>
                                    @endif
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    @parent
    <script>
        $('#inclusive3').daterangepicker();
        $(document).ready(function () {
            $('.leave_ledger2').on("click", function () {
                $('#ledger_body2').empty();
                var user_name = <?php echo json_encode($pis->lname . ", " . $pis->fname . " " . $pis->mname); ?>;
                var section_division = <?php echo json_encode($section_division); ?>;
                var user_etd = <?php echo json_encode($etd); ?>;

                $('.user_ledger_leave').text('NAME: ' + user_name);
                $('.user_ledger_section_division').text('SECTION/DIVISION - ' + section_division);
                $('.user_ledger_etd').text('ETD: ' + user_etd);

                <?php if(count($leave_card) > 0): ?>
                    <?php foreach ($leave_card as $card): ?>
                        <?php if ($card): ?>
                                var tabledata1 = "<tr>";
                                <?php if ($card->period !== null): ?>
                                    tabledata1 += "<td style='border: 1px solid black'><?php echo htmlspecialchars($card->period); ?></td>";
                                <?php else: ?>
                                    tabledata1 += "<td style='border: 1px solid black'></td>";
                                <?php endif; ?>
                                tabledata1 += "<td style='border: 1px solid black'><?php echo $card->particulars; ?></td>" +
                                    "<td style='border: 1px solid black'><?php echo $card->vl_earned == 0 ? '':rtrim(rtrim(number_format($card->vl_earned, 3, '.', ''), '0'), '.'); ?></td>" +
                                    "<td style='border: 1px solid black'><?php echo $card->vl_abswp == 0 ? '':rtrim(rtrim(number_format($card->vl_abswp, 3, '.', ''), '0'), '.'); ?></td>" +
                                    "<td style='border: 1px solid black'><?php echo $card->vl_bal == 0 ? '':rtrim(rtrim(number_format($card->vl_bal, 3, '.', ''), '0'), '.'); ?></td>" +
                                    "<td style='border: 1px solid black'><?php echo $card->vl_abswop == 0 ? '':htmlspecialchars($card->vl_abswop); ?></td>" +
                                    "<td style='border: 1px solid black'><?php echo $card->sl_earned == 0 ? '':rtrim(rtrim(number_format($card->sl_earned, 3, '.', ''), '0'), '.'); ?></td>" +
                                    "<td style='border: 1px solid black'><?php echo $card->sl_abswp == 0 ? '' : rtrim(rtrim(number_format($card->sl_abswp, 3, '.', ''), '0'), '.');?></td>" +
                                    "<td style='border: 1px solid black'><?php echo $card->sl_bal == 0 ? '':rtrim(rtrim(number_format($card->sl_bal, 3, '.', ''), '0'), '.'); ?></td>" +
                                    "<td style='border: 1px solid black'><?php echo $card->sl_abswop == 0 ?'':rtrim(rtrim(number_format($card->sl_abswop, 3, '.', ''), '0'), '.'); ?></td>" +
                                    "<td style='border: 1px solid black'><?php echo $card->date_used; ?></td>";
                                tabledata1 += "</tr>";
                                document.getElementById('ledger_body2').innerHTML += tabledata1;
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php else: ?>
                        var tableData2 = "<tr><td style='border: 1px solid black' colspan='11' class='text-danger'>No Data Available</td></tr>";
                        document.getElementById('ledger_body2').innerHTML += tableData2;
                <?php endif; ?>
            });
            $('.pagination-link').on('click', function(e) {
                e.preventDefault();
                var nextPageUrl = $(this).attr('href');

                $.get(nextPageUrl, function(data) {
                    $('#modal-content').html(data);
                });
            });

        });

        $('a[href="#leave_info').click(function(){
            var id = $(this).data('id');
            var url = $(this).data('link');

            $.get(url +'/' +id , function(data){
                $('#leave_info').modal('show');
                $('.modal-body_leave').html(data);
            });
        });

    </script>
@endsection
