<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductCategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = ProductCategory::withCount('products');

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $categories = $query->orderBy('name')->paginate(8)->withQueryString();

        return view('admin.product-categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:100|unique:product_categories,name',
            'icon'        => 'nullable|string|max:100',
            'description' => 'nullable|string',
        ]);

        ProductCategory::create([
            'name'        => $validated['name'],
            'slug'        => $this->generateUniqueSlug($validated['name']),
            'icon'        => $validated['icon'] ?? null,
            'description' => $validated['description'] ?? null,
        ]);

        return redirect()->route('admin.product-categories.index')->with('success', 'Kategori produk berhasil ditambahkan.');
    }

    public function update(Request $request, ProductCategory $productCategory)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:100|unique:product_categories,name,' . $productCategory->id,
            'icon'        => 'nullable|string|max:100',
            'description' => 'nullable|string',
        ]);

        $productCategory->update($validated);
        // slug sengaja gak diubah otomatis, biar link katalog produk per kategori gak putus

        return redirect()->route('admin.product-categories.index')->with('success', 'Kategori produk berhasil diperbarui.');
    }

    public function destroy(ProductCategory $productCategory)
    {
        if ($productCategory->products()->exists()) {
            return redirect()->route('admin.product-categories.index')
                ->with('error', 'Kategori tidak bisa dihapus karena masih dipakai oleh produk.');
        }

        $productCategory->delete();

        return redirect()->route('admin.product-categories.index')->with('success', 'Kategori produk berhasil dihapus.');
    }

    private function generateUniqueSlug(string $name): string
    {
        $slug = Str::slug($name);
        $original = $slug;
        $counter = 1;

        while (ProductCategory::where('slug', $slug)->exists()) {
            $slug = "{$original}-{$counter}";
            $counter++;
        }

        return $slug;
    }
}
