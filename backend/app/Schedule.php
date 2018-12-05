<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = [
        'title',
        'image'
    ];

    /*protected $hidden = [
        'curtain_id',
        'created_at',
        'updated_at'
    ];*/

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'curtain_id',
        'created_at',
        'updated_at'
    ];
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
