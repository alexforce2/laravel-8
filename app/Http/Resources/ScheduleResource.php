<?php declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ScheduleResource extends JsonResource
{
    public function toArray($request = null): array
    {
        return [
            'title' => $this->title,
            'start_at' => $this->start_at,
            'end_at' => $this->end_at,
        ];
    }
}
