<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Note\StoreNoteRequest;
use App\Http\Requests\Note\UpdateNoteRequest;
use App\Models\Note;
use App\Http\Resources\Note\NoteResource;
use App\Traits\JsonRespond;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    use JsonRespond;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $notes = Note::all();
        return NoteResource::collection($notes);
    }

    public function equipment($id)
    {
        $notes = Note::where('equipment_id', $id)->get();
        return NoteResource::collection($notes);
    }

    public function employee($id)
    {
        $notes = Note::where('employee_id', $id)->get();
        return NoteResource::collection($notes);
    }

    public function search(Request $request)
    {
        $notes = Note::with('equipment', 'employee')
            ->where('equipment_id', $request->equipment_id)
            ->where('employee_id', $request->employee_id)
            ->get();
        return NoteResource::collection($notes);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreNoteRequest $request)
    {
        $note = Note::create($request->validated());
        return NoteResource::make($note->load('equipment', 'employee'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function show(Note $note)
    {
        return new NoteResource($note);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Request  $request
     * @param  \App\Models\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateNoteRequest $request, Note $note)
    {
        $note->update($request->validated());
        return new NoteResource($note);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  integer  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $note = Note::findOrFail($id);
        $note->delete();
        return $this->respondObjectDeleted($id);
    }
}
