<?php session_start(); ?>
@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12 wrapper">
            <div class="alert alert-jim">
                <div class="row">
                    <div class="col-md-4">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading"><strong style="color: #f0ad4e;font-size:medium;">Print individual DTR</strong></div>
                                    <div class="panel-body">
                                        <form action="{{ asset('FPDF/timelog/print_individual1.php') }}" target="_blank" autocomplete="off" method="POST" id="print_pdf">
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <tr>
                                                        <td class="col-sm-3"><small>User ID </small></td>
                                                        <td class="col-sm-1">: </td>
                                                        <td class="col-sm-9">
                                                            <input type="text" readonly class="col-md-2 form-control" id="inputEmail3" name="userid" value="{{ Auth::user()->userid }}" required>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="col-sm-3"><small>Job Status </small></td>
                                                        <td class="col-sm-1">: </td>
                                                        <td class="col-sm-9">
                                                            <input type="text" readonly class="col-md-2 form-control" name="job_status" value="{{ Session::get("job_status") }}" required>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="col-sm-3"><small>Dates</small></td>
                                                        <td class="col-sm-1"> :</td>
                                                        <td class="col-sm-9">
                                                            <div class="input-group">
                                                                <div class="input-group-addon">
                                                                    <i class="fa fa-calendar"></i>
                                                                </div>
                                                                <input type="text" class="form-control" id="inclusive3" value="{{ isset($_SESSION['date_range']) ? $_SESSION['date_range'] : '' }}" name="filter_range" placeholder="Input date range here..." required>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                            <button type="submit"  class="btn-lg btn-success center-block col-sm-12" id="upload" data-loading-text="<i class='fa fa-refresh fa-spin'></i> Printing DTR">
                                                <span class="glyphicon glyphicon-print" aria-hidden="true"></span> Generate PDF
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-12">
                                <!-- Box Comment -->
                                <div class="box box-widget">
                                    <div class="box-header with-border">
                                        <div class="user-block">
                                            <img class="img-circle" src="{{ asset('public/img/doh.png') }}" alt="User Image">
                                            <span class="username"><strong class="text-blue">IT</strong></span>
                                            <span class="description">FAQs - 08:00 AM 05/16/2019</span>
                                        </div>
                                        <!-- /.user-block -->
                                    </div>
                                    <!-- /.box-header -->
                                    <div class="box-body">
                                        <div class="alert alert-info text-blue">
                                            New features of DTR VERSION 4.3<br> Just click here <i class="ace-icon fa fa-hand-o-right"></i> <a href="{{ asset('logs/timelog') }}"><strong class="text-blue">Manage Timelog</strong></a>
                                        </div>
                                        <div class="alert alert-success text-green">
                                            If you encountered an error, please send us feedback and suggestion. Just comment below <i class="ace-icon fa fa-hand-o-down"></i>
                                        </div>
                                    </div>

                                    <?php $defaultPicture = InformationPersonal::where("userid","=",Auth::user()->userid)->first() ?>
                                    <!-- Chat box -->
                                    <div class="box-body chat" id="chat-box">
                                        <form action="#" method="post" class="submit_comment" autocomplete="off">
                                            <div class="row">
                                                <div class="col-md-1">
                                                    <div class="item">
                                                        <img src="{{ isset($defaultPicture->picture) ? str_replace('dtr','pis',asset('')).'public/upload_picture/picture/'.InformationPersonal::where('userid','=',Auth::user()->userid)->first()->picture : str_replace('dtr','pis',asset('')).'public/upload_picture/picture/uknown.png' }}"  alt="user image" class="online">
                                                    </div>
                                                </div>
                                                <div class="col-md-11 form-group">
                                                    <div class="img-push">
                                                        <input type="text" class="form-control input-sm" id="text_comment" placeholder="Press enter to post comment">
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                        <div class="comment_append">
                                            @if(count($comments) > 0)
                                                @foreach($comments as $com)
                                                    <div class="item">
                                                        <div class="row">
                                                            <div class="col-md-1">
                                                                <div class="item">
                                                                    <img src="{{ isset($com->picture) ? str_replace('dtr','pis',asset('')).'public/upload_picture/picture/'.$com->picture : str_replace('dtr','pis',asset('')).'public/upload_picture/picture/uknown.png' }}" alt="user image" class="online">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-9">
                                                                <div class="message">
                                                                    <span href="#" class="name text-blue" style="display: inline;">
                                                                        {{ strtoupper($com->fname." ".$com->lname) }}
                                                                    </span>
                                                                    <small class="text-success">
                                                                        {{ $com->description }}<br>
                                                                    </small>

                                                                    <a data-toggle="collapse" class="text-blue" href="#collapse{{ $com->id }}" aria-expanded="false" aria-controls="collapseExample" style="font-size: 8pt"> Reply</a>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <small class="text-muted pull-top" style="margin-left: 10%"><i class="fa fa-clock-o"></i> {{ date("M d,Y",strtotime($com->created_at)) }}</small><br>
                                                                <small class="text-muted pull-top" style="margin-left: 10%">({{ date("h:i:s a",strtotime($com->created_at)) }})</small>
                                                            </div>
                                                        </div>

                                                        <div class="reply_append{{ $com->id }}">
                                                            <?php
                                                                $replies = Reply::select('reply.*','personal_information.picture','personal_information.lname','personal_information.fname')
                                                                                ->leftJoin('pis.personal_information','personal_information.userid','=','reply.userid')
                                                                                ->where('post_id',1)
                                                                                ->where('comment_id',$com->id)
                                                                                ->get()
                                                            ?>
                                                            @foreach($replies as $rep)
                                                                <div class="item" style="margin-left:8%;margin-top: 1%">
                                                                    <div class="row">
                                                                        <div class="col-md-1">
                                                                            <div class="item">
                                                                                <img src="{{ isset($rep->picture) ? str_replace('dtr','pis',asset('')).'public/upload_picture/picture/'.$rep->picture : str_replace('dtr','pis',asset('')).'public/upload_picture/picture/uknown.png' }}" alt="user image" class="offline">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-9">
                                                                            <span href="#" class="name text-blue" style="display: inline">
                                                                                {{ $rep->fname.' '.$rep->lname }}
                                                                            </span>
                                                                            <small class="text-danger">
                                                                                {{ $rep->description }}<br>
                                                                            </small>
                                                                        </div>
                                                                        <div class="col-md-2">
                                                                            <small class="text-muted pull-top"><i class="fa fa-clock-o"></i> {{ date("M d,Y",strtotime($rep->created_at)) }}<br>({{ date("h:i:s a",strtotime($rep->created_at)) }})</small>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                        <div class="collapse" id="collapse{{ $com->id }}">
                                                            <div class="box-footer" style="margin-left:8%;">
                                                                <form action="#" method="post" id="{{ 'submit_reply'.$com->id }}" class="{{ $com->id }} form_reply" autocomplete="off">
                                                                    <img class="img-responsive img-circle img-sm" src="{{ isset($defaultPicture->picture) ? str_replace('dtr','pis',asset('')).'public/upload_picture/picture/'.$defaultPicture->picture : str_replace('dtr','pis',asset('')).'public/upload_picture/picture/uknown.png' }}" alt="Alt Text">
                                                                    <div class="img-push">
                                                                        <input type="text" class="form-control input-sm" value="" id="text_reply{{ $com->id }}" placeholder="Press enter to reply">
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>

                                    </div>


                                </div>

                                <!-- /.box -->
                            </div>
                            <!-- /.col -->
                        </div> <!-- END ROW -->
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')
    @parent

    <script>
        $('.input-daterange input').each(function() {
            $(this).datepicker("clearDates");
        });
        $('#inclusive3').daterangepicker();
        $('#filter_dates').daterangepicker();

        var count = parseInt("<?php echo count($comments) ?>")+1;
        console.log(count);
        $(".submit_comment").submit(function(e){
            if($("#text_comment").val() != ''){
                var url = "<?php echo asset('faq/comment_append'); ?>";
                var json = {
                    "userid" : "<?php echo Auth::user()->userid; ?>",
                    "post_id" : 1,
                    "description" : $("#text_comment").val(),
                    "status" : 1,
                    "count" : count
                };
                $.post(url,json,function(result){
                    var view = result[0];
                    var comment_id = result[1];
                    $("#text_comment").val('');
                    $("#text_comment").focus();
                    $(".comment_append").prepend(view);
                    $("#"+comment_id).hide().fadeIn();
                    count++;
                });
            }
            e.preventDefault();
        });

       var replyCount = parseInt("<?php if(isset($replies)){echo count($replies);}else{echo '0';} ?>")+1;
        $(".form_reply").each(function(e){
            $("#"+this.id).submit(function(form){
                var inputElement = $("#"+this.id).find('input');
                var ID = this.id;
                var url = "<?php echo asset('faq/reply_append'); ?>";
                var json = {
                    "userid" : "<?php echo Auth::user()->userid; ?>",
                    "post_id" : 1,
                    "comment_id" : this.id.split('submit_reply')[1],
                    "description" : inputElement.val(),
                    "status" : 1,
                    "count" : replyCount
                };
                if(inputElement.val() != ''){
                    $.post(url,json,function(result){
                        inputElement.val('');
                        $(".reply_append"+ID.split('submit_reply')[1]).append(result);
                        $("#reply"+replyCount).hide().fadeIn();
                        replyCount++;
                    });
                }
                form.preventDefault();
            });
        });

    </script>
@endsection