<?php

/**
 * Created by PhpStorm.
 * User: lourence
 * Date: 5/25/2017
 * Time: 9:02 AM
 */
class cdo extends Eloquent
{
    protected $table = 'cdo';
    protected $primaryKey = 'id';

    public function appliedDates(){
        return $this->hasMany(CdoAppliedDate::class, 'cdo_id');
    }
}