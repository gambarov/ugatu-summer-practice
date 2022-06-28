<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Placement\StorePlacementRequest;
use App\Http\Requests\Placement\UpdatePlacementRequest;
use App\Http\Resources\Placement\PlacementResource;
use App\Models\Equipment\Placement;
use App\Services\Placement\CreatePlacementService;
use App\Services\Placement\UpdatePlacementService;
use App\Traits\JsonRespond;

class PlacementController extends Controller
{
    use JsonRespond;

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
     * Возвращает размещение по идентификатору оборудованию.
     *
     * @param integer $id Идентификатор оборудования
     * @return void
     */
    public function equipment($id)
    {
        $placements = Placement::with(['audience'])->where('equipment_id', $id)->get();
        return PlacementResource::collection($placements);
    }
 
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePlacementRequest $request)
    {
        $placement = app(CreatePlacementService::class)->execute($request->validated());
        // FIXME:
        return response()->json(['data' => new PlacementResource($placement->load(['equipment', 'audience']))], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  integer  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $placement = Placement::with(['equipment', 'audience'])->findOrFail($id);
        return new PlacementResource($placement);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  integer  $placement
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePlacementRequest $request, $id)
    {
        $placement = app(UpdatePlacementService::class)->execute($request->validated() + ['id' => $id]);
        return new PlacementResource($placement->load(['equipment', 'audience']));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  integer  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $placement = Placement::findOrFail($id);
        $placement->delete();
        return $this->respondObjectDeleted($id);
    }
}
