<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\Audience;
use App\Http\Requests\StoreAudienceRequest;
use App\Http\Requests\UpdateAudienceRequest;

class AudienceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Audience::all()->toJson();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreAudienceRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAudienceRequest $request)
    {
        return Audience::create($request->all())->toJson();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Audience  $audience
     * @return \Illuminate\Http\Response
     */
    public function show(Audience $audience)
    {
        return $audience->toJson();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAudienceRequest  $request
     * @param  \App\Models\Audience  $audience
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAudienceRequest $request, Audience $audience)
    {
        $audience->update($request->all());
        return $audience->toJson();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Audience  $audience
     * @return \Illuminate\Http\Response
     */
    public function destroy(Audience $audience)
    {
        $audience->delete();
        return $audience->toJson();
    }
}
