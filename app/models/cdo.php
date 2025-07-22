<?php

/**
 * Created by PhpStorm.
 * User: lourence
 * Date: 5/25/2017
 * Time: 9:02 AM
 */
class cdo extends Eloquent
{
    use SoftDeletingTrait; 
    
    protected $table = 'cdo';
    protected $primaryKey = 'id';
    protected $dates = ['deleted_at'];

    public function appliedDates(){
        return $this->hasMany(CdoAppliedDate::class, 'cdo_id');
    }

    public function name(){
        return $this->belongsTo(InformationPersonal::class, 'prepared_name', 'userid');
    }
}