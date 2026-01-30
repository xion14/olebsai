<?php

return [
    // Dashboard variants
    'dashboard_admin' => [1, 2],
    'dashboard_register' => [5],
    'dashboard_user' => [6],
    'dashboard_consumer' => [7],

    // Admin master
    'admin_master' => [1],

    // Seller & product management
    'seller_mgmt' => [1, 2, 6],      // contoh: role 1 menu juga tampil di role 6
    'product_mgmt' => [1, 2, 6],
    'performance' => [1, 2, 6],
    'setting_menu' => [1, 2],

    // Register (SKPD)
    'register_menus' => [5],

    // Consumer (complaint/review/analysis)
    'consumer_menus' => [7],

    // Balance / withdraw / report (admin)
    'balance' => [1, 2],
    'withdraw' => [1, 2],
    'report' => [1, 2],
];
