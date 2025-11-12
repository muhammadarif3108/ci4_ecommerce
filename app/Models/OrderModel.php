<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderModel extends Model
{
    protected $table = 'orders';
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_id', 'total_amount', 'status', 'shipping_address'];

    // NONAKTIFKAN TIMESTAMPS - INI PENYEBAB ERROR
    protected $useTimestamps = false;  // Ubah dari true ke false

    // Hapus atau comment baris ini:
    // protected $createdField = 'created_at';
    // protected $updatedField = 'updated_at';

    public function createOrder($userId, $totalAmount, $shippingAddress, $cartItems)
    {
        $this->db->transStart();

        // Insert order
        $orderData = [
            'user_id' => $userId,
            'total_amount' => $totalAmount,
            'status' => 'pending',
            'shipping_address' => $shippingAddress,
            'created_at' => date('Y-m-d H:i:s')  // Tambahkan manual
        ];

        $this->insert($orderData);
        $orderId = $this->getInsertID();  // Gunakan getInsertID() bukan insert()

        // Insert order items
        $orderItemModel = new OrderItemModel();
        foreach ($cartItems as $item) {
            $orderItemModel->insert([
                'order_id' => $orderId,
                'product_id' => $item['id'],
                'quantity' => $item['quantity'],
                'price' => $item['price']
            ]);

            // Update stock
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
}
