<div class="item" id="reply{{ $count }}" style="margin-left:8%;margin-top: 1%">
    <?php $replyUser = InformationPersonal::where('userid','=',Auth::user()->userid)->first(); ?>
    <img src="{{ isset($replyUser->picture) ? 'https://pis.cvchd7.com/pis/public/upload_picture/picture/'.InformationPersonal::where('userid','=',$replyUser->userid)->first()->picture : 'https://pis.cvchd7.com/pis/public/upload_picture/picture/uknown.png' }}" alt="user image" class="offline">

    <p class="message">
            <span href="#" class="name text-blue">
                <!-- <small class="text-muted pull-right"><i class="fa fa-clock-o"></i> 2:15</small> -->
                {{ strtoupper($replyUser->lname.', '.$replyUser->fname) }}
            </span>
        {{ $description }}
    </p>
</div>