<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Leds extends Model
{
    const MODES = ['static', 'random', 'cloudy', 'rainbow', 'rainbow_1', 'rainbow_2', 'lava', 'party_colors'];

    protected $guarded = ['owner_id', 'curtain_id'];

    public function curtain()
    {
        return $this->belongsTo(Curtain::class, 'curtain_id', 'id');
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id', 'id');
    }

}
