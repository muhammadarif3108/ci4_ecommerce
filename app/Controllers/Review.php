<?php

namespace App\Controllers;

use App\Models\ReviewModel;
use App\Models\OrderModel;
use App\Models\OrderItemModel;

class Review extends BaseController
{
    protected $reviewModel;
    protected $orderModel;
    protected $orderItemModel;

    public function __construct()
    {
        $this->reviewModel = new ReviewModel();
        $this->orderModel = new OrderModel();
        $this->orderItemModel = new OrderItemModel();
    }

    // Tampilkan form review
    public function create($orderId, $productId)
    {
        if (!session()->get('user_id')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu');
        }

        $userId = session()->get('user_id');

        // Validasi order milik user dan sudah selesai
        $order = $this->orderModel->find($orderId);

        if (!$order || $order['user_id'] != $userId) {
            return redirect()->to('/orders')->with('error', 'Order tidak ditemukan');
        }

        if ($order['status'] != 'delivered') {
            return redirect()->to('/order/detail/' . $orderId)
                ->with('error', 'Anda hanya bisa memberikan review setelah pesanan diterima');
        }

        // Cek apakah produk ada di order
        $orderItem = $this->orderItemModel
            ->select('order_items.*, products.name as product_name, products.image as product_image')
            ->join('products', 'products.id = order_items.product_id')
            ->where(['order_items.order_id' => $orderId, 'order_items.product_id' => $productId])
            ->first();

        if (!$orderItem) {
            return redirect()->to('/order/detail/' . $orderId)
                ->with('error', 'Produk tidak ditemukan dalam pesanan ini');
        }

        // Cek apakah sudah pernah review
        if ($this->reviewModel->hasReviewed($productId, $userId, $orderId)) {
            return redirect()->to('/order/detail/' . $orderId)
                ->with('error', 'Anda sudah memberikan review untuk produk ini');
        }

        $data = [
            'title' => 'Beri Review',
            'order' => $order,
            'product' => $orderItem
        ];

        return view('review/create', $data);
    }

    // Simpan review
    public function store()
    {
        if (!session()->get('user_id')) {
            return redirect()->to('/login');
        }

        // Validasi input
        $rules = [
            'product_id' => 'required|integer',
            'order_id' => 'required|integer',
            'rating' => 'required|integer|greater_than[0]|less_than[6]',
            'comment' => 'permit_empty|max_length[1000]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $userId = session()->get('user_id');
        $productId = $this->request->getPost('product_id');
        $orderId = $this->request->getPost('order_id');

        // Validasi ulang order
        $order = $this->orderModel->find($orderId);

        if (!$order || $order['user_id'] != $userId || $order['status'] != 'delivered') {
            return redirect()->to('/orders')->with('error', 'Order tidak valid');
        }

        // Cek duplikasi
        if ($this->reviewModel->hasReviewed($productId, $userId, $orderId)) {
            return redirect()->to('/order/detail/' . $orderId)
                ->with('error', 'Anda sudah memberikan review untuk produk ini');
        }

        // Handle upload multiple images (max 5 images)
        $uploadedImages = [];
        $files = $this->request->getFileMultiple('review_images');

        if ($files && count($files) > 0) {
            $uploadPath = ROOTPATH . 'public/uploads/reviews';

            // Buat folder jika belum ada
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
            $maxSize = 2048; // 2MB per image
            $maxImages = 5;

            $validFiles = array_filter($files, function ($file) {
                return $file->isValid() && !$file->hasMoved();
            });

            if (count($validFiles) > $maxImages) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Maksimal upload 5 gambar');
            }

            foreach ($validFiles as $file) {
                // Validasi tipe file
                if (!in_array($file->getMimeType(), $allowedTypes)) {
                    continue;
                }

                // Validasi ukuran file
                if ($file->getSize() > ($maxSize * 1024)) {
                    continue;
                }

                // Generate nama file unik
                $newName = 'review_' . uniqid() . '_' . time() . '.' . $file->getExtension();

                // Move file
                if ($file->move($uploadPath, $newName)) {
                    $uploadedImages[] = $newName;
                }
            }
        }

        // Simpan review
        $data = [
            'product_id' => $productId,
            'user_id' => $userId,
            'order_id' => $orderId,
            'rating' => $this->request->getPost('rating'),
            'comment' => $this->request->getPost('comment'),
            'review_images' => !empty($uploadedImages) ? json_encode($uploadedImages) : null
        ];

        if ($this->reviewModel->insert($data)) {
            return redirect()->to('/order/detail/' . $orderId)
                ->with('success', 'Terima kasih! Review Anda telah disimpan');
        } else {
            // Hapus gambar jika gagal simpan
            foreach ($uploadedImages as $image) {
                $imagePath = ROOTPATH . 'public/uploads/reviews/' . $image;
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }

            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal menyimpan review');
        }
    }

