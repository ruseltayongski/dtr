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
                @if(Auth::user()->usertype)
                    <th class="text-center">Prepared Name</th>
                @else
                    <th class="text-center">Document Type</th>
                @endif
                <th class="text-center">Beginning Balance</th>
                @if(Auth::user()->usertype)
                <th class="text-center" width="17%">Option</th>
                @endif
            </tr>
            </thead>
            <tbody style="font-size: 10pt;">
            @foreach($paginate_approve as $row)
                <tr>
                    <td><a href="#track" data-link="{{ asset('form/track/'.$row->route_no) }}" data-route="{{ $row->route_no }}" data-toggle="modal" class="btn btn-sm btn-success col-sm-12" style="background-color:#9C8AA5;color:white;"><i class="fa fa-line-chart"></i> Track</a></td>
                    <td><a class="title-info" data-backdrop="static" data-route="{{ $row->route_no }}" style="color: #f0ad4e;" data-link="{{ asset('/form/info/'.$row->route_no.'/cdo') }}" href="#document_info" data-toggle="modal">{{ $row->route_no }}</a></td>
                    <td>{{ $row->subject }}</td>
                    <td><?php if(isset($row->start)) echo date('m/d/Y',strtotime($row->start)).' - '.date('m/d/Y',strtotime('-1 day',strtotime($row->end))); ?></td>
                    @if(Auth::user()->usertype)
                        <td>
                            <?php
                                $personal_information = InformationPersonal::where('userid','=',$row['prepared_name'])->first();
                                echo $personal_information->fname.' '.$personal_information->mname.' '.$personal_information->lname;
                            ?>
                        </td>
                    @else
                        <td>CTO</td>
                    @endif
                    <td class="text-center">
                        <b style="color:green;">
                            {{ $personal_information->bbalance_cto }}
                        </b>
                    </td>
                    @if(Auth::user()->usertype)
                        <td><button type="submit" class="btn-xs btn-danger" value="{{ $row->id }}" onclick="approved_status($(this))" style="color:white;"><i class="fa fa-ban"></i> Cancel</button></td>
                    @endif
                </tr>
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
    });

    $('#click_pending').on('ifChecked', function(){
        $(".button").html("<button type='button' value='pending' onclick='click_all($(this))' class='btn-group-sm btn-danger'><i class='fa fa-frown-o'></i> pending all cdo/cto</button>");
    });
    $('#click_pending').on('ifUnchecked', function(){
        $(".button").html("");
    });
</script>