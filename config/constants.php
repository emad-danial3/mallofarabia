<?php 


return [
    'save_order_link' => env('APP_ENV') === 'production' ? 'https://sales.atr-eg.com/api/mallofarabiaTest.php':'http://sales.atr-eg.com/api/mallofarabiaTest.php',
    'refresh_order_link' => env('APP_ENV') === 'production' ? 'https://sales.atr-eg.com/api/RefreshNettinghubInvoices.php' :'http://sales.atr-eg.com/api/RefreshNettinghubInvoices.php',
    'item_avalability_link' => env('APP_ENV') === 'production' ? 'https://sales.atr-eg.com/api/get_NettinghubItems_item_avalability.php' :'http://sales.atr-eg.com/api/get_NettinghubItems_item_avalability.php',
  
]; 