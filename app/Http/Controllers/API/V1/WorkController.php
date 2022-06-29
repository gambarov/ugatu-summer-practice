<?php

namespace App\Http\Controllers\API\V1;

use App\Helpers\MorphHelper;
use App\Http\Controllers\API\ApiController;
use App\Http\Requests\Work\StoreWorkRequest;
use App\Http\Requests\Work\UpdateWorkRequest;
use App\Http\Resources\Work\WorkResource;
use App\Models\Equipment\Work;
use App\Services\Work\CreateWorkService;
use App\Services\Work\UpdateWorkService;
use App\Traits\JsonRespond;
use Illuminate\Http\Request;

class WorkController extends ApiController
{
    use JsonRespond;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return WorkResource::collection(Work::with('workable')->get());
    }

    public function workable(Request $request, $id)
    {
        $data = $request->validate([
            'workable_type' => 'required|string',
        ]);
        $workable_type = MorphHelper::getMorphType($data['workable_type']);
        return WorkResource::collection(
            Work::where('workable_id', $id)
                ->where('workable_type', $workable_type)->get()
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreWorkRequest $request)
    {
        $work = app(CreateWorkService::class)->execute($request->validated());
        return new WorkResource($work->load(['workable', 'type', 'status', 'employee']));
    }

    /**
     * Display the specified resource.
     *
     * @param  integer  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $work = Work::with('workable')->findOrFail($id);
        return new WorkResource($work);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Request  $request
     * @param  integer  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateWorkRequest $request, $id)
    {
        $work = app(UpdateWorkService::class)->execute($request->validated() + ['id' => $id]);
        return new WorkResource($work->load(['workable']));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  integer  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $work = Work::findOrFail($id);
        $work->delete();
        return $this->respondObjectDeleted($id);
    }
}
