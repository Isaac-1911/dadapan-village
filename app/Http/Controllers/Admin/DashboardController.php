<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\Product;
use App\Models\SellerProfile;
use App\Models\Gallery;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'totalSellers' => SellerProfile::count(),
            'totalProducts' => Product::count(),
            'totalNews' => News::count(),
            'totalGalleries' => Gallery::count(),
            'latestNews' => News::latest()->take(5)->get(),
        ];

        return view('admin.dashboard', $data);
    }
}
