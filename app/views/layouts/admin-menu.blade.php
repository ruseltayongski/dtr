<ul class="nav navbar-nav">
    <li><a href="{{ url('/') }}"><i class="fa fa-home"></i> Home</a></li>

    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-file"></i> Manage DTR<span class="caret"></span></a>
        <ul class="dropdown-menu">
            <li class="dropdown-submenu">
                <a href="#"><i class="fa fa-unlock"></i> Employee DTR</a>
                <ul class="dropdown-menu">
                    <li><a href="{{ asset('dtr/list/jo') }}">Job Order</a></li>
                    <li><a href="{{ asset('dtr/list/regular') }}">Regular Employee</a></li>
                </ul>
            </li>
            <li class="divider"></li>
            <li>
                <a href="{{ asset('print/individual') }}"><i class="fa fa-print"></i> Print Individual</a>
            </li>
            <li class="divider"></li>
            <li>
                <a href="{{ asset('work-schedule') }}"><i class="fa fa-clock-o"></i> Work Schedule</a>
            </li>
            <li class="divider"></li>
            <li><a href="{{ url('calendar') }}"><i class="fa fa-calendar"></i> Holidays Calendar</a></li>
            <li class="divider"></li>
            <li class="dropdown-submenu">
                <a href="#"><i class="fa fa-user"></i> Employees</a>
                <ul class="dropdown-menu">
                    <li><a href="{{ asset('list/job-order') }}">Job Order</a></li>
                    <div class="divider"></div>
                    <li><a href="{{ asset('list/regular') }}">Regular</a></li>
                    <div class="divider"></div>
                </ul>
            </li>
            <li class="divider"></li>
            <li><a href="{{ url('attendance') }}"><i class="glyphicon glyphicon-time"></i> Attendance</a></li>
            <li class="divider"></li>
            <li><a href="{{ url('add/user') }}"><i class="fa fa-user"></i> Add user</a></li>
        </ul>
    </li>
    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="glyphicon glyphicon-duplicate"></i> Tracking Documents<span class="caret"></span></a>
        <ul class="dropdown-menu">
            <li>

                <a href="{{ asset('form/so_list') }}"><i class="fa fa-file"></i> Office Order</a>

            </li>
            <li class="divider"></li>
            <li>
                <a href="{{ asset('tracked/leave') }}"><i class="fa fa-file"></i> Leave</a>
            </li>
            <li class="divider"></li>
            <li class="dropdown-submenu">
                <a href="#" data-toggle="dropdown"><i class="fa fa-file"></i> CTO</a>
                <ul class="dropdown-menu">
                    <li><a href="{{ asset('form/cdo_list') }}"><i class="fa fa-file-text"></i> Pending CTO</a></li>
                </ul>
            </li>
        </ul>
    </li>
    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user"></i> Account<span class="caret"></span></a>
        <ul class="dropdown-menu">
            <li><a href="{{ asset('add/user')}}"><i class="fa fa-plus"></i> Add user</a></li>
            <li class="divider"></li>
            <li><a href="{{ asset('resetpass')}}"><i class="fa fa-unlock"></i> Change Password</a></li>
            <li class="divider"></li>
            <li><a href="{{ url('/logout') }}"><i class="fa fa-sign-out"></i> Logout</a></li>
        </ul>
    </li>
</ul>