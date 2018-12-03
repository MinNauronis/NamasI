<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Curtain extends Model
{
    /**
     * Curtain's schedules
     */
    public function getSchedules()
    {
        return $this->hasMany('App\Schedule');
    }

    /**
     * Curtain's user
     */
    public function getUser()
    {
        return $this->belongsTo('App\User');
    }
}
