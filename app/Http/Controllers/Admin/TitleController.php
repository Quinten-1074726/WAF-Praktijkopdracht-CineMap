<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Title;
use App\Models\Platform;
use Illuminate\Http\Request;

class TitleController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->get('filter');
        $q      = $request->get('q');

        $titles = Title::with('platform','user')
            ->when($q, fn($qbuilder) =>
                $qbuilder->where(function ($sub) use ($q) {
                    $sub->where('title','like',"%{$q}%")
                        ->orWhere('description','like',"%{$q}%");
                })
            )
            ->when($filter === 'unpublished', fn($qb) => $qb->where('is_published', false))
            ->orderByDesc('created_at')
            ->paginate(20)
            ->withQueryString();

        return view('admin.titles.index', compact('titles','q','filter'));
    }

    public function create()
    {
        $platforms = Platform::all();
        return view('admin.titles.create', compact('platforms'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'        => ['required','string','max:255'],
            'description'  => ['required','string','max:1000'],
            'type'         => ['required','in:movie,series'],
            'year'         => ['required','integer','between:1900,2100'],
            'is_published' => ['sometimes','boolean'],
            'platform_id'  => ['required','exists:platforms,id'],
        ]);

        $data['user_id']      = $request->user()->id;
        $data['is_published'] = $request->boolean('is_published');

        Title::create($data);

        return redirect()->route('admin.titles.index')->with('status','Title opgeslagen');
    }

    public function edit(Title $title)
    {
        $platforms = Platform::all();
        return view('admin.titles.edit', compact('title','platforms'));
    }

    public function update(Request $request, Title $title)
    {
        $data = $request->validate([
            'title'        => ['required','string','max:255'],
            'description'  => ['required','string','max:1000'],
            'type'         => ['required','in:movie,series'],
            'year'         => ['required','integer','between:1900,2100'],
            'is_published' => ['sometimes','boolean'],
            'platform_id'  => ['required','exists:platforms,id'],
        ]);

        $data['is_published'] = $request->boolean('is_published');

        $title->update($data);

        return redirect()->route('admin.titles.index')->with('status','Title bijgewerkt');
    }

    public function destroy(Title $title)
    {
        $title->delete();
        return back()->with('status','Title verwijderd');
    }

    public function togglePublish(Title $title)
    {
        $title->update(['is_published' => ! $title->is_published]);
        return back()->with('status','Publicatiestatus gewijzigd');
    }
}
