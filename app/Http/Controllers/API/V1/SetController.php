<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\ApiController;
use App\Http\Requests\Set\StoreSetRequest;
use App\Http\Requests\Set\UpdateSetRequest;
use App\Models\Equipment\Set;
use App\Http\Resources\Set\SetResource;
use App\Services\Set\CreateSetService;
use App\Services\Set\UpdateSetService;

class SetController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sets = Set::with('equipment')->get();
        return SetResource::collection($sets);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSetRequest $request)
    {
        $set = app(CreateSetService::class)->execute($request->validated());
        return new SetResource($set->load(['employee', 'equipment']));
    }

    /**
     * Display the specified resource.
     *
     * @param  integer  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $set = Set::with('equipment')->findOrFail($id);
        return new SetResource($set);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Request  $request
     * @param  integer  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSetRequest $request, int $id)
    {
        $set = app(UpdateSetService::class)->execute($request->validated() + ['id' => $id]);
        return new SetResource($set->load(['equipment']));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param integer   $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $set = Set::findOrFail($id);
        $set->delete();
        return $this->respondObjectDeleted($id);
    }
}
