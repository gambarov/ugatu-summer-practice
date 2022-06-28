<?php

namespace App\Http\Resources\Work;

use App\Http\Resources\Employee\EmployeeResource;
use App\Http\Resources\Equipment\EquipmentResource;
use App\Http\Resources\Set\SetResource;
use App\Traits\WhenMorph;
use Illuminate\Http\Resources\Json\JsonResource;

class WorkResource extends JsonResource
{
    use WhenMorph;
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
            'workable' => $this->whenMorphLoaded('workable', [
                'App\Models\Equipment\Equipment' => EquipmentResource::class,
                'App\Models\Equipment\Set' => SetResource::class
            ]),
            'work_type' => new WorkTypeResource($this->whenLoaded('type')),
            'work_status' => new WorkStatusResource($this->whenLoaded('status')),
            'employee' => new EmployeeResource($this->whenLoaded('employee')),
            'started_at' => $this->started_at,
            'ended_at' => $this->ended_at,
        ];
    }
}
