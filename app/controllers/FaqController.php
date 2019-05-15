<?php

class FaqController extends Controller
{
    public function comment_append(){
        $datein = date('Y-m-d H:i:s');
        $comment = new Comments();
        $comment->userid = Input::get('userid');
        $comment->post_id = 1;
        $comment->description = Input::get('description');
        $comment->datein = $datein;
        $comment->status = 1;
        $comment->save();

        $comment_id = Comments::OrderBy("id","desc")->first()->id;
        return View::make('faq.comment_append',[
            "userid" => Input::get("userid"),
            "description" => Input::get("description"),
            "datein" => Input::get("datein"),
            "comment_id" => $comment_id
        ]);
    }

    public function reply_append(){
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