<?php

namespace App\Http\Resources\Equipment;

use App\Http\Resources\Char\CharResource;
use Illuminate\Http\Resources\Json\JsonResource;

class EquipmentCharResource extends JsonResource
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
            'char' => new CharResource($this->whenLoaded('char')),
            'value' => $this->value,
        ];
    }
}
