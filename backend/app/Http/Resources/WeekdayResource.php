<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class WeekdayResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'weekday' => $this->weekday,
            'mode' => $this->mode,
            'close_time' => $this->close_time,
            'open_time' => $this->open_time,
        ];
    }
}
