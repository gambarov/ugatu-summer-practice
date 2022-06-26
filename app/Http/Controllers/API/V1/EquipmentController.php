<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\ApiController;
use App\Http\Requests\Equipment\StoreEquipmentRequest;
use App\Http\Requests\Equipment\UpdateEquipmentRequest;
use App\Models\Equipment\Equipment;
use App\Http\Resources\Equipment\EquipmentResource;
use App\Services\Equipment\CreateEquipmentService;
use App\Services\Equipment\UpdateEquipmentService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

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
        try {
            $equipment = app(CreateEquipmentService::class)->execute($request->all());
        } catch (ValidationException $e) {
            return $this->respondValidatorFailed($e->validator);
        }

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
        try {
            $equipment = Equipment::with('sets')->findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return $this->respondNotFound('Оборудование не найдено');
        }

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
        try {
            $equipment = app(UpdateEquipmentService::class)->execute($request->all() + ['id' => $id]);
        } catch (ValidationException $e) {
            return $this->respondValidatorFailed($e->validator);
        } catch (ModelNotFoundException $e) {
            return $this->respondNotFound('Оборудование не найдено');
        }

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
        try {
            $equipment = Equipment::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return $this->respondNotFound('Оборудование не найдено');
        }

        $equipment->delete();
        return $this->respondObjectDeleted($equipment->id);
    }
}
