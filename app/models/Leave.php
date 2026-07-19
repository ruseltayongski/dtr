<?php

use Illuminate\Database\Eloquent\Model;

class Leave extends Eloquent
{
    protected $table = 'leave';
    protected $primaryKey = 'id';

    public function appliedDates(){
        return $this->hasMany(LeaveAppliedDates::class, 'leave_id', 'id');
    }

    public function extension(){
        return $this->hasMany(ExtendedLeave::class, 'route_no', 'route_no');
    }

    public function sl_remarks(){
        return $this->hasMany(SLRemarks::class, 'leave_id', 'id');
    }

    public function type(){
        return $this->belongsTo(LeaveTypes::class, 'leave_type', 'code');
    }
}
