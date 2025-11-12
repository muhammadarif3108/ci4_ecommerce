<?php
// app/Controllers/Admin/Order.php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\OrderModel;
use App\Models\OrderItemModel;

class Order extends BaseController
{
    protected $orderModel;
    protected $orderItemModel;

    public function __construct()
    {
        $this->orderModel = new OrderModel();
        $this->orderItemModel = new OrderItemModel();
    }

    public function index()
    {
        if (!session()->get('is_admin')) {
            return redirect()->to('/admin/login');
        }

        $orders = $this->orderModel->select('orders.*, users.name as customer_name, users.email as customer_email')
            ->join('users', 'users.id = orders.user_id')
            ->orderBy('orders.created_at', 'DESC')
            ->findAll();

        $data = [
            'title' => 'Manage Orders',
            'orders' => $orders
        ];

        return view('admin/orders/index', $data);
    }

    public function detail($id)
    {
        if (!session()->get('is_admin')) {
            return redirect()->to('/admin/login');
        }

        $order = $this->orderModel->select('orders.*, users.name as customer_name, users.email as customer_email, users.phone as customer_phone')
            ->join('users', 'users.id = orders.user_id')
            ->where('orders.id', $id)
            ->first();

        if (!$order) {
            return redirect()->to('/admin/orders')->with('error', 'Order not found');
        }

        $orderItems = $this->orderItemModel->getOrderItems($id);

        $data = [
            'title' => 'Order Detail #' . $id,
            'order' => $order,
            'orderItems' => $orderItems
        ];

        return view('admin/orders/detail', $data);
    }

    public function updateStatus($id)
    {
        if (!session()->get('is_admin')) {
            return redirect()->to('/admin/login');
        }

        $status = $this->request->getPost('status');

        if ($this->orderModel->update($id, ['status' => $status])) {
            return redirect()->back()->with('success', 'Order status updated successfully');
        }

        return redirect()->back()->with('error', 'Failed to update order status');
    }
}
