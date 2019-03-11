<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Weekday extends Model
{
    const MODE_SUN = 'sun';
    const MODE_TIME = 'time';
    const MODE_AUTO = 'auto';

    const MODES = [
        self::MODE_SUN,
        self::MODE_TIME,
        self::MODE_AUTO,
    ];

    protected $guarded = ['owner_id', 'schedule_id'];

    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id', 'id');
    }
}
