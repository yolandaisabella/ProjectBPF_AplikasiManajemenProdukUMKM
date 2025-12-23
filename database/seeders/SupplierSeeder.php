<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Supplier::create(['name' => 'PT. Elektronik Indonesia', 'contact_email' => 'contact@elektronik.co.id', 'contact_phone' => '08123456789', 'address' => 'Jakarta']);
        \App\Models\Supplier::create(['name' => 'CV. Pakaian Nusantara', 'contact_email' => 'contact@pakaian.co.id', 'contact_phone' => '08198765432', 'address' => 'Bandung']);
        \App\Models\Supplier::create(['name' => 'UD. Makanan Sehat', 'contact_email' => 'contact@makanan.co.id', 'contact_phone' => '08111222333', 'address' => 'Surabaya']);
        \App\Models\Supplier::create(['name' => 'PT. Furnitur Modern', 'contact_email' => 'contact@furnitur.co.id', 'contact_phone' => '08144555666', 'address' => 'Semarang']);
        \App\Models\Supplier::create(['name' => 'CV. Otomotif Maju', 'contact_email' => 'contact@otomotif.co.id', 'contact_phone' => '08177888999', 'address' => 'Yogyakarta']);
    }
}
