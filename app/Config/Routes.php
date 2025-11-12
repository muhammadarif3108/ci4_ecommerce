<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Home Routes
$routes->get('/', 'Home::index');
$routes->get('product/(:num)', 'Home::product/$1');
$routes->get('category/(:num)', 'Home::category/$1');
$routes->get('search', 'Home::search');

// Cart Routes
$routes->get('cart', 'Cart::index');
$routes->post('cart/add', 'Cart::add');
$routes->post('cart/update', 'Cart::update');
$routes->get('cart/remove/(:num)', 'Cart::remove/$1');
$routes->get('cart/clear', 'Cart::clear');

// Checkout Routes
$routes->get('checkout', 'Checkout::index');
$routes->post('checkout/process', 'Checkout::process');
$routes->get('order/success/(:num)', 'Order::success/$1');

// Order Routes
$routes->get('order/success/(:num)', 'Order::success/$1');
$routes->get('orders', 'Order::index');
$routes->get('order/detail/(:num)', 'Order::detail/$1');

// Auth Routes
$routes->get('login', 'Auth::login');
$routes->post('login/process', 'Auth::loginProcess');
$routes->get('register', 'Auth::register');
$routes->post('register/process', 'Auth::registerProcess');
$routes->get('logout', 'Auth::logout');

// User Profile Routes (authenticated)
$routes->group('', ['filter' => 'auth'], function ($routes) {
    $routes->get('profile', 'User::profile');
    $routes->post('profile/update', 'User::updateProfile');
    $routes->get('orders', 'Order::index');
    $routes->get('order/detail/(:num)', 'Order::detail/$1');
});

// Admin Auth Routes
$routes->get('admin/login', 'Admin\Auth::login');
$routes->post('admin/login/process', 'Admin\Auth::loginProcess');
$routes->get('admin/logout', 'Admin\Auth::logout');

// Admin Routes (protected)
$routes->group('admin', function ($routes) {
    $routes->get('/', 'Admin\Dashboard::index');

    // Products
    $routes->get('products', 'Admin\Product::index');
    $routes->get('products/add', 'Admin\Product::add');
    $routes->post('products/save', 'Admin\Product::save');
    $routes->get('products/edit/(:num)', 'Admin\Product::edit/$1');
    $routes->post('products/update/(:num)', 'Admin\Product::update/$1');
    $routes->get('products/delete/(:num)', 'Admin\Product::delete/$1');

    // Orders
    $routes->get('orders', 'Admin\Order::index');
    $routes->get('orders/detail/(:num)', 'Admin\Order::detail/$1');
    $routes->post('orders/update-status/(:num)', 'Admin\Order::updateStatus/$1');

    // Categories
    $routes->get('categories', 'Admin\Category::index');
    $routes->post('categories/save', 'Admin\Category::save');
    $routes->post('categories/update/(:num)', 'Admin\Category::update/$1');
    $routes->get('categories/delete/(:num)', 'Admin\Category::delete/$1');
});
