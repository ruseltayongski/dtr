<ul class="nav navbar-nav">
    <li><a href="{{ url('/') }}"><i class="fa fa-home"></i> Home</a></li>

    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user"></i> Account<span class="caret"></span></a>
        <ul class="dropdown-menu">
            <li><a href="{{ url('add/user') }}"><i class="fa fa-user"></i> Add user</a></li>
            <li><a href="{{ asset('reset/password')}}"><i class="glyphicon glyphicon-cog"></i> Reset Password</a></li>
            <li><a href="{{ url('/logout') }}"><i class="fa fa-sign-out"></i> Logout</a></li>
        </ul>
    </li>
</ul>

