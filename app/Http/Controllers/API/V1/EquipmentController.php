<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Equipment\UpdateEquipmentRequest;
use App\Models\Equipment\Equipment;
use App\Http\Resources\Equipment\EquipmentResource;
use App\Services\Equipment\CreateEquipmentService;
use App\Services\Equipment\UpdateEquipmentService;
use Illuminate\Http\Request;

class EquipmentController extends Controller
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
    public function store(Request $request)
    {
        $equipment = app(CreateEquipmentService::class)->execute($request->all());
        return new EquipmentResource($equipment);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Equipment  $equipment
     * @return \Illuminate\Http\Response
     */
    public function show(Equipment $equipment)
    {
        return new EquipmentResource($equipment->load('sets'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Request  $request
     * @param  \App\Models\Equipment  $equipment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        $equipment = app(UpdateEquipmentService::class)->execute($request->all() + ['id' => $id]);
        return new EquipmentResource($equipment);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Equipment  $equipment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Equipment $equipment)
    {
        $equipment->delete();
        return response()->noContent();
    }
}
