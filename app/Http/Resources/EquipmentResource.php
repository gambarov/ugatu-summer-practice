<?php

namespace App\Http\Resources;

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
            'equipment_type_id' => $this->equipment_type_id,
            'equipment_type' => new WithEquipmentTypeResource($this->equipment_type),
            'sets' => WithEquipmentSetResource::collection($this->sets),
        ];
    }
}
