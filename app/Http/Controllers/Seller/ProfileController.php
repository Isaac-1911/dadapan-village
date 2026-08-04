<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\SellerProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    public function create(Request $request)
    {
        // Kalau profil udah ada, jangan biarin bikin duplikat, arahin ke edit
        if ($request->user()->sellerProfile) {
            return redirect()->route('seller.profile.edit');
        }

        return view('seller.profile.create');
    }

    public function store(Request $request)
    {
        if ($request->user()->sellerProfile) {
            return redirect()->route('seller.dashboard');
        }

        $validated = $request->validate([
            'business_name' => 'required|string|max:150',
            'owner_name'    => 'required|string|max:100',
            'description'   => 'nullable|string',
            'address'       => 'required|string',
            'whatsapp'      => 'required|string|max:20',
            'logo'          => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $slug = Str::slug($validated['business_name']);
        $originalSlug = $slug;
        $counter = 1;
        while (SellerProfile::where('slug', $slug)->exists()) {
            $slug = "{$originalSlug}-{$counter}";
            $counter++;
        }

        $logoPath = null;
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('seller-logos', 'public');
        }

        SellerProfile::create([
            'user_id'      => $request->user()->id,
            'business_name'=> $validated['business_name'],
            'slug'         => $slug,
            'owner_name'   => $validated['owner_name'],
            'description'  => $validated['description'] ?? null,
            'address'      => $validated['address'],
            'whatsapp'     => $validated['whatsapp'],
            'logo'         => $logoPath,
        ]);

        return redirect()->route('seller.dashboard')
            ->with('success', 'Profil UMKM berhasil dibuat.');
    }

    public function edit(Request $request)
    {
        $sellerProfile = $request->user()->sellerProfile;

        if (!$sellerProfile) {
            return redirect()->route('seller.profile.create');
        }

        return view('seller.profile.edit', compact('sellerProfile'));
    }

    public function update(Request $request)
    {
        $sellerProfile = $request->user()->sellerProfile;

        if (!$sellerProfile) {
            return redirect()->route('seller.profile.create');
        }

        $validated = $request->validate([
            'business_name' => 'required|string|max:150',
            'owner_name'    => 'required|string|max:100',
            'description'   => 'nullable|string',
            'address'       => 'required|string',
            'whatsapp'      => 'required|string|max:20',
            'logo'          => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('logo')) {
            if ($sellerProfile->logo) {
                Storage::disk('public')->delete($sellerProfile->logo);
            }
            $validated['logo'] = $request->file('logo')->store('seller-logos', 'public');
        }

        // Slug gak diubah otomatis saat update, biar link produk yang udah share gak putus
        $sellerProfile->update($validated);

        return redirect()->route('seller.dashboard')
            ->with('success', 'Profil UMKM berhasil diperbarui.');
    }
}
