<?php

namespace Database\Seeders;

use App\Models\Item;
use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
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
        Item::create(['name' => 'Kopi Arabika Gayo (per kg)', 'category_id' => $category1->id, 'description' => 'Kopi arabika premium dari dataran tinggi Gayo', 'stock' => 25, 'price' => 150000]);
        Item::create(['name' => 'Kopi Robusta Lampung (per kg)', 'category_id' => $category1->id, 'description' => 'Kopi robusta berkualitas dari Lampung', 'stock' => 40, 'price' => 80000]);
        Item::create(['name' => 'Kopi Blend Special (per kg)', 'category_id' => $category1->id, 'description' => 'Campuran arabika dan robusta untuk rasa balanced', 'stock' => 30, 'price' => 120000]);
        Item::create(['name' => 'Kopi Arabika Mandailing (per kg)', 'category_id' => $category1->id, 'description' => 'Kopi arabika spesial dari Mandailing', 'stock' => 20, 'price' => 180000]);
        Item::create(['name' => 'Kopi Robusta Temanggung (per kg)', 'category_id' => $category1->id, 'description' => 'Kopi robusta premium dari Temanggung', 'stock' => 35, 'price' => 95000]);

        // Coffee drinks per cup
        Item::create(['name' => 'Espresso (per cup)', 'category_id' => $category2->id, 'description' => 'Kopi espresso klasik', 'stock' => 100, 'price' => 15000]);
        Item::create(['name' => 'Americano (per cup)', 'category_id' => $category2->id, 'description' => 'Kopi americano dengan air panas', 'stock' => 100, 'price' => 18000]);
        Item::create(['name' => 'Latte (per cup)', 'category_id' => $category2->id, 'description' => 'Kopi latte dengan susu', 'stock' => 100, 'price' => 25000]);
        Item::create(['name' => 'Cappuccino (per cup)', 'category_id' => $category2->id, 'description' => 'Kopi cappuccino dengan foam susu', 'stock' => 100, 'price' => 22000]);
        Item::create(['name' => 'Macchiato (per cup)', 'category_id' => $category2->id, 'description' => 'Kopi macchiato dengan sedikit susu', 'stock' => 100, 'price' => 20000]);
    }
}
