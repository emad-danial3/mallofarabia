<?php 


return [
    'save_order_link' => env('APP_ENV') === 'production' ? 'https://sales.atr-eg.com/api/save_order_mall_of_arabia_test.php':'https://sales.atr-eg.com/api/save_order_mall_of_arabia_test.php',
    'refresh_order_link' => env('APP_ENV') === 'production' ? 'https://sales.atr-eg.com/api/RefreshNettinghubInvoices.php' :'https://sales.atr-eg.com/api/RefreshNettinghubInvoices.php',
    'save_order_link' => env('APP_ENV') === 'production' ? 'https://sales.atr-eg.com/api/RefreshNettinghubInvoices.php' :'https://sales.atr-eg.com/api/RefreshNettinghubInvoices.php',
    'item_avalability_link' => env('APP_ENV') === 'production' ? 'https://sales.atr-eg.com/api/get_NettinghubItems_item_avalability.php' :'https://sales.atr-eg.com/api/get_NettinghubItems_item_avalability.php',
  
]; 