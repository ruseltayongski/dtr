<?php

/**
 * Created by PhpStorm.
 * User: Lourence
 * Date: 4/5/2017
 * Time: 3:03 PM
 */
class TestController extends Controller
{
    public function __construct()
    {

    }

    public function index()
    {
        return $_SERVER['REQUEST_METHOD'];
    }
}