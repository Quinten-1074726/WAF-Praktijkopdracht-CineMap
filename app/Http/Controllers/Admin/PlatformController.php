<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Platform;
use Illuminate\Http\Request;

class PlatformController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $q = $request->get('q', '');

        $platforms = Platform::withCount('titles')
            ->when($q, fn($qb) => $qb->where('name', 'like', "%{$q}%"))
            ->orderBy('name')
            ->paginate(20)
            ->withQueryString();

        return view('admin.platforms.index', compact('platforms', 'q'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.platforms.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:platforms,name'],
        ]);

        Platform::create($validated);

        return redirect()->route('admin.platforms.index')
            ->with('status', 'Platform succesvol aangemaakt.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Platform $platform)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Platform $platform)
    {
        return view('admin.platforms.edit', compact('platform'));
    }

    /**
     * Update the specified resource in storage.
     */
     public function update(Request $request, Platform $platform)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:platforms,name,' . $platform->id],
        ]);

        $platform->update($validated);

        return redirect()->route('admin.platforms.index')
            ->with('status', 'Platform bijgewerkt.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Platform $platform)
    {
        $platform->delete();

        return redirect()->route('admin.platforms.index')
            ->with('status', 'Platform verwijderd.');
    }
}
