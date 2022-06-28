<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\ApiController;
use App\Http\Requests\Equipment\StoreEquipmentRequest;
use App\Http\Requests\Equipment\UpdateEquipmentRequest;
use App\Models\Equipment\Equipment;
use App\Http\Resources\Equipment\EquipmentResource;
use App\Services\Equipment\CreateEquipmentService;
use App\Services\Equipment\UpdateEquipmentService;

class EquipmentController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $equipment = Equipment::with(['sets'])->get();
        return EquipmentResource::collection($equipment);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEquipmentRequest $request)
    {
        $equipment = app(CreateEquipmentService::class)->execute($request->validated());
        return new EquipmentResource($equipment->load(['type', 'sets']));
    }

    /**
     * Display the specified resource.
     *
     * @param  integer  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $equipment = Equipment::with('sets')->findOrFail($id);
        return new EquipmentResource($equipment);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Request  $request
     * @param  integer  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEquipmentRequest $request, int $id)
    {
        $equipment = app(UpdateEquipmentService::class)->execute($request->validated() + ['id' => $id]);
        return new EquipmentResource($equipment->load('sets'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  integer  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $equipment = Equipment::findOrFail($id);
        $equipment->delete();
        return $this->respondObjectDeleted($id);
    }
}
