<?php

return [
    'server_key' => env('MIDTRANS_SERVER_KEY', 'SB-Mid-server-test-key-demo'),
    'client_key' => env('MIDTRANS_CLIENT_KEY', 'SB-Mid-client-test-key-demo'),
    'is_production' => env('MIDTRANS_IS_PRODUCTION', false),
    'is_sanitized' => true,
    'is_3ds' => true,
];

