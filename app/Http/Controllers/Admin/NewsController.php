<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\NewsCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        $query = News::with(['category', 'author'])->latest('published_at');

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status === 'published');
        }

        $news = $query->paginate(6)->withQueryString();
        $categories = NewsCategory::orderBy('name')->get();

        return view('admin.news.index', compact('news', 'categories'));
    }

    public function create()
    {
        $categories = NewsCategory::orderBy('name')->get();

        return view('admin.news.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id'   => 'required|exists:news_categories,id',
            'title'         => 'required|string|max:200',
            'content'       => 'required|string',
            'thumbnail'     => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'status'        => 'required|boolean',
            'published_at'  => 'nullable|date',
        ]);

        $slug = $this->generateUniqueSlug($validated['title']);

        $validated['thumbnail'] = $request->hasFile('thumbnail')
            ? $request->file('thumbnail')->store('news', 'public')
            : null;

        News::create([
            ...$validated,
            'slug'         => $slug,
            'author_id'    => $request->user()->id,
            'published_at' => $validated['status'] ? ($validated['published_at'] ?? now()) : null,
        ]);

        return redirect()->route('admin.news.index')->with('success', 'Berita berhasil ditambahkan.');
    }

    public function update(Request $request, News $news)
    {
        $validated = $request->validate([
            'category_id'   => 'required|exists:news_categories,id',
            'title'         => 'required|string|max:200',
            'content'       => 'required|string',
            'thumbnail'     => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'status'        => 'required|boolean',
            'published_at'  => 'nullable|date',
        ]);

        if ($request->hasFile('thumbnail')) {
            if ($news->thumbnail) {
                Storage::disk('public')->delete($news->thumbnail);
            }
            $validated['thumbnail'] = $request->file('thumbnail')->store('news', 'public');
        }

        $validated['published_at'] = $validated['status']
            ? ($validated['published_at'] ?? $news->published_at ?? now())
            : null;

        $news->update($validated);

        return redirect()->route('admin.news.index')->with('success', 'Berita berhasil diperbarui.');
    }

    public function destroy(News $news)
    {
        if ($news->thumbnail) {
            Storage::disk('public')->delete($news->thumbnail);
        }

        $news->delete();

        return redirect()->route('admin.news.index')->with('success', 'Berita berhasil dihapus.');
    }

    private function generateUniqueSlug(string $title): string
    {
        $slug = Str::slug($title);
        $original = $slug;
        $counter = 1;

        while (News::where('slug', $slug)->exists()) {
            $slug = "{$original}-{$counter}";
            $counter++;
        }

        return $slug;
    }
}
