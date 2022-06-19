<?php

namespace App\Http\Controllers;

use App\Models\EquipmentType;
use App\Http\Requests\StoreEquipmentTypeRequest;
use App\Http\Requests\UpdateEquipmentTypeRequest;

class EquipmentTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreEquipmentTypeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEquipmentTypeRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EquipmentType  $equipmentType
     * @return \Illuminate\Http\Response
     */
    public function show(EquipmentType $equipmentType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\EquipmentType  $equipmentType
     * @return \Illuminate\Http\Response
     */
    public function edit(EquipmentType $equipmentType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateEquipmentTypeRequest  $request
     * @param  \App\Models\EquipmentType  $equipmentType
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEquipmentTypeRequest $request, EquipmentType $equipmentType)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EquipmentType  $equipmentType
     * @return \Illuminate\Http\Response
     */
    public function destroy(EquipmentType $equipmentType)
    {
        //
    }
}
