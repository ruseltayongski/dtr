<span id="cdo_updatev1" data-link="{{ asset('cdo_updatev1') }}"></span>
@if(isset($paginate_all) and count($paginate_all) >0)
    <div class="table-responsive">
        <table class="table table-list table-hover table-striped">
            <thead>
            <tr>
                <th></th>
                <th class="text-center">Route #</th>
                <th class="text-center">Reason</th>
                <th class="text-center">Inclusive Dates</th>
                <th class="text-center">Prepared Name</th>
                <th class="text-center">Beginning Balance</th>
                <th class="text-center" width="15%">Option</th>
            </tr>
            </thead>
            <tbody style="font-size: 10pt;">
            @foreach($paginate_all as $row)
                <tr>
                    <td><a href="#track" data-link="{{ asset('form/track/'.$row->route_no) }}" data-route="{{ $row->route_no }}" data-toggle="modal" class="btn btn-sm btn-success col-sm-12" style="background-color:#9C8AA5;color:white;"><i class="fa fa-line-chart"></i> Track</a></td>
                    <td><a class="title-info" data-backdrop="static" data-route="{{ $row->route_no }}" data-link="{{ asset('/form/info/'.$row->route_no.'/cdo') }}" href="#document_info" data-toggle="modal" style="color: #f0ad4e;">{{ $row->route_no }}</a></td>
                    <td>{{ $row->subject }}</td>
                    <td>
                        @if($row->applied_dates == null)
                            <?php
                            $hours = ($row->cdo_hours == "cdo_am") ? "(AM)" : ($row->cdo_hours == "cdo_pm") ? "(PM)" : null;
                            $start_date = date('M j, Y', strtotime($row->start));
                            $end_date = date('M j, Y', strtotime('-1 day', strtotime($row->end)));
                            $dateStrings = ($start_date == $end_date) ? "$start_date $hours" : "$start_date - $end_date $hours";
                            echo $dateStrings;
                            ?>
                        @else
                            <?php
                                $get_date = CdoAppliedDate::where('cdo_id', $row->id)->get();
                                $dateStrings=[];
                                foreach ($get_date as $index=>$dates){
                                    $hours = ($dates->cdo_hours == "cdo_am") ? " (AM)" : ($dates->cdo_hours == "cdo_pm") ? " (PM)" : null;
                                    $start_date = date('M j, Y', strtotime($dates->start_date));
                                    $end_date = date('M j, Y', strtotime($dates->end_date));
                                    $dateStrings[] = ($start_date == $end_date) ? "$start_date $hours" : "$start_date - $end_date $hours";
                                }
                                echo implode(',<br>',$dateStrings);
                                ?>
                        @endif
                    </td>
                    <td>
                        <?php
                        $personal_information = InformationPersonal::where('userid','=',$row['prepared_name'])->first();
                        echo $personal_information->fname.' '.$personal_information->mname.' '.$personal_information->lname;
                        ?>
                    </td>
                    <td class="text-center">
                        <b style="color:green;">
                            {{ $personal_information->bbalance_cto }}
                        </b>
                    </td>
                    @if($row->status == 3)
                        <td class="text-center"><span class="label label-warning"><i class="fa fa-frown-o"></i> Cancelled </span></td>
                    @elseif($row->approved_status == 1)
                        <td  class="text-center"><button type="button" value="{{ $row->id }}" onclick="all_status($(this),'cancel')" class="btn-xs btn-danger" style="color:white;"><i class="fa fa-ban"></i> Unprocessed</button></td>
                    @else
                        <td  class="text-center"><button type="button" value="{{ $row->id }}" onclick="all_status($(this),'approve')" class="btn-xs btn-info" style="color:white;"><i class="fa fa-frown-o"></i> Processed</button></td>
                    @endif
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    {{ $paginate_all->links() }}
@else
    <div class="alert alert-danger" role="alert"><span style="color:red;">Documents records are empty.</span></div>
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