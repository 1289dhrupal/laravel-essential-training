<?php

namespace App\Http\Controllers;

use App\Models\Notebook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotebookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        /** @var App\Models\User $user */
        $user = Auth::user();
        $notebooks = Notebook::whereBelongsTo($user)->latest('updated_at')->paginate(5);
        return view('notebooks.index')->with('notebooks', $notebooks);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('notebooks.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        /** @var App\Models\User $user */
        $user = Auth::user();

        $notebook = $user->notebooks()->make([
            'name' => $request->name
        ]);

        $notebook->save();

        return to_route('notebooks.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Notebook $notebook)
    {
        if ($notebook->user->is(Auth::user()) === false) {
            abort(403);
        }

        return view('notebooks.show', ['notebook' => $notebook]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Notebook $notebook)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Notebook $notebook)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Notebook $notebook)
    {
        //
    }
}
