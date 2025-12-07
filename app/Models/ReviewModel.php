<?php

namespace App\Models;  // ← Pastikan ini 'Models' dengan huruf 's'

use CodeIgniter\Model;

class ReviewModel extends Model
{
    protected $table = 'product_reviews';
    protected $primaryKey = 'id';
    protected $allowedFields = ['product_id', 'user_id', 'order_id', 'rating', 'comment'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Cek apakah user sudah memberikan review untuk produk dari order tertentu
    public function hasReviewed($productId, $userId, $orderId)
    {
        return $this->where([
            'product_id' => $productId,
            'user_id' => $userId,
            'order_id' => $orderId
        ])->first() !== null;
    }

    // Ambil semua review produk dengan informasi user
    public function getProductReviews($productId, $limit = null)
    {
        $builder = $this->select('product_reviews.*, users.name as user_name')
            ->join('users', 'users.id = product_reviews.user_id')
            ->where('product_reviews.product_id', $productId)
            ->orderBy('product_reviews.created_at', 'DESC');

        if ($limit) {
            $builder->limit($limit);
        }

        return $builder->findAll();
    }

    // Hitung rata-rata rating produk
    public function getAverageRating($productId)
    {
        $result = $this->selectAvg('rating')
            ->where('product_id', $productId)
            ->first();

        return $result['rating'] ? round($result['rating'], 1) : 0;
    }

    // Hitung total review produk
    public function getTotalReviews($productId)
    {
        return $this->where('product_id', $productId)->countAllResults();
    }

    // Ambil statistik rating (berapa banyak rating 1-5)
    public function getRatingStats($productId)
    {
        $stats = [];
        for ($i = 5; $i >= 1; $i--) {
            $count = $this->where(['product_id' => $productId, 'rating' => $i])
                ->countAllResults();
            $stats[$i] = $count;
        }
        return $stats;
    }

    // Ambil review user untuk produk tertentu
    public function getUserReview($productId, $userId, $orderId)
    {
        return $this->where([
            'product_id' => $productId,
            'user_id' => $userId,
            'order_id' => $orderId
        ])->first();
    }

    // Update rating dan review count di tabel products
    public function updateProductRating($productId)
    {
        $avgRating = $this->getAverageRating($productId);
        $totalReviews = $this->getTotalReviews($productId);

        $productModel = new \App\Models\ProductModel();
        $productModel->update($productId, [
            'rating' => $avgRating,
            'review_count' => $totalReviews
        ]);
    }
}
