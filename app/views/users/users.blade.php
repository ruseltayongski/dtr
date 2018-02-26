@extends('layouts.app')

@section('content')
    @if(Session::has('name'))
        <div class="alert alert-success">

            <strong> <i class="fa fa-check-square-o" aria-hidden="true"></i> {{ Session::get('name') }}</strong>
        </div>
    @endif
    <div class="alert alert-jim" id="inputText">
        <h2 class="page-header">Employees</h2>
        <form class="form-inline form-accept" action="{{ asset('/search/user/j') }}" method="GET">
            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
            <div class="form-group">
                <input type="text" name="search" class="form-control" placeholder="Quick Search" autofocus>
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
                        <th class="text-center">User ID</th>
                        <th class="text-center">Name </th>
                        <th class="text-center" with="30%">Work Schedule</th>
                        <th class="text-center">Option</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td class="text-center"><a href="#user" data-id="{{ $user->userid }}"  class="title-info">{{ $user->userid }}</a></td>
                            <td class="text-center"><a href="#user" data-id="{{ $user->id }}" data-link="{{ asset('user/edit') }}" class="text-bold">{{ $user->fname ." ". $user->mname." ".$user->lname }}</a></td>
                            <td class="text-center">
                                <span class="text-bold">{{ $user->description }}</span>
                                <button data-id="{{ $user->userid }}" type="button" class="btn btn-info btn-xs change_sched">Change</button>
                            </td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <a href="#edit"  class="btn btn-sm btn-info user_edit" data-toggle="modal" data-target="#update_user_info" data-link="{{ asset('user/edit') }}" data-id="{{ $user->userid }}">
                                        <i class="fa fa-pencil"></i>  Update
                                    </a>
                                </div>
                                <button data-id="{{ $user->userid }}" class="btn btn-danger delete_userid"><i class="fa fa-trash"></i> Delete</button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <span id="data_link" data-link="{{ asset('change/work-schedule') }}" />
            {{ $users->links() }}
        @else
            <div class="alert alert-danger">
                <strong><i class="fa fa-times fa-lg"></i>No users found.</strong>
            </div>
        @endif
    </div>

    <div class="modal fade" tabindex="-1" role="dialog" id="change_schedule">
        <div class="modal-dialog modal-md" role="document" id="size">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #9900cc;">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><i class="fa fa-plus"></i>Change working schedule</h4>
                </div>
                <div class="modal-body" id="schedule_modal">
                    <div class="modal_content"><center><img src="{{ asset('public/img/spin.gif') }}" width="150" style="padding:10px;"></center></div>
                </div>
            </div><!-- .modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@endsection

@section('js')
    @parent
    <script>
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

        $('.delete_userid').click(function(){
            var id = $(this).data('id');
            $('#del_userid_input').val('');
            $('#del_userid_input').val(id);
            var e_id =  $('#del_userid_input').val();
            console.log(e_id);
            $('#delete_user_modal').modal('show');
        });

    </script>
@endsection



