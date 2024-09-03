<div class="reply_append{{ $comment_id }}">
    <div class="item" id="{{ $comment_id }}">
        <?php $commentUser = InformationPersonal::where('userid',Auth::user()->userid)->first() ?>
        <div class="row">
            <div class="col-md-1">
                <div class="item">
                    <img src="{{ isset($commentUser->picture) ? 'https://pis.cvchd7.com/pis/public/upload_picture/picture/'.$commentUser->picture : 'https://pis.cvchd7.com/pis/public/upload_picture/picture/uknown.png' }}" alt="user image" class="online">
                </div>
            </div>
            <div class="col-md-9">
                <div class="message">
                    <span href="#" class="name text-blue" style="display: inline;">
                        {{ strtoupper(Auth::user()->lname.', '.Auth::user()->fname) }}
                    </span>
                    <small class="text-success"><br>
                        <p>{{ trim(strip_tags(nl2br($description))) }}</p>
                    </small>
                    <a data-toggle="collapse" class="text-blue" href="#collapse{{ $comment_id }}" aria-expanded="false" aria-controls="collapseExample" style="font-size: 8pt"> Reply</a>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="collapse" id="collapse{{ $comment_id }}">
    <div class="box-footer" style="margin-left:5%;">
        <form action="#" method="post" class="submit_reply_append{{ $comment_id }}" autocomplete="off">
            <img class="img-responsive img-circle img-sm" src="{{ isset($commentUser->picture) ? 'https://pis.cvchd7.com/pis/public/upload_picture/picture/'.$commentUser->picture :'https://pis.cvchd7.com/pis/public/upload_picture/picture/uknown.png' }}" alt="Alt Text">
            <!-- .img-push is used to add margin to elements next to floating images -->
            <div class="img-push">
                <input type="text" class="form-control input-sm" id="text_reply{{ $comment_id }}" placeholder="Press enter to reply">
            </div>
        </form>
    </div>
</div>

<script>
    var comment_id = "<?php echo $comment_id; ?>";
    var replyCount = 0;
    $(".submit_reply_append"+comment_id).submit(function(form){
        var inputElement = $("#text_reply"+comment_id);
        var url = "<?php echo asset('faq/reply_append'); ?>";
        var json = {
            "userid" : "<?php echo Auth::user()->userid; ?>",
            "post_id" : 1,
            "comment_id" : comment_id,
            "description" : inputElement.val(),
            "status" : 1,
            "count" : "append"+replyCount
        };
        console.log(json);
        if(inputElement.val() != ''){
            $.post(url,json,function(result){
                console.log(result);
                inputElement.val('');
                $(".reply_append"+comment_id).append(result);
                $("#replyappend"+replyCount).hide().fadeIn();
                replyCount++;
            });
        }
        form.preventDefault();
    });
</script>

