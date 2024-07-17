
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
                    <td><a href="#track" data-link="{{ asset('form/track/'.$row->route_no) }}" data-route="{{ $row->route_no }}" data-toggle="modal" class="btn btn-sm btn-success col-sm-12" style="background-color:#9C8AA5;color:white;"><i class="fa fa-line-chart"></i> Track</a></td>

                    <td class="text-center route-cell"> <a class="title-info" data-route="{{ $row->route_no }}" data-id="{{ $row->id }}" data-backdrop="static" data-link="{{ asset('leave/get') }}" href="#leave_info" data-toggle="modal">{{ $row->route_no }}</a></td>

                    <td class="text-center">{{ $row->leave_type }}</td>
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
                        @if($row->leave_details == 8)
                            <button type="button" class="btn btn-success btn-sm leave_approved" data-route="{{$row->route_no}}" onclick="pending_leave($(this), '{{$row->leave_details}}', '{{$row->userid}}')" data-target="#leave_approved"><span class="glyphicon glyphicon-ok"></span> Process</button>
                        @else
                            <a class="btn btn-success btn-sm leave_approved" href="{{ url('leave/approved/' .$row->route_no) }}"><span class="glyphicon glyphicon-ok"></span> Process</a>

                            {{--<button type="button" class="btn btn-success btn-sm leave_approved" data-route="{{$row->route_no}}" onclick="pending_leave($(this), '{{$row->leave_details}}', '{{$row->userid}}')" data-target="#leave_approved"><span class="glyphicon glyphicon-ok"></span> Process</button>--}}
                        @endif
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

<script>

</script>