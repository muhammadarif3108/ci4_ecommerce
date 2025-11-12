<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderItemModel extends Model
{
    protected $table = 'order_items';
    protected $primaryKey = 'id';
    protected $allowedFields = ['order_id', 'product_id', 'quantity', 'price'];

    // NONAKTIFKAN TIMESTAMPS
    protected $useTimestamps = false;

    public function getOrderItems($orderId)
    {
        return $this->select('order_items.*, products.name as product_name, products.image')
            ->join('products', 'products.id = order_items.product_id')
            ->where('order_items.order_id', $orderId)
            ->findAll();
    }
}
