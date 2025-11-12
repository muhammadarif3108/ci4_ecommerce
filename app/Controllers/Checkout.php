<?php

namespace App\Controllers;

use App\Models\OrderModel;

class Checkout extends BaseController
{
    public function index()
    {
        if (!session()->has('user_id')) {
            return redirect()->to(base_url('login'))->with('error', 'Please login to checkout');
        }

        $cart = session()->get('cart') ?? [];

        if (empty($cart)) {
            return redirect()->to(base_url('cart'))->with('error', 'Your cart is empty');
        }

        $data = [
            'title' => 'Checkout',
            'cart' => $cart 
        ];

        return view('checkout', $data);
    }

    public function process()
    {
        if (!session()->has('user_id')) {
            return redirect()->to(base_url('login'))->with('error', 'Please login to checkout');
        }

        $cart = session()->get('cart') ?? [];

        if (empty($cart)) {
            return redirect()->to(base_url('cart'))->with('error', 'Your cart is empty');
        }

        $shippingAddress = $this->request->getPost('shipping_address');
        $totalAmount = 0;

        foreach ($cart as $item) {
            $totalAmount += $item['price'] * $item['quantity'];
        }

        $orderModel = new OrderModel();
        $orderId = $orderModel->createOrder(
            session()->get('user_id'),
            $totalAmount, // +20000 untuk shipping
            $shippingAddress,
            $cart
        );

        session()->remove('cart');

        // Menggunakan base_url()
        return redirect()->to(base_url('order/success/' . $orderId))->with('success', 'Order placed successfully');
    }
}
