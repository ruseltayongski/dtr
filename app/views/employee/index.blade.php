@extends('layouts.app')

@section('content')
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
                                                    <td class="col-sm-3"><strong>User ID </strong></td>
                                                    <td class="col-sm-1">: </td>
                                                    <td class="col-sm-9">
                                                        <input type="text" readonly class="col-md-2 form-control" id="inputEmail3" name="userid" value="{{ Auth::user()->userid }}" required>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="col-sm-3"><strong>Dates</strong></td>
                                                    <td class="col-sm-1"> :</td>
                                                    <td class="col-sm-9">
                                                        <div class="input-group">
                                                            <div class="input-group-addon">
                                                                <i class="fa fa-calendar"></i>
                                                            </div>
                                                            <input type="text" class="form-control" id="inclusive3" name="filter_range" placeholder="Input date range here..." required>
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
                                        New features: Just click here <i class="ace-icon fa fa-hand-o-right"></i> <a href="{{ asset('logs/timelog') }}" target="_blank"><strong class="text-blue">Manage DTR</strong></a>
                                    </div>
                                    <!--
                                    <div class="alert alert-success text-green">
                                        If you encountered an error, please send us feedback and suggestion. Just comment below <i class="ace-icon fa fa-hand-o-down"></i>
                                    </div>
                                    -->
                                </div>

                                <!-- Chat box -->
                                <!--
                                <div class="box-body chat" id="chat-box">
                                    <div class="comment_append">
                                        @if(count($comments) > 0)
                                            @foreach($comments as $com)
                                            <div class="item">
                                                <img src="{{ str_replace('dtr','pis',asset('')).'public/upload_picture/picture/'.$com->picture }}" alt="user image" class="online">
                                                <p class="message">
                                                    <span href="#" class="name text-blue" style="display: inline;">
                                                        <small class="text-muted pull-right"><i class="fa fa-clock-o"></i> 2:15</small>
                                                        {{ Auth::user()->lname.', '.Auth::user()->fname }}
                                                    </span>
                                                    {{ $com->description }}<br>
                                                    <a data-toggle="collapse" class="text-blue" href="#collapse{{ $com->id }}" aria-expanded="false" aria-controls="collapseExample" style="font-size: 8pt"> Reply</a>
                                                </p>
                                                <div class="reply_append{{ $com->id }}">
                                                    @foreach(Reply::where('comment_id','=',$com->id)->get() as $rep)
                                                        <?php $replyUser = User::where('userid','=',$rep->userid)->first(); ?>
                                                        <div class="item" style="margin-left:5%;">
                                                            <img src="{{ str_replace('dtr','pis',asset('')).'public/upload_picture/picture/'.InformationPersonal::where('userid','=',$rep->userid)->first()->picture }}" alt="user image" class="offline">
                                                            <p class="message">
                                                            <span href="#" class="name text-blue">
                                                                <small class="text-muted pull-right"><i class="fa fa-clock-o"></i> 2:15</small>
                                                                {{ $replyUser->lname.', '.$replyUser->fname }}
                                                            </span>
                                                                {{ $rep->description }}
                                                            </p>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <div class="collapse" id="collapse{{ $com->id }}">
                                                    <div class="box-footer" style="margin-left:5%;">
                                                        <form action="#" method="post" id="{{ 'submit_reply'.$com->id }}" class="{{ $com->id }} form_reply" autocomplete="off">
                                                            <img class="img-responsive img-circle img-sm" src="{{ str_replace('dtr','pis',asset('')).'public/upload_picture/picture/'.InformationPersonal::where('userid','=',Auth::user()->userid)->first()->picture }}" alt="Alt Text">
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

                                    <div class="box-footer">
                                        <form action="#" method="post" class="submit_comment" autocomplete="off">
                                            <img class="img-responsive img-circle img-sm" src="{{ str_replace('dtr','pis',asset('')).'public/upload_picture/picture/'.InformationPersonal::where('userid','=',Auth::user()->userid)->first()->picture }}" alt="Alt Text">
                                            <div class="img-push">
                                                <input type="text" class="form-control input-sm" id="text_comment" placeholder="Press enter to post comment">
                                            </div>
                                        </form>
                                    </div>
                                    -->
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
            var url = "<?php echo asset('faq/comment_append'); ?>";
            var json = {
                "userid" : "<?php echo Auth::user()->userid; ?>",
                "post_id" : 1,
                "description" : $("#text_comment").val(),
                "status" : 1,
                "count" : count
            };
            $.post(url,json,function(result){
                $("#text_comment").val('');
                $("#text_comment").focus();
                $(".comment_append").append(result);
                $("#"+count).hide().fadeIn();
                count++;
            });
            e.preventDefault();
        });

        var replyCount = parseInt("<?php echo count($replies); ?>")+1;
        $(".form_reply").each(function(e){
            $("#"+this.id).submit(function(form){
                var inputElement = $("#"+this.id).find('input');
                var ID = this.id;
                var url = "<?php echo asset('faq/reply_append'); ?>";
                var json = {
                    "userid" : "<?php echo Auth::user()->userid; ?>",
                    "post_id" : 1,
                    "comment_id" : count,
                    "description" : inputElement.val(),
                    "status" : 1,
                    "count" : replyCount
                };
                console.log(json);
                $.post(url,json,function(result){
                    inputElement.val('');
                    $(".reply_append"+ID.split('submit_reply')[1]).append(result);
                    $("#reply"+replyCount).hide().fadeIn();
                    replyCount++;
                    form.preventDefault();
                });

            });
        });

    </script>
@endsection