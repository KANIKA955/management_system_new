<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BreakResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'duration' => $this->formatted_duration,
            'time_left' => $this->time_left,
            'is_active' => $this->is_active,
        ];
    }
    
}
