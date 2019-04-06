<?php

namespace App;

use App\Interfaces\ArduinoConnectableInterface;
use Illuminate\Database\Eloquent\Model;

class Curtain extends Model implements ArduinoConnectableInterface
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
        return $this->hasMany('App\Schedule');
    }

    public function owner()
    {
        return $this->belongsTo('App\User', 'owner_id', 'id');
    }

    public function leds()
    {
        return $this->hasOne('App\Leds');
    }

    public function dht()
    {
        return $this->hasMany('App\DHT');
    }

    public function get_selected_schedule()
    {
        return $this->hasOne('App\Schedule', 'select_schedule_id', 'id');
    }

    public function getArduinoIP(): string
    {
        $address = $this->micro_controller_id;

        return !$address ? '' : $address;
    }
}
