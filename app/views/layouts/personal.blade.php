<ul class="nav navbar-nav">
    {{--<li>
        <a href="{{ URL::to('document') }}"><i class="fa fa-file-code-o"></i> Create Document</a>
    </li>--}}
    <li><a href="{{ url('/') }}"><i class="fa fa-home"></i> Home</a></li>
    @if(Auth::user()->pass_change == 1)
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-tasks"></i> Manage DTR<span class="caret"></span></a>
            <ul class="dropdown-menu">
                <li><a href="{{ url('logs/timelogs') }}"><i class="fa fa-clock-o"></i> Time Log</a></li>
                <li class="divider"></li>
                <li><a href="#" data-toggle="modal" data-target="#delete_edited" ><i class="fa fa-trash"></i> Delete Logs</a></li>
                <li class="divider"></li>
                <!--
                <li class="dropdown-submenu">
                    <a href="#create-absent"><i class="fa fa-hand-lizard-o"></i>Display in Time Log</a>
                    <ul class="dropdown-menu">
                        <li><a href="#" class="create-absent" data-toggle="modal" data-target="#absent_desc" data-link="{{ asset('create/absent/description?t=SO') }}">OFFICE ORDER</a></li>
                        <li class="divider"></li>
                        <li><a href="#" class="create-absent" data-toggle="modal" data-target="#absent_desc" data-link="{{ asset('create/absent/description?t=LEAVE') }}">LEAVE</a> </li>
                        <li class="divider"></li>
                        <li><a href="#" class="create-absent" data-toggle="modal" data-target="#absent_desc" data-link="{{ asset('create/absent/description?t=CTO') }}">CDO</a> </li>
                    </ul>
                </li>
                -->
            </ul>
        </li>
    @endif

    <?php
    $id= Auth::user()->userid;
    $get = InformationPersonal::where('userid', $id)->first();
    $field = !Empty($get->field_status)? $get->field_status : "NULL";
     ?>

    @if(Auth::user()->region == "region_7")
        <li class="divider"></li>
        <li><a href="{{ url('calendar') }}"><i class="fa fa-calendar"></i> Calendar</a></li>
    @endif
    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-file"></i> Forms<span class="caret"></span></a>
        <ul class="dropdown-menu">
            @if($field != "HRH")
                @if(Session::get("job_status") == 'Permanent')
                    <li><a href="{{ asset('form/leave/all') }}">Leave</a></li>
                    <li class="divider"></li>
                @endif
                <li><a href="{{ asset('form/so_list') }}">Office Order</a></li>
                <li class="divider"></li>
                <li><a href="{{ asset("form/cdo_user") }}">CDO</a></li>
            @else
                <li><a href="{{ asset('form/so_list') }}">Office Order</a></li>
            @endif
        </ul>
    </li>

    <li class="divider"></li>
    <?php
    $user_roles = UserRoles::select('users_roles.id','users_claims.claim_type','users_claims.claim_value','users_claims.id as claims_id')
        ->where('users_roles.userid','=',Auth::user()->userid)
        ->LeftJoin('users_claims','users_claims.id','=','users_roles.claims_id')
        ->get();
    ?>
    @if(count($user_roles) >= 1)
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog"></i> User Roles<span class="caret"></span></a>
            <ul class="dropdown-menu">
                @foreach($user_roles as $role)
                    @if($role->claims_id == 1)
                        <li class="dropdown-submenu">
                            <a href="#" data-toggle="dropdown">{{ $role->claim_type }}</a>
                            <ul class="dropdown-menu">
                                <li><a href="{{ asset('leave/roles') }}">Leave Applications</a></li>
                                <li><a href="{{ asset('leave/credits') }}">Leave Balance Credit</a></li>
                            </ul>
                        </li>
                    @elseif($role->claims_id == 2)
                        <?php Session::put('cdo_roles',true); ?>
                        <li class="dropdown-submenu">
                            <a href="#" data-toggle="dropdown">{{ $role->claim_type }}</a>
                            <ul class="dropdown-menu">
                                <li><a href="{{ asset('form/cdo_list') }}">Pending CDO</a></li>
                                <li><a href="{{ asset('beginning_balance') }}">CDO Balance Credit</a></li>
                            </ul>
                        </li>
                    @else
                        @if($role->claims_id == 6)
                            <?php Session::put('flexi-time_roles',true); ?>
                        @else
                            <li><a href="{{ asset($role->claim_value) }}">{{ $role->claim_type }}</a></li>
                        @endif
                    @endif
                @endforeach
            </ul>
        </li>
    @endif
    <!--
    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-mobile-phone"></i> MobileDTR<span class="caret"></span></a>
        <ul class="dropdown-menu">
            <li><a href="{{ asset('public/apk/version_3/dtr.apk') }}"><i class="fa fa-download"></i> for OFFICE</a></li>
            <?php
                $check_dmo = UserRoles::select('users_roles.id','users_claims.claim_type','users_claims.claim_value','users_claims.id as claims_id')
                    ->where('users_roles.userid','=',Auth::user()->userid)
                    ->where('users_roles.claims_id','=','4')
                    ->LeftJoin('users_claims','users_claims.id','=','users_roles.claims_id')
                    ->first();
            ?>
            @if($check_dmo)
                <li><a href="{{ asset('public/apk/version_3/dtr.apk') }}"><i class="fa fa-download"></i> for DMO</a></li>
            @endif
        </ul>
    </li>
    -->
    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user"></i> Account<span class="caret"></span></a>
        <ul class="dropdown-menu">
            <li><a href="{{ asset('resetpass')}}"><i class="fa fa-unlock"></i> Change Password</a></li>
            <li class="divider"></li>
            <li><a href="{{ url('/logout') }}"><i class="fa fa-sign-out"></i> Logout</a></li>
        </ul>
    </li>
</ul>
<script>
    function absent(data) {
        <?php $delete = 'absent' ?>
        $("#absentDocument").modal();
        $('.modal-title').html('Absent');
        $('.modal_content').html(loadingState);
        var url = data.data('link');
        setTimeout(function () {
            $.ajax({
                url: url,
                type: 'GET',
                success: function (data) {
                    $('.modal_content').html(data);
                    $('#reservation').daterangepicker();
                    var datePicker = $('body').find('.datepicker');
                    $('input').attr('autocomplete', 'off');
                }
            });
        }, 700);
    }
</script>