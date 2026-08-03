<?php

namespace Database\Seeders;

use App\Models\ProductCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Anyaman Bambu',
            'Kerajinan Tangan',
            'Makanan Olahan',
            'Souvenir',
            'Lainnya',
        ];

        foreach ($categories as $name) {
            ProductCategory::firstOrCreate(
                ['slug' => Str::slug($name)],
                ['name' => $name]
            );
        }
    }
}
