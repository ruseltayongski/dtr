
<span id="cdo_updatev1" data-link="{{ asset('cdo_updatev1') }}"></span>
@if(isset($paginate_disapproved) and count($paginate_disapproved) >0)
    <div class="table-responsive" style="margin-top: -20px;">

        <table class="table table-list table-hover table-striped">
            <thead>
            <tr>
                <th></th>
                <th class="text-center">Route #</th>
                <th class="text-center">Leave Type</th>
                <th class="text-center">Inclusive Dates</th>
                <th class="text-center">Remarks</th>
                <th class="text-center">Prepared Name</th>
                <th class="text-center">Option</th>
            </tr>
            </thead>
            <tbody style="font-size: 10pt;">
            @foreach($paginate_disapproved as $row)
                <tr>
                    <td><a href="#track" data-link="/dtr/form/track/'.$row->route_no" data-route="{{ $row->route_no }}" data-toggle="modal" class="btn btn-sm btn-success col-sm-12" style="background-color:#9C8AA5;color:white;"><i class="fa fa-line-chart"></i> Track</a></td>

                    <td class="text-left route-cell"> <a class="title-info" data-route="{{ $row->route_no }}" data-id="{{ $row->id }}" data-backdrop="static" data-link="/dtr/form/leave/form" href="#leave_info" data-toggle="modal">{{ $row->route_no }}</a></td>
                    <td class="text-left">
                        <div style="margin:0; line-height:.8;">
                            @if(count($row->extension) > 0)
                                <?php
                                    $shown = [];
                                ?>
                                
                                @foreach($row->extension as $item)
                                    @if(!in_array($item->leave_type, $shown))
                                        @if($item->type == "emergency" && !empty($item->details) && $item->leave_type != "SPL")
                                            <a href="{{ asset('public/img/wellness/' . $item->details) }}" target="_blank">
                                                {{ $item->type_leave->desc }}
                                            </a>
                                        @else   
                                            @if($item->type == "emergency" && $item->leave_type == "SPL")
                                                {{ $item->type_leave->desc }} <br>
                                                <small style="line-height:0" class="text-info">(Domestic Emergency)</small>
                                            @else
                                                {{ $item->type_leave->desc }}
                                            @endif
                                        @endif
                                    @endif
                                    <br>
                                    <?php $shown[] = $item->leave_type; ?>
                                @endforeach
                            @else
                                {{ $row->leave_details == 8
                                    ? 'Monetization'
                                    : ($row->leave_details == 9
                                        ? 'Terminal Leave'
                                        : ($row->type ? $row->type->desc : '')
                                    )
                                }} 
                            @endif
                        </div>
                    </td>
                    <td class="text-left">
                        @foreach($row->extension as $date)
                            <li>
                                {{ $date->start == $date->end
                                    ? date("F j, Y", strtotime($date->start))
                                    : date("F j, Y", strtotime($date->start)) . ' - ' . date("F j, Y", strtotime($date->end))
                                }}
                            </li>
                        @endforeach
                    </td>
                    <td class="text-left">{{ $row->disapproval_remarks }}</td>
                    <td class="text-left">{{ $row->firstname.' '.$row->middlename.' '.$row->lastname }}</td>
                    <td class="text-center">
                        <a class="btn btn-success btn-xs leave_approved" href="{{ url('leave/approved/' .$row->route_no) }}"><span class="glyphicon glyphicon-ok"></span> Process</a>
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
