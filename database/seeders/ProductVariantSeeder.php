<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductVariantSeeder extends Seeder
{
    public function run(): void
    {
        $rings = DB::table('products')
            ->where('category_id', 2)
            ->get();

        foreach ($rings as $ring) {
            foreach (['6', '7', '8'] as $size) {
                DB::table('product_variants')->insert([
                    'product_id' => $ring->id,
                    'variant_name' => 'Size ' . $size,
                    'size' => $size,
                    'color' => $ring->color,
                    'additional_price' => 0,
                    'stock' => 5,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}