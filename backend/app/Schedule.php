<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    /**
     * Schedule's curtain
     */
    public function getCurtain()
    {
        return $this->belongsTo('App\Curtain');
    }

    /**
     * Schedule's weekdays
     */
    public function getWeekdays()
    {
        return $this->hasMany('App\Weekday');
    }
}
