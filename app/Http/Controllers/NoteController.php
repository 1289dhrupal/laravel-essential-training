<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\Notebook;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function Laravel\Prompts\select;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        /** @var App\Models\User $user */
        $user = Auth::user();

        // $user_id = Auth::id();
        // $notes = Note::where('user_id', $user_id)->latest('updated_at')->paginate(5);

        // $notes = $user->notes()->latest('updated_at')->paginate(5);
        $notes = Note::whereBelongsTo($user)->latest('updated_at')->paginate(5);

        return view('notes.index')->with('notes', $notes);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $notebooks = Notebook::whereBelongsTo(Auth::user())->get(['id', 'name']);
        return view('notes.create')->with('notebooks', $notebooks);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:120',
            'text' => 'required',
            'notebook_id' => 'nullable|exists:notebooks,id'
        ]);

        /** @var App\Models\User $user */
        $user = Auth::user();

        $note = $user->notes()->create([
            'uuid' => Str::uuid(),
            'title' => $request->title,
            'text' => $request->text,
            'notebook_id' => $request->notebook_id
        ]);

        return to_route('notes.show', $note)->with('success', 'Note created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Note $note)
    {
        if ($note->user->is(Auth::user()) === false) {
            abort(403);
        }

        $notebook = $note->notebook;
        // return view('notes.show')->with('note', $note);
        return view('notes.show', ['note' => $note, 'notebook' => $notebook]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Note $note)
    {
        if ($note->user->is(Auth::user()) === false) {
            abort(403);
        }
        $notebooks = Notebook::whereBelongsTo(Auth::user())->get(['id', 'name']);
        return view('notes.edit', ['note' => $note, 'notebooks' => $notebooks]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Note $note)
    {
        if ($note->user->is(Auth::user()) === false) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|max:120',
            'text' => 'required',
            'notebook_id' => 'nullable|exists:notebooks,id'
        ]);

        $note->update([
            'title' => $request->title,
            'text' => $request->text,
            'notebook_id' => $request->notebook_id
        ]);

        return to_route('notes.show', $note)->with('success', 'Note updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Note $note)
    {
        if ($note->user->is(Auth::user()) === false) {
            abort(403);
        }

        $note->delete();

        return to_route('notes.index')->with('success', 'Note deleted successfully.');
    }
}
