<?php

namespace App\Controllers;

use App\Models\OrderModel;

class Payment extends BaseController
{
    protected $orderModel;

    public function __construct()
    {
        $this->orderModel = new OrderModel();
    }

    // Halaman pembayaran
    public function index($orderId)
    {
        if (!session()->has('user_id')) {
            return redirect()->to('/login');
        }

        $order = $this->orderModel->find($orderId);

        if (!$order || $order['user_id'] != session()->get('user_id')) {
            return redirect()->to('/orders')->with('error', 'Order not found');
        }

        // Cek apakah sudah upload bukti
        if ($order['payment_status'] !== 'unpaid') {
            return redirect()->to('/order/success/' . $orderId)
                ->with('info', 'Payment proof already uploaded');
        }

        $data = [
            'title' => 'Payment - Order #' . $orderId,
            'order' => $order
        ];

        return view('payment/index', $data);
    }

    // Upload bukti transfer
    public function upload($orderId)
    {
        if (!session()->has('user_id')) {
            return redirect()->to('/login');
        }

        $order = $this->orderModel->find($orderId);

        if (!$order || $order['user_id'] != session()->get('user_id')) {
            return redirect()->to('/orders')->with('error', 'Order not found');
        }

        // Validasi file
        $validation = \Config\Services::validation();
        $rules = [
            'payment_proof' => [
                'rules' => 'uploaded[payment_proof]|max_size[payment_proof,2048]|is_image[payment_proof]',
                'errors' => [
                    'uploaded' => 'Please upload payment proof',
                    'max_size' => 'File size must not exceed 2MB',
                    'is_image' => 'Only image files are allowed'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $validation->getErrors());
        }

        $file = $this->request->getFile('payment_proof');

        if ($file->isValid() && !$file->hasMoved()) {
            $newName = 'payment_' . $orderId . '_' . time() . '.' . $file->getExtension();
            $file->move(ROOTPATH . 'public/uploads/payments', $newName);

            // Update database
            if ($this->orderModel->updatePaymentProof($orderId, $newName)) {
                return redirect()->to('/order/success/' . $orderId)
                    ->with('success', 'Payment proof uploaded successfully. Waiting for verification.');
            }
        }

        return redirect()->back()->with('error', 'Failed to upload payment proof');
    }
}
