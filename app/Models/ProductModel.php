<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table = 'products';
    protected $primaryKey = 'id';
    protected $allowedFields = ['category_id', 'name', 'description', 'price', 'stock', 'image'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // ===== METHOD DASAR UNTUK CRUD =====

    public function getProducts($limit = null)
    {
        $builder = $this->select('products.*, categories.name as category_name')
            ->join('categories', 'categories.id = products.category_id', 'left')
            ->orderBy('products.created_at', 'DESC');

        if ($limit) {
            $builder->limit($limit);
        }

        return $builder->findAll();
    }

    public function getProduct($id)
    {
        return $this->select('products.*, categories.name as category_name')
            ->join('categories', 'categories.id = products.category_id', 'left')
            ->where('products.id', $id)
            ->first();
    }

    public function getProductsByCategory($categoryId)
    {
        return $this->where('category_id', $categoryId)
            ->orderBy('created_at', 'DESC')
            ->findAll();
    }

    // ===== METHOD UNTUK DASHBOARD =====

    public function getBestSellers($limit = 5)
    {
        return $this->select('products.*, COALESCE(SUM(order_items.quantity), 0) as total_sold')
            ->join('order_items', 'order_items.product_id = products.id', 'left')
            ->groupBy('products.id')
            ->orderBy('total_sold', 'DESC')
            ->limit($limit)
            ->findAll();
    }

    public function getTopRated($limit = 5)
    {
        return $this->select('products.*, categories.name as category_name')
            ->join('categories', 'categories.id = products.category_id', 'left')
            ->orderBy('products.price', 'DESC')
            ->limit($limit)
            ->findAll();
    }

    public function getLowStockProducts($threshold = 10)
    {
        return $this->select('products.*, categories.name as category_name')
            ->join('categories', 'categories.id = products.category_id', 'left')
            ->where('products.stock <', $threshold)
            ->orderBy('products.stock', 'ASC')
            ->findAll();
    }

    // ===== METHOD UNTUK SEARCH & FILTER =====

    public function searchProducts($keyword)
    {
        return $this->select('products.*, categories.name as category_name')
            ->join('categories', 'categories.id = products.category_id', 'left')
            ->groupStart()
            ->like('products.name', $keyword)
            ->orLike('products.description', $keyword)
            ->groupEnd()
            ->findAll();
    }

    // ===== METHOD UNTUK FRONTEND =====

    public function getActiveProducts()
    {
        return $this->select('products.*, categories.name as category_name')
            ->join('categories', 'categories.id = products.category_id', 'left')
            ->where('products.stock >', 0)
            ->orderBy('products.created_at', 'DESC')
            ->findAll();
    }

    public function getFeaturedProducts($limit = 8)
    {
        return $this->select('products.*, categories.name as category_name')
            ->join('categories', 'categories.id = products.category_id', 'left')
            ->where('products.stock >', 0)
            ->orderBy('products.created_at', 'DESC')
            ->limit($limit)
            ->findAll();
    }

    // ===== METHOD UNTUK PRODUCT DETAIL PAGE =====

    public function getProductWithCategory($id)
    {
        return $this->select('products.*, categories.name as category_name, categories.id as category_id')
            ->join('categories', 'categories.id = products.category_id', 'left')
            ->where('products.id', $id)
            ->first();
    }

    public function getRelatedProducts($categoryId, $currentProductId, $limit = 4)
    {
        return $this->select('products.*, categories.name as category_name')
            ->join('categories', 'categories.id = products.category_id', 'left')
            ->where('products.category_id', $categoryId)
            ->where('products.id !=', $currentProductId)
            ->where('products.stock >', 0)
            ->orderBy('RAND()')
            ->limit($limit)
            ->findAll();
    }
}
