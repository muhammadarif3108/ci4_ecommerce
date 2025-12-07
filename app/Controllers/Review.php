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
        // Cek login
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

        // Simpan review
        $data = [
            'product_id' => $productId,
            'user_id' => $userId,
            'order_id' => $orderId,
            'rating' => $this->request->getPost('rating'),
            'comment' => $this->request->getPost('comment')
        ];

        if ($this->reviewModel->insert($data)) {
            // HAPUS auto-update rating untuk menghindari error
            // Data rating akan dihitung real-time di Home controller

            return redirect()->to('/order/detail/' . $orderId)
                ->with('success', 'Terima kasih! Review Anda telah disimpan');
        } else {
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

        $data = [
            'rating' => $this->request->getPost('rating'),
            'comment' => $this->request->getPost('comment')
        ];

        if ($this->reviewModel->update($reviewId, $data)) {
            // HAPUS auto-update rating untuk menghindari error
            // Data rating akan dihitung real-time di Home controller

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

        if ($this->reviewModel->delete($reviewId)) {
            // HAPUS auto-update rating untuk menghindari error
            // Data rating akan dihitung real-time di Home controller

            return redirect()->to('/order/detail/' . $review['order_id'])
                ->with('success', 'Review berhasil dihapus');
        } else {
            return redirect()->back()->with('error', 'Gagal menghapus review');
        }
    }
}
