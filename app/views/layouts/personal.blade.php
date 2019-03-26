<ul class="nav navbar-nav">
    {{--<li>
        <a href="{{ URL::to('document') }}"><i class="fa fa-file-code-o"></i> Create Document</a>
    </li>--}}
    <li><a href="{{ url('/') }}"><i class="fa fa-home"></i> Home</a></li>
    @if(Auth::user()->pass_change  == 1)
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-file"></i> Manage DTR<span class="caret"></span></a>
            <ul class="dropdown-menu">
                <li class="dropdown-submenu">
                    <a href="#"><i class="fa fa-unlock"></i>&nbsp;&nbsp; My DTR</a>
                    <ul class="dropdown-menu">
                        <li class="dropdown-submenu">
                        <li><a href="{{ asset('/personal/dtr/list')  }}">Admin generated DTR</a></li>
                        <li class="divider"></li>
                        <li><a href="{{ asset('/personal/add/logs') }}">Create time log</a></li>
                        <li class="divider"></li>
                        <li class="dropdown-submenu">
                            <a href="#create-absent">Create absence</a>
                            <ul class="dropdown-menu">
                                <li><a href="#" class="create-absent" data-toggle="modal" data-target="#absent_desc" data-link="{{ asset('create/absent/description?t=SO') }}">OFFICE ORDER</a></li>
                                <li class="divider"></li>
                                <li><a href="#" class="create-absent" data-toggle="modal" data-target="#absent_desc" data-link="{{ asset('create/absent/description?t=LEAVE') }}">LEAVE</a> </li>
                                <li class="divider"></li>
                                <li><a href="#" class="create-absent" data-toggle="modal" data-target="#absent_desc" data-link="{{ asset('create/absent/description?t=CTO') }}">CDO</a> </li>
                            </ul>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#" data-toggle="modal" data-target="#delete_edited" >Delete user created logs</a>
                        </li>
                    </ul>
                </li>
                <li class="divider"></li>
                <li><a href="{{ url('calendar') }}"><i class="fa fa-calendar"></i>&nbsp;&nbsp; Calendar</a></li>
                <li class="divider"></li>
                <li class="dropdown-submenu">
                    <a href="#" data-toggle="dropdown"><i class="fa fa-file" aria-hidden="true"></i>&nbsp;&nbsp; Form</a>
                    <ul class="dropdown-menu">
                        <li class="dropdown-submenu">
                        <li><a href="{{ asset('form/leave/all') }}">Leave</a></li>
                        <li class="divider"></li>
                        <li><a href="{{ asset('form/so_list') }}">Office Order</a></li>
                        <li class="divider"></li>
                        <li><a href="{{ asset("form/cdo_list") }}">CDO</a></li>
                    </ul>
                </li>
                
            </ul>
        </li>
    @endif
    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user"></i> Account<span class="caret"></span></a>
        <ul class="dropdown-menu">
            <li><a href="{{ asset('resetpass')}}"><i class="fa fa-unlock"></i>&nbsp;&nbsp; Change Password</a></li>
            <li class="divider"></li>
            <li><a href="{{ url('/logout') }}"><i class="fa fa-sign-out"></i>&nbsp;&nbsp; Logout</a></li>
        </ul>
    </li>
    <li class="divider"></li>
    <li><a href="{{ asset('manual') }}"> <i class="glyphicon glyphicon-question-sign"></i> User Manual</a></li>
</ul>
<script>
    function absent(data){
        <?php $delete = 'absent' ?>
        $("#absentDocument").modal();
        $('.modal-title').html('Absent');
        $('.modal_content').html(loadingState);
        var url = data.data('link');
        setTimeout(function(){
            $.ajax({
                url: url,
                type: 'GET',
                success: function(data) {
                    $('.modal_content').html(data);
                    $('#reservation').daterangepicker();
                    var datePicker = $('body').find('.datepicker');
                    $('input').attr('autocomplete', 'off');
                }
            });
        },700);
    }
</script>