<span id="cdo_updatev1" data-link="{{ asset('cdo_updatev1') }}"></span>
@if(isset($paginate_all) and count($paginate_all) >0)
    <div class="table-responsive">
        <table class="table table-list table-hover table-striped">
            <thead>
                <tr>
                    <th></th>
                    <th class="text-center">Route #</th>
                    <th class="text-center">Leave Type</th>
                    <th class="text-center">Inclusive Dates</th>
                    <th class="text-center">Prepared Name</th>
                    <th class="text-center">Option</th>
                </tr>
            </thead>
            <tbody style="font-size: 10pt;">
            @foreach($paginate_all as $row)
                <tr>
                    <td><a href="#track" data-link="{{ asset('form/track/'.$row->route_no) }}" data-route="{{ $row->route_no }}" data-toggle="modal" class="btn btn-sm btn-success col-sm-12" style="background-color:#9C8AA5;color:white;"><i class="fa fa-line-chart"></i> Track</a></td>
                    <td class="text-center route-cell"> <a class="title-info" data-route="{{ $row->route_no }}" data-id="{{ $row->id }}" data-backdrop="static" data-link="{{ asset('leave/get') }}" href="#leave_info" data-toggle="modal">{{ $row->route_no }}</a></td>
                    <td class="text-center">{{ ($row->leave_details == '8')?"Monetization" : $row->leave_type  }}</td>
                    <td class="text-center">
                        @foreach($row->appliedDates as $applied)
                            @if($applied->status == 1)
                                {{ '<s>'. date('F j, Y', strtotime($applied->startdate)) .'</s>'}}
                            @elseif($applied->status == 2)
                                {{ '<s>'. date('F j, Y', strtotime($applied->startdate)).'</s>'.' '. date('F j, Y', strtotime($applied->from_date))}}
                            @else
                                @if($applied->startdate == $applied->enddate)
                                    {{date('F j, Y', strtotime($applied->startdate))}}
                                @else
                                    {{date('F j, Y', strtotime($applied->startdate)) . ' - ' . date('F j, Y', strtotime($applied->enddate))}}
                                @endif
                            @endif
                            <br>
                        @endforeach
                    </td>
                    <td class="text-center">
                        {{$row->firstname.' '.$row->middlename.' '.$row->lastname}}
                    </td>
                    @if($row->status == 3)
                        <td class="text-center"><span class="label label-warning"><i class="fa fa-frown-o"></i> Cancelled </span></td>
                    @elseif($row->status == 1)
                        <td  class="text-center"><button type="button" value="{{ $row->route_no }}" onclick="all_status($(this),'cancel')" class="btn-xs btn-danger" style="color:white;"><i class="fa fa-ban"></i> Unprocess</button></td>
                    @else
                        <td  class="text-center"><button type="button" class="btn btn-success btn-xs leave_approved" value="{{$row->id}}" data-route="{{ $row->route_no }}" onclick="pending_status($(this))"><span class="glyphicon glyphicon-ok"></span> Process</button></td>
                    @endif
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    {{ $paginate_all->links() }}
@else
    <div class="alert alert-danger" role="alert"><span style="color:white;">Documents records are empty.</span></div>
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

    function all_status(data,btnType){
        var page = "<?php echo Session::get('page_all') ?>";
        var url = $("#cdo_updatev1").data('link')+'/'+data.val()+'/all?page='+page;
        $.post(url,function(result){

            Lobibox.notify('success',{
                msg:''
            });
            $('.ajax_all').html(result);

            var pendingCount = $(".pending").text();
            var approveCount = $(".approve").text();

            if( btnType == 'cancel'){
                pendingCount++;
                if( approveCount != 0 ){
                    approveCount--;
                }

            }
            else if(btnType == 'approve') {
                if( pendingCount != 0 ){
                    pendingCount--;
                }
                approveCount++;
            }

            $(".pending").html(pendingCount);
            $(".approve").html(approveCount);
        });
    }
    //document information
    $('#inclusive3').daterangepicker();

    $('a[href="#leave_info').click(function(){
        var id = $(this).data('id');
        var url = $(this).data('link');
        $('.modal-title').html('Route #: '+ $(this).data('route'));

        $.get(url +'/' +id , function(data){
            $('#leave_info').modal('show');
            $('.modal-body_leave').html(data);
        });
    });
</script>