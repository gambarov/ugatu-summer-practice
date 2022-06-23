<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\EquipmentPlacement;
use App\Services\EquipmentPlacement\CreateEquipmentPlacementService;
use Illuminate\Http\Request;

class EquipmentPlacementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return app(CreateEquipmentPlacementService::class)
            ->execute($request->all())
            ->toJson();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EquipmentPlacement  $equipmentPlacement
     * @return \Illuminate\Http\Response
     */
    public function show(EquipmentPlacement $equipmentPlacement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EquipmentPlacement  $equipmentPlacement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EquipmentPlacement $equipmentPlacement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EquipmentPlacement  $equipmentPlacement
     * @return \Illuminate\Http\Response
     */
    public function destroy(EquipmentPlacement $equipmentPlacement)
    {
        //
    }
}
