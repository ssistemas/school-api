<?php

return [
    'default' => env('FILESYSTEM_DRIVER', 'local'),

    'cloud' => env('FILESYSTEM_CLOUD', 's3'),

    'disks' => [
        'avatars' => [
            'driver' => 'local',
            'root' => base_path('public_html/storage/avatars'),
            'url' => env('APP_URL').'/storage/avatars',
            'visibility' => 'public',
        ],

        'documents' => [
            'driver' => 'local',
            'root' => storage_path('app/documents'),
            'url' => storage_path('app/documents'),
        ],

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_KEY'),
            'secret' => env('AWS_SECRET'),
            'region' => env('AWS_REGION'),
            'bucket' => env('AWS_BUCKET'),
        ],

        'tmp' => [
            'driver' => 'local',
            'root' => storage_path('app/temporaries'),
            'url' => storage_path('app/temporaries'),
        ],
    ],
];
