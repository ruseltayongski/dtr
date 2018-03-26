<span id="cdo_updatev1" data-link="{{ asset('cdo_updatev1') }}"></span>
@if(isset($paginate_pending) and count($paginate_pending) >0)
    <div class="table-responsive" style="margin-top: -20px;">
        <label style="padding-bottom: 10px;">Check to select all to approve </label>
        <input type="checkbox" id="click_approve">
        <label class="button" style="font-weight: normal !important;"></label>
        <table class="table table-list table-hover table-striped">
            <thead>
            <tr>
                <th></th>
                <th class="text-center">Route #</th>
                <th class="text-center">Reason</th>
                @if(\Illuminate\Support\Facades\Auth::user()->usertype)
                    <th class="text-center">Prepared Name</th>
                @else
                    <th class="text-center">Document Type</th>
                @endif
                <th class="text-center">Beginning Balance</th>
                <th class="text-center" width="17%">Option</th>
            </tr>
            </thead>
            <tbody style="font-size: 10pt;">
            @foreach($paginate_pending as $row)
                <tr>
                    <td><a href="#track" data-link="{{ asset('form/track/'.$row->route_no) }}" data-route="{{ $row->route_no }}" data-toggle="modal" class="btn btn-sm btn-success col-sm-12" style="background-color:darkmagenta;color:white;"><i class="fa fa-line-chart"></i> Track</a></td>
                    <td><a class="title-info" data-backdrop="static" data-route="{{ $row->route_no }}" style="color: #f0ad4e;" data-link="{{ asset('/form/info/'.$row->route_no.'/cdo') }}" href="#document_info" data-toggle="modal">{{ $row->route_no }}</a></td>
                    <td>{{ $row->subject }}</td>
                    @if(\Illuminate\Support\Facades\Auth::user()->usertype)
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
                        <td><button type="submit" class="btn-xs btn-info" value="{{ $row->id }}" onclick="pending_status($(this))" style="color:white;"><i class="fa fa-smile-o"></i> Approve</button></td>
                    @endif
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    {{ $paginate_pending->links() }}
@else
    <div class="alert alert-danger" role="alert"><span style="color:red;">Documents records are empty.</span></div>
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
        },1000);
    });

    function pending_status(data){
        var page = "<?php echo Session::get('page_pending') ?>";
        var url = $("#cdo_updatev1").data('link')+'/'+data.val()+'/pending?page='+page;
        $.post(url,function(result){
            console.log(url);
            //$('.ajax_pending').html(loadingState);
            setTimeout(function(){
                if(result['count_pending'] && !result['paginate_pending']){
                    console.log("asin1");
                    getPosts(page-1,'');
                } else {
                    console.log("asin2");
                    $('.ajax_pending').html(result);
                }
                Lobibox.notify('info',{
                    msg:'Approve!'
                });

                var pendingCount = parseInt($(".pending").text()) - 1;
                var approveCount = parseInt($(".approve").text()) + 1;

                $(".pending").html(pendingCount);
                $(".approve").html(approveCount);

            },700);
        });
    }

    function click_all(type){
        var url = "<?php echo asset('click_all');?>"+"/"+type.val();
        $.get(url,function(result){
            if(type.val() == 'pending'){
                $('.ajax_approve').html(loadingState);
                setTimeout(function(){
                    Lobibox.notify('error',{
                        msg:'pending!'
                    });
                    $('.ajax_approve').html(result['view']);
                    $(".pending").html(result['pending']);
                    $(".approve").html(result['approve']);
                },700);
            }
            else if(type.val() == 'approve'){
                $('.ajax_pending').html(loadingState);
                setTimeout(function(){
                    Lobibox.notify('info',{
                        msg:'Approve!'
                    });
                    $('.ajax_pending').html(result['view']);
                    $(".pending").html(result['pending']);
                    $(".approve").html(result['approve']);
                },700);
            }
        });
    }

    $(function () {
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' // optional
        });
    });

    $('#click_approve').on('ifChecked', function(event){
        $(".button").html("<button type='button' value='approve' onclick='click_all($(this))' class='btn-group-sm btn-info'><i class='fa fa-smile-o'></i> Approve all cdo/cto</button>");
    });
    $('#click_approve').on('ifUnchecked', function(event){
        $(".button").html("");
    });
</script>