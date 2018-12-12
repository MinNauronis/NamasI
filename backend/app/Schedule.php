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
    private $image;
    private $title;
    private $id;
    private $image;
    private $title;
    private $curtain_id;
    private $getWeekdays;
    private $curtain_id;

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
