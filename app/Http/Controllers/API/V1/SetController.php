<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\Equipment\Set;
use App\Http\Resources\Set\SetResource;
use App\Services\Set\CreateSetService;
use App\Services\Set\UpdateSetService;
use Illuminate\Http\Request;

class SetController extends Controller
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
    public function store(Request $request)
    {
        $set = app(CreateSetService::class)->execute($request->all());
        return new SetResource($set);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Set  $set
     * @return \Illuminate\Http\Response
     */
    public function show(Set $set)
    {
        return new SetResource($set->load('equipment'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Request  $request
     * @param  \App\Models\Set  $set
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        $set = app(UpdateSetService::class)->execute($request->all() + ['id' => $id]);
        return new SetResource($set);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Set  $set
     * @return \Illuminate\Http\Response
     */
    public function destroy(Set $set)
    {
        $set->delete();
        return response()->noContent();
    }
}
