<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $iphoneCategory = Category::where('name', 'iPhone')->first();

        Product::create([
            'category_id' => $iphoneCategory->id,
            'name'        => 'iPhone 15 Pro Max 256GB',
            'slug'        => Str::slug('iPhone 15 Pro Max 256GB'),
            'description' => 'Siêu phẩm mới nhất từ Apple với khung viền Titan.',
            'price'       => 34990000,
            'stock'       => 50,
            'is_active'   => true,
            'attributes'  => [
                'screen' => '6.7 inch, Super Retina XDR',
                'cpu'    => 'A17 Pro',
                'ram'    => '8GB',
                'storage'=> '256GB'
            ]
        ]);

    }
}
