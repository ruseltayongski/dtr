<?php

class ExtendedLeave extends Eloquent
{
    protected $table = 'leave_extension';
    protected $primaryKey = 'id';

    public function type_leave(){
        return $this->belongsTo(LeaveTypes::class, 'leave_type', 'code');
    }

    public function modified(){
        return $this->belongsTo(ModifiedLeave::class, 'id', 'extended_id');
    }
}
