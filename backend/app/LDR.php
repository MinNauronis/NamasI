<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LDR extends Model
{
    protected $table = 'ldr_values';
    protected $guarded = ['curtain_id'];

    public function curtain()
    {
        return $this->belongsTo(Curtain::class);
    }
}
