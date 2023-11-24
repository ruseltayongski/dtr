@extends('layouts.app')

@section('content')
    @if(Session::has('name'))
        <div class="alert alert-success">

            <strong> <i class="fa fa-check-square-o" aria-hidden="true"></i> {{ Session::get('name') }}</strong>
        </div>
    @endif
    <div class="alert alert-jim" id="inputText">
        <h2 class="page-header">Employee</h2>
        <form class="form-inline form-accept" action="{{ asset('beginning_balance') }}" method="GET">
            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
            <div class="form-group">
                <input type="text" name="keyword" value="{{ Session::get('keyword') }}" class="form-control" placeholder="Quick Search" autofocus>
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
                        <th class="text-center">Employee ID</th>
                        <th class="text-center">Name</th>
                        <th class="text-center">Remaining Balance</th>
                        <th class="text-center">Section / Division</th>
                        <th width="30%" class="text-center">Option</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($pis as $user)
                        <tr>
                            <td>
                                @if(strpos($user->userid,'no_userid'))
                                    NO USERID
                                @else
                                    {{ $user->userid }}
                                @endif
                            </td>
                            <td class="name-cell">
                                @if($user->fname || $user->lname || $user->mname || $user->name_extension) {{ $user->fname.' '.$user->mname.' '.$user->lname.' '.$user->name_extension }} @else <i>NO NAME</i> @endif
                            </td>
                            <td class="text-center">
                                <label style='color:green'>@if($user->bbalance_cto) {{ $user->bbalance_cto }} @else 0 @endif</label>
                            </td>
                            <td>
                                <label class="orange">@if(isset(pdoController::search_section($user->section_id)['description'])) {{ pdoController::search_section($user->section_id)['description'] }} @else NO SECTION @endif</label><br>
                                <small><em>(@if(isset(pdoController::search_division($user->division_id)['description'])) {{ pdoController::search_division($user->division_id)['description'] }} @else NO DIVISION @endif {{ ')' }}</em></small>
                            </td>
                            <td class="center">
                                <button class="button btn-sm beginning_balance" id="update_balance"style="background-color: #9C8AA5;color: white" data-toggle="modal" data-id="{{ $user->userid }}" data-target="#beginning_balance">Add CTO Balance</button>
                                <button class="button btn-sm ledger" id="viewCard" name="viewCard" style="background-color: #9C8AA5;color: white" data-toggle="modal" data-id="{{ $user->userid }}" data-target="#ledger">View Card</button>
                                <button class="button btn-sm balances" style="background-color: #9C8AA5;color: white" data-toggle="modal" data-id="{{ $user->userid }}" data-target="#balances">Update Balance</button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <span id="data_link" data-link="{{ asset('change/work-schedule') }}" />
            {{ $pis->links() }}
        @else
            <div class="alert alert-danger">
                <strong><i class="fa fa-times fa-lg"></i>No users found.</strong>
            </div>
        @endif
    </div>
    <div class="modal fade" tabindex="-1" role="dialog" id="ledger">
        <div class="modal-dialog modal-xl" role="document" id="size" style=" width: 70%;">
            <div class="modal-content">
                <div class="header-container">
                    <div class="modal-header sticky-top" style="background-color: #9C8AA5;">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <strong><h4 class="modal-title"></h4></strong>
                    </div>
                </div>
                <div class="table-container"  style="max-height: calc(100vh - 50px); overflow-y: auto;">
                    <table class="table  table-list table-hover table-striped" id="card_table">
                        <thead style="position:sticky; top: 0; z-index: 5;">
                        <tr style="text-align: center">
                            <th style="align-items: center; width: 22%" colspan="5">No. Of Hours Earned/Beginning Balance</th>
                            <th>Date of Overtime</th>
                            <th># of Hours Used</th>
                            <th style="width: 19%;">Date Used</th>
                            <th>Bal. Credits</th>
                            <th>As Of</th>
                            <th>Remarks</th>
                        </tr>
                        </thead>
                        <tbody id="t_body" name="t_body" style="overflow-y: auto;">
                        </tbody>
                    </table>
                </div>
                {{--</form>--}}
                <div class="modal-footer">
                    <input type ="hidden"value="" id="user_iid" name="user_iid" style="display: inline-block">
                    <ul class="pagination justify-content-center" id="pagination" style="margin: 0; padding: 0; display: inline-block; float: right; margin-left:3%"></ul>
                    <button class="button btn-sm btn-success process_pending" style="bdisplay:inline-block;color: white; float: right" data-toggle="modal" data-id="{{ $user->userid }}" data-target="#process_pending">Process_Pending</button>
                </div>
            </div><!-- .modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    {{--to be removed / waiting HR to be finally done with updating manually users' balances--}}
    <div class="modal fade" tabindex="-1" role="dialog" id="balances">
        <div class="modal-dialog modal-sm" role="document" id="size">
            <div class="modal-content">
                <form action="{{ asset('update_bbalance') }}" method="get">
                    <div class="modal-header" style="background-color: #9C8AA5;">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"><i class="fa fa-pencil"></i> Update Beginning Balance</h4>
                    </div>
                    <div class="modal-body">

                    </div>
                    <div class="modal-footer">
                        <input type="hidden" value="" id="id_id" name="id_id">
                        <input type="hidden" value="" id="check" name="check">
                        <button type="submit" class="btn btn-success" style="color:white;" value="second" name="second_update"><i class="fa fa-pencil"> Update</i></button>
                    </div>
                </form>
            </div><!-- .modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    {{-------------------------}}
    {{----process pending application manually----}}
    <div class="modal fade" tabindex="-1" role="dialog" id="process_pending">f
        <div class="modal-dialog modal-sm" role="document" id="size">
            <div class="modal-content">
                <form action="{{ asset('process_pending') }}" method="get">
                    <div class="modal-header" style="background-color: #9C8AA5;">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"><i class="fa fa-question-circle"></i>DTR Says:</h4>
                    </div>
                    <div class="modal-body">

                    </div>
                    <div class="modal-footer">
                        <input type="hidden" value="" id="id_to_process" name="id_to_process">
                        <input type="hidden" value="" id="check" name="check">
                        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> No</button>
                        <button type="submit" class="btn btn-success" style="color:white;" value="process" name="manual_process"><i class="fa fa-pencil"> Yes</i></button>
                    </div>
                </form>
            </div><!-- .modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    {{-------------------------}}

@endsection

@section('js')
    @parent
    <script>

        $(".process_pending").on('click',function(e){

            $('.modal-body').html(loadingState);
            var userid = $(this).data('id');
            $("#check").val("process");

           $('#id_to_process'). val($('#user_iid').val());
            setTimeout(function(){
                $('.modal-body').html(
                    "<span >Are you sure you want to process pending CTO credits?</span>");
            },500);
        });
// to be removed once HR is done
        $(".balances").on('click',function(e){
            $('.modal-body').html(loadingState);
            var userid = $(this).data('id');
            $("#check").val("second");
            $("#id_id").val(userid);
            setTimeout(function(){
                $('.modal-body').html(
                    "<input type='text' class='form-control' id='balances' name='balances' required>");
            },500);
        });

        $("#balances").keydown(function (e) {
            // Allow: backspace, delete, tab, escape, enter and .
            if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
                // Allow: Ctrl+A, Command+A
                (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) ||
                // Allow: home, end, left, right, down, up
                (e.keyCode >= 35 && e.keyCode <= 40)) {
                // let it happen, don't do anything
                return;
            }
            // Ensure that it is a number and stop the keypress
            if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                e.preventDefault();
            }
        });
//        to be removed once HR is done //


        function setAction(action){
            $('#action').val(action);
            var button = $('#action').val();
            if(button=="update"){
                Lobibox.notify('info', {msg: "CDO UPDATED!"});
            }else{
                Lobibox.notify('warning', {msg: "CDO REMOVED!"});
            }
        }

        function modifiedUpdatedCTO(button) {
            $("#option2").show();
            var row = $(button).closest('tr');
            var rowData = {};
            row.find('td').each(function(cellIndex, cell) {
                var columnName = 'data' + (cellIndex + 1);
                rowData[columnName] = $(cell).text().trim();
            });
            var userid = $(this).data('id');
            $(".datepickercalendar").datepicker("setDate", new Date(rowData.data6));
            $("#ot_hours").val(rowData.data1 );
            $("#ot_weight").val(rowData.data3);
            $("#cto_total").val(rowData.data5);
            $("#user_id").val($("#user_iid").val());
            $("#userid").val($("#user_iid").val());
            $("#row_id").val(rowData.data11);

            var total_first = parseFloat(rowData.data4);
            var total_second= parseFloat($("#cto_total").val());
            var total= total_first-total_second;
            $("#total_total").val(rowData.data5);
        }


        function updateCTO() {
            if ($("#ot_hours").val() == 0) {
                $("#ot_hours").val("");
            } else if ($("#ot_weight").val() == 0) {
                $("#ot_weight").val("");
            }
            var hours = parseFloat(document.getElementById("ot_hours").value);
            var weight = parseFloat(document.getElementById("ot_weight").value);

            var total = hours * weight;

            var totalDecimal = (total - Math.floor(total)).toFixed(2);
            var totalWhole = Math.floor(total);

            if (totalDecimal >= 0.750 && totalDecimal < 1.00) {
                total= totalWhole+0.75;
            } else if (totalDecimal >= 0.500 && totalDecimal < 0.749) {
                total= totalWhole+0.50;
            }else if (totalDecimal >= 0.250 && totalDecimal <0.499) {
                total= totalWhole+0.25;
            }else if(totalDecimal < 0.250){
                total= totalWhole;
            }

            document.getElementById("cto_total").value = total || '';
            document.getElementById("beginning_balance").value = total || '';
        }

    $(document).ready(function () {
            $("#viewCard").on("click", function(){
                $("#t_body").empty();
            });

            $(".ledger").on('click', function(e) {
                $("#t_body").empty();
                var userid = $(this).data('id');
                $("#user_Id").text(userid);
                $("#userId").text(userid);

                var name= $(this).closest("tr").find(".name-cell").text();
                $("#user_name").text("Name: "+ name);
                $(".modal-title").html("CTO HISTORY of: <strong>" + name);
                var count=0;

                    <?php if (isset($card_view) && count($card_view) > 0) { ?>

                var userid = $(this).data('id');

                    <?php foreach ($card_view as $card_viewL) { ?>
                var id = "<?php echo $card_viewL->userid; ?>";
                var date = "<?php echo $card_viewL->ot_date; ?>";
                var status = "<?php echo $card_viewL->status; ?>";
                $("#user_iid").val(userid);

                if (id == userid && status != 5) {
                    var tableData2 = "<tr>" +
                        <?php if ($card_viewL->ot_hours !== null): ?>
                            "<td><?php echo ($card_viewL->ot_hours !=0)? $card_viewL->ot_hours : ''; ?></td>" +
                            "<td><?php echo ($card_viewL->ot_hours !=0)? 'x' : ''; ?></td>" +
                            "<td><?php echo ($card_viewL->ot_rate !=0)? $card_viewL->ot_rate : ''; ?></td>" +
                            "<td><?php echo ($card_viewL->ot_rate !=0)? '=' : ''; ?></td>"+
                            "<td><?php echo ($card_viewL->ot_credits !=0)? $card_viewL->ot_credits : '';?></td>"+
                            <?php else: ?>
                            "<td></td>"+"<td></td>"+"<td></td>"+"<td></td>"+"<td></td>"+
                        <?php endif; ?>
                        <?php if ($card_viewL->ot_date !== null): ?>
                            <?php if ($card_viewL->status !=5 && $card_viewL->status !=2 && $card_viewL->status !=6  && $card_viewL->status !=7): ?>
                            "<td><a href= '#' data-toggle='modal' onclick='modifiedUpdatedCTO(this)' data-target='#beginning_balance'><?php echo ($card_viewL->ot_date !== '0000-00-00')? date('F j, Y', strtotime($card_viewL->ot_date )): ''; ?></a></td>"+
                            <?php else: ?>
                                "<td><?php echo ($card_viewL->ot_date !== '0000-00-00')? date('F j, Y', strtotime($card_viewL->ot_date )): ''; ?></td>"+
                            <?php endif; ?>
                        <?php else: ?>
                        "<td></td>"+
                        <?php endif; ?>
                        "<td><?php echo ($card_viewL->hours_used !=0)? $card_viewL->hours_used : ''; ?></td>" +
                        "<td><?php

                            if(!Empty($card_viewL->date_used) ){
                                $created = strtotime($card_viewL->created_at);
                                $condition = strtotime('2023-10-24');
                                if($created<=$condition){
                                    $dateRanges = explode(",", $card_viewL->date_used);
                                    $datelist = [];
                                    foreach ($dateRanges as $date){
                                        $pattern = '/(\d{1,2}\/\d{1,2}\/\d{4}) - (\d{1,2}\/\d{1,2}\/\d{4}(?: \([^)]*\))?)/';

                                        if(preg_match($pattern, $date, $matches)){
                                            $startDate = $matches[1];
                                            $endDate = $matches[2];
                                            $add_ons = isset($matches[3])? $matches[3]: '';
                                            $endDate2 = preg_replace('/ \([^)]*\)/', '', $matches[2]);
                                            $diff= (strtotime($startDate)- strtotime($endDate2))/ (60*60*24);
                                            $diff= $diff * -1;

                                            $additionalData = '';
                                            $additionalPattern = '/\(([^)]*)\)/';
                                            if (preg_match($additionalPattern, $endDate, $additionalMatches)) {
                                                $additionalData = $additionalMatches[1];
                                            }

                                            if($diff == 0){
                                                $datelist[]= date('F j, Y', strtotime($endDate2)).' '. $additionalData;
                                            }else{
                                                $datelist[]= date('F j, Y', strtotime($startDate)).'-'. date('F j, Y', strtotime($endDate)).' '. $additionalData;
                                            }
                                        }
                                    }
                                    $dateRanges = implode('$', $datelist);
                                    echo str_replace('$', '<br>', $dateRanges);

                                }else{
                                    $dateRanges =str_replace('$', '<br>', $card_viewL->date_used);
                                    echo $dateRanges;
                                }

                            }else{
                                echo "";
                            }
                            ?></td>"+
                        "<td><?php echo $card_viewL->bal_credits; ?></td>" +
                        "<td><?php
                            if($card_viewL->status == "7" ){
                                $created = strtotime($card_viewL->created_at);
                                $condition = strtotime('2023-10-24');
                                if($created <= $condition){
                                    echo "September 30, 2023";
                                }else{
                                    echo date("F j, Y", strtotime($card_viewL->created_at));
                                }
                            }else{
                                echo date("F j, Y", strtotime($card_viewL->created_at));
                            }
                            ?></td>"+
                        "<td style='display:none'><?php echo $card_viewL->id; ?></td>";

                        if(status==5){
                            tableData2 += "<td id='remarks'style='color: RED'>  REMOVED: <?php echo $card_viewL->remarks; ?></td>";
                        }else if(status==2){
                            tableData2 += "<td id='remarks'style='color: RED'>  MODIFIED(ELIMINATED): <?php echo $card_viewL->remarks; ?></td>";
                        }else if(status==3){
                            tableData2 += "<td id='remarks'style='color: RED'>  CANCELLED</td>";
                        }else if(status==4){
                            tableData2 += "<td id='remarks'style='color: BLUE'>  PROCESSED</td>";
                        }else if (status==1){
                            tableData2 += "<td id='remarks'style='color: BLUE'>  PROCESSED: <?php echo $card_viewL->remarks; ?></td>";
                        }else if (status==0){
                            tableData2 += "<td id='remarks'style='color: mediumvioletred'>  PENDING</td>";
                        }else if(status==6){
                            tableData2 += "<td id='remarks'style='color: RED'>  MODIFIED(ELIMINATED)</td>";
                        }else if(status==7) {
                            tableData2 += "<td id='remarks'style='color: BLUE'> BALANCE</td>";
                        }else if(status==9) {
                            tableData2 += "<td id='remarks'style='color: red'> EXCEED</td>";
                        }else if(status==11) {
                            tableData2 += "<td id='remarks'style='color: green'> MAXIMUM</td>";
                        }else{
                            tableData2 += "<td > </td>";
                        }
                    tableData2 += "</tr>";
                    $("#t_body").append(tableData2);
                    count++;
                }

                <?php } ?>
                if (count==0) {
                    var tableData3 = "<tr>" +
                        "<td colspan='8'>No Data Available</td>" +
                        "</tr>";
                    $("#t_body").append(tableData3);
//                    count=1;
                }
                    <?php } ?>
                        var pageSize = 15;
                        var currentPage = 1;
                        var pagination = $("#pagination");
                        var totalItems = $("#t_body tr").length;
                        var totalPages = Math.ceil(totalItems / pageSize);

                        function updateTableRows(page) {
                            var startIndex = (page - 1) * pageSize;
                            $("#t_body tr").hide().slice(startIndex, startIndex + pageSize).show();
                        }

                        function createPaginationButtons() {
                            var buttons = [];
                            buttons.push('<li class="page-item"><a class="page-link" href="#" data-page="prev">&laquo;</a></li>');
                            for (var i = 1; i <= totalPages; i++) {
                                buttons.push('<li class="page-item"><a class="page-link" href="#" data-page="' + i + '">' + i + '</a></li>');
                            }
                            buttons.push('<li class="page-item"><a class="page-link" href="#" data-page="next">&raquo;</a></li>');
                            pagination.html(buttons.join(''));
                        }

                        createPaginationButtons();
                        updateTableRows(currentPage);

                        pagination.on("click", ".page-link", function () {
                            var targetPage = $(this).data("page");
                            if (targetPage === "prev") {
                                currentPage = Math.max(currentPage - 1, 1);
                            } else if (targetPage === "next") {
                                currentPage = Math.min(currentPage + 1, totalPages);
                            } else {
                                currentPage = parseInt(targetPage);
                            }
                            updateTableRows(currentPage);
                        });
            });

        });

        $('');
        $('.chosen-select-static').chosen();
        $('.datepickercalendar').datepicker({
            autoclose:true
        });

        $(".beginning_balance").on('click',function(e){
            $("#row_id").val("");
            $("#total_total").val("");
            $("#overtime_date").val("");
            $("#ot_hours").val("");
            $("#ot_weight").val("");
            $("#cto_total").val("");
            $("#option2").hide();
            var userid = $(this).data('id');
            $("#userid").val(userid);
            $("#user_id").val(userid);

        });

        $("#beginning_balance").keydown(function (e) {
            var remarksField = document.getElementById("remarks");
            var focusedInputId = document.activeElement.id;

            // Allow: backspace, delete, tab, escape, enter, and .
            if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
                // Allow: Ctrl+A, Command+A
                (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) ||
                // Allow: home, end, left, right, down, up
                (e.keyCode >= 35 && e.keyCode <= 40)) {
                // Let it happen, don't do anything
                return;
            }

            // Allow numbers (0-9) for other input fields
            if (((e.keyCode >= 48 && e.keyCode <= 57) || (e.keyCode >= 96 && e.keyCode <= 105)) &&
                focusedInputId !== "remarks") {
                return;
            }
            //For remarks input
            if (focusedInputId === "remarks" &&
                ((e.keyCode >= 65 && e.keyCode <= 90) ||  // Letters (uppercase)
                    (e.keyCode >= 97 && e.keyCode <= 122) || // Letters (lowercase)
                    e.keyCode === 32 ||  // Space
                    (e.keyCode >= 48 && e.keyCode <= 57) ||  // Numbers
                    (e.keyCode >= 186 && e.keyCode <= 192) || // Special characters (part 1)
                    (e.keyCode >= 219 && e.keyCode <= 222)    // Special characters (part 2)
                )) {
                return;
            }

            // Prevent the keypress for other characters
            e.preventDefault();
        });


    </script>

@endsection



