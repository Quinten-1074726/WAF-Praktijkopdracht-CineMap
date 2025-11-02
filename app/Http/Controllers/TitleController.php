<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Title;
use App\Models\Platform;
use App\Models\Genre;

class TitleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $q          = $request->get('q');
        $platformId = $request->get('platform');      
        $genreIds   = array_filter((array) $request->get('genres')); 
        $yearFrom   = $request->integer('year_from');
        $yearTo     = $request->integer('year_to');
        $type       = $request->get('type');          

        $titles = Title::query()
            ->with('platform')
            ->where('is_published', true)
            ->when($q, function ($query) use ($q) {
                $query->where(function ($sub) use ($q) {
                    $sub->where('title', 'like', "%{$q}%")
                        ->orWhere('description', 'like', "%{$q}%");
                });
            })
            ->when($type, fn($qb) => $qb->where('type', $type))
            ->when($platformId, fn($qb) => $qb->where('platform_id', $platformId))
            ->when($genreIds, function ($qb) use ($genreIds) {
                $qb->whereHas('genres', function ($gq) use ($genreIds) {
                    $gq->whereIn('genres.id', $genreIds);
                });
            })
            ->when($yearFrom, fn($qb) => $qb->where('year', '>=', $yearFrom))
            ->when($yearTo,   fn($qb) => $qb->where('year', '<=', $yearTo))
            ->orderByDesc('year')
            ->paginate(12)
            ->withQueryString();

        $platforms = Platform::orderBy('name')->get(['id','name']);
        $genres    = Genre::orderBy('name')->get(['id','name']);

        $watchStatuses = collect();
        if (auth()->check()) {
            $watchStatuses = auth()->user()->watchlist()->pluck('status','title_id');
        }

        return view('titles.index', compact(
            'titles','q','watchStatuses','platforms','genres','platformId','genreIds','yearFrom','yearTo','type'
        ));
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
        $isAdmin = auth()->user()?->can('admin-access') ?? false;
        if (!$title->is_published && !$isAdmin) {
            abort(404);
        }

        $title->load('platform','genres','user');
        $inWatchlist = auth()->check()
            ? auth()->user()->watchlist()->where('title_id',$title->id)->first()
            : null;

        return view('titles.show', compact('title','inWatchlist'));
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
