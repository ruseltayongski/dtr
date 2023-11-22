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
                                    <button class="btn btn-info center-block col-md-2 leave_ledger" href="#leave_ledger" id="viewCard" name="viewCard" data-toggle="modal"
                                            data-target="#leave_ledger"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>View Card</button>
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
                                            <table class="table table-list table-hover table-striped">
                                                <thead>
                                                <tr style="background-color:grey;">
                                                    <th ></th>
                                                    <th >Route #</th>
                                                    <th ><b>Date Created</b></th>
                                                    <th ><b>Application for Leave</b></th>
                                                    <th>Status</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($leaves as $leave)
                                                    <tr>
                                                        <td >
                                                            <a href="#track" data-link="{{ asset('form/track/'.$leave->route_no) }}" data-route="{{ $leave->route_no }}" data-toggle="modal" class="btn btn-sm btn-success col-sm-12" ><i class="fa fa-line-chart"></i> Track</a>
                                                        </td>
                                                        <td >
                                                            <a class="title-info" data-route="{{ $leave->route_no }}" data-id="{{ $leave->id }}" data-backdrop="static" data-link="{{ asset('leave/get') }}" href="#leave_info" data-toggle="modal">{{ $leave->route_no }}</a>
                                                        </td>
                                                        <td >
                                                            <a href="#" data-toggle="modal"><b>{{ date("F d,Y",strtotime($leave->date_filling)) }}</b></a>
                                                        </td>
                                                        <td >{{ $leave->leave_type }}</td>
                                                        <td>
                                                            <?php
                                                            if($leave->status == 'PENDING')
                                                                $color = 'primary';
                                                            elseif($leave->status == 'APPROVED')
                                                                $color = 'success';
                                                            else
                                                                $color = 'danger';
                                                            ?>
                                                            @if($leave->status == 'PENDING')
                                                            <small class="label label-{{ $color }}">PENDING</small>
                                                            @else
                                                             <small class="label label-{{ $color }}">PROCESSED</small>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        {{ $leaves->links() }}
                                    @else
                                        <div class="alert alert-danger" role="alert">Documents records are empty.</div>
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
            $('.leave_ledger').on("click", function () {
                console.log("fgshdfd");
                var count=0;
                    <?php if(count($leave_card)>0){?>
                    <?php foreach ($leave_card as $card){ ?>

                var tabledata1 = "<tr>" +
                        <?php if ($card->period !== null): ?>
                            "<td style= 'border: 1px solid black'><a href= '#' data-toggle='modal' onclick='modifiedUpdatedCTO(this)' data-target='#beginning_balance'><?php echo $card->period; ?></a></td>"+
                            <?php else: ?>
                            "<td style= 'border: 1px solid black'></td>"+
                        <?php endif; ?>
                        "<td style= 'border: 1px solid black'><?php echo $card->particulars; ?></td>" +
                        "<td style= 'border: 1px solid black'><?php echo $card->vl_earned; ?></td>" +
                        "<td style= 'border: 1px solid black'><?php echo $card->vl_abswp; ?></td>" +
                        "<td style= 'border: 1px solid black'><?php echo $card->vl_bal; ?></td>" +
                        "<td style= 'border: 1px solid black'><?php echo $card->vl_abswop; ?></td>" +
                        "<td style= 'border: 1px solid black'><?php echo $card->sl_earned; ?></td>" +
                        "<td style= 'border: 1px solid black'><?php echo $card->sl_abswp; ?></td>" +
                        "<td style= 'border: 1px solid black'><?php echo $card->sl_bal; ?></td>" +
                        "<td style= 'border: 1px solid black'><?php echo $card->sl_abswop; ?></td>" +
                        "<td style= 'border: 1px solid black'><?php echo $card->date_used; ?></td>";
                    tabledata1 += "</tr>";
                    $('#ledger_body').append(tabledata1);
                    count++;
                    <?php }?>
                    if (count==0) {
                        console.log("else");
                        var tableData2 = "<tr>" +
                            "<td>No Data Available</td>" +
                            "</tr>";
                        $("#ledger_body").append(tableData2);
                    }
                    <?php }?>
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
