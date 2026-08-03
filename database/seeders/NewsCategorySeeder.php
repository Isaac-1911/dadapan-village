<?php

namespace Database\Seeders;

use App\Models\NewsCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class NewsCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Kegiatan Desa',
            'Pengumuman',
            'UMKM',
            'Pembangunan',
        ];

        foreach ($categories as $name) {
            NewsCategory::firstOrCreate(
                ['slug' => Str::slug($name)],
                ['name' => $name]
            );
        }
    }
}
