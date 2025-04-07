
<span id="cdo_updatev1" data-link="{{ asset('cdo_updatev1') }}"></span>
@if(isset($paginate_pending) and count($paginate_pending) >0)
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
            @foreach($paginate_pending as $row)
                <tr>
                    <td><a href="#track" data-link="/dtr/form/track/'.$row->route_no" data-route="{{ $row->route_no }}" data-toggle="modal" class="btn btn-sm btn-success col-sm-12" style="background-color:#9C8AA5;color:white;"><i class="fa fa-line-chart"></i> Track</a></td>

                    <td class="text-center route-cell"> <a class="title-info" data-route="{{ $row->route_no }}" data-id="{{ $row->id }}" data-backdrop="static" data-link="/dtr/leave/get" href="#leave_info" data-toggle="modal">{{ $row->route_no }}</a></td>
                    <td class="text-center">{{ ($row->leave_details == '8')?"Monetization" : $row->leave_type  }}</td>
                    <td class="text-center">
                        @foreach($row->appliedDates as $applied)
                            @if($applied->startdate == $applied->enddate)
                                {{date('F j, Y', strtotime($applied->startdate))}}
                            @else
                                {{date('F j, Y', strtotime($applied->startdate)) . ' - ' . date('F j, Y', strtotime($applied->enddate))}}
                            @endif
                            <br>
                        @endforeach
                    </td>
                    <td class="text-center">{{$row->firstname.' '.$row->middlename.' '.$row->lastname}}</td>
                    <td class="text-center">
                        <a class="btn btn-success btn-xs leave_approved" href="{{ url('leave/approved/' .$row->route_no) }}"><span class="glyphicon glyphicon-ok"></span> Process</a>
                        <a class="btn btn-danger btn-xs leave_disapprove" data-toggle="modal" onclick="disapproved('{{ $row->route_no }}')" href="#disapproved"><span class="glyphicon glyphicon-remove"></span> Disapprove</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    {{ $paginate_pending->links() }}
@else
    <div class="alert alert-danger" role="alert"><span style="color:white;">Documents records are empty.</span></div>
@endif

<div class="modal fade" tabindex="5" role="dialog" id="disapproved">
    <div class="modal-dialog modal-xs" role="document" id="size">
        <div class="modal-content">
            <form method="POST" id="disapproved_form">
                <div class="modal-header" style="background-color: orange; font-weight: bold">
                    <strong><h4 class="modal-title" style="display: inline-block">Disapproved Leave</h4></strong>
                    <button style="display: inline-block" type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal_body" style="text-align: center; padding:2%;">
                    <textarea class="form-control" name="remarks" style="margin-left: 1%; height: 100px; width: 98%;" placeholder="Reason ..." required></textarea>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function disapproved(route_no){
        $('#disapproved_form').attr('action', '/dtr/leave/disapproved/' + route_no);
    }
</script>