<?php

return [
    'role' => env('SYNC_ROLE', 'local'),
    'peer_url' => env('SYNC_PEER_URL'),
    'token' => env('SYNC_TOKEN'),

    'tables' => [
        'products',
        'categories',
        'collections',
        'product_images',
        'events',
    ],
];