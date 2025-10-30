<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Title;

class TitleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $q = $request->get('q');

        $titles = Title::query()
            ->with('platform')
            ->where('is_published', true)
            ->when($q, function ($query) use ($q) {
                $query->where(function ($sub) use ($q) {
                    $sub->where('title', 'like', "%{$q}%")
                        ->orWhere('description', 'like', "%{$q}%");
                });
            })
            ->orderByDesc('year')
            ->paginate(12)
            ->withQueryString();

        return view('titles.index', compact('titles', 'q'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Title $title)
    {
        // middleware('auth') staat al op de route
        // bescherm ook tegen ongepubliceerde titels voor niet-admins:
        $isAdmin = auth()->user()?->can('admin-access') ?? false;
        if (!$title->is_published && !$isAdmin) {
            abort(404);
        }

        $title->load('platform','genres','user');
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
