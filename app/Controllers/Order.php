<?php

namespace App\Controllers;

use App\Models\OrderModel;
use App\Models\OrderItemModel;

class Order extends BaseController
{
    public function success($orderId)
    {
        if (!session()->has('user_id')) {
            return redirect()->to('/login');
        }

        $orderModel = new OrderModel();
        $order = $orderModel->select('orders.*, users.name as customer_name, users.email as customer_email')
            ->join('users', 'users.id = orders.user_id')
            ->where('orders.id', $orderId)
            ->where('orders.user_id', session()->get('user_id'))
            ->first();

        if (!$order) {
            return redirect()->to('/')->with('error', 'Order not found');
        }

        $orderItemModel = new OrderItemModel();
        $orderItems = $orderItemModel->getOrderItems($orderId);

        $data = [
            'title' => 'Order Success',
            'order' => $order,
            'orderItems' => $orderItems
        ];

        return view('order/success', $data);
    }

    public function index()
    {
        if (!session()->has('user_id')) {
            return redirect()->to('/login');
        }

        $orderModel = new OrderModel();
        $orders = $orderModel->getUserOrders(session()->get('user_id'));

        $data = [
            'title' => 'My Orders',
            'orders' => $orders
        ];

        return view('order/index', $data);
    }

    public function detail($orderId)
    {
        if (!session()->has('user_id')) {
            return redirect()->to('/login');
        }

        $orderModel = new OrderModel();
        $order = $orderModel->select('orders.*, users.name as customer_name, users.email as customer_email')
            ->join('users', 'users.id = orders.user_id')
            ->where('orders.id', $orderId)
            ->where('orders.user_id', session()->get('user_id'))
            ->first();

        if (!$order) {
            return redirect()->to('/orders')->with('error', 'Order not found');
        }

        $orderItemModel = new OrderItemModel();
        $orderItems = $orderItemModel->getOrderItems($orderId);

        $data = [
            'title' => 'Order Detail',
            'order' => $order,
            'orderItems' => $orderItems
        ];

        return view('order/detail', $data);
    }

    public function confirmDelivery($orderId)
    {
        if (!session()->has('user_id')) {
            return redirect()->to('/login');
        }

        $orderModel = new OrderModel();
        $order = $orderModel->where('id', $orderId)
            ->where('user_id', session()->get('user_id'))
            ->first();

        if (!$order) {
            return redirect()->to('/orders')->with('error', 'Order not found');
        }

        // Only allow confirmation if status is 'shipped'
        if ($order['status'] !== 'shipped') {
            return redirect()->back()->with('error', 'Order cannot be confirmed at this stage');
        }

        // Update status to 'delivered'
        $updated = $orderModel->update($orderId, [
            'status' => 'delivered',
            'delivered_at' => date('Y-m-d H:i:s')
        ]);

        if ($updated) {
            return redirect()->to('/order/detail/' . $orderId)
                ->with('success', 'Terima kasih! Pesanan telah dikonfirmasi diterima');
        }

        return redirect()->back()->with('error', 'Failed to confirm delivery');
    }
}
