<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderModel extends Model
{
    protected $table = 'orders';
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_id', 'total_amount', 'status', 'shipping_address'];
    protected $useTimestamps = false;

    public function createOrder($userId, $totalAmount, $shippingAddress, $cartItems)
    {
        $this->db->transStart();

        $orderData = [
            'user_id' => $userId,
            'total_amount' => $totalAmount,
            'status' => 'pending',
            'shipping_address' => $shippingAddress,
            'created_at' => date('Y-m-d H:i:s')
        ];

        $this->insert($orderData);
        $orderId = $this->getInsertID();

        $orderItemModel = new OrderItemModel();
        foreach ($cartItems as $item) {
            $orderItemModel->insert([
                'order_id' => $orderId,
                'product_id' => $item['id'],
                'quantity' => $item['quantity'],
                'price' => $item['price']
            ]);

            $productModel = new ProductModel();
            $product = $productModel->find($item['id']);
            if ($product) {
                $productModel->update($item['id'], [
                    'stock' => $product['stock'] - $item['quantity']
                ]);
            }
        }

        $this->db->transComplete();

        if ($this->db->transStatus() === false) {
            return false;
        }

        return $orderId;
    }

    public function getUserOrders($userId)
    {
        return $this->where('user_id', $userId)
            ->orderBy('created_at', 'DESC')
            ->findAll();
    }

    // ===== METHOD UNTUK DASHBOARD =====

    public function getAllOrdersWithCustomer()
    {
        return $this->select('orders.*, users.name as customer_name, users.email as customer_email')
            ->join('users', 'users.id = orders.user_id', 'left')
            ->orderBy('orders.created_at', 'DESC')
            ->findAll();
    }

    public function getTotalRevenue()
    {
        $result = $this->select('SUM(total_amount) as total')
            ->whereNotIn('status', ['cancelled'])
            ->first();

        return $result['total'] ?? 0;
    }

    public function getOrderStatistics()
    {
        return [
            'pending' => $this->where('status', 'pending')->countAllResults(),
            'processing' => $this->where('status', 'processing')->countAllResults(),
            'shipped' => $this->where('status', 'shipped')->countAllResults(),
            'delivered' => $this->where('status', 'delivered')->countAllResults(),
            'cancelled' => $this->where('status', 'cancelled')->countAllResults(),
        ];
    }

    public function getRecentOrders($limit = 10)
    {
        return $this->select('orders.*, users.name as customer_name, users.email as customer_email')
            ->join('users', 'users.id = orders.user_id', 'left')
            ->orderBy('orders.created_at', 'DESC')
            ->limit($limit)
            ->findAll();
    }

    // Di OrderModel.php, tambahkan method ini
    public function updateProductSold($orderId)
    {
        $orderItemModel = new OrderItemModel();
        $items = $orderItemModel->where('order_id', $orderId)->findAll();

        $productModel = new ProductModel();
        foreach ($items as $item) {
            $product = $productModel->find($item['product_id']);
            if ($product) {
                $productModel->update($item['product_id'], [
                    'sold' => $product['sold'] + $item['quantity']
                ]);
            }
        }
    }
}
