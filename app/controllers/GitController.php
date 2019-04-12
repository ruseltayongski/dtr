<?php

class GitController extends BaseController{
    public function git_pull(){
        return exec("git pull origin master");
    }
}