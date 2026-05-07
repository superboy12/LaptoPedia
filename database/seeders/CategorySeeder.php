<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $brands = [
            'Apple',
            'Dell',
            'ASUS',
            'Lenovo',
            'HP',
            'Acer',
            'MSI',
            'Samsung',
            'Razer',
            'Microsoft',
        ];

        foreach ($brands as $brand) {
            Category::updateOrCreate(
                ['slug' => Str::slug($brand)],
                ['name' => $brand]
            );
        }
    }
}
