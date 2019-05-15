<div class="item" id="reply{{ $count }}" style="margin-left:5%;">
    <?php $replyUser = User::where('userid','=',Auth::user()->userid)->first(); ?>
    <img src="{{ str_replace('dtr','pis',asset('')).'public/upload_picture/picture/'.InformationPersonal::where('userid','=',$replyUser->userid)->first()->picture }}" alt="user image" class="offline">
    <p class="message">
            <span href="#" class="name text-blue">
                <small class="text-muted pull-right"><i class="fa fa-clock-o"></i> 2:15</small>
                {{ $replyUser->lname.', '.$replyUser->fname }}
            </span>
        {{ $description }}
    </p>
</div>