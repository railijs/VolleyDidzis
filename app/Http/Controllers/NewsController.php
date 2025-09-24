<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    /**
     * Display a paginated list of news.
     */
    public function index()
    {
        $news = News::latest()->paginate(10);

        return view('news.index', compact('news'));
    }

    /**
     * Show the form for creating news (admin only).
     */
    public function create()
    {
        if (!auth()->user() || !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized');
        }

        return view('news.create');
    }

    /**
     * Store a newly created news entry.
     */
    public function store(Request $request)
    {
        if (!auth()->user() || !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required|string',
            'image'   => 'nullable|image|max:2048',
        ], [
            'title.required'   => 'Lūdzu ievadiet virsrakstu.',
            'title.string'     => 'Virsraksts jābūt tekstam.',
            'title.max'        => 'Virsraksts nedrīkst pārsniegt 255 rakstzīmes.',
            'content.required' => 'Lūdzu ievadiet saturu.',
            'content.string'   => 'Saturs jābūt tekstam.',
            'image.image'      => 'Izvēlētais fails nav attēls.',
            'image.max'        => 'Attēls nedrīkst būt lielāks par 2MB.',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('news', 'public');
        }

        News::create($validated);

        return redirect()->route('news.index')
            ->with('success', 'Ziņa veiksmīgi pievienota.');
    }

    /**
     * Display a single news entry.
     */
    public function show(News $news)
    {
        return view('news.show', compact('news'));
    }

    /**
     * Show the form for editing news (admin only).
     */
    public function edit(News $news)
    {
        if (!auth()->user() || !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized');
        }

        return view('news.edit', compact('news'));
    }

    /**
     * Update an existing news entry.
     */
    public function update(Request $request, News $news)
    {
        if (!auth()->user() || !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required|string',
            'image'   => 'nullable|image|max:2048',
        ], [
            'title.required'   => 'Lūdzu ievadiet virsrakstu.',
            'title.string'     => 'Virsraksts jābūt tekstam.',
            'title.max'        => 'Virsraksts nedrīkst pārsniegt 255 rakstzīmes.',
            'content.required' => 'Lūdzu ievadiet saturu.',
            'content.string'   => 'Saturs jābūt tekstam.',
            'image.image'      => 'Izvēlētais fails nav attēls.',
            'image.max'        => 'Attēls nedrīkst būt lielāks par 2MB.',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('news', 'public');
        }

        $news->update($validated);

        return redirect()->route('news.index')
            ->with('success', 'Ziņa veiksmīgi atjaunināta.');
    }

    /**
     * Delete a news entry (admin only).
     */
    public function destroy(News $news)
    {
        if (!auth()->user() || !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized');
        }

        $news->delete();

        return redirect()->route('news.index')
            ->with('success', 'News deleted successfully.');
    }
}
