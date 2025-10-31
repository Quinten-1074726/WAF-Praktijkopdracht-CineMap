<?php

namespace App\Http\Controllers;

use App\Models\WatchlistItem;
use Illuminate\Http\Request;

class WatchlistItemController extends Controller
{
    // GET /watchlist
    public function index(Request $request)
    {
        $user = $request->user();

        $status = $request->get('status');  
        $q      = $request->get('q');        

        $items = WatchlistItem::query()
            ->with(['title.platform'])
            ->where('user_id', $user->id)
            ->when($status, fn($qb) => $qb->where('status', $status))
            ->when($q, function ($qb) use ($q) {
                $qb->whereHas('title', function ($sub) use ($q) {
                    $sub->where('title', 'like', "%{$q}%")
                        ->orWhere('description', 'like', "%{$q}%");
                });
            })
            ->orderByDesc('created_at')
            ->paginate(12)
            ->withQueryString();

        $counts = WatchlistItem::selectRaw('status, COUNT(*) as c')
            ->where('user_id', $user->id)
            ->groupBy('status')
            ->pluck('c','status');

        $seenCount = WatchlistItem::where('user_id', $user->id)
            ->where('status', 'GEZIEN')
            ->count();

        return view('watchlist.index', compact('items','status','q','counts','seenCount'));
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
        $data = $request->validate([
            'title_id' => ['required','exists:titles,id'],
            'status'   => ['nullable','in:WIL_KIJKEN,BEZIG,GEZIEN'],
        ]);

        $data['user_id'] = $request->user()->id;
        $data['status']  = $data['status'] ?? 'WIL_KIJKEN';

        // voorkom UNIQUE-fout (user_id + title_id)
        WatchlistItem::updateOrCreate(
            ['user_id' => $data['user_id'], 'title_id' => $data['title_id']],
            ['status' => $data['status']]
        );

        return back()->with('status', 'Toegevoegd aan je watchlist.');
    }

    /**
     * Display the specified resource.
     */
    public function show(WatchlistItem $watchlistItem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(WatchlistItem $watchlistItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, WatchlistItem $watchlist)
    {
        $item = $request->user()->watchlist()->findOrFail($watchlist->id);

        $seenCount = $request->user()->watchlist()
            ->where('status', 'GEZIEN')
            ->count();

        $canRate = $seenCount >= 5;

        $rules = [
            'status' => ['required', 'in:WIL_KIJKEN,BEZIG,GEZIEN'],
            'rating' => ['nullable', 'integer', 'between:1,10'],
            'review' => ['nullable', 'string', 'max:2000'],
        ];

        if ($request->input('status') === 'GEZIEN' && $canRate) {
            $rules['rating'] = ['required', 'integer', 'between:1,10'];
            $rules['review'] = ['required', 'string', 'min:10', 'max:2000'];
        }

        $data = $request->validate($rules);

        if ($request->input('status') === 'GEZIEN' && ! $canRate) {
            $data['rating'] = null;
            $data['review'] = null;
        }

        $item->update($data);

        return back()->with('status', 'Watchlist-item bijgewerkt.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, WatchlistItem $watchlist)
    {
        $item = $request->user()->watchlist()->findOrFail($watchlist->id);
        $item->delete();

        return back()->with('status', 'Verwijderd uit je watchlist.');
    }
}
