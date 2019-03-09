<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Curtain extends Model
{
    const MODE_AUTO = 'auto';
    const MODE_MANUAL = 'manual';

    const MODES = [
        self::MODE_AUTO,
        self::MODE_MANUAL
    ];

    protected $guarded = ['owner_id'];

    public function schedules()
    {
        return $this->hasMany('App\Schedule', );
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function get_selected_schedule()
    {
        return $this->hasOne('App\Schedule', 'select_schedule_id', 'id');
    }


}
