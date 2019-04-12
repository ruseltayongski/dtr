<?php

class GitController extends BaseController{
    public function git_pull(){
        return json_encode(exec("git pull origin master"));
    }
    public function git_add(){
        return json_encode(exec("git add ."));
    }
    public function git_commit(){
        return json_encode(exec("git commit -m 'PullUpdates'"));
    }
}