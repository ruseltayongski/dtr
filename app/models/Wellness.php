<?php

class Wellness extends Eloquent {

    protected $table = 'wellness';
    protected $primaryKey = 'id';

protected $fillable = [
    'userid',
    'unique_code',
    'scheduled_date',
    'type_of_request',
    'status',
    'approved_by'
];

    public function wellness_logs()
    {
        return $this->hasMany('WellnessLogs');
    }

    public function user()
    {
        return $this->belongsTo('Users', 'userid'); // assuming 'userid' is the foreign key
    }
}