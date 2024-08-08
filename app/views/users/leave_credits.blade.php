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
                            <button class="button btn-sm leave_balance" style="background-color: #9C8AA5;color: white" data-toggle="modal" data-id="{{ $user->userid }}" data-fl="{{$user->FL? $user->FL : 0}}" data-spl="{{$user->SPL? $user->SPL : 0}}" data-vacation="{{ $user->vacation_balance }}" data-sick="{{ $user->sick_balance }}" data-target="#leave_balance">Update Leave Balance</button>
                            <button class="button btn-sm leave_ledger" style="background-color: #31b0d5;color: white" data-toggle="modal" data-id="{{ $user->userid }}" id="viewCard" name="viewCard" data-toggle="modal"
                                    data-target="#leave_ledger"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>View Leave Balance</button>
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

        $(document).ready(function () {
            $("#viewCard").on("click", function(){
                $("#ledger_body").empty();
            });

            $(".leave_ledger").on('click', function(){
                $("#ledger_body").empty();
                var userid= $(this).data('id');
                $('.user_iid').val(userid);
                console.log('suerid', userid);
                var name = $(this).closest("tr").find(".name-cell").text();
                <?php if(isset($leave_card) && count($leave_card)>0){ ?>
                <?php foreach($leave_card as $card){?>
                var id = "<?php echo $card->userid;?>";
                if(id==userid){

                    <?php
                        $div = InformationPersonal::where('userid', '=', $card->userid)->first();
                        $divi = !empty($div) ? $div->division_id : '';
                        $division = Division::where('id', '=', $divi)->first();
                        if($division){
                            $div_p = $division->description;
                        }
                        echo "var division=".json_encode(($div_p)? $div_p : '' ).";";
                        ?>
                    $('.name').html("NAME: " + name + "<span style='margin-left: 100px; color:white;'> DIVISION/OFFICE:</span> " + division);

                    var tabledata1 = "<tr>" +
                        <?php if ($card->period !== null): ?>
                            "<td style= 'border: 1px solid black'><?php echo $card->period; ?></td>"+
                        <?php else: ?>
                            "<td style= 'border: 1px solid black'></td>"+
                        <?php endif; ?>
                        <?php if (strpos($card->particulars, 'deduct') !== false): ?>
                            "<td style= 'border: 1px solid black'><a href= '#' data-toggle='modal' onclick='checkAbsence(this)' data-target='#modify_deduction'><?php echo $card->particulars; ?></a></td>" +
                        <?php elseif ($card->remarks == 0): ?>
                            "<td style= 'border: 1px solid black'><a href= '#' data-toggle='modal' onclick='updateUT(this)' data-target='#modify_deduction'><?php echo $card->particulars; ?></a></td>" +
                        <?php else: ?>
                            "<td style= 'border: 1px solid black'><?php echo $card->particulars; ?></td>" +
                        <?php endif; ?>

                        "<td style= 'border: 1px solid black'><?php echo $card->vl_earned; ?></td>" +
                        "<td style= 'border: 1px solid black'><?php echo $card->vl_abswp; ?></td>" +
                        "<td style= 'border: 1px solid black'><?php echo $card->vl_bal; ?></td>" +
                        "<td style= 'border: 1px solid black'><?php echo $card->vl_abswop; ?></td>" +
                        "<td style= 'border: 1px solid black'><?php echo $card->sl_earned; ?></td>" +
                        "<td style= 'border: 1px solid black'><?php echo $card->sl_abswp; ?></td>" +
                        "<td style= 'border: 1px solid black'><?php echo $card->sl_bal; ?></td>" +
                        "<td style= 'border: 1px solid black'><?php echo $card->sl_abswop; ?></td>" +
                        "<td style= 'border: 1px solid black'><?php echo !empty($card->date_used)?$card->date_used: ''; ?></td>" +
                        "<td style='display:none'><?php echo $card->userid; ?></td>" +
                    "<td style='display:none'><?php echo $card->id; ?></td>";

                    tabledata1 += "</tr>";
                    $('#ledger_body').append(tabledata1);
                }
                <?php }?>
                <?php }?>

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
            $('#month_date').val('');
            $('#absence').val('');
            $(".card_id").val('');
            var row = $(button).closest('tr');
            var rowData = {};
            row.find('td').each(function(cellIndex, cell) {
                var columnName = 'data' + (cellIndex + 1);
                rowData[columnName] = $(cell).text().trim();
            });
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
            var total = rowData.data10 / 0.0417;
            $(".modify_userid").val(rowData.data12);
            $(".card_id").val(rowData.data13);
            $("#absence").val(total.toFixed(0));
        }

        function updateUT(button){
            console.log('update ut');
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
            $("#absence").val((rowData.data10 == '')? 0 : rowData.data10);
        }
    </script>
@endsection



