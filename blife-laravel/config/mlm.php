<?php

return [
    'base_url' => env('MLM_API_BASE_URL'),
    'token' => env('MLM_API_TOKEN'),
    'timeout' => env('MLM_API_TIMEOUT', 30),
    'enabled' => env('MLM_API_ENABLED', true),
];