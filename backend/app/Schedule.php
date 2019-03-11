<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $guarded = ['owner_id'];

    public function curtain()
    {
        return $this->belongsTo('App\Curtain');
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id', 'id');
    }

    public function weekdays()
    {
        return $this->hasMany('App\Weekday');
    }
}
