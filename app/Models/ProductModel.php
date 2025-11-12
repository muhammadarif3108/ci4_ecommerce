<?php
// app/Models/ProductModel.php
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

    public function getProducts($limit = null, $offset = 0)
    {
        $builder = $this->select('products.*, categories.name as category_name')
            ->join('categories', 'categories.id = products.category_id')
            ->where('products.stock >', 0);

        if ($limit) {
            $builder->limit($limit, $offset);
        }

        return $builder->get()->getResultArray();
    }

    public function getProduct($id)
    {
        return $this->select('products.*, categories.name as category_name')
            ->join('categories', 'categories.id = products.category_id')
            ->where('products.id', $id)
            ->first();
    }

    public function searchProducts($keyword)
    {
        return $this->select('products.*, categories.name as category_name')
            ->join('categories', 'categories.id = products.category_id')
            ->like('products.name', $keyword)
            ->orLike('products.description', $keyword)
            ->get()->getResultArray();
    }
}