<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\News;
use App\Models\Product;
use App\Models\SellerProfile;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $now = now();

        $stats = [
            'sellers'   => $this->buildStat(SellerProfile::class),
            'products'  => $this->buildStat(Product::class),
            'news'      => $this->buildStat(News::class),
            'galleries' => $this->buildStat(Gallery::class),
        ];

        // ===== Unggahan Produk Bulanan (line chart) =====
        $monthlyProducts = Product::whereYear('created_at', $now->year)
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->groupBy('month')
            ->pluck('total', 'month');

        $months = collect(range(1, $now->month));
        $productChartLabels = $months->map(fn ($m) => Carbon::create()->month($m)->translatedFormat('M'));
        $productChartData = $months->map(fn ($m) => $monthlyProducts->get($m, 0));

        // ===== Publikasi Berita Bulanan (bar chart) =====
        $monthlyNews = News::whereYear('published_at', $now->year)
            ->whereNotNull('published_at')
            ->selectRaw('MONTH(published_at) as month, COUNT(*) as total')
            ->groupBy('month')
            ->pluck('total', 'month');

        $newsChartData = $months->map(fn ($m) => $monthlyNews->get($m, 0));

        // ===== Distribusi Kategori Produk (donut chart) =====
        $categoryDistribution = Product::selectRaw('category_id, COUNT(*) as total')
            ->groupBy('category_id')
            ->with('category')
            ->get()
            ->map(fn ($row) => [
                'name'  => $row->category->name ?? 'Lainnya',
                'total' => $row->total,
            ])
            ->sortByDesc('total')
            ->values();

        // ===== Data terbaru =====
        $recentProducts = Product::with(['category', 'sellerProfile'])->latest()->take(5)->get();
        $recentNews = News::with(['category', 'author'])->latest()->take(5)->get();
        $recentSellers = SellerProfile::with('user')->latest()->take(5)->get();

        // ===== Aktivitas terkini (gabungan feed) =====
        $activity = collect()
            ->merge(Product::latest()->take(4)->get()->map(fn ($p) => [
                'type' => 'product', 'label' => "Produk baru \"{$p->name}\" ditambahkan", 'time' => $p->created_at,
            ]))
            ->merge(News::latest()->take(4)->get()->map(fn ($n) => [
                'type' => 'news', 'label' => "Berita \"{$n->title}\" dipublikasikan", 'time' => $n->created_at,
            ]))
            ->merge(Gallery::latest()->take(4)->get()->map(fn ($g) => [
                'type' => 'gallery', 'label' => "Galeri \"{$g->title}\" ditambahkan", 'time' => $g->created_at,
            ]))
            ->merge(SellerProfile::latest()->take(4)->get()->map(fn ($s) => [
                'type' => 'seller', 'label' => "Seller \"{$s->business_name}\" bergabung", 'time' => $s->created_at,
            ]))
            ->sortByDesc('time')
            ->take(8)
            ->values();

        return view('admin.dashboard', compact(
            'stats',
            'productChartLabels', 'productChartData', 'newsChartData',
            'categoryDistribution',
            'recentProducts', 'recentNews', 'recentSellers',
            'activity'
        ));
    }

    private function buildStat(string $model): array
    {
        $now = now();
        $lastMonth = $now->copy()->subMonth();

        $thisMonthCount = $model::whereMonth('created_at', $now->month)
            ->whereYear('created_at', $now->year)->count();

        $lastMonthCount = $model::whereMonth('created_at', $lastMonth->month)
            ->whereYear('created_at', $lastMonth->year)->count();

        $percentage = $lastMonthCount > 0
            ? round((($thisMonthCount - $lastMonthCount) / $lastMonthCount) * 100)
            : ($thisMonthCount > 0 ? 100 : 0);

        return [
            'total'      => $model::count(),
            'percentage' => abs($percentage),
            'trend'      => $percentage >= 0 ? 'up' : 'down',
        ];
    }
}
