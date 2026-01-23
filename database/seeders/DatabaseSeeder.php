<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // منتجات تجريبية
        Product::query()->delete();

        Product::create([
            'name' => 'Golden Perfume - Blue',
            'category' => 'perfume',
            'short_description' => 'عطر منعش وثابت، مناسب للاستعمال اليومي.',
            'price' => 79.00,
            'image_path' => 'images/blue-green-grass.png',
            'is_active' => true,
        ]);

        Product::create([
            'name' => 'Golden Perfume - Green',
            'category' => 'perfume',
            'short_description' => 'نفحات خضراء أنيقة مع لمسة حمضية خفيفة.',
            'price' => 79.00,
            'image_path' => 'images/blue-green-tree.png',
            'is_active' => true,
        ]);

        Product::create([
            'name' => 'Golden Perfume - Black',
            'category' => 'perfume',
            'short_description' => 'عطر فخم بلمسة دافئة ومناسبة للمناسبات.',
            'price' => 89.00,
            'image_path' => 'images/black-rock.png',
            'is_active' => true,
        ]);

        Product::create([
            'name' => 'Le Pack (مجموعة)',
            'category' => 'pack',
            'short_description' => 'باك يجمع أكثر العطور طلباً بسعر خاص.',
            'price' => 199.00,
            'image_path' => 'images/box-pack.png',
            'is_active' => true,
        ]);
    }
}
