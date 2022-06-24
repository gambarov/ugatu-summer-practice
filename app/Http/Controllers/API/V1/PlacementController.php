<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Placement\PlacementResource;
use App\Models\Equipment\Placement;
use App\Services\Placement\CreatePlacementService;
use Illuminate\Http\Request;

class PlacementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $placements = Placement::with(['equipment', 'audience'])->get();
        return PlacementResource::collection($placements);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $placement = app(CreatePlacementService::class)
            ->execute($request->all());
        return new PlacementResource($placement);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Equipment\Placement  $placement
     * @return \Illuminate\Http\Response
     */
    public function show(Placement $placement)
    {
        return new PlacementResource($placement->load(['equipment', 'audience']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Equipment\Placement  $placement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Placement $placement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Equipment\Placement  $placement
     * @return \Illuminate\Http\Response
     */
    public function destroy(Placement $placement)
    {
        //
    }
}
