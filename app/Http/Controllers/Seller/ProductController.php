<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $sellerProfile = $request->user()->sellerProfile;

        $query = $sellerProfile->products()->with('category');

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status === 'active');
        }

        $products = $query->latest()->paginate(8)->withQueryString();
        $categories = ProductCategory::orderBy('name')->get();

        return view('seller.products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = ProductCategory::orderBy('name')->get();

        return view('seller.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:product_categories,id',
            'name'        => 'required|string|max:150',
            'description' => 'required|string',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'status'      => 'required|boolean',
            'thumbnail'   => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'images'      => 'nullable|array',
            'images.*'    => 'image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $sellerProfile = $request->user()->sellerProfile;
        $slug = $this->generateUniqueSlug($validated['name']);
        $thumbnailPath = $request->file('thumbnail')->store('products', 'public');

        $product = Product::create([
            'seller_profile_id' => $sellerProfile->id,
            'category_id'       => $validated['category_id'],
            'name'              => $validated['name'],
            'slug'              => $slug,
            'description'       => $validated['description'],
            'price'             => $validated['price'],
            'stock'             => $validated['stock'],
            'status'            => $validated['status'],
            'thumbnail'         => $thumbnailPath,
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_url'  => $image->store('products/gallery', 'public'),
                    'sort_order' => $index,
                ]);
            }
        }

        return redirect()->route('seller.products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function update(Request $request, Product $product)
    {
        $this->authorizeOwnership($request, $product);

        $validated = $request->validate([
            'category_id' => 'required|exists:product_categories,id',
            'name'        => 'required|string|max:150',
            'description' => 'required|string',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'status'      => 'required|boolean',
            'thumbnail'   => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'images'      => 'nullable|array',
            'images.*'    => 'image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('thumbnail')) {
            Storage::disk('public')->delete($product->thumbnail);
            $validated['thumbnail'] = $request->file('thumbnail')->store('products', 'public');
        }

        $product->update($validated);

        if ($request->hasFile('images')) {
            $startOrder = $product->images()->max('sort_order') + 1;
            foreach ($request->file('images') as $index => $image) {
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_url'  => $image->store('products/gallery', 'public'),
                    'sort_order' => $startOrder + $index,
                ]);
            }
        }

        return redirect()->route('seller.products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Request $request, Product $product)
    {
        $this->authorizeOwnership($request, $product);

        Storage::disk('public')->delete($product->thumbnail);

        foreach ($product->images as $image) {
            Storage::disk('public')->delete($image->image_url);
        }

        $product->delete();

        return redirect()->route('seller.products.index')->with('success', 'Produk berhasil dihapus.');
    }

    public function destroyImage(Request $request, Product $product, ProductImage $image)
    {
        $this->authorizeOwnership($request, $product);
        abort_unless($image->product_id === $product->id, 404);

        Storage::disk('public')->delete($image->image_url);
        $image->delete();

        return back()->with('success', 'Gambar produk berhasil dihapus.');
    }

    private function authorizeOwnership(Request $request, Product $product): void
    {
        abort_unless($product->seller_profile_id === $request->user()->sellerProfile->id, 403, 'Anda tidak memiliki akses ke produk ini.');
    }

    private function generateUniqueSlug(string $name): string
    {
        $slug = Str::slug($name);
        $original = $slug;
        $counter = 1;

        while (Product::where('slug', $slug)->exists()) {
            $slug = "{$original}-{$counter}";
            $counter++;
        }

        return $slug;
    }
}
