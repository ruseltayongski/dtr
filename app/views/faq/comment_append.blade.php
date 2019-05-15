<div class="item" id="{{ $count }}">
    <img src="{{ str_replace('dtr','pis',asset('')).'public/upload_picture/picture/'.InformationPersonal::where('userid','=',Auth::user()->userid)->first()->picture }}" alt="user image" class="online">
    <p class="message">
        <span href="#" class="name text-blue" style="display: inline;">
            <small class="text-muted pull-right"><i class="fa fa-clock-o"></i> 2:15</small>
            {{ Auth::user()->lname.', '.Auth::user()->fname }}
        </span>{{ $description }} <br>
        <a data-toggle="collapse" class="text-blue" href="#collapse{{ $count }}" aria-expanded="false" aria-controls="collapseExample" style="font-size: 8pt"> Reply</a>
    </p>
    <div class="collapse" id="collapse{{ $count }}">
        <div class="box-footer" style="margin-left:5%;">
            <form action="#" method="post" class="submit_reply{{ $count }}" autocomplete="off">
                <img class="img-responsive img-circle img-sm" src="{{ str_replace('dtr','pis',asset('')).'public/upload_picture/picture/'.InformationPersonal::where('userid','=',Auth::user()->userid)->first()->picture }}" alt="Alt Text">
                <!-- .img-push is used to add margin to elements next to floating images -->
                <div class="img-push">
                    <input type="text" class="form-control input-sm" id="text_reply{{ $count }}" placeholder="Press enter to reply">
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    /*var replyCount = "<?php echo $count ?>";
    $(".submit_reply"+replyCount).submit(function(e){
        var ID = this.id;
        var url = "<?php echo asset('faq/reply_append'); ?>";
        var json = {
            "userid" : "<?php echo Auth::user()->userid; ?>",
            "post_id" : 1,
            "comment_id" : "<?php echo $count ?>",
            "description" : $("#text_reply"+replyCount).val(),
            "status" : 1,
            "count" : replyCount
        };
        $.post(url,json,function(result){
            $("#text_reply"+replyCount).val('');
            $(".reply_append"+ID.split('submit_reply')[1]).append(result);
            $("#reply"+replyCount).hide().fadeIn();
            replyCount++;
            e.preventDefault();
        });
    });*/
</script>