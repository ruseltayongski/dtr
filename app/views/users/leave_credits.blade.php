@extends('layouts.app')

@section('content')
    @if(Session::has('name'))
        <div class="alert alert-success">

            <strong> <i class="fa fa-check-square-o" aria-hidden="true"></i> {{ Session::get('name') }}</strong>
        </div>
    @endif
    <h2 class="page-header">Leave Credits</h2>
    <form class="form-inline form-accept" action="{{ asset('leave/credits') }}" method="GET">
        <div class="form-group">
            <input type="text" name="search" value="{{ $keyword }}" class="form-control" placeholder="Quick Search" autofocus>
            <button type="submit" class="btn btn-default"><i class="fa fa-search"></i> Search</button>
        </div>
    </form>
    <div class="clearfix"></div>
    <div class="page-divider"></div>

    @if(isset($pis) and count($pis) > 0)
        <div class="table-responsive">
            <table class="table table-list table-hover table-striped">
                <thead>
                <tr>
                    <th style="width: 17%;"><div style="margin-left: 15px;">Userid</div></th>
                    <th style="width: 25%;"><div style="margin-left: 15px;">Name</div></th>
                    {{--<th style="width: 100px;"><div style="margin-left: 15px;">Section / Division</div></th>--}}
                    <th style="width: 40%;" colspan="2"><div style="margin-left: 15px;">Balance</div></th>
                    <th style="width: 15%;"><div style="margin-left: 15px;">Option</div></th>
                </tr>
                </thead>
                <tbody>
                @foreach($pis as $user)
                    <tr>
                        <td>
                            <label class="text-info">
                                @if(strpos($user->userid,'no_userid'))
                                    NO USERID
                                @else
                                    {{ $user->userid }}
                                @endif
                            </label>
                        </td>
                        <td>
                            <label class="name-cell">
                                @if($user->fname || $user->lname || $user->mname || $user->name_extension) {{ $user->fname.' '.$user->mname.' '.$user->lname.' '.$user->name_extension }} @else <i>NO NAME</i> @endif
                            </label>
                        </td>
                        <!--<td>
                            <label class="text-info">@if(isset(pdoController::search_section($user->section_id)['description'])) {{ pdoController::search_section($user->section_id)['description'] }} @else NO SECTION @endif</label><br>
                            <small class="text-success" style="margin-left: 15px;"><em>(@if(isset(pdoController::search_division($user->division_id)['description'])) {{ pdoController::search_division($user->division_id)['description'] }} @else NO DIVISION @endif {{ ')' }}</em></small>
                        </td>-->
                        <td>
                            <label class="text-primary">Vacation: @if($user->vacation_balance) {{ $user->vacation_balance }} @else 0 @endif</label><br>
                            <label class="text-danger">Sick: @if($user->sick_balance) {{ $user->sick_balance }} @else 0 @endif</label>
                        </td>
                        <td>
                            <label class="text-primary">Force: @if($user->FL) {{ $user->FL }} @else 0 @endif</label><br>
                            <label class="text-danger">Special Privilege: @if($user->SPL) {{ $user->SPL }} @else 0 @endif</label>
                        </td>
                        <td>
                            <button class="btn btn-sm leave_balance" style="background-color: #9C8AA5;color: white; width: 150px;" data-toggle="modal" data-id="{{ $user->userid }}" data-fl="{{$user->FL? $user->FL : 0}}" data-spl="{{$user->SPL? $user->SPL : 0}}"
                                    data-vacation="{{ $user->vacation_balance }}" data-sick="{{ $user->sick_balance }}" data-target="#leave_balance"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>&nbsp;&nbsp;Update Leave Balance</button>
                            <button onclick="view_leave('{{ $user->userid }}')" class="btn btn-sm leave_ledger" style="background-color: #31b0d5;color: white; width: 150px;" data-toggle="modal" data-id="{{ $user->userid }}" id="viewCard" name="viewCard" data-toggle="modal"
                                    data-target="#leave_ledger"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>&nbsp;&nbsp;View Leave Balance</button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        {{ $pis->links() }}
    @else
        <div class="alert alert-danger">
            <strong><i class="fa fa-times fa-lg"></i>No users found.</strong>
        </div>
    @endif

@endsection

@section('js')
    @parent
    <script>
        $('.range').daterangepicker({
            autoclose:true
        });

        var u_id;

        function view_leave(userid){
            $(".l_view_body").empty();
            $.get("{{ url('leave/card-view').'/' }}" + userid, function(result){
                $(".l_view_body").html(result);
            });
            u_id = userid;
            $('.user_iid').val(userid);
        }

        $(document).on('click', '.pagination  a', function(e) {
            e.preventDefault(); 
            var url = $(this).attr('href');
            $.ajax({
                url: url,
                type: 'GET',
                success: function(response) {
                    $('.l_view_body').html(response);
                },
                error: function(xhr) {
                    console.error('Error:', xhr.responseText);
                }
            });
        });
        
        $(".leave_balance").on('click',function(e){
            $('.leave_modal').html(loadingState);
            var fl = $(this).data('fl');
            var spl = $(this).data('spl');
            var vacation = $(this).data('vacation');
            var sick = $(this).data('sick');
            var userid = $(this).data('id');
            $("#userid_bal").val(userid);
            $(".leave_title").text(userid);
            setTimeout(function(){
                $('.leave_modal').html(

                "<table class='table'>"+
                    "<tr>" +
                        "<td class='col-sm-3'><strong>Vacation Balance</strong></td>" +
                        "<td class='col-sm-1'>: </td>" +
                        "<td class='col-sm-9'>" +
                            "<input type='text' class='form-control ' id='vacation' value='"+vacation+"' name='vacation' required>" +
                        "</td>" +
                    "</tr>" +
                    "<tr>" +
                        "<td class='col-sm-3'><strong>Sick Balance</strong></td>" +
                        "<td class='col-sm-1'>: </td>" +
                        "<td class='col-sm-9'>" +
                            "<input type='text' class='form-control' id='sick' value='"+sick+"' name='sick' required>" +
                        "</td>" +
                    "</tr>" +
                        "<tr>" +
                        "<td class='col-sm-3'><strong>SPL Balance</strong></td>" +
                        "<td class='col-sm-1'>: </td>" +
                        "<td class='col-sm-9'>" +
                        "<input type='text' class='form-control' id='spl' value='"+spl+"' name='spl' required>" +
                        "</td>" +
                    "</tr>" +
                    "<tr>" +
                        "<td class='col-sm-3'><strong>FL Balance</strong></td>" +
                        "<td class='col-sm-1'>: </td>" +
                        "<td class='col-sm-9'>" +
                        "<input type='text' class='form-control' id='fl' value='"+fl+"' name='fl' required>" +
                        "</td>" +
                    "</tr>" +
                "</table>");
            },500);
        });

        function checkAbsence(button) {
            $('.mod_update_btn').val('update');
            $('.type_label').text('No of Absences');
            $('#month_date').val('');
            $('#absence').val('');
            $(".card_id").val('');
            $(".delete_btn").hide();
            var row = $(button).closest('tr');
            var rowData = {};
            row.find('td').each(function(cellIndex, cell) {
                var columnName = 'data' + (cellIndex + 1);
                rowData[columnName] = $(cell).text().trim();
            });
            console.log('dates', rowData);
            var dates = (rowData.data1).split("-");
            var get_year = moment(dates[1],'MMMM D, YYYY');
            var start = dates[0] +', '+get_year.year();
            var startDate = moment(start,'MMMM D, YYYY');
            var end = startDate.format('MMMM')+ " "+dates[1];
            var endDate = moment(end, 'MMMM D, YYYY');
            $('#month_date').daterangepicker({
                startDate: startDate,
                endDate: endDate,
                locale: {
                    format: 'MM/DD/YYYY'
                }
            });
            $('#month_date').val(startDate.format('MM/DD/YYYY') + ' - ' + endDate.format('MM/DD/YYYY'));
//            var total = rowData.data10 / 0.0417;
            var number = (rowData.data2).match(/\((\d+)\)/);
            number = number ? parseInt(number[1], 10) : 0;
            console.log('number', number);
            $(".modify_userid").val(rowData.data12);
            $(".card_id").val(rowData.data13);
            $("#absence").val(number.toFixed(0));
        }

        function updateUT(button){
            $('.mod_update_btn').val('update_1');
            console.log('update ut');
            $('.type_label').text('No of Minutes');
            $('#month_date').val('');
            $('#absence').val('');
            $(".card_id").val('');
            $('.mod_update_btn').val('update_1');
            $(".delete_btn").hide();
            var row = $(button).closest('tr');
            var rowData = {};
            row.find('td').each(function(cellIndex, cell) {
                var columnName = 'data' + (cellIndex + 1);
                rowData[columnName] = $(cell).text().trim();
            });
            console.log('row', rowData);
            if(rowData.data11 == null ||rowData.data11 == '' ){
                $('#month_date').daterangepicker();
            }else{
                var dates = (rowData.data11).split("-");
                var get_year = moment(dates[1],'MMMM D, YYYY');
                var start = dates[0] +', '+get_year.year();
                var startDate = moment(start,'MMMM D, YYYY');
                var end = startDate.format('MMMM')+ " "+dates[1];
                var endDate = moment(end, 'MMMM D, YYYY');
                $('#month_date').daterangepicker({
                    startDate: startDate,
                    endDate: endDate,
                    locale: {
                        format: 'MM/DD/YYYY'
                    }
                });
                $('#month_date').val(startDate.format('MM/DD/YYYY') + ' - ' + endDate.format('MM/DD/YYYY'));
            }

            $(".modify_userid").val(rowData.data12);
            $(".card_id").val(rowData.data13);
            var number = (rowData.data2).match(/\((\d+)\s*min/);
            number = number ? parseInt(number[1], 10) : 0;
            console.log('number', number);
            $("#absence").val(number.toFixed(0));
        }
    </script>
@endsection



