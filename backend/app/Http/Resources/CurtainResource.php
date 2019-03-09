<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CurtainResource extends JsonResource
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
            'title' => $this->title,
            'micro_controller_id' => $this->micro_controller_id,
            'is_close' => $this->is_close,
            'is_activated' => $this->is_activated,
            'mode' => $this->mode,
            'select_schedule_id' => $this->select_schedule_id,
        ];
    }
}
