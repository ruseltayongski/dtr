<?php

use Illuminate\Database\Eloquent\Model;

class Leave extends Eloquent
{
    protected $table = 'leave';
    protected $primaryKey = 'id';

    public function appliedDates(){
        return $this->hasMany(LeaveAppliedDates::class, 'leave_id', 'id');
    }
}
