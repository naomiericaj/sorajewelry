<?php

use App\Models\ProductImage;

describe('Product image asset URLs', function () {
    it('returns a storage URL for seeded product images', function () {
        $image = new ProductImage([
            'image_path' => 'products/solene-circle-necklace.jpg',
        ]);

        expect($image->image_url)
            ->toContain('/storage/products/solene-circle-necklace.jpg');
    });

    it('returns a public images URL for uploaded image files', function () {
        $image = new ProductImage([
            'image_path' => 'sample-image.jpg',
        ]);

        expect($image->image_url)
            ->toContain('/images/sample-image.jpg');
    });
});
