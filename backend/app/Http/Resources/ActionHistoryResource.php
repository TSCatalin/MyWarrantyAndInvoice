<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ActionHistoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'type_action' => $this->type_action,
            'info_action' => $this->info_action,
            'date_action' => (new Carbon($this->date_action))->format('H:i:s / d-m-Y'),
        ];
    }
}
