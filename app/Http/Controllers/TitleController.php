<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Title;
class TitleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $titles = Title::where('is_published', true)
            ->orderByDesc('year')
            ->paginate(12);

        return view('titles.index', compact('titles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('titles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $titles = $request->validate([
            'title'        => ['required','string','max:255'],
            'description'  => ['nullable','string'],
            'type'         => ['required','in:movie,series'],
            'year'         => ['nullable','integer','between:1900,2100'],
            'is_published' => ['sometimes','boolean'],
        ]);

        $titles = Title::create([
            'title'       => $titles['title'],
            'description' => $titles['description'] ?? null,
            'type'        => $titles['type'],
            'year'        => $titles['year'] ?? null,
            'is_published'=> $request->has('is_published') ? (bool)$titles['is_published'] : false,
            'user_id'     => auth()->id(),
            'platform_id' => null,

        ]);
        return redirect()->route('titles.index')->with('status', 'Title opgeslagen!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Title $title)   
    {
        abort_unless($title->is_published, 404);
        return view('titles.show', compact('title'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
