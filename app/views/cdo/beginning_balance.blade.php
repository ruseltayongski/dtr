@extends('layouts.app')

@section('content')
    @if(Session::has('name'))
        <div class="alert alert-success">

            <strong> <i class="fa fa-check-square-o" aria-hidden="true"></i> {{ Session::get('name') }}</strong>
        </div>
    @endif
    <div class="alert alert-jim" id="inputText">
        <h2 class="page-header">Employees</h2>
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
                        <th class="text-center">Option</th>
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
                            <td>
                                @if($user->fname || $user->lname || $user->mname || $user->name_extension) {{ $user->fname.' '.$user->mname.' '.$user->lname.' '.$user->name_extension }} @else <i>NO NAME</i> @endif
                            </td>
                            <td class="text-center">
                                <label style='color:green'>@if($user->bbalance_cto) {{ $user->bbalance_cto }} @else 0 @endif</label>
                            </td>
                            <td>
                                <label class="orange">@if(isset(pdoController::search_section($user->section_id)['description'])) {{ pdoController::search_section($user->section_id)['description'] }} @else NO SECTION @endif</label>
                                <small><em>(@if(isset(pdoController::search_division($user->division_id)['description'])) {{ pdoController::search_division($user->division_id)['description'] }} @else NO DIVISION @endif {{ ')' }}</em></small>
                            </td>
                            <td class="center">
                                <button class="button btn-sm beginning_balance" style="background-color: #9C8AA5;color: white" data-toggle="modal" data-id="{{ $user->userid }}" data-target="#beginning_balance">Update Beginning Balance</button>
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

    <div class="modal fade" tabindex="-1" role="dialog" id="beginning_balance">
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
            var userid = $(this).data('id');
            $("#userid").val(userid);
            console.log(userid);
            setTimeout(function(){
                $('.modal-body').html(
                    "<input type='text' class='form-control' id='beginning_balance' name='beginning_balance' required>");
            },500);
        });

        $("#beginning_balance").keydown(function (e) {
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

    </script>
@endsection



