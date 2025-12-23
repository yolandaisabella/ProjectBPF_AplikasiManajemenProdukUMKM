<?php

namespace Database\Seeders;

use App\Models\Item;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure categories exist
        $category1 = Category::firstOrCreate(['name' => 'Bubuk Kopi']);
        $category2 = Category::firstOrCreate(['name' => 'Minuman']);

        // Coffee beans
        Product::create(['name' => 'Kopi Arabika Gayo (per kg)', 'description' => 'Kopi arabika premium dari dataran tinggi Gayo', 'stock' => 25, 'price' => 150000, 'category' => $category1->name]);
        Product::create(['name' => 'Kopi Robusta Lampung (per kg)', 'description' => 'Kopi robusta berkualitas dari Lampung', 'stock' => 40, 'price' => 80000, 'category' => $category1->name]);
        Product::create(['name' => 'Kopi Blend Special (per kg)', 'description' => 'Campuran arabika dan robusta untuk rasa balanced', 'stock' => 30, 'price' => 120000, 'category' => $category1->name]);
        Product::create(['name' => 'Kopi Arabika Mandailing (per kg)', 'description' => 'Kopi arabika spesial dari Mandailing', 'stock' => 20, 'price' => 180000, 'category' => $category1->name]);
        Product::create(['name' => 'Kopi Robusta Temanggung (per kg)', 'description' => 'Kopi robusta premium dari Temanggung', 'stock' => 35, 'price' => 95000, 'category' => $category1->name]);

        // Coffee drinks per cup
        Product::create(['name' => 'Espresso (per cup)', 'description' => 'Kopi espresso klasik', 'stock' => 100, 'price' => 15000, 'category' => $category2->name]);
        Product::create(['name' => 'Americano (per cup)', 'description' => 'Kopi americano dengan air panas', 'stock' => 100, 'price' => 18000, 'category' => $category2->name]);
        Product::create(['name' => 'Latte (per cup)', 'description' => 'Kopi latte dengan susu', 'stock' => 100, 'price' => 25000, 'category' => $category2->name]);
        Product::create(['name' => 'Cappuccino (per cup)', 'description' => 'Kopi cappuccino dengan foam susu', 'stock' => 100, 'price' => 22000, 'category' => $category2->name]);
        Product::create(['name' => 'Macchiato (per cup)', 'description' => 'Kopi macchiato dengan sedikit susu', 'stock' => 100, 'price' => 20000, 'category' => $category2->name]);

    }
}
