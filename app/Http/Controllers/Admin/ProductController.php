<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductImage;
use App\Models\SellerProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['category', 'sellerProfile']);

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category') && $request->category !== 'all') {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status === 'active');
        }

        $products = $query->latest()->paginate(8)->withQueryString();
        $categories = ProductCategory::orderBy('name')->get();
        $sellers = SellerProfile::orderBy('business_name')->get();

        return view('admin.products.index', compact('products', 'categories', 'sellers'));
    }

    public function create()
    {
        $categories = ProductCategory::orderBy('name')->get();
        $sellers = SellerProfile::orderBy('business_name')->get();

        return view('admin.products.create', compact('categories', 'sellers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'seller_profile_id' => 'required|exists:seller_profiles,id',
            'category_id'       => 'required|exists:product_categories,id',
            'name'              => 'required|string|max:150',
            'description'       => 'required|string',
            'price'             => 'required|numeric|min:0',
            'stock'             => 'required|integer|min:0',
            'status'            => 'required|boolean',
            'thumbnail'         => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'images'            => 'nullable|array',
            'images.*'          => 'image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $slug = $this->generateUniqueSlug($validated['name']);
        $thumbnailPath = $request->file('thumbnail')->store('products', 'public');

        $product = Product::create([
            'seller_profile_id' => $validated['seller_profile_id'],
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

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'seller_profile_id' => 'required|exists:seller_profiles,id',
            'category_id'       => 'required|exists:product_categories,id',
            'name'              => 'required|string|max:150',
            'description'       => 'required|string',
            'price'             => 'required|numeric|min:0',
            'stock'             => 'required|integer|min:0',
            'status'            => 'required|boolean',
            'thumbnail'         => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'images'            => 'nullable|array',
            'images.*'          => 'image|mimes:jpg,jpeg,png|max:2048',
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

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Product $product)
    {
        Storage::disk('public')->delete($product->thumbnail);

        foreach ($product->images as $image) {
            Storage::disk('public')->delete($image->image_url);
        }

        $product->delete(); // product_images ikut terhapus lewat cascadeOnDelete di migration

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil dihapus.');
    }

    public function destroyImage(Product $product, ProductImage $image)
    {
        abort_unless($image->product_id === $product->id, 404);

        Storage::disk('public')->delete($image->image_url);
        $image->delete();

        return back()->with('success', 'Gambar produk berhasil dihapus.');
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
