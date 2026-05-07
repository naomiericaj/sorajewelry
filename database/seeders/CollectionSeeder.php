<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CollectionSeeder extends Seeder
{
    public function run(): void
    {
        $collections = [
            [
                'name' => 'Aurora Collection',
                'description' => 'Elegant jewelry pieces inspired by soft light, pearls, and timeless details.',
                'image' => 'collections/aurora-collection.jpg',
            ],
            [
                'name' => 'Celeste Collection',
                'description' => 'Modern jewelry with a clean, minimal, and artistic style.',
                'image' => 'collections/celeste-collection.jpg',
            ],
        ];

        foreach ($collections as $collection) {
            DB::table('collections')->insert([
                'name' => $collection['name'],
                'slug' => Str::slug($collection['name']),
                'description' => $collection['description'],
                'image' => $collection['image'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}