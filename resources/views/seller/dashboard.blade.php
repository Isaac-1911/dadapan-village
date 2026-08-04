@extends('layouts.admin')

@section('page-title', 'Dashboard')

@section('content')
    <h1 class="text-2xl font-bold text-gray-900">Selamat Datang, {{ auth()->user()->name }} 👋</h1>
    <p class="text-gray-500 text-sm mt-1">Portal Administrasi Desa Dadapan</p>

    <div class="mt-6">
        {{-- statistik cards nanti kita bikin di sini --}}
        <p>Total Seller: {{ $totalSellers }}</p>
        <p>Total Produk: {{ $totalProducts }}</p>
        <p>Total Berita: {{ $totalNews }}</p>
        <p>Total Galeri: {{ $totalGalleries }}</p>
    </div>
@endsection
