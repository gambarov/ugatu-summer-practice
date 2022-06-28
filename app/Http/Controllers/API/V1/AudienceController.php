<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\ApiController;
use App\Http\Requests\Audience\StoreAudienceRequest;
use App\Http\Requests\Audience\UpdateAudienceRequest;
use App\Http\Resources\Audience\AudienceResource;
use App\Models\Equipment\Audience;
use App\Services\Audience\CreateAudienceService;
use App\Services\Audience\UpdateAudienceService;

class AudienceController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return AudienceResource::collection(Audience::with('equipment')->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAudienceRequest $request)
    {
        $audience = app(CreateAudienceService::class)->execute($request->all());
        return AudienceResource::make($audience->load(['type', 'equipment']));
    }

    /**
     * Display the specified resource.
     *
     * @param  integer  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $audience = Audience::with('equipment')->findOrFail($id);
        return AudienceResource::make($audience);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Request  $request
     * @param  integer  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAudienceRequest $request, $id)
    {
        $audience = app(UpdateAudienceService::class)->execute($request->all() + ['id' => $id]);
        return AudienceResource::make($audience->load(['equipment']));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  integer  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $audience = Audience::findOrFail($id);
        $audience->delete();
        return $this->respondObjectDeleted($id);
    }
}
