<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Equipment\EquipmentTypeResource;
use App\Models\Equipment\EquipmentType;
use Illuminate\Http\Request;

class EquipmentTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return EquipmentTypeResource::collection(EquipmentType::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EquipmentType  $type
     * @return \Illuminate\Http\Response
     */
    public function show(EquipmentType $type)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Request  $request
     * @param  \App\Models\EquipmentType  $type
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EquipmentType $type)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EquipmentType  $type
     * @return \Illuminate\Http\Response
     */
    public function destroy(EquipmentType $type)
    {
        //
    }
}
