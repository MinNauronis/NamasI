<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LedsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'brightness' => $this->brightness,
            'mode' => $this->mode,
            'color' => $this->color,
            'change_rate' => $this->change_rate,
        ];
    }
}
