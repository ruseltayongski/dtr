<?php
/**
 * Created by PhpStorm.
 * User: doh7_it
 * Date: 6/29/2023
 * Time: 1:04 PM
 */

class CdoAppliedDate extends Eloquent
{
    protected $table = 'cdo_applied_dates';
    protected $primaryKey = 'id';
    protected $fillable = [
        'cdo_id',
        'start_date',
        'end_date',
    ];
    //public $timestamps = false;


    public function cdo()
    {
        return $this->belongsTo(cdo::class, 'cdo_id');
    }
}