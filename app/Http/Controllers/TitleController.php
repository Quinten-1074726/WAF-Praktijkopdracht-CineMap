<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Title;
use App\Models\Platform;    

class TitleController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified', 'can:admin-access'])->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $titles = Title::query()
            ->with('platform')                 
            ->where('is_published', true)
            ->orderByDesc('year')
            ->paginate(12);

        return view('titles.index', compact('titles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $platforms = Platform::all();
        return view('titles.create', compact('platforms'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'        => ['required','string','max:255'],
            'description'  => ['required','string', 'max:1000'],
            'type'         => ['required','in:movie,series'],
            'year'         => ['required','integer','between:1900,2100'],
            'is_published' => ['sometimes','boolean'],
            'platform_id'  => ['required','exists:platforms,id'],
        ]);
 
        
        $title = new Title();
        $title['title']        = $request->input('title');
        $title['description']  = $request->input('description');
        $title['type']         = $request->input('type');
        $title['year']         = $request->input('year');
        $title['user_id']      = $request->user()->id;
        $title['platform_id']  = $request->input('platform_id');
        $title['is_published'] = $request->boolean('is_published');

        $title->save();
        return redirect()
            ->route('titles.index')
            ->with('status', 'Title opgeslagen!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Title $title)
    {
        
        $canSeeUnpublished = auth()->user()?->can('admin-access') ?? false;
        if (!$title->is_published && !$canSeeUnpublished) {
            abort(404);
        }

        $title->load('platform'); 
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
