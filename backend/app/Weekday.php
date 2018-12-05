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
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    /**
     * Weekday's schedule
     */
    public function getSchedule()
    {
        return $this->belongsTo('App\Schedule');
    }
}
