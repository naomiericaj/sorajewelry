<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ProductImage extends Model
{
    protected $fillable = [
        'product_id',
        'image_path',
        'processed_image_path',
        'is_main',
    ];

    public function getImageUrlAttribute(): string
    {
        if (Str::startsWith($this->image_path, 'products/')) {
            return asset('storage/' . $this->image_path);
        }

        return asset('images/' . $this->image_path);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}