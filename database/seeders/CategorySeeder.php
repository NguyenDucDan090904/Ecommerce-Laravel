<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Laptop', 'children' => ['MacBook', 'Gaming', 'Văn phòng']],
            ['name' => 'Điện thoại', 'children' => ['iPhone', 'Samsung', 'Oppo']],
            ['name' => 'Phụ kiện', 'children' => ['Tai nghe', 'Sạc dự phòng', 'Bàn phím']],
        ];

        foreach ($categories as $item) {
            $parent = Category::create([
                'name' => $item['name'],
                'slug' => Str::slug($item['name']),
            ]);

            foreach ($item['children'] as $childName) {
                Category::create([
                    'name' => $childName,
                    'slug' => Str::slug($childName),
                    'parent_id' => $parent->id,
                ]);
            }
        }
    }
}
