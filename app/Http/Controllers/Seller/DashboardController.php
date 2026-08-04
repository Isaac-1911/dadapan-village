<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $sellerProfile = $request->user()->sellerProfile;

        // if (!$sellerProfile) {
        //     return redirect()->route('seller.profile.create')
        //         ->with('warning', 'Lengkapi profil UMKM Anda terlebih dahulu.');
        // }

        // $data = [
        //     'sellerProfile' => $sellerProfile,
        //     'totalProducts' => $sellerProfile->products()->count(),
        //     'activeProducts' => $sellerProfile->products()->where('status', true)->count(),
        //     'latestProducts' => $sellerProfile->products()->latest()->take(5)->get(),
        // ];

        return view('seller.dashboard');
    }
}
