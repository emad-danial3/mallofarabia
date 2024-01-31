<?php


return [
    'save_order_link' => env('APP_ENV') === 'production' ? 'https://sales.atr-eg.com/api/mallofarabia.php':'http://sales.atr-eg.com/api/mallofarabiaTest.php',
    'refresh_order_link' => env('APP_ENV') === 'production' ? 'https://sales.atr-eg.com/api/RefreshNettinghubInvoices.php' :'http://sales.atr-eg.com/api/RefreshNettinghubInvoices.php',
    'item_avalability_link' => env('APP_ENV') === 'production' ? 'https://sales.atr-eg.com/api/get_NettinghubItems_item_avalability.php' :'http://sales.atr-eg.com/api/get_NettinghubItems_item_avalability.php',
    'refresh_mall_items' => env('APP_ENV') === 'production' ? 'https://sales.atr-eg.com/api/RefreshMallItems.php' :'http://sales.atr-eg.com/api/RefreshMallItems.php',
    'is_valid_mall_invoice' => env('APP_ENV') === 'production' ? 'https://sales.atr-eg.com/api/is_valid_mall_invoice.php' :'http://sales.atr-eg.com/api/is_valid_mall_invoice.php',
    'page_items_count' => 20,
    'oil_ids' =>[10037,10039,10038,10040,10041,10042,10043,10044,10045,10046,10047,10048] ,
    'oil_our_ids' =>[2999,3000,3001,3002,3003,3004,3005,3006,3007,3008,3009,3010]
] ;
