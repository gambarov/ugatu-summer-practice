<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\EquipmentChar;
use App\Http\Requests\StoreEquipmentCharRequest;
use App\Http\Requests\UpdateEquipmentCharRequest;

class EquipmentCharController extends Controller
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
     * @param  \App\Http\Requests\StoreEquipmentCharRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEquipmentCharRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EquipmentChar  $equipmentChar
     * @return \Illuminate\Http\Response
     */
    public function show(EquipmentChar $equipmentChar)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\EquipmentChar  $equipmentChar
     * @return \Illuminate\Http\Response
     */
    public function edit(EquipmentChar $equipmentChar)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateEquipmentCharRequest  $request
     * @param  \App\Models\EquipmentChar  $equipmentChar
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEquipmentCharRequest $request, EquipmentChar $equipmentChar)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EquipmentChar  $equipmentChar
     * @return \Illuminate\Http\Response
     */
    public function destroy(EquipmentChar $equipmentChar)
    {
        //
    }
}
