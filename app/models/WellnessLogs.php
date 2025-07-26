<?php

class WellnessLogs extends Eloquent {

    protected $table = 'wellness_logs';
    protected $primaryKey = 'id';

    protected $fillable = [
        'remarks'
    ];

    public function wellness()
    {
        return $this->belongsTo('Wellness');
    }
}