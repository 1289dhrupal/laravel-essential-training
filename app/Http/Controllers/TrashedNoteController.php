<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Note;

class TrashedNoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        /** @var App\Models\User $user */
        $user = Auth::user();

        $notes = Note::whereBelongsTo($user)->onlyTrashed()->latest('updated_at')->paginate(5);

        return view('notes.index')->with('notes', $notes);
    }

    /**
     * Display the specified resource.
     */
    public function show(Note $note)
    {
        if ($note->user->is(Auth::user()) === false) {
            abort(403);
        }

        return view('notes.show', ['note' => $note]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Note $note)
    {
        if ($note->user->is(Auth::user()) === false) {
            abort(403);
        }

        $note->restore();

        return to_route('notes.show', $note)->with('success', 'Note restored successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Note $note)
    {
        if ($note->user->is(Auth::user()) === false) {
            abort(403);
        }

        $note->forceDelete();

        return to_route('trashed.index')->with('success', 'Note deleted permanently!');
    }
}
