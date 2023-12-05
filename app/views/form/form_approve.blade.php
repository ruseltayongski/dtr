{{--<span id="cdo_updatev1" data-link="{{ asset('cdo_updatev1') }}"></span>--}}
@if(isset($paginate_approve) and count($paginate_approve) >0)
    <div class="table-responsive" style="margin-top: -20px;">
        <table class="table table-list table-hover table-striped">
            <thead>
            <tr>
                <th></th>
                <th class="text-center" style="width: 10%">Route #</th>
                <th class="text-center" style="width: 10%">Leave Type</th>
                <th class="text-center" style="width: 25%">Inclusive Dates</th>
                <th class="text-center" width="20%">Prepared Name</th>
                {{--<th class="text-center"width="15%">Beginning Balance</th>--}}
                <th class="text-center" width="40%">Option</th>
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
                            <button class="btn-xs btn-warning cancel_dates" id="cancel" onclick="cancel_dates(event)"  value="{{ $row->route_no }}" style="color: white;" data-toggle="modal"  data-target="#cancel_dates"><i class="fa fa-close"></i>Cancel</button>
                            <button type="submit" class="btn-xs btn-info remarks" data-target="#remarks" data-route="{{ $row->route_no }}" value="{{ $row->id }}" onclick="add_remarks($(this))" style="color:white;"><i class="fa fa-comment"></i> Remarks</button>
                            <button class="btn-xs btn-success move_leave" id="move" onclick="move_dates(event)"  value="{{ $row->route_no }}" style="color: white;" data-toggle="modal"  data-target="#move_leave"><i class="fa fa-eraser"></i>Move</button>

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
        $("#route").val(date_route);
        console.log("route", date_route);

        $('#remarks_body').empty();

            <?php $routes = Leave::get(); ?>
            <?php foreach ($routes as $route){ ?>
        var route = "<?php echo $route->route_no;?>";
        if(date_route == route){
            $(".modal-title").html("Route No:<strong>"+route);
                <?php $dates = LeaveAppliedDates::where('leave_id', '=', $route->id)->get(); ?>
            var dateList= [];
//                var dateTime = [];//for cdo_hours
                <?php foreach ($dates as $date) {?>
            var container = document.querySelector("#remarks table");
            var diff = "<?php $diff=(strtotime($date->startdate)-strtotime($date->enddate))/ (60*60*24); echo $diff*-1; ?>";
            var startDate = new Date("<?php echo date('F j, Y', strtotime($date->startdate)); ?>");
            var endDate = new Date("<?php echo date('F j, Y', strtotime($date->enddate)); ?>");
            console.log("date", startDate);
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
            var cancelAllCheckbox ='<label>Check to Disapproved All:</label>'+
                '<input style="transform: scale(1.5)" type="checkbox" class="minimal" id="applied_dates" value="disapproved_all" name="applied_dates" />';
            container.innerHTML += cancelAllCheckbox;
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
                    '<input style="transform: scale(1.5); width: 60%; align-self: center" type="text" class="minimal" id="applied_dates" name="applied_dates" />'+
                '</div>';
            container.innerHTML += remarks;

            var container2 = document.querySelector("#remarks .modal-footer");
            var button = '<button class="btn btn-info restore" value="restore" id="restore_btn" onclick="restore_leave($(this))">Restore'+
                    '</button>';
            container2.innerHTML += button;

            $('#dates').val(dateList);
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
            $('#from_date').val(selectedCheckboxes.join(', '));
        });

        $('#restore_btn').on('click', function (e) {
            e.preventDefault(e);
        });

    }
    function restore_leave(button) {
        console.log("restore_here");
        $('#restore').modal({
            show: true
        });
        var btn_pstn = $(button).offset();
        $('#restore').css({
            'top':(btn_pstn.top+10) + 'px',
            'left':btn_pstn.left + 'px',
            'display': 'none'
        });
//        var route = $(data).data('route');
//        $("#leave_route_pending").val(route);
//        console.log("route", route);
    }
</script>