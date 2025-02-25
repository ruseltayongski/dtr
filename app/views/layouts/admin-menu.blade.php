<ul class="nav navbar-nav">
    <li><a href="{{ url('/') }}"><i class="fa fa-home"></i> Home</a></li>

    <!--
    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="glyphicon glyphicon-calendar"></i> Manage DTR<span class="caret"></span></a>
        <ul class="dropdown-menu">
            <li class="dropdown-submenu">
                <a href="#"><i class="fa fa-unlock"></i> Employee DTR</a>
                <ul class="dropdown-menu">
                    <li><a href="{{ asset('dtr/list/jo') }}">Job Order</a></li>
                    <li><a href="{{ asset('dtr/list/regular') }}">Regular Employee</a></li>
                </ul>
            </li>
            <li class="divider"></li>
            <li class="dropdown-submenu">
                <a href="#"><i class="fa fa-calendar-plus-o" aria-hidden="true"></i> Work Schedule</a>
                <ul class="dropdown-menu">
                    <li><a href="{{ asset('work-schedule') }}"><i class="fa fa-clock-o"></i> Schedules</a></li>
                    <li><a href="{{ asset('work-schedule/group') }}"><i class="fa fa-users" aria-hidden="true"></i> Flixeble Hours Group</a></li>
                </ul>
            </li>


            <li class="divider"></li>

            <li class="divider"></li>
            <li><a href="{{ url('employees') }}"><i class="fa fa-users" aria-hidden="true"></i> Employees</a></li>
            <li class="divider"></li>
            <li><a href="#print" aria-hidden="true" data-toggle="modal" data-target="#print_emp"><i class="fa fa-print" ></i> Print Employee</a></li>
            <li class="divider"></li>
            <li><a href="{{ url('attendance') }}"><i class="glyphicon glyphicon-time"></i> Attendance</a></li>
            <li class="divider"></li>
            <li class="dropdown-submenu">
                <a href="#delete"><i class="fa fa-trash"></i> Delete time logs</a>
                <ul class="dropdown-menu">
                    <li><a href="#all" data-toggle="modal" data-target="#delete_all"> All Employee</a></li>
                    <li><a href="#one" data-toggle="modal" data-target="#delete_one"> By Employee</a></li>
                </ul>
            </li>
            <li class="divider"></li>
            <li><a href="{{ url('print/user/logs')}}"><i class="fa fa-print"></i> Print user logs</a>
            <li class="divider"></li>
            <li><a href="{{ url('print/mobile/logs')}}"><i class="fa fa-mobile"></i> Print Mobile Logs</a></li>

        </ul>
    </li>
    -->

    <li><a href="{{ url('calendar') }}"><i class="fa fa-calendar"></i> Holidays Calendar</a></li>
    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="glyphicon glyphicon-duplicate"></i> Tracking Documents<span class="caret"></span></a>
        <ul class="dropdown-menu">
            <li>
                <a href="{{ asset('form/so_list') }}"><i class="fa fa-file"></i> Office Order</a>
            </li>
            <li class="divider"></li>
            <li class="dropdown-submenu">
                <a href="#" data-toggle="dropdown"><i class="fa fa-file"></i> Leave</a>
                <ul class="dropdown-menu">
                    <li><a href="{{ asset('leave/roles') }}">Leave Applications</a></li>
                    <li><a href="{{ asset('leave/credits') }}">Leave Credits</a></li>
                </ul>
            </li>
            @if(Auth::user()->userid == 3856)
                <li class="divider"></li>
                <li class="dropdown-submenu">
                    <a href="#" data-toggle="dropdown"><i class="fa fa-file"></i> CTO</a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ asset('form/cdo_list') }}"><i class="fa fa-file-text"></i> Pending CTO</a></li>
                        <li><a href="{{ asset('beginning_balance') }}"><i class="fa fa-user"></i> Beginning Balance</a></li>
                    </ul>
                </li>
            @endif
        </ul>
    </li>

    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-wrench"></i> Manage<span class="caret"></span></a>
        <ul class="dropdown-menu">
            <li class="dropdown-submenu">
                <a href="#"><i class="fa fa-map-marker"></i> Area of Assignment</a>
                <ul class="dropdown-menu">
                    <li><a href="{{ url('area-assignment/cebu') }}">Cebu</a></li>
                    <li><a href="{{ url('area-assignment/bohol') }}">Bohol</a></li>
                    <li><a href="{{ url('area-assignment/negros') }}">Negros</a></li>
                    <li><a href="{{ url('area-assignment/siquijor') }}">Siquijor</a></li>
                </ul>
             </li>   
        </ul>
    </li>

    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-info-circle"></i> API<span class="caret"></span></a>
        <ul class="dropdown-menu">
            <li><a href="{{ asset('mobile/office/announcement/view') }}">Announcement</a></li>
            <li class="dropdown-submenu"><a href="#">App Version</a>
                <ul class="dropdown-menu">
                    <li><a href="{{ asset('mobile/office/version/view/android') }}">Android</a></li>
                    <li><a href="{{ asset('mobile/office/version/view/ios') }}">IOS</a></li>
                </ul>
            </li>
        </ul>
    </li>

    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog"></i> Account<span class="caret"></span></a>
        <ul class="dropdown-menu">
            <!--
            <li><a href="{{ asset('add/user')}}"><i class="fa fa-plus"></i> Add user</a></li>
            -->
            <li><a href="{{ asset('resetpass')}}"><i class="fa fa-unlock"></i> Change Password</a></li>
            <li><a href="{{ asset('reset/password')}}"><i class="glyphicon glyphicon-cog"></i> Reset Password</a></li>
            <li><a href="{{ url('/logout') }}"><i class="fa fa-sign-out"></i> Logout</a></li>
        </ul>
    </li>
</ul>