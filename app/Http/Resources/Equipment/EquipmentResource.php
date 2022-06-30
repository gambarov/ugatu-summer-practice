<?php

namespace App\Http\Resources\Equipment;

use App\Http\Resources\Audience\AudienceResource;
use App\Http\Resources\Char\CharResource;
use App\Http\Resources\Set\SetResource;
use Illuminate\Http\Resources\Json\JsonResource;

class EquipmentResource extends JsonResource
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
            'inventory_id' => $this->inventory_id,
            'name' => $this->name,
            'equipment_type' => new EquipmentTypeResource($this->whenLoaded('type')),
            'sets' => SetResource::collection($this->whenLoaded('sets')),
            'chars' => CharResource::collection($this->whenLoaded('chars')),
            'audience' => $this->whenLoaded('audiences', function () {
                return new AudienceResource($this->currentAudience());
            }),
        ];
    }
}
