<?php
session_start();
?>
@extends('layouts.app')

@section('content')
@if(Session::has('msg_sched'))
    <div class="col-md-12 wrapper">
        <div class="alert alert-success" role="alert">
            {{ Session::get('msg_sched') }}
        </div>
    </div>
@endif
<div class="row">
    <div class="col-md-4">
        <!--
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading"><strong style="color: #f0ad4e;font-size:medium;">Generate DTR | All Employee</strong></div>
                    <div class="panel-body">
                        <form action="{{ asset('FPDF/print_all.php') }}" method="POST" id="print_all">
                            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                            <div class="table-responsive">
                                <table class="table">
                                    <tr>
                                        <td class="col-sm-3"><strong>Type </strong></td>
                                        <td class="col-sm-1">: </td>
                                        <td class="col-sm-9">
                                            <select class="form-control input-md" name="emptype">
                                                <option value="JO"><strong>Job Order</strong></option>
                                                <option value="REG"><strong>Regular</strong></option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="col-sm-3"><strong>Dates</strong></td>
                                        <td class="col-sm-1"> :</td>
                                        <td class="col-sm-9">
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                                <input type="text" class="form-control" id="inclusive4" name="filter_range" placeholder="Input date range here..." required>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <button type="submit"  class="btn-lg btn-success center-block col-sm-12" id="print" data-loading-text="<i class='fa fa-refresh fa-spin'></i> Printing DTR">
                                <span class="glyphicon glyphicon-print" aria-hidden="true"></span> Print
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        -->
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading"><strong style="color: #f0ad4e;font-size:medium;">Generate individual DTR</strong></div>
                    <div class="panel-body">
                        <form action="{{ asset('FPDF/timelog/print_individual1.php') }}" method="POST" target="_blank" id="print_one_temp">
                            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                            <div class="table-responsive">
                                <table class="table">
                                    <tr>
                                        <td class="col-sm-3"><strong>User ID </strong></td>
                                        <td class="col-sm-1">: </td>
                                        <td class="col-sm-9">
                                            @if(Auth::user()->usertype == "1")
                                                <input type="text" class="col-md-2 form-control" id="inputEmail3" name="userid" value="" required>
                                            @else
                                                <input type="text" readonly class="col-md-2 form-control" id="inputEmail3" name="userid" value="{{ Auth::user()->userid }}" required>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="col-sm-3"><strong>Dates</strong></td>
                                        <td class="col-sm-1"> :</td>
                                        <td class="col-sm-9">
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                                <input type="text" class="form-control" id="inclusive3" name="filter_range" placeholder="Input date range here..." required>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <button type="submit"  class="btn-lg btn-success center-block col-sm-12" id="print_one_btn_temp" data-loading-text="<i class='fa fa-refresh fa-spin'></i> Printing DTR">
                                <span class="glyphicon glyphicon-print" aria-hidden="true"></span> Generate
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading"><strong style="color: #f0ad4e;font-size:medium;">Generate Bulk DTR</strong></div>
                    <div class="panel-body">
                        <form action="{{ asset('FPDF/timelog/print_bulk.php') }}" method="POST" target="_blank" id="print_bulk">
                            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                            <div class="table-responsive">
                                <table class="table">
                                    <tr>
                                        <td class="col-sm-3"><strong>Job Status</strong></td>
                                        <td class="col-sm-1">: </td>
                                        <td class="col-sm-9">
                                            <select name="job_status" class="form-control" required>
                                                <option value="">Select Option</option>
                                                <option value="Permanent">Permanent</option>
                                                <option value="Job Order">Job Order</option>
                                                <option value="CBII">CBII</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="col-sm-3"><strong>Dates</strong></td>
                                        <td class="col-sm-1"> :</td>
                                        <td class="col-sm-9">
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                                <input type="text" class="form-control" id="inclusive4" name="filter_range_bulk" placeholder="Input date range here..." required>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="col-sm-3"><strong>Region</strong></td>
                                        <td class="col-sm-1">: </td>
                                        <td class="col-sm-9">
                                            <select class="form-control" name="region" required>
                                                <option value="region_7">Region 7</option>
                                                <option value="region_8">Region 8</option>
                                                <option value="region_10">Region 10</option>
                                                <option value="region_12">Region 12</option>
                                            </select>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <button type="submit"  class="btn-lg btn-success center-block col-sm-12" id="print_one_btn_temp" data-loading-text="<i class='fa fa-refresh fa-spin'></i> Printing DTR">
                                <span class="glyphicon glyphicon-print" aria-hidden="true"></span> Generate
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading"><strong style="color: #f0ad4e;font-size:medium;">Generate Tardiness</strong></div>
                    <div class="panel-body">
                        <form action="{{ asset('FPDF/tardiness_undertime/print_class.php') }}" method="POST" id="print_tardiness" target="_blank">
                            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                            <div class="table-responsive">
                                <table class="table">
                                    <tr>
                                        <td class="col-sm-3"><strong>Dates</strong></td>
                                        <td class="col-sm-1"> :</td>
                                        <td class="col-sm-9">
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                                <input type="text" class="form-control" id="inclusiveTardiness" value="{{ isset($_SESSION['tardiness_undertime_date']) ? $_SESSION['tardiness_undertime_date'] : '' }}" name="tardiness_undertime_date" placeholder="Input date range here..." required>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <button type="submit" class="btn-lg btn-success center-block col-sm-12" id="print_tardiness_btn" data-loading-text="<i class='fa fa-refresh fa-spin'></i> Printing Tardiness">
                                <span class="glyphicon glyphicon-print" aria-hidden="true"></span> Generate
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading"><strong style="color: #f0ad4e;font-size:medium;">Generate Flag Attendance</strong></div>
                    <div class="panel-body">
                        <form action="{{ asset('generate/flag/attendance') }}" method="POST">
                            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                            <div class="table-responsive">
                                <table class="table">
                                    <tr>
                                        <td class="col-sm-3"><strong>Dates</strong></td>
                                        <td class="col-sm-1"> :</td>
                                        <td class="col-sm-9">
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                                    <input type="text" class="form-control" id="flag_attendance" name="flag_attendance_date" placeholder="Input date range here..." required>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <button type="submit" class="btn-lg btn-success center-block col-sm-12" id="print_tardiness_btn" data-loading-text="<i class='fa fa-refresh fa-spin'></i> Printing Tardiness">
                                <span class="glyphicon glyphicon-print" aria-hidden="true"></span> Generate
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading"><strong style="color: #f0ad4e;font-size:medium;">Upload time logs</strong></div>
                    <div class="panel-body">
                        <form id="form_upload" action="{{ asset('admin/uploadv2') }}" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                            <h3 style="font-weight: bold;" class="text-center">Upload a file</h3>
                            <div class="modal-body">
                                <table class="table table-hover table-form table-striped">
                                    <tr>
                                        <td class="col-sm-5">
                                            <input id="file" type="file"  class="hidden" value="" name="dtr_file" onchange="readFile(this);"/>
                                            <p class="text-center" id="file_select" style="border: dashed;padding:20px;">
                                                Click here to select a file
                                            </p>
                                        </td>
                                    </tr>
                                </table>
                                <button type="button" class="btn-lg btn-success center-block col-sm-12" id="upload" data-loading-text="<i class='fa fa-refresh fa-spin'></i> Uploading time logs">
                                    <span class="glyphicon glyphicon-arrow-up" aria-hidden="true"></span> Upload File
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- PRINT LOGS -->
        <!--
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading"><strong style="color: #f0ad4e;font-size:medium;">Print user logs</strong></div>
                    <div class="panel-body">
                        <form action="{{ asset('FPDF/print_logs.php') }}" method="POST" id="print_one">
                            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                            <div class="table-responsive">
                                <table class="table">
                                    <tr>
                                        <td class="col-sm-3"><strong>User ID </strong></td>
                                        <td class="col-sm-1">: </td>
                                        <td class="col-sm-9">
                                            <input type="text" class="col-md-2 form-control" id="inputEmail3" name="userid">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="col-sm-3"><strong>Type </strong></td>
                                        <td class="col-sm-1">: </td>
                                        <td class="col-sm-9">
                                            <select class="form-control input-md" name="emptype">
                                                <option value="JO"><strong>Job Order</strong></option>
                                                <option value="REG"><strong>Regular</strong></option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="col-sm-3"><strong>Dates</strong></td>
                                        <td class="col-sm-1"> :</td>
                                        <td class="col-sm-9">
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                                <input type="text" class="form-control" id="inclusive5" name="filter_range" placeholder="Input date range here..." required>
                                            </div>
                                        </td>
                                    </tr>

                                </table>
                            </div>
                            <button type="submit"  class="btn-lg btn-success center-block col-sm-12" id="print_one_btn" data-loading-text="<i class='fa fa-refresh fa-spin'></i> Printing DTR">
                                <span class="glyphicon glyphicon-print" aria-hidden="true"></span> Print
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        -->
        <!-- PRINT MOBILE LOGS -->
        <!--
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading"><strong style="color: #f0ad4e;font-size:medium;">Print mobile logs</strong></div>
                    <div class="panel-body">
                        <form action="{{ asset('print/mobile/logs') }}" method="POST" id="print_one">
                            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                            <div class="table-responsive">
                                <table class="table">
                                    <tr>
                                        <td class="col-sm-3"><strong>User ID </strong></td>
                                        <td class="col-sm-1">: </td>
                                        <td class="col-sm-9">
                                            <input type="text" class="col-md-2 form-control" id="inputEmail3" name="userid">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="col-sm-3"><strong>Dates</strong></td>
                                        <td class="col-sm-1"> :</td>
                                        <td class="col-sm-9">
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                                <input type="text" class="form-control" id="inclusive6" name="filter_range" placeholder="Input date range here..." required>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <button type="submit"  class="btn-lg btn-success center-block col-sm-12" id="print_one_btn" data-loading-text="<i class='fa fa-refresh fa-spin'></i> Printing DTR">
                                <span class="glyphicon glyphicon-print" aria-hidden="true"></span> Print
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        -->
    </div>
    <div class="col-md-8">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading"><strong style="color: #f0ad4e;font-size:medium;">Employee list</strong></div>
                    <div class="panel-body">
                        <form class="form-inline form-accept" action="{{ asset('/home') }}" method="GET">
                            <div class="form-group">
                                <input type="text" name="search" value="{{ $keyword }}" class="form-control" placeholder="Quick Search" autofocus>
                                <button type="submit" class="btn btn-default"><i class="fa fa-search"></i> Search</button>
                            </div>
                        </form>
                        <div class="clearfix"></div>
                        <div class="page-divider"></div>

                        @if(isset($users) and count($users) > 0)
                            <div class="table-responsive">
                                <table class="table table-list table-hover table-striped">
                                    <thead>
                                    <tr>
                                        <th>User ID</th>
                                        <th>Name </th>
                                        <th>Work Schedule</th>
                                        <th>User Roles</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($users as $user)
                                        <tr>
                                            <td>
                                                <a href="#edit" data-id="{{ $user->userid }}" data-toggle="modal" data-target="#update_user_info" data-link="/dtr/user/edit" class="title-info user_edit">{{ $user->userid }}</a>
                                            </td>
                                            <td>
                                                <a href="#edit" data-id="{{ $user->userid }}" data-toggle="modal" data-target="#update_user_info" data-link="/dtr/user/edit" class="text-bold user_edit text-blue">{{ $user->fname ." ". $user->mname." ".$user->lname }}</a>
                                            </td>
                                            <td>
                                                <a href="#edit" data-id="{{ $user->userid }}" class="text-bold change_sched text-green">{{ $user->description }}</a>
                                            </td>
                                            <td>
                                                <?php
                                                    $roles = UserRoles::
                                                            select("users_roles.id","users_roles.userid","users_claims.claim_type","users_claims.claim_value","users_claims.id as claims_id")
                                                            ->leftJoin("users_claims","users_claims.id","=","users_roles.claims_id")
                                                            ->where("users_roles.userid","=",$user->userid)
                                                            ->get()
                                                ?>
                                                @if(count($roles) >= 1)
                                                @foreach($roles as $role)
                                                    <div>
                                                        @if($role->claims_id == 3)
                                                            <button data-userid="{{ $role->userid }}" type="button" class="btn btn-success btn-xs users_roles_modal" style="margin-top: 5px"><i class="fa fa-cog"></i> {{ $role->claim_type }}</button>
                                                        @else
                                                            <small class="label bg-green">{{ $role->claim_type }}</small>
                                                        @endif
                                                    </div>
                                                @endforeach
                                                @else
                                                    <small class="label bg-red">None</small>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- <span id="data_link" data-link="{{ asset('change/work-schedule') }}"></span> -->
                            <span id="data_link" data-link="/dtr/change/work-schedule"></span>
                            {{ $users->links() }}
                        @else
                            <div class="alert alert-danger">
                                <strong><i class="fa fa-times fa-lg"></i>No users found.</strong>
                            </div>
                        @endif
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

        $(".users_roles_modal").click(function(){
            $('#users_roles_modal').modal({
                backdrop: 'static',
                keyboard: false,
                show: true
            });

            var userid = $(this).data('userid');
            var url = "<?php echo asset('supervise/list') ?>";
            var json = {
               'supervisor_id' : userid
            };

            $('.users_roles_select_body').html(loadingState);
            setTimeout(function(){
                $.post(url,json,function(result){
                    $('.users_roles_select_body').html(result);
                });
            },700);

            $("#supervisor_id").val(userid);
        });


        $('.input-daterange input').each(function() {
            $(this).datepicker("clearDates");
        });
        function delete_time(id)
        {
            $('#delete_time').modal('show');
            $('#dtr_id_val').val(id);
        }

        function readFile(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('input[type="file"]').attr('value', e.target.result);
                    $('#file_select').html('<strong>'+ $('input[type="file"]').val() + '</strong>');
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#file_select").click(function() {
            $('input[type="file"]').trigger("click");
        });
        (function($){

            $('.alert-warning').hide();

            $('#upload').on('click', function(e){

                var x = $('input[type="file"]').val();
                var arr = x.split('.');
                if(arr[1] === "txt"){
                    $('a').prop('disabled',true);
                    $('#upload').button('loading');
                    $('#upload_loading').modal({
                        backdrop: 'static',
                        keyboard: false,
                        show: true
                    });
                   $('#form_upload').submit();
                } else {

                    e.preventDefault();
                    $('.alert-warning').show();
                }
            });
        })($);

        function check_file() {
            $('#file').change(function(event){
                var file = this.files[0];
                var reader = new FileReader();
                reader.onload = function(progress){
                    var lines = this.result.split('\n');

                    for (var line = 0; line < 1;line++) {
                        if(line == 0 ){
                            console.log(lines[line]);
                            var data = lines[line].split(',');
                            if(data[0].length < 9){
                                $("#upload").prop("disabled",true);
                            }
                        }
                    }

                };
                reader.readAsText(file);
            });
        }
        $('#flag_attendance').daterangepicker();
        $('#inclusive2').daterangepicker();
        $('#inclusive3').daterangepicker();
        $('#inclusive4').daterangepicker();
        $('#inclusive5').daterangepicker();
        $('#inclusive6').daterangepicker();
        $('#inclusiveTardiness').daterangepicker();
        $('#print_all').submit(function(){
            $('#print').button('loading');
            $('#print_individual').modal({
                backdrop: 'static',
                keyboard: false,
                show: true
            });
        });

        $('#print_one').submit(function(){

            $('#print_one_btn').button('loading');
            $('#print_individual').modal({
                backdrop: 'static',
                keyboard: false,
                show: true
            });
        });

        /*$('#print_tardiness').submit(function(){
            $('#print_tardiness_btn').button('loading');
            $('#print_individual').modal({
                backdrop: 'static',
                keyboard: false,
                show: true
            });
        });*/

        $('.change_sched').click(function(){
            $('#change_schedule').modal({
                backdrop: 'static',
                keyboard: false,
                show: true
            });
            var url = $('#data_link').data('link');
            var data = {
                id : $(this).data('id')
            };

            $.get(url,data, function(res){
                $('#schedule_modal').html(res);
            });

        });
        $('.delete_logs').submit(function(){
            $('.delete_all').modal('hide');
            $('#data_table').modal('show');
        });

        $('.user_edit').click(function() {

            var url = $(this).data('link');
            var id = $(this).data('id');
            var data = "id=" + id;

            $.get(url,data,function(data){
                $('.user_edit_modal').html(data);
            });
        });

    </script>
@endsection