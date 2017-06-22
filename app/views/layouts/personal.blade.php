<ul class="nav navbar-nav">
    {{--<li>
        <a href="{{ URL::to('document') }}"><i class="fa fa-file-code-o"></i> Create Document</a>
    </li>--}}
    <li><a href="{{ url('/') }}"><i class="fa fa-home"></i> Home</a></li>
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
                    <li>
                        <a href="#" onclick="absent($(this));" data-link="{{ asset('form/absent') }}" data-dismiss="modal" data-backdrop="static"> Create absent</a>
                    </li>
                </ul>
            </li>
            <li class="divider"></li>
            <li><a href="{{ url('calendar') }}"><i class="fa fa-calendar"></i>&nbsp;&nbsp; Calendar</a></li>
            <li class="divider"></li>
            <li class="dropdown-submenu">
                <a href="#" data-toggle="dropdown"><i class="fa fa-file" aria-hidden="true"></i>&nbsp;&nbsp; Leave/CDO/SO</a>
                <ul class="dropdown-menu">
                    <li class="dropdown-submenu">
                    <li><a href="{{ asset('form/leave/all') }}">Leave</a></li>
                    <li class="divider"></li>
                    <li><a href="{{ asset('form/so_list') }}">Office Order</a></li>
                    <li class="divider"></li>
                    <li><a href="{{ asset("form/cdo_list") }}">CTO</a></li>
                </ul>
            </li>
            <li class="divider"></li>
            <li class="dropdown-submenu">
                <a href="#" data-toggle="dropdown"><i class="fa fa-cog"></i>&nbsp;&nbsp; Settings</a>
                <ul class="dropdown-menu">
                    <li><a href="#document_form" data-backdrop="static" data-toggle="modal" data-link="{{ asset('/form/worksheet') }}">Edit work schedule</a></li>
                    <li><a href="#document_form" data-backdrop="static" data-toggle="modal" data-link="{{ asset('/form/justification/letter') }}"></a></li>
                </ul>
            </li>
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
@if(Session::get('added'))
    <script>
        Lobibox.notify('success',{
            msg:'Successfully Added!'
        });
    </script>
    <?php Session::forget('added'); ?>
@endif
@if(Session::get('deleted'))
    <script>
        Lobibox.notify('error',{
            msg:'Successfully Deleted!'
        });
    </script>
    <?php Session::forget('deleted'); ?>
@endif
@if(Session::get('updated'))
    <script>
        Lobibox.notify('info',{
            msg:'Successfully Updated!'
        });
    </script>
    <?php Session::forget('updated'); ?>
@endif
@if(Session::get('absent'))
    <script>
        Lobibox.notify('error',{
            msg:'Successfully Absent!'
        });
    </script>
    <?php Session::forget('absent'); ?>
@endif
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