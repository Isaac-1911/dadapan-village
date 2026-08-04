<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class NewsCategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = NewsCategory::withCount('news');

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $categories = $query->orderBy('name')->paginate(8)->withQueryString();

        return view('admin.news-categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:news_categories,name',
        ]);

        NewsCategory::create([
            'name' => $validated['name'],
            'slug' => $this->generateUniqueSlug($validated['name']),
        ]);

        return redirect()->route('admin.news-categories.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function update(Request $request, NewsCategory $newsCategory)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:news_categories,name,' . $newsCategory->id,
        ]);

        $newsCategory->update(['name' => $validated['name']]);
        // slug sengaja gak diubah otomatis, biar link berita yang udah share gak putus

        return redirect()->route('admin.news-categories.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(NewsCategory $newsCategory)
    {
        if ($newsCategory->news()->exists()) {
            return redirect()->route('admin.news-categories.index')
                ->with('error', 'Kategori tidak bisa dihapus karena masih dipakai oleh berita.');
        }

        $newsCategory->delete();

        return redirect()->route('admin.news-categories.index')->with('success', 'Kategori berhasil dihapus.');
    }

    private function generateUniqueSlug(string $name): string
    {
        $slug = Str::slug($name);
        $original = $slug;
        $counter = 1;

        while (NewsCategory::where('slug', $slug)->exists()) {
            $slug = "{$original}-{$counter}";
            $counter++;
        }

        return $slug;
    }
}
