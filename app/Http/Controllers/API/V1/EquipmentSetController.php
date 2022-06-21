<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\EquipmentSet;
use App\Http\Requests\StoreEquipmentSetRequest;
use App\Http\Requests\UpdateEquipmentSetRequest;

class EquipmentSetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return EquipmentSet::all()->toJson();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreEquipmentSetRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEquipmentSetRequest $request)
    {
        return EquipmentSet::create($request->all())->toJson();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EquipmentSet  $equipmentSet
     * @return \Illuminate\Http\Response
     */
    public function show(EquipmentSet $equipmentSet)
    {
        return $equipmentSet->toJson();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateEquipmentSetRequest  $request
     * @param  \App\Models\EquipmentSet  $equipmentSet
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEquipmentSetRequest $request, EquipmentSet $equipmentSet)
    {
        $equipmentSet->update($request->all());
        return $equipmentSet->toJson();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EquipmentSet  $equipmentSet
     * @return \Illuminate\Http\Response
     */
    public function destroy(EquipmentSet $equipmentSet)
    {
        $equipmentSet->delete();
        return response()->noContent();
    }
}
