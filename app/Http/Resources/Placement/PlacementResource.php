<?php

namespace App\Http\Resources\Placement;

use App\Http\Resources\Audience\AudienceResource;
use App\Http\Resources\Equipment\EquipmentResource;

use Illuminate\Http\Resources\Json\JsonResource;

class PlacementResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'equipment' => new EquipmentResource($this->whenLoaded('equipment')),
            'audience' => new AudienceResource($this->whenLoaded('audience')),
            'placed_at' => $this->placed_at,
            'removed_at' => $this->removed_at,
        ];
    }
}
