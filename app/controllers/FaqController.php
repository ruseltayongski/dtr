<?php

class FaqController extends Controller
{
    public function comment_append(){
        $comment = new Comments();
        $comment->userid = Input::get('userid');
        $comment->post_id = 1;
        $comment->description = Input::get('description');
        $comment->datein = date('Y-m-d');
        $comment->status = 1;
        $comment->save();
        return View::make('faq.comment_append',Input::get());
    }

    public function reply_append(){
        return Input::get();
        $reply = new Reply();
        $reply->userid = Input::get('userid');
        $reply->post_id = 1;
        $reply->comment_id = Input::get('comment_id');
        $reply->description = Input::get('description');
        $reply->datein = date('Y-m-d');
        $reply->status = 1;
        $reply->save();
        return View::make('faq.reply_append',Input::get());
    }
}