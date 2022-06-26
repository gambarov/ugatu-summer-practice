<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\ApiController;
use App\Http\Resources\Audience\AudienceResource;
use App\Models\Equipment\Audience;
use App\Services\Audience\CreateAudienceService;
use App\Services\Audience\UpdateAudienceService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

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
    public function store(Request $request)
    {
        try {
            $audience = app(CreateAudienceService::class)->execute($request->all());
        } catch (ValidationException $e) {
            return $this->respondValidatorFailed($e->validator);
        }

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
        try {
            $audience = Audience::with('equipment')->findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return $this->respondNotFound('Аудитория не найдена');
        }

        return AudienceResource::make($audience);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Request  $request
     * @param  integer  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $audience = app(UpdateAudienceService::class)->execute($request->all() + ['id' => $id]);
        } catch (ModelNotFoundException $e) {
            return $this->respondNotFound('Аудитория не найдена');
        } catch (ValidationException $e) {
            return $this->respondValidatorFailed($e->validator);
        }

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
        try {
            $audience = Audience::findOrFail($id);
            $audience->delete();
        } catch (ModelNotFoundException $e) {
            return $this->respondNotFound('Аудитория не найдена');
        }

        return $this->respondObjectDeleted($audience->id);
    }
}
