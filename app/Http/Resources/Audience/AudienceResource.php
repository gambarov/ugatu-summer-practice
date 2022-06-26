<?php

namespace App\Http\Resources\Audience;

use App\Http\Resources\Equipment\EquipmentResource;
use Illuminate\Http\Resources\Json\JsonResource;

class AudienceResource extends JsonResource
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
            'building' => $this->building,
            'number' => $this->number,
            'letter' => $this->letter,
            'audience_type' => new AudienceTypeResource($this->whenLoaded('type')),
            'equipment' => EquipmentResource::collection($this->whenLoaded('equipment')),
        ];
    }
}
