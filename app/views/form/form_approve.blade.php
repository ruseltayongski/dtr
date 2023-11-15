{{--<span id="cdo_updatev1" data-link="{{ asset('cdo_updatev1') }}"></span>--}}
@if(isset($paginate_approve) and count($paginate_approve) >0)
    <div class="table-responsive" style="margin-top: -20px;">
        <table class="table table-list table-hover table-striped">
            <thead>
            <tr>
                <th></th>
                <th class="text-center">Route #</th>
                <th class="text-center" >Reason</th>
                <th class="text-center">Inclusive Dates</th>
                <th class="text-center" width="13%">Prepared Name</th>
                {{--<th class="text-center"width="15%">Beginning Balance</th>--}}
                <th class="text-center" width="17%">Option</th>
            </tr>
            </thead>
            <tbody style="font-size: 10pt;">
            @foreach($paginate_approve as $row)
                @if($row->status != 3)
                    <tr>
                        <td><a href="#track" data-link="{{ asset('form/track/'.$row->route_no) }}" data-route="{{ $row->route_no }}" data-toggle="modal" class="btn btn-sm btn-success col-sm-12" style="background-color:#9C8AA5;color:white;"><i class="fa fa-line-chart"></i> Track</a></td>
                        <td class="route-cell"> <a class="title-info" data-route="{{ $row->route_no }}" data-id="{{ $row->id }}" data-backdrop="static" data-link="{{ asset('leave/get') }}" href="#leave_info" data-toggle="modal">{{ $row->route_no }}</a></td>
                        <td>{{ $row->leave_type }}</td>
                        <td>
                            {{--@if($row->applied_dates == null)--}}
                            {{--<?php--}}
                            {{--$hours = " ";--}}
                            {{--if($row->cdo_hours == "cdo_am"){--}}
                            {{--$hours=" (AM)";--}}
                            {{--}else if($row->cdo_hours == "cdo_pm"){--}}
                            {{--$hours=" (PM)";--}}
                            {{--}--}}
                            {{--$start_date = date('M j, Y', strtotime($row->start));--}}
                            {{--$end_date = date('M j, Y', strtotime('-1 day', strtotime($row->end)));--}}
                            {{--$dateStrings = ($start_date == $end_date) ? "$start_date $hours" : "$start_date - $end_date $hours";--}}
                            {{--echo $dateStrings;--}}
                            {{--?>--}}
                            {{--@else--}}

                            {{--<?php--}}
                            {{--$get_date = CdoAppliedDate::where('cdo_id', $row->id)->get();--}}
                            {{--$dateStrings=[];--}}
                            {{--if(count($get_date)>0){--}}

                            {{--foreach ($get_date as $index=>$dates){--}}
                            {{--$hours = " ";--}}
                            {{--if($dates->cdo_hours == "cdo_am"){--}}
                            {{--$hours=" (AM)";--}}
                            {{--}else if($dates->cdo_hours == "cdo_pm"){--}}
                            {{--$hours=" (PM)";--}}
                            {{--}--}}
                            {{--$start_date = date('M j, Y', strtotime($dates->start_date));--}}
                            {{--$end_date = date('M j, Y', strtotime('-1 day', strtotime($dates->end_date)));--}}
                            {{--$dateStrings[] = ($start_date == $end_date) ? "$start_date $hours" : "$start_date - $end_date $hours";--}}
                            {{--}--}}
                            {{--echo implode(',<br>',$dateStrings);--}}
                            {{--}else{--}}

                            {{--$hours = " ";--}}
                            {{--if($row->cdo_hours == "cdo_am"){--}}
                            {{--$hours=" (AM)";--}}
                            {{--}else if($row->cdo_hours == "cdo_pm"){--}}
                            {{--$hours=" (PM)";--}}
                            {{--}--}}
                            {{--$start_date = date('M j, Y', strtotime($row->start));--}}
                            {{--$end_date = date('M j, Y', strtotime('-1 day', strtotime($row->end)));--}}
                            {{--$dateStrings = ($start_date == $end_date) ? "$start_date $hours" : "$start_date - $end_date $hours";--}}
                            {{--echo $dateStrings;--}}
                            {{--}--}}
                            {{--?>--}}
                            {{--@endif--}}
                        </td>
                        <td>
                            {{$row->firstname.' '.$row->middlename.' '.$row->lastname}}
                        </td>
                        <td>
                            <button type="submit" class="btn-xs btn-danger leave_pending" data-route="{{ $row->route_no }}" value="{{ $row->id }}" onclick="approved_status($(this))" style="color:white;"><i class="fa fa-ban"></i> Unprocess</button>
                            <button class="btn-xs btn-warning cancel_dates" id="cancel" onclick="cancel_dates(event)"  value="{{ $row->route_no }}" style="color: white;" data-toggle="modal"  data-target="#cancel_dates"><i class="fa fa-ban"></i>Cancel</button>
                        </td>

                    </tr>
                @endif
            @endforeach
            </tbody>
        </table>
    </div>
    {{ $paginate_approve->links() }}
@else
    <div class="alert alert-danger" role="alert" style="color: red"><span style="color:red;">Documents records are empty.</span></div>
@endif

<div class="modal fade" tabindex="5" role="dialog" id="cancel_dates">
    <div class="modal-dialog modal-xs" role="document" id="size">
        <div class="modal-content" id="cancel_date">
            <form action="{{asset('cancel_dates')}}" method="get">
                <div class="modal-header" style="background-color: orange">
                    <strong><h4 class="modal-title" style="display: inline-block"></h4></strong>
                    <button style="display: inline-block" type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div>
                    <table class="modal-body table" id="cancel_body">

                    </table>
                </div>
                <div class="modal-footer">
                    <input type="hidden" id="route" name="route">
                    <input type="hidden" id="selected_date" name="selected_date">
                    <input type="hidden" id="dates" name="dates">
                    <input type="hidden" id="cdo_hours" name="cdo_hours">
                    <input type="hidden" id="all_hours" name="all_hours">
                    <input type="hidden" id="cancel_type" name="cancel_type">
                    <button type="submit" value="specific_date" class="btn btn-success">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    //document information
    $('a[href="#leave_info').click(function(){
        var id = $(this).data('id');
        var url = $(this).data('link');

        $.get(url +'/' +id , function(data){
            $('#leave_info').modal('show');
            $('.modal-body_leave').html(data);
        });
    });
    function approved_status(data){
        $(".leave_pending").click(function(){
            $('#modal_leave_pending').modal({
                backdrop: 'static',
                keyboard: false,
                show: true
            });

            var route = $(this).data('route');
            $("#leave_route_pending").val(route);
        });
    }
</script>