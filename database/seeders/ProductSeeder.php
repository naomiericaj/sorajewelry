<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            // NECKLACE
            [
                'category_id' => 1,
                'collection_id' => 1,
                'name' => 'Aurora Pendant Necklace',
                'price' => 275000,
                'stock' => 12,
                'material' => 'Stainless Steel',
                'color' => 'Silver',
                'image' => 'products/aurora-pendant-necklace.jpg',
                'is_featured' => true,
            ],
            [
                'category_id' => 1,
                'collection_id' => 1,
                'name' => 'Celeste Layered Necklace',
                'price' => 320000,
                'stock' => 10,
                'material' => 'Stainless Steel',
                'color' => 'Silver',
                'image' => 'products/celeste-layered-necklace.jpg',
                'is_featured' => true,
            ],
            [
                'category_id' => 1,
                'collection_id' => 1,
                'name' => 'Lumière Pearl Necklace',
                'price' => 350000,
                'stock' => 8,
                'material' => 'Pearl',
                'color' => 'White',
                'image' => 'products/lumiere-pearl-necklace.jpg',
                'is_featured' => true,
            ],
            [
                'category_id' => 1,
                'collection_id' => 1,
                'name' => 'Nova Lock Necklace',
                'price' => 295000,
                'stock' => 15,
                'material' => 'Stainless Steel',
                'color' => 'Silver',
                'image' => 'products/nova-lock-necklace.jpg',
                'is_featured' => false,
            ],
            [
                'category_id' => 1,
                'collection_id' => 1,
                'name' => 'Solene Circle Necklace',
                'price' => 285000,
                'stock' => 11,
                'material' => 'Stainless Steel',
                'color' => 'Gold',
                'image' => 'products/solene-circle-necklace.jpg',
                'is_featured' => false,
            ],

            // RING
            [
                'category_id' => 2,
                'collection_id' => 1,
                'name' => 'Aurelia Solitaire Ring',
                'price' => 250000,
                'stock' => 14,
                'material' => 'Stainless Steel',
                'color' => 'Silver',
                'image' => 'products/aurelia-solitaire-ring.jpg',
                'is_featured' => true,
            ],
            [
                'category_id' => 2,
                'collection_id' => 1,
                'name' => 'Elara Twist Ring',
                'price' => 230000,
                'stock' => 18,
                'material' => 'Stainless Steel',
                'color' => 'Gold',
                'image' => 'products/elara-twist-ring.jpg',
                'is_featured' => false,
            ],
            [
                'category_id' => 2,
                'collection_id' => 1,
                'name' => 'Lyra Adjustable Ring',
                'price' => 215000,
                'stock' => 20,
                'material' => 'Stainless Steel',
                'color' => 'Silver',
                'image' => 'products/lyra-adjustable-ring.jpg',
                'is_featured' => false,
            ],
            [
                'category_id' => 2,
                'collection_id' => 1,
                'name' => 'Celestia Eternity Ring',
                'price' => 290000,
                'stock' => 9,
                'material' => 'Stainless Steel',
                'color' => 'Silver',
                'image' => 'products/celestia-eternity-ring.jpg',
                'is_featured' => true,
            ],
            [
                'category_id' => 2,
                'collection_id' => 1,
                'name' => 'Orion Signet Ring',
                'price' => 270000,
                'stock' => 13,
                'material' => 'Stainless Steel',
                'color' => 'Gold',
                'image' => 'products/orion-signet-ring.jpg',
                'is_featured' => false,
            ],

            // BRACELET
            [
                'category_id' => 3,
                'collection_id' => 2,
                'name' => 'Dainty Stone Bracelet',
                'price' => 260000,
                'stock' => 10,
                'material' => 'Stainless Steel',
                'color' => 'Silver',
                'image' => 'products/dainty-stone-bracelet.jpg',
                'is_featured' => true,
            ],
            [
                'category_id' => 3,
                'collection_id' => 2,
                'name' => 'Aura Link Bracelet',
                'price' => 310000,
                'stock' => 7,
                'material' => 'Stainless Steel',
                'color' => 'Gold',
                'image' => 'products/aura-link-bracelet.jpg',
                'is_featured' => false,
            ],
            [
                'category_id' => 3,
                'collection_id' => 2,
                'name' => 'Radiant Tennis Bracelet',
                'price' => 390000,
                'stock' => 6,
                'material' => 'Stainless Steel',
                'color' => 'Silver',
                'image' => 'products/radiant-tennis-bracelet.jpg',
                'is_featured' => true,
            ],
            [
                'category_id' => 3,
                'collection_id' => 2,
                'name' => 'Celeste Charm Bracelet',
                'price' => 280000,
                'stock' => 12,
                'material' => 'Stainless Steel',
                'color' => 'Silver',
                'image' => 'products/celeste-charm-bracelet.jpg',
                'is_featured' => false,
            ],
            [
                'category_id' => 3,
                'collection_id' => 2,
                'name' => 'Knot Bangle Bracelet',
                'price' => 335000,
                'stock' => 8,
                'material' => 'Stainless Steel',
                'color' => 'Gold',
                'image' => 'products/knot-bangle-bracelet.jpg',
                'is_featured' => false,
            ],

            // EARRINGS
            [
                'category_id' => 4,
                'collection_id' => 2,
                'name' => 'Classic Stud Earrings',
                'price' => 190000,
                'stock' => 22,
                'material' => 'Stainless Steel',
                'color' => 'Silver',
                'image' => 'products/classic-stud-earrings.jpg',
                'is_featured' => true,
            ],
            [
                'category_id' => 4,
                'collection_id' => 2,
                'name' => 'Timeless Hoop Earrings',
                'price' => 240000,
                'stock' => 16,
                'material' => 'Stainless Steel',
                'color' => 'Gold',
                'image' => 'products/timeless-hoop-earrings.jpg',
                'is_featured' => true,
            ],
            [
                'category_id' => 4,
                'collection_id' => 2,
                'name' => 'Nova Drop Earrings',
                'price' => 260000,
                'stock' => 11,
                'material' => 'Stainless Steel',
                'color' => 'Silver',
                'image' => 'products/nova-drop-earrings.jpg',
                'is_featured' => false,
            ],
            [
                'category_id' => 4,
                'collection_id' => 2,
                'name' => 'Pearl Drop Earrings',
                'price' => 285000,
                'stock' => 9,
                'material' => 'Pearl',
                'color' => 'White',
                'image' => 'products/pearl-drop-earrings.jpg',
                'is_featured' => true,
            ],
            [
                'category_id' => 4,
                'collection_id' => 2,
                'name' => 'Luxe Ear Cuff',
                'price' => 175000,
                'stock' => 25,
                'material' => 'Stainless Steel',
                'color' => 'Silver',
                'image' => 'products/luxe-ear-cuff.jpg',
                'is_featured' => false,
            ],
        ];

        $availableImages = array_values(Storage::disk('public_images')->files());

        if ($availableImages === []) {
            throw new \RuntimeException('No product images are available in public/images for seeding.');
        }

        foreach ($products as $index => $product) {
            $imagePath = basename($availableImages[$index % count($availableImages)]);

            $productId = DB::table('products')->insertGetId([
                'category_id' => $product['category_id'],
                'collection_id' => $product['collection_id'],
                'name' => $product['name'],
                'slug' => Str::slug($product['name']),
                'description' => 'A minimal and elegant jewelry piece designed for everyday wear.',
                'price' => $product['price'],
                'discount_price' => null,
                'stock' => $product['stock'],
                'material' => $product['material'],
                'color' => $product['color'],
                'status' => 'active',
                'is_featured' => $product['is_featured'],
                'view_count' => rand(10, 200),
                'sold_count' => rand(0, 50),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('product_images')->insert([
                'product_id' => $productId,
                'image_path' => $imagePath,
                'processed_image_path' => null,
                'is_main' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}