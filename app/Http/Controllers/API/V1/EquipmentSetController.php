<?php

namespace App\Http\Controllers;

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
     * @param  \App\Http\Requests\StoreEquipmentSetRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEquipmentSetRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EquipmentSet  $equipmentSet
     * @return \Illuminate\Http\Response
     */
    public function show(EquipmentSet $equipmentSet)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\EquipmentSet  $equipmentSet
     * @return \Illuminate\Http\Response
     */
    public function edit(EquipmentSet $equipmentSet)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EquipmentSet  $equipmentSet
     * @return \Illuminate\Http\Response
     */
    public function destroy(EquipmentSet $equipmentSet)
    {
        //
    }
}
