<?php

class WellnessLogs extends Eloquent {

    protected $table = 'wellness_logs';
    protected $primaryKey = 'id';

    public function wellness()
    {
        return $this->belongsTo('Wellness');
    }
}