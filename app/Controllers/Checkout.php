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
        $paymentMethod = $this->request->getPost('payment_method');
        $totalAmount = 0;

        foreach ($cart as $item) {
            $totalAmount += $item['price'] * $item['quantity'];
        }

        $orderModel = new OrderModel();
        $orderId = $orderModel->createOrder(
            session()->get('user_id'),
            $totalAmount,
            $shippingAddress,
            $cart,
            $paymentMethod
        );

        session()->remove('cart');

        // Redirect berdasarkan metode pembayaran
        if ($paymentMethod === 'transfer') {
            return redirect()->to(base_url('payment/' . $orderId))->with('success', 'Order created. Please complete payment.');
        } else {
            return redirect()->to(base_url('order/success/' . $orderId))->with('success', 'Order placed successfully');
        }
    }
}
