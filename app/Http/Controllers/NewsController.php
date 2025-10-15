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
        if (!auth()->user() || !auth()->user()->isAdmin()) abort(403, 'Unauthorized');
        return view('news.create');
    }

    public function store(Request $request)
    {
        if (!auth()->user() || !auth()->user()->isAdmin()) abort(403, 'Unauthorized');

        $validated = $request->validate([
            'title'     => 'required|string|max:255',
            'content'   => 'required|string',
            'image'     => 'nullable|image|max:2048', // upload path
            'image_url' => 'nullable|url',            // external URL
        ]);

        if (!$request->hasFile('image') && !$request->filled('image_url')) {
            return back()
                ->withErrors(['image' => 'Lūdzu augšupielādējiet attēlu vai norādiet saiti uz attēlu.'])
                ->withInput();
        }

        // Prefer upload if both are present
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('news', 'public');
        } else {
            $validated['image'] = $validated['image_url'];
        }
        unset($validated['image_url']);

        News::create($validated);

        return redirect()->route('news.index')->with('success', 'Ziņa veiksmīgi pievienota.');
    }

    public function show(News $news)
    {
        $more = News::where('id', '!=', $news->id)->latest()->take(4)->get();
        return view('news.show', compact('news', 'more'));
    }

    public function edit(News $news)
    {
        if (!auth()->user() || !auth()->user()->isAdmin()) abort(403, 'Unauthorized');
        return view('news.edit', compact('news'));
    }

    public function update(Request $request, News $news)
    {
        if (!auth()->user() || !auth()->user()->isAdmin()) abort(403, 'Unauthorized');

        $validated = $request->validate([
            'title'     => 'required|string|max:255',
            'content'   => 'required|string',
            'image'     => 'nullable|image|max:2048',
            'image_url' => 'nullable|url',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('news', 'public');
        } elseif ($request->filled('image_url')) {
            $validated['image'] = $validated['image_url'];
        } else {
            unset($validated['image']); // keep current
        }
        unset($validated['image_url']);

        $news->update($validated);

        return redirect()->route('news.index')->with('success', 'Ziņa veiksmīgi atjaunināta.');
    }

    public function destroy(News $news)
    {
        if (!auth()->user() || !auth()->user()->isAdmin()) abort(403, 'Unauthorized');

        $news->delete();

        return redirect()->route('news.index')->with('success', 'Ziņa veiksmīgi izdzēsta.');
    }
}
