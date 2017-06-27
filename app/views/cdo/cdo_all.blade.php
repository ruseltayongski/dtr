<span id="cdo_updatev1" data-link="{{ asset('cdo_updatev1') }}"></span>
@if(isset($cdo[2]) and count($cdo[2]) >0)
    <div class="table-responsive">
        <table class="table table-list table-hover table-striped">
            <thead>
            <tr>
                <th></th>
                <th class="text-center">Route #</th>
                <th class="text-center">Prepared Date</th>
                @if(\Illuminate\Support\Facades\Auth::user()->usertype)
                    <th class="text-center">Prepared Name</th>
                @else
                    <th class="text-center">Document Type</th>
                @endif
                <th class="text-center">Subject</th>
                <th class="text-center">Option</th>
            </tr>
            </thead>
            <tbody style="font-size: 10pt;">
            @foreach($cdo[2] as $row)
                <tr>
                    <td><a href="#track" data-link="{{ asset('form/track/'.$row->route_no) }}" data-route="{{ $row->route_no }}" data-toggle="modal" class="btn btn-sm btn-success col-sm-12" style="background-color:darkmagenta;color:white;"><i class="fa fa-line-chart"></i> Track</a></td>
                    <td><a class="title-info" data-backdrop="static" data-route="{{ $row->route_no }}" data-link="{{ asset('/form/info/'.$row->route_no.'/cdo') }}" href="#document_info" data-toggle="modal" style="color: #f0ad4e;">{{ $row->route_no }}</a></td>
                    <td>{{ date('M d, Y',strtotime($row->prepared_date)) }}<br>{{ date('h:i:s A',strtotime($row->prepared_date)) }}</td>
                    @if(\Illuminate\Support\Facades\Auth::user()->usertype)
                        <td>{{ pdoController::user_search1($row['prepared_name'])['fname'].' '.pdoController::user_search1($row['prepared_name'])['mname'].' '.pdoController::user_search1($row['prepared_name'])['lname'] }}</td>
                    @else
                        <td>CTO</td>
                    @endif
                    <td>{{ $row->subject }}</td>
                    @if($row->approved_status == 1)
                        <td><button type="button" value="{{ $row->id }}" onclick="approved_status($(this))" class="btn btn-danger" style="color:white;"><i class="fa fa-user-times"></i> Click to disapprove</button></td>
                    @else
                        <td><button type="button" value="{{ $row->id }}" onclick="approved_status($(this))" class="btn btn-info" style="color:white;"><i class="fa fa-check-square"></i> Click to approve</button></td>
                    @endif
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    {{ $cdo[2]->links() }}
@else
    <div class="alert alert-danger" role="alert">Documents records are empty.</div>
@endif

<script>
    //tracking history of the document
    $("a[href='#track']").on('click',function(){
        $('.track_history').html(loadingState);
        var route_no = $(this).data('route');
        var url = $(this).data('link');

        $('#track_route_no').val('Loading...');
        setTimeout(function(){
            $('#track_route_no').val(route_no);
            $.ajax({
                url: url,
                type: 'GET',
                success: function(data) {
                    $('.track_history').html(data);
                }
            });
        },1000);
    });

    function approved_status(data){
        var page = "<?php echo Session::get('page_all') ?>";
        var url = $("#cdo_updatev1").data('link')+'/'+data.val()+'/all?page='+page;
        $.post(url,function(result){
            Lobibox.notify('success',{
                msg:''
            });
            $(".approve").html("<?php echo count(Session::get('cdo_display'))?>");
            $('.ajax_all').html(result);
        });
    }
    //document information
    $("a[href='#document_info']").on('click',function(){
        var route_no = $(this).data('route');
        $('.modal_content').html(loadingState);
        $('.modal-title').html('Route #: '+route_no);
        var url = $(this).data('link');
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
        },1000);
    });

    $("a[href='#document_form']").on('click',function(){
        $('.modal-title').html('CTO');
        var url = $(this).data('link');
        $('.modal_content').html(loadingState);
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
        },1000);
    });
</script>