<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DHT extends Model
{
    protected $table = 'dht_values';
    protected $guarded = ['curtain_id'];

    public function curtain()
    {
        return $this->belongsTo(Curtain::class);
    }
}
