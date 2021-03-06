
@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading"><strong style="color: #f0ad4e;font-size:medium;">Print individual DTR</strong></div>
                        <div class="panel-body">
                            <form action="{{ asset('FPDF/timelog/print_individual1.php') }}" method="POST" target="_blank">
                                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                <div class="table-responsive">
                                    <table class="table">
                                        <tr>
                                            <td class="col-sm-3"><strong>User ID </strong></td>
                                            <td class="col-sm-1">: </td>
                                            <td class="col-sm-9">
                                                <input type="text" class="col-md-2 form-control" id="inputEmail3" name="userid" value="" required>
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
                                <button type="submit"  class="btn-lg btn-success center-block col-sm-12" id="print_one_btn" data-loading-text="<i class='fa fa-refresh fa-spin'></i> Printing DTR">
                                    <span class="glyphicon glyphicon-print" aria-hidden="true"></span> Print
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
                            <form id="form_upload" action="{{ asset('sub/upload') }}" method="POST" enctype="multipart/form-data">
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
        </div>
        <div class="col-md-8">
            <div class="row">
                <form class="form-inline form-accept" action="{{ asset('/subHome') }}" method="GET">
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
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
                                <th >User ID</th>
                                <th >Name </th>
                                <th>Work Schedule</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td ><a href="#edit" data-id="{{ $user->userid }}" data-toggle="modal" data-target="#update_user_info" data-link="{{ asset('user/edit') }}" class="title-info user_edit">{{ $user->userid }}</a></td>
                                    <td ><a href="#edit" data-id="{{ $user->userid }}" data-toggle="modal" data-target="#update_user_info" data-link="{{ asset('user/edit') }}" class="text-bold user_edit">{{ $user->fname ." ". $user->mname." ".$user->lname }}</a></td>
                                    <td >
                                        <span class="text-bold">{{ $user->description }}</span>
                                        <button data-id="{{ $user->userid }}" type="button" class="btn btn-info btn-xs change_sched">Change</button>
                                    </td>
                                    <td width="5%">
                                        <a href="#" data-id="{{ $user->userid }}" class="delete_userid" style="color: #ff5751"><i class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $users->links() }}
                @else
                    <div class="alert alert-danger">
                        <strong><i class="fa fa-times fa-lg"></i>No users found.</strong>
                    </div>
                @endif
            </div>

        </div>
    </div>


    <span id="data_link" data-link="{{ asset('change/work-schedule') }}"></span>

@endsection

@section('js')
    @parent

    <script>
        $('.input-daterange input').each(function() {
            $(this).datepicker("clearDates");
        });
        function delete_time(id)
        {
            $('#delete_time').modal('show');
            $('#dtr_id_val').val(id);
        }
    </script>
    <script>
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

        $('#print_tardiness').submit(function(){
            $('#print_tardiness_btn').button('loading');
            $('#print_individual').modal({
                backdrop: 'static',
                keyboard: false,
                show: true
            });
        });

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

        (function($){

            $('.form-accept').submit(function(event){
                $(this).submit();
            });

            $('.user_edit').click(function() {

                var url = $(this).data('link');
                var id = $(this).data('id');
                var data = "id=" + id;

                $.get(url,data,function(data){
                    $('.user_edit_modal').html(data);
                });
            });

        })($);


        $('.delete_userid').click(function(){
            var id = $(this).data('id');
            $('#del_userid_input').val('');
            $('#del_userid_input').val(id);
            var e_id =  $('#del_userid_input').val();
            console.log(e_id);
            $('#delete_user_modal').modal('show');
        });

        @if(Session::has('sub_upload'))
        Lobibox.notify('success',{
            msg:"<?php echo Session::get('sub_upload'); ?>"
        });
        @endif
        @if(Session::has('deletedUser'))
        Lobibox.notify('info',{
            msg:"<?php echo Session::get('deletedUser'); ?>"
        });
        @endif
        @if(Session::has('updatedSchedule'))
        Lobibox.notify('info',{
            msg:"<?php echo Session::get('updatedSchedule'); ?>"
        });
        @endif


    </script>
@endsection
