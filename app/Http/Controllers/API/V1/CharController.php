<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Char\StoreCharRequest;
use App\Http\Requests\Char\UpdateCharRequest;
use App\Http\Resources\Char\CharResource;
use App\Models\Equipment\Char;
use App\Traits\JsonRespond;

class CharController extends Controller
{
    use JsonRespond;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return CharResource::collection(Char::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCharRequest $request)
    {
        $char = Char::create($request->validated());
        return CharResource::make($char->load('measure', 'group'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Char  $equipmentChar
     * @return \Illuminate\Http\Response
     */
    public function show(Char $char)
    {
        return CharResource::make($char);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Request  $request
     * @param  \App\Models\Char  $equipmentChar
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCharRequest $request, Char $char)
    {
        $char->update($request->validated());
        return CharResource::make($char->load('measure', 'group'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  integer $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $char = Char::findOrFail($id);
        $char->delete();
        $this->respondObjectDeleted($id);
    }
}
