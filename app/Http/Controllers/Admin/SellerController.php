<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\SellerProfile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SellerController extends Controller
{
    public function index(Request $request)
    {
        $query = SellerProfile::with('user')->withCount('products');

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('business_name', 'like', '%' . $request->search . '%')
                  ->orWhere('owner_name', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('status') && $request->status !== 'all') {
            $active = $request->status === 'active';
            $query->whereHas('user', fn ($q) => $q->where('is_active', $active));
        }

        $sellers = $query->latest()->paginate(8)->withQueryString();

        return view('admin.sellers.index', compact('sellers'));
    }

    public function create()
    {
        return view('admin.sellers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'          => 'required|string|max:100',
            'email'         => 'required|email|unique:users,email',
            'password'      => 'required|string|min:8',
            'phone'         => 'nullable|string|max:20',
            'business_name' => 'required|string|max:150',
            'owner_name'    => 'required|string|max:100',
            'description'   => 'nullable|string',
            'address'       => 'required|string',
            'whatsapp'      => 'required|string|max:20',
            'logo'          => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $sellerRole = Role::where('name', 'seller')->firstOrFail();

        DB::transaction(function () use ($validated, $sellerRole, $request) {
            $user = User::create([
                'role_id'   => $sellerRole->id,
                'name'      => $validated['name'],
                'email'     => $validated['email'],
                'password'  => Hash::make($validated['password']),
                'phone'     => $validated['phone'] ?? null,
                'is_active' => true,
            ]);

            $logoPath = $request->hasFile('logo')
                ? $request->file('logo')->store('seller-logos', 'public')
                : null;

            SellerProfile::create([
                'user_id'       => $user->id,
                'business_name' => $validated['business_name'],
                'slug'          => $this->generateUniqueSlug($validated['business_name']),
                'owner_name'    => $validated['owner_name'],
                'description'   => $validated['description'] ?? null,
                'address'       => $validated['address'],
                'whatsapp'      => $validated['whatsapp'],
                'logo'          => $logoPath,
            ]);
        });

        return redirect()->route('admin.sellers.index')->with('success', 'Akun seller berhasil dibuat.');
    }

    public function update(Request $request, SellerProfile $seller)
    {
        $validated = $request->validate([
            'name'          => 'required|string|max:100',
            'email'         => 'required|email|unique:users,email,' . $seller->user_id,
            'phone'         => 'nullable|string|max:20',
            'business_name' => 'required|string|max:150',
            'owner_name'    => 'required|string|max:100',
            'description'   => 'nullable|string',
            'address'       => 'required|string',
            'whatsapp'      => 'required|string|max:20',
            'logo'          => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('logo')) {
            if ($seller->logo) {
                Storage::disk('public')->delete($seller->logo);
            }
            $validated['logo'] = $request->file('logo')->store('seller-logos', 'public');
        }

        $seller->user->update([
            'name'  => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
        ]);

        $seller->update([
            'business_name' => $validated['business_name'],
            'owner_name'    => $validated['owner_name'],
            'description'   => $validated['description'] ?? null,
            'address'       => $validated['address'],
            'whatsapp'      => $validated['whatsapp'],
            'logo'          => $validated['logo'] ?? $seller->logo,
        ]);

        return redirect()->route('admin.sellers.index')->with('success', 'Data seller berhasil diperbarui.');
    }

    public function toggleStatus(SellerProfile $seller)
    {
        $seller->user->update(['is_active' => ! $seller->user->is_active]);

        return back()->with('success', $seller->user->is_active
            ? 'Akun seller diaktifkan kembali.'
            : 'Akun seller dinonaktifkan.');
    }

    public function destroy(SellerProfile $seller)
    {
        if ($seller->products()->exists()) {
            return redirect()->route('admin.sellers.index')
                ->with('error', 'Seller tidak bisa dihapus karena masih memiliki produk.');
        }

        if ($seller->logo) {
            Storage::disk('public')->delete($seller->logo);
        }

        $user = $seller->user;
        $seller->delete();
        $user?->delete();

        return redirect()->route('admin.sellers.index')->with('success', 'Seller berhasil dihapus.');
    }

    private function generateUniqueSlug(string $name): string
    {
        $slug = Str::slug($name);
        $original = $slug;
        $counter = 1;

        while (SellerProfile::where('slug', $slug)->exists()) {
            $slug = "{$original}-{$counter}";
            $counter++;
        }

        return $slug;
    }
}
