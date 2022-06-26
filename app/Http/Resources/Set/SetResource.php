<?php

namespace App\Http\Resources\Set;

use App\Http\Resources\Employee\EmployeeResource;
use App\Http\Resources\Equipment\EquipmentResource;
use Illuminate\Http\Resources\Json\JsonResource;

class SetResource extends JsonResource
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
            'employee' => new EmployeeResource($this->whenLoaded('employee')),
            'equipment' => EquipmentResource::collection($this->whenLoaded('equipment')),
        ];
    }
}