    // Edit review
    public function edit($reviewId)
    {
        if (!session()->get('user_id')) {
            return redirect()->to('/login');
        }

        $userId = session()->get('user_id');
        $review = $this->reviewModel->find($reviewId);

        if (!$review || $review['user_id'] != $userId) {
            return redirect()->to('/orders')->with('error', 'Review tidak ditemukan');
        }

        $orderItem = $this->orderItemModel
            ->select('order_items.*, products.name as product_name, products.image as product_image')
            ->join('products', 'products.id = order_items.product_id')
            ->where(['order_items.order_id' => $review['order_id'], 'order_items.product_id' => $review['product_id']])
            ->first();

        $data = [
            'title' => 'Edit Review',
            'review' => $review,
            'product' => $orderItem
        ];

        return view('review/edit', $data);
    }

    // Update review
    public function update($reviewId)
    {
        if (!session()->get('user_id')) {
            return redirect()->to('/login');
        }

        $userId = session()->get('user_id');
        $review = $this->reviewModel->find($reviewId);

        if (!$review || $review['user_id'] != $userId) {
            return redirect()->to('/orders')->with('error', 'Review tidak ditemukan');
        }

        $rules = [
            'rating' => 'required|integer|greater_than[0]|less_than[6]',
            'comment' => 'permit_empty|max_length[1000]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        // Handle upload new images
        $existingImages = !empty($review['review_images']) ? json_decode($review['review_images'], true) : [];
        $uploadedImages = $existingImages;

        $files = $this->request->getFileMultiple('review_images');

        if ($files && count($files) > 0) {
            $uploadPath = ROOTPATH . 'public/uploads/reviews';

            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
            $maxSize = 2048;
            $maxImages = 5;

            $validFiles = array_filter($files, function ($file) {
                return $file->isValid() && !$file->hasMoved();
            });

            $totalImages = count($existingImages) + count($validFiles);

            if ($totalImages > $maxImages) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Total gambar tidak boleh lebih dari 5');
            }

            foreach ($validFiles as $file) {
                if (!in_array($file->getMimeType(), $allowedTypes)) {
                    continue;
                }

                if ($file->getSize() > ($maxSize * 1024)) {
                    continue;
                }

                $newName = 'review_' . uniqid() . '_' . time() . '.' . $file->getExtension();

                if ($file->move($uploadPath, $newName)) {
                    $uploadedImages[] = $newName;
                }
            }
        }

        $data = [
            'rating' => $this->request->getPost('rating'),
            'comment' => $this->request->getPost('comment'),
            'review_images' => !empty($uploadedImages) ? json_encode($uploadedImages) : null
        ];

        if ($this->reviewModel->update($reviewId, $data)) {
            return redirect()->to('/order/detail/' . $review['order_id'])
                ->with('success', 'Review berhasil diperbarui');
        } else {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui review');
        }
    }

    // Hapus review
    public function delete($reviewId)
    {
        if (!session()->get('user_id')) {
            return redirect()->to('/login');
        }

        $userId = session()->get('user_id');
        $review = $this->reviewModel->find($reviewId);

        if (!$review || $review['user_id'] != $userId) {
            return redirect()->to('/orders')->with('error', 'Review tidak ditemukan');
        }

        // Hapus gambar review jika ada
        if (!empty($review['review_images'])) {
            $images = json_decode($review['review_images'], true);
            foreach ($images as $image) {
                $imagePath = ROOTPATH . 'public/uploads/reviews/' . $image;
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }
        }

        if ($this->reviewModel->delete($reviewId)) {
            return redirect()->to('/order/detail/' . $review['order_id'])
                ->with('success', 'Review berhasil dihapus');
        } else {
            return redirect()->back()->with('error', 'Gagal menghapus review');
        }
    }

    // Hapus satu gambar dari review
    public function deleteImage($reviewId, $imageIndex)
    {
        if (!session()->get('user_id')) {
            return $this->response->setJSON(['success' => false, 'message' => 'Unauthorized']);
        }

        $userId = session()->get('user_id');
        $review = $this->reviewModel->find($reviewId);

        if (!$review || $review['user_id'] != $userId) {
            return $this->response->setJSON(['success' => false, 'message' => 'Review not found']);
        }

        if (empty($review['review_images'])) {
            return $this->response->setJSON(['success' => false, 'message' => 'No images found']);
        }

        $images = json_decode($review['review_images'], true);

        if (!isset($images[$imageIndex])) {
            return $this->response->setJSON(['success' => false, 'message' => 'Image not found']);
        }

        // Hapus file gambar
        $imagePath = ROOTPATH . 'public/uploads/reviews/' . $images[$imageIndex];
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }

        // Hapus dari array
        unset($images[$imageIndex]);
        $images = array_values($images); // Reindex array

        // Update database
        $updatedImages = !empty($images) ? json_encode($images) : null;
        $this->reviewModel->update($reviewId, ['review_images' => $updatedImages]);

        return $this->response->setJSON(['success' => true, 'message' => 'Image deleted']);
    }
}
