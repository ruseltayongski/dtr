{{--<span id="cdo_updatev1" data-link="{{ asset('cdo_updatev1') }}"></span>--}}
@if(isset($paginate_approve) and count($paginate_approve) >0)
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
            @foreach($paginate_approve as $row)
                @if($row->status != 3)
                    <tr>
                        <td ><a href="#track" data-link="/dtr/form/track/'.$row->route_no" data-route="{{ $row->route_no }}" data-toggle="modal" class="btn btn-sm btn-success col-sm-12" style="background-color:#9C8AA5;color:white;"><i class="fa fa-line-chart"></i> Track</a></td>
                        <td class="text-left route-cell"> <a class="title-info" data-route="{{ $row->route_no }}" data-id="{{ $row->id }}" data-backdrop="static" data-link="/dtr/form/leave/form" href="#leave_info" data-toggle="modal">{{ $row->route_no }}</a></td>
                        <td class="text-left" style="width:170px"style="width:170px">
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
                        <td class="text-left">
                            {{$row->firstname.' '.$row->middlename.' '.$row->lastname}}
                        </td>
                        <td class="text-center">
                            @if($row->leave_details != 8)
                                <button type="submit" class="btn-xs btn-danger leave_pending" data-route="{{ $row->route_no }}" value="{{ $row->id }}" onclick="approved_status($(this))" style="color:white;"><i class="fa fa-ban"></i> Unprocess</button>
                                <button class="btn-xs btn-warning cancel_leave_dates" id="cancel" onclick="cancel_leave_dates(event)" value="{{ $row->route_no }}" style="color: white;" data-toggle="modal"  data-target="#cancel_leave"><i class="fa fa-close"></i>Cancel</button>
                                {{--<button type="submit" class="btn-xs btn-info remarks" data-target="#remarks" data-route="{{ $row->route_no }}" value="{{ $row->id }}" onclick="add_remarks($(this))" style="color:white;"><i class="fa fa-comment"></i> Remarks</button>--}}
                                <button class="btn-xs btn-success leave_move" onclick="move_leave_dates(event, '{{ $row->route_no }}')" value="{{ $row->route_no }}" style="color: white;" data-toggle="modal" data-target="#leave_move"><i class="fa fa-eraser"></i>Move</button>
                            @else
                                <button type="submit" class="btn-xs btn-danger leave_pending" data-route="{{ $row->route_no }}" value="{{ $row->id }}" onclick="approved_status($(this))" style="color:white;"><i class="fa fa-ban"></i> Unprocess</button>
                            @endif
                        </td>

                    </tr>
                @endif
            @endforeach
            </tbody>
        </table>
    </div>
    {{ $paginate_approve->links() }}
@else
    <div class="alert alert-danger" role="alert" style="color: white"><span style="color:white;">Documents records are empty.</span></div>
@endif

<script>
    //document information
    $('#cancel').click(function () {

    });
    $('a[href="#leave_info').click(function(){
        var id = $(this).data('id');
        var url = $(this).data('link');
        $('.modal-title').html('Route #: '+ $(this).data('route'));

        $.get(url +'/' +id , function(data){
            $('#leave_info').modal('show');
            $('.modal-body_leave').html(data);
        });
    });

    function approved_status(data){
        $('#modal_leave_pending').modal({
            backdrop: 'static',
            keyboard: false,
            show: true
        });

        var route = $(data).data('route');
        $("#leave_route_pending").val(route);
        console.log("route", route);
    }

    function add_remarks(data){
        $('#remarks').modal({
            backdrop: 'static',
            keyboard: false,
            show: true
        });

        var date_route = $(data).data('route');
        console.log("route", date_route);
        $("#route_remarks").val(date_route);
        console.log("route",$("#route_remarks").val());

        $('#remarks_body').empty();

            <?php $routes = Leave::get(); ?>
            <?php foreach ($routes as $route){ ?>
        var route = "<?php echo $route->route_no;?>";
        if(date_route == route){
            $(".modal-title").html("Route No:<strong>"+route);
                <?php $dates = LeaveAppliedDates::where('leave_id', '=', $route->id)->get(); ?>
            var dateList= [];
                <?php foreach ($dates as $date) {?>
            var container = document.querySelector("#remarks table");
            var diff = "<?php $diff=(strtotime($date->startdate)-strtotime($date->enddate))/ (60*60*24); echo $diff*-1; ?>";
            var startDate = new Date("<?php echo date('F j, Y', strtotime($date->startdate)); ?>");
            var endDate = new Date("<?php echo date('F j, Y', strtotime($date->enddate)); ?>");
            if(diff == 0){
                dateList.push(startDate.toLocaleDateString());
            }else{
                while (startDate <= endDate) {
                    dateList.push(startDate.toLocaleDateString());
                    startDate.setDate(startDate.getDate() + 1);
                }
            }
                <?php }?>
            var length = dateList.length;
            var i=0;
            var disapprovedAll ='<label>Check to Disapproved All:</label>'+
                '<input style="transform: scale(1.5)" type="checkbox" class="minimal" id="applied_dates" value="disapproved_all" name="applied_dates" />';
            container.innerHTML += disapprovedAll;
            while (length > i) {
                var html = '<div class="checkbox">' +
                    '<label style="margin-left: 15%">' +
                    '<input type="checkbox" style="transform: scale(1.5)" class="minimal" id="applied_dates_'+ i +'" name="applied_dates" value="' + dateList[i] + '"  />' +
                    dateList[i] +
                    '</div>';
                container.innerHTML += html;
                i = i + 1;
            }
            var remarks ='<label>Remarks:</label><br>'+
                '<div align="center">'+
                    '<input style="transform: scale(1.5); width: 60%; align-self: center" type="text" class="minimal" id="remarks" name="remarks" required/>'+
                '</div>';
            container.innerHTML += remarks;

            $('#dates_remarks').val(dateList);
        }
        <?php }?>

        $('input[type="checkbox"]').on('change', function () {
            if($(this).val() === "disapproved_all"){
                var ischecked = $(this).prop('checked');
                $('input[name="applied_dates"]').prop('checked', ischecked);
            }
            var selectedCheckboxes = [];
            $('input[name="applied_dates"]:checked').each(function () {
                selectedCheckboxes.push($(this).val());
            });
            $('#dis_dates').val(selectedCheckboxes.join(', '));
        });

        $('#restore_btn').on('click', function (e) {
            e.preventDefault(e);
        });

    }
</script>