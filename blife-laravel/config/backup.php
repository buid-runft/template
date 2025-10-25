<?php

return [
    'strategy' => 'hybrid',
    'retention_days' => env('BACKUP_RETENTION_DAYS', 30),
    
    'database' => [
        'enabled' => true,
        'schedule' => 'daily',
        'compress' => true,
    ],
    
    'files' => [
        'important_directories' => [
            'storage/app/private/documents',
            'storage/app/public/products',
            'storage/app/public/stores',
        ],
        'exclude_temp_files' => true,
    ],
];