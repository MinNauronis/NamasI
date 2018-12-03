<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Weekday extends Model
{
    protected $fillable = [
      'weekday',
      'mode',
      'openTime',
      'closeTime'
    ];

    /**
     * Weekday's schedule
     */
    public function getSchedule()
    {
        return $this->belongsTo('App\Schedule');
    }
}
