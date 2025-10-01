<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

class NewsController
{

    public function index(Request $request)
    {
        $q = trim($request->get('q', ''));

        $news = News::query()
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($sub) use ($q) {
                    $sub->where('title', 'like', "%{$q}%")
                        ->orWhere('content', 'like', "%{$q}%");
                });
            })
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('news.index', compact('news', 'q'));
    }


    public function create()
    {
        if (!auth()->user() || !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized');
        }

        return view('news.create');
    }


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


    public function show(News $news)
    {
        return view('news.show', compact('news'));
    }


    public function edit(News $news)
    {
        if (!auth()->user() || !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized');
        }

        return view('news.edit', compact('news'));
    }


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
