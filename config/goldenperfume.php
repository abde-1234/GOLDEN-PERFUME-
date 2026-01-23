<?php

return [
    'whatsapp_number' => env('WHATSAPP_NUMBER', '212600000000'),

    'currency' => env('SHOP_CURRENCY', 'DH'),

    'shop_name' => env('SHOP_NAME', 'GOLDEN PERFUME'),

    'admin_email' => env('ADMIN_EMAIL'),

    'admin_code' => env('ADMIN_CODE'),

    'admin_emails' => env('ADMIN_EMAILS'),

    'shipping_fee' => env('SHOP_SHIPPING_FEE', 20),
    'free_shipping_threshold' => env('SHOP_FREE_SHIPPING_THRESHOLD', 200),
    'min_order_total' => env('SHOP_MIN_ORDER_TOTAL', 50),
];
