
<span id="cdo_updatev1" data-link="{{ asset('cdo_updatev1') }}"></span>
@if(isset($paginate_cancelled) and count($paginate_cancelled) >0)
    <div class="table-responsive" style="margin-top: -20px;">
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
            @foreach($paginate_cancelled as $row)
                <tr>
                    <td><a href="#track" data-link="/dtr/form/track/'.$row->route_no" data-route="{{ $row->route_no }}" data-toggle="modal" class="btn btn-sm btn-success col-sm-12" style="background-color:#9C8AA5;color:white;"><i class="fa fa-line-chart"></i> Track</a></td>
                    <td class="text-left route-cell"> <a class="title-info" data-route="{{ $row->route_no }}" data-id="{{ $row->id }}" data-backdrop="static" data-link="/dtr/leave/get" href="#leave_info" data-toggle="modal">{{ $row->route_no }}</a></td>
                    <td class="text-left">{{ ($row->leave_details == '8')?"Monetization" : $row->type->desc  }}</td>
                    <td class="text-left">
                        @foreach($row->appliedDates as $applied)
                            @if($applied->startdate == $applied->enddate)
                                {{date('F j, Y', strtotime($applied->startdate))}}
                            @else
                                {{date('F j, Y', strtotime($applied->startdate)) . ' - ' . date('F j, Y', strtotime($applied->enddate))}}
                            @endif
                        @endforeach
                    </td>
                    <td class="text-left">
                        {{$row->firstname.' '.$row->middlename.' '.$row->lastname}}
                    </td>
                    <td class="text-center"><span class="label label-warning"><i class="fa fa-frown-o"></i> Cancelled </span></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    {{ $paginate_cancelled->links() }}
@else
    <div class="alert alert-danger" role="alert"><span style="color:white;">Documents records are empty.</span></div>
@endif
<script>
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
