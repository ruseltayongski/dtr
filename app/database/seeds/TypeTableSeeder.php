<?php

/**
 * Created by PhpStorm.
 * User: hahahehe
 * Date: 8/3/2017
 * Time: 4:31 PM
 */
class TypeTableSeeder extends Seeder
{
    public function run()
    {
        $a = new AbsentTypes();
        $a->code = "SO";
        $a->desc = "OFFICE ORDER";
        $a->save();

        $a = new AbsentTypes();
        $a->code = "LEAVE";
        $a->desc = "LEAVE";
        $a->save();

        $a = new AbsentTypes();
        $a->code = "CTO";
        $a->desc = "CTO";
        $a->save();
    }
}