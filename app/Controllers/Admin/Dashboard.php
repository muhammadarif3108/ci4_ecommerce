<?php
// app/Controllers/Admin/Dashboard.php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ProductModel;
use App\Models\OrderModel;
use App\Models\UserModel;
use App\Models\CategoryModel;

class Dashboard extends BaseController
{
    public function index()
    {
        if (!session()->get('is_admin')) {
            return redirect()->to('/admin/login');
        }

        $productModel = new ProductModel();
        $orderModel = new OrderModel();
        $userModel = new UserModel();
        $categoryModel = new CategoryModel();

        // Get statistics
        $totalProducts = $productModel->countAll();
        $totalOrders = $orderModel->countAll();
        $totalUsers = $userModel->countAll();
        $totalCategories = $categoryModel->countAll();

        // Get recent orders with customer info (gunakan method baru)
        $recentOrders = $orderModel->getAllOrdersWithCustomer();

        // Batasi hanya 10 order terbaru
        $recentOrders = array_slice($recentOrders, 0, 10);

        // Calculate total revenue (gunakan method baru - exclude cancelled)
        $totalRevenue = $orderModel->getTotalRevenue();

        // Get low stock products
        $lowStockProducts = $productModel->where('stock <', 10)
            ->orderBy('stock', 'ASC')
            ->findAll();

        // Get order statistics (tambahan untuk chart/grafik)
        $orderStats = $orderModel->getOrderStatistics();

        // Get best sellers (produk terlaris)
        $bestSellers = $productModel->getBestSellers(5);

        // Get top rated products
        $topRated = $productModel->getTopRated(5);

        $data = [
            'title' => 'Admin Dashboard',
            'totalProducts' => $totalProducts,
            'totalOrders' => $totalOrders,
            'totalUsers' => $totalUsers,
            'totalCategories' => $totalCategories,
            'totalRevenue' => $totalRevenue,
            'recentOrders' => $recentOrders,
            'lowStockProducts' => $lowStockProducts,
            'orderStats' => $orderStats,
            'bestSellers' => $bestSellers,
            'topRated' => $topRated
        ];

        return view('admin/dashboard', $data);
    }
}
