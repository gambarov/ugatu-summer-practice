<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\ApiController;
use App\Models\Equipment\Set;
use App\Http\Resources\Set\SetResource;
use App\Services\Set\CreateSetService;
use App\Services\Set\UpdateSetService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

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
    public function store(Request $request)
    {
        try {
            $set = app(CreateSetService::class)->execute($request->all());
        } catch (ValidationException $e) {
            return $this->respondValidatorFailed($e->validator);
        }

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
        try {
            $set = Set::with('equipment')->findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return $this->respondNotFound('Комплект не найден');
        }

        return new SetResource($set);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Request  $request
     * @param  integer  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        try {
            $set = app(UpdateSetService::class)->execute($request->all() + ['id' => $id]);
        } catch (ValidationException $e) {
            return $this->respondValidatorFailed($e->validator);
        } catch (ModelNotFoundException $e) {
            return $this->respondNotFound('Комплект не найден');
        }

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
        try {
            $set = Set::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return $this->respondNotFound('Комплект не найден');
        }

        $set->delete();
        return $this->respondObjectDeleted($set->id);
    }
}
