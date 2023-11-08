<span id="cdo_updatev1" data-link="{{ asset('cdo_updatev1') }}"></span>
@if(isset($paginate_approve) and count($paginate_approve) >0)
    <div class="table-responsive" style="margin-top: -20px;">
        <label style="padding-bottom: 10px;">Check to select all to pending </label>
        <input type="checkbox" id="click_pending">
        <label class="button" style="font-weight: normal !important;"></label>
        <table class="table table-list table-hover table-striped">
            <thead>
            <tr>
                <th></th>
                <th class="text-center">Route #</th>
                <th class="text-center">Reason</th>
                <th class="text-center">Inclusive Dates</th>
                <th class="text-center">Prepared Name</th>
                <th class="text-center">Beginning Balance</th>
                <th class="text-center" width="20%">Option</th>
            </tr>
            </thead>
            <tbody style="font-size: 10pt;">
            @foreach($paginate_approve as $row)
                @if($row->status != 3)
                <tr>
                    <td><a href="#track" data-link="{{ asset('form/track/'.$row->route_no) }}" data-route="{{ $row->route_no }}" data-toggle="modal" class="btn btn-sm btn-success col-sm-12" style="background-color:#9C8AA5;color:white;"><i class="fa fa-line-chart"></i> Track</a></td>
                    <td><a class="title-info" data-backdrop="static" data-route="{{ $row->route_no }}" style="color: #f0ad4e;" data-link="{{ asset('/form/info/'.$row->route_no.'/cdo') }}" href="#document_info" data-toggle="modal">{{ $row->route_no }}</a></td>
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
                                $end_date = date('M j, Y', strtotime('-1 day', strtotime($dates->end_date)));
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
                    <td>
                        <button type="submit" class="btn-xs btn-danger" value="{{ $row->id }}" onclick="approved_status($(this))" style="color:white;"><i class="fa fa-ban"></i> Unprocessed</button>
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
                    <button type="submit" value="specific_date" class="btn btn-success">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
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
        },700);
    });

    function approved_status(data){
        var page = "<?php echo Session::get('page_approve') ?>";
        var url = $("#cdo_updatev1").data('link')+'/'+data.val()+'/approve?page='+page;
        console.log(url);
        $.post(url,function(result){
            console.log(result);
            //$('.ajax_approve').html(loadingState);
            setTimeout(function(){
                if(result["count_approve"] && !result['paginate_approve']){
                    getPosts(page-1,'');
                } else {
                    $('.ajax_approve').html(result);
                }

                var pendingCount = parseInt($(".pending").text()) + 1;
                var approveCount = parseInt($(".approve").text()) - 1;

                $(".pending").html(pendingCount);
                $(".approve").html(approveCount);

                Lobibox.notify('error',{
                    msg:'CTO CANCELED!'
                });

            },700);
        });
    }

    $(function () {
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' // optional
        });

        $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' // optional
        });
    });

    $('#click_pending').on('ifChecked', function(){
        $(".button").html("<button type='button' value='pending' onclick='click_all($(this))' class='btn-group-sm btn-danger'><i class='fa fa-frown-o'></i> pending all cdo/cto</button>");
    });
    $('#click_pending').on('ifUnchecked', function(){
        $(".button").html("");
    });
</script>