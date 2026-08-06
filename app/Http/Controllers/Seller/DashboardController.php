<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $sellerProfile = $request->user()->sellerProfile;

        if (!$sellerProfile) {
            return redirect()->route('seller.profile.create')
                ->with('warning', 'Lengkapi profil UMKM Anda terlebih dahulu.');
        }

        $now = now();
        $products = $sellerProfile->products();

        $totalProducts = (clone $products)->count();
        $activeProducts = (clone $products)->where('status', true)->count();
        $outOfStock = (clone $products)->where('stock', 0)->count();
        $categoryCount = (clone $products)->pluck('category_id')->unique()->count();

        $newThisMonth = (clone $products)
            ->whereMonth('created_at', $now->month)
            ->whereYear('created_at', $now->year)
            ->count();

        $activePercentage = $totalProducts > 0 ? round(($activeProducts / $totalProducts) * 100) : 0;

        // ===== Chart: Upload Produk Bulanan =====
        $monthlyUploads = (clone $products)
            ->whereYear('created_at', $now->year)
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->groupBy('month')
            ->pluck('total', 'month');

        $months = collect(range(1, $now->month));
        $chartLabels = $months->map(fn ($m) => Carbon::create()->month($m)->translatedFormat('M'));
        $chartData = $months->map(fn ($m) => $monthlyUploads->get($m, 0));

        // ===== Produk Terbaru =====
        $recentProducts = (clone $products)->with('category')->latest()->take(5)->get();

        // ===== Aktivitas Terkini =====
        $activity = collect();

        (clone $products)->latest()->take(5)->get()->each(function ($p) use ($activity) {
            $activity->push([
                'label' => $p->status
                    ? "Produk \"{$p->name}\" berhasil diterbitkan"
                    : "Produk \"{$p->name}\" disimpan sebagai draft",
                'time'  => $p->created_at,
                'type'  => $p->status ? 'success' : 'muted',
            ]);
        });

        (clone $products)->where('stock', 0)->latest('updated_at')->take(3)->get()->each(function ($p) use ($activity) {
            $activity->push([
                'label' => "Stok \"{$p->name}\" habis",
                'time'  => $p->updated_at,
                'type'  => 'warning',
            ]);
        });

        if ($sellerProfile->updated_at->gt($sellerProfile->created_at)) {
            $activity->push([
                'label' => 'Profil usaha diperbarui',
                'time'  => $sellerProfile->updated_at,
                'type'  => 'muted',
            ]);
        }

        $activity = $activity->sortByDesc('time')->take(6)->values();

        return view('seller.dashboard', [
            'sellerProfile'    => $sellerProfile,
            'totalProducts'    => $totalProducts,
            'newThisMonth'     => $newThisMonth,
            'activeProducts'   => $activeProducts,
            'activePercentage' => $activePercentage,
            'outOfStock'       => $outOfStock,
            'categoryCount'    => $categoryCount,
            'chartLabels'      => $chartLabels,
            'chartData'        => $chartData,
            'recentProducts'   => $recentProducts,
            'activity'         => $activity,
        ]);
    }
}
