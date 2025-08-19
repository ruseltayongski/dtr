<?php

class WellnessLogs extends Eloquent {

    protected $table = 'wellness_logs';
    protected $primaryKey = 'id';

    // protected $fillable = [
    //     'remarks'
    // ];
    protected $fillable = ['wellness_id', 'time_start', 'time_end', 'time_consumed', 'remarks'];

    public function wellness()
    {
        return $this->belongsTo('Wellness');
    }
}