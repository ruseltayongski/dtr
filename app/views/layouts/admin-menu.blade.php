<ul class="nav navbar-nav">
    <li><a href="{{ url('/') }}"><i class="fa fa-home"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('admin/upload') }}"><i class="fa fa-plus"></i> Upload File</a></li>
    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-file"></i> Manage DTR<span class="caret"></span></a>
        <ul class="dropdown-menu">
            <li class="dropdown-submenu">
                <a href="#"><i class="fa fa-unlock"></i>&nbsp;&nbsp; Employee DTR</a>
                <ul class="dropdown-menu">
                    <li><a href="{{ asset('dtr/list/jo') }}">Job Order</a></li>
                    <li><a href="{{ asset('dtr/list/regular') }}">Regular Employee</a></li>
                </ul>
            </li>
            <li class="divider"></li>
            <li class="dropdown-submenu">
                <a href="#"><i class="fa fa-clock-o"></i>&nbsp;&nbsp; Manage Schedule</a>
                <ul class="dropdown-menu">
                    <li><a href="{{ asset('work-schedule') }}">Working Schedule</a></li>
                    <li><a href="{{ asset('new/flixe/group') }}">Employee Flixe Group</a></li>
                </ul>
            </li>
            <li class="divider"></li>
            <li><a href="{{ url('calendar') }}"><i class="fa fa-calendar"></i>&nbsp;&nbsp; Calendar</a></li>
            <li class="divider"></li>
            <li class="dropdown-submenu">
                <a href="#" data-toggle="dropdown"><i class="fa fa-cog"></i>&nbsp;&nbsp; Settings</a>
                <ul class="dropdown-menu">
                    <li><a href="#document_form" data-backdrop="static" data-toggle="modal" data-link="{{ asset('/form/worksheet') }}">Edit work schedule</a></li>
                    <li><a href="#document_form" data-backdrop="static" data-toggle="modal" data-link="{{ asset('/form/justification/letter') }}"></a></li>
                </ul>
            </li>
            <li class="divider"></li>
            <li><a href="{{ url('employees') }}"><i class="fa fa-user"></i> Employees</a></li>
            <li class="divider"></li>
            <li><a href="{{ url('add/attendance') }}"><i class="fa fa-user"></i> Add attendance</a></li>
        </ul>
    </li>
    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user"></i> Account<span class="caret"></span></a>
        <ul class="dropdown-menu">
            <li><a href="{{ asset('resetpass')}}"><i class="fa fa-unlock"></i>&nbsp;&nbsp; Change Password</a></li>
            <li class="divider"></li>
            <li><a href="{{ url('/logout') }}"><i class="fa fa-sign-out"></i>&nbsp;&nbsp; Logout</a></li>
        </ul>
    </li>
</ul>