<?php

namespace App\Http\Resources\Work;

use App\Http\Resources\Employee\EmployeeResource;
use App\Http\Resources\Equipment\EquipmentResource;
use Illuminate\Http\Resources\Json\JsonResource;

class EquipmentWorkResource extends JsonResource
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
            'work_type' => new WorkTypeResource($this->whenLoaded('type')),
            'work_status' => new WorkStatusResource($this->whenLoaded('status')),
            'employee' => new EmployeeResource($this->whenLoaded('employee')),
            'started_at' => $this->started_at,
            'ended_at' => $this->ended_at,
        ];
    }
}
