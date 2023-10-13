<?php
/**
 * Created by PhpStorm.
 * User: doh7_it
 * Date: 10/4/2023
 * Time: 1:20 PM
 */

class Designation extends Eloquent
{
    protected $connection = 'dts';
    protected $table = 'designation';
    protected $primaryKey = 'id';
}