<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoryModel extends Model
{
    protected $table = 'categories';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'description'];

    // NONAKTIFKAN TIMESTAMPS
    protected $useTimestamps = false;

    public function getCategories()
    {
        return $this->findAll();
    }

    public function getProductsByCategory($categoryId)
    {
        return $this->db->table('products')
            ->select('products.*, categories.name as category_name')
            ->join('categories', 'categories.id = products.category_id')
            ->where('products.category_id', $categoryId)
            ->where('products.stock >', 0)
            ->get()->getResultArray();
    }
}
