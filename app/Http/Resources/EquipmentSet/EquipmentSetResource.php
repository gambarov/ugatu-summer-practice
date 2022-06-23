<?php

namespace App\Http\Resources\EquipmentSet;

use App\Http\Resources\Equipment\WithEquipmentResource;
use Illuminate\Http\Resources\Json\JsonResource;

class EquipmentSetResource extends JsonResource
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
            'name' => $this->name,
            'employee_id' => $this->employee_id,
            'employee' => $this->employee,
            'equipment' => WithEquipmentResource::collection($this->equipment)
        ];
    }
}
