@extends('layouts.app')

@section('content')
    @if(Session::has('name'))
        <div class="alert alert-success">

            <strong> <i class="fa fa-check-square-o" aria-hidden="true"></i> {{ Session::get('name') }}</strong>
        </div>
    @endif
    <div class="alert alert-jim" id="inputText">
        <h2 class="page-header">Leave Credits</h2>
        <form class="form-inline form-accept" action="{{ asset('leave/credits') }}" method="GET">
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
                        <th style="width: 100px;"><div style="margin-left: 15px;">Userid</div></th>
                        <th style="width: 100px;"><div style="margin-left: 15px;">Name</div></th>
                        <th style="width: 100px;"><div style="margin-left: 15px;">Section / Division</div></th>
                        <th style="width: 100px;"><div style="margin-left: 15px;">Balance</div></th>
                        <th style="width: 100px;"><div style="margin-left: 15px;">Option</div></th>
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
                                <label class="text-info">
                                    @if($user->fname || $user->lname || $user->mname || $user->name_extension) {{ $user->fname.' '.$user->mname.' '.$user->lname.' '.$user->name_extension }} @else <i>NO NAME</i> @endif
                                </label>
                            </td>
                            <td>
                                <label class="text-info">@if(isset(pdoController::search_section($user->section_id)['description'])) {{ pdoController::search_section($user->section_id)['description'] }} @else NO SECTION @endif</label><br>
                                <small class="text-success" style="margin-left: 15px;"><em>(@if(isset(pdoController::search_division($user->division_id)['description'])) {{ pdoController::search_division($user->division_id)['description'] }} @else NO DIVISION @endif {{ ')' }}</em></small>
                            </td>
                            <td>
                                <label class="text-primary">Vacation: @if($user->vacation_balance) {{ $user->vacation_balance }} @else 0 @endif</label><br>
                                <label class="text-danger">Sick: @if($user->sick_balance) {{ $user->sick_balance }} @else 0 @endif</label>
                            </td>
                            <td>
                                <button class="button btn-sm beginning_balance" style="background-color: #9C8AA5;color: white" data-toggle="modal" data-id="{{ $user->userid }}" data-vacation="{{ $user->vacation_balance }}" data-sick="{{ $user->sick_balance }}" data-target="#beginning_balance">Update Beginning Balance</button>
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
    </div>

    <div class="modal fade" tabindex="-1" role="dialog" id="beginning_balance">
        <div class="modal-dialog modal-sm" role="document" id="size">
            <div class="modal-content">
                <form action="{{ asset('leave/credits/save') }}" method="POST">
                    <div class="modal-header" style="background-color: #9C8AA5;">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"><i class="fa fa-pencil"></i> Leave Credits</h4>
                    </div>
                    <div class="modal-body">

                    </div>
                    <div class="modal-footer">
                        <input type="hidden" value="" id="userid" name="userid">
                        <button type="submit" class="btn btn-success" style="color:white;"><i class="fa fa-pencil"> Update</i></button>
                    </div>
                </form>
            </div><!-- .modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@endsection

@section('js')
    @parent
    <script>

        $(".beginning_balance").on('click',function(e){
            $('.modal-body').html(loadingState);
            var vacation = $(this).data('vacation');
            var sick = $(this).data('sick');
            var userid = $(this).data('id');
            $("#userid").val(userid);
            setTimeout(function(){
                $('.modal-body').html(
                    "<label class='text-success'>Vacation Balance</label><input type='number' class='form-control' id='vacation' value='"+vacation+"' name='vacation' required><label class='text-success'>Sick Balance</label><input type='number' class='form-control' id='sick' value='"+sick+"' name='sick' required>");
            },500);
        });


    </script>
@endsection



