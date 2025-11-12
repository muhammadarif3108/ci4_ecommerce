<?php
// app/Controllers/Home.php
namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\CategoryModel;

class Home extends BaseController
{
    public function index()
    {
        $productModel = new ProductModel();
        $categoryModel = new CategoryModel();

        $data = [
            'title' => 'Home',
            'products' => $productModel->getProducts(12),
            'categories' => $categoryModel->getCategories()
        ];

        return view('home', $data);
    }

    public function product($id)
    {
        $productModel = new ProductModel();
        $product = $productModel->getProduct($id);

        if (!$product) {
            return redirect()->to('/')->with('error', 'Product not found');
        }

        $data = [
            'title' => $product['name'],
            'product' => $product
        ];

        return view('product_detail', $data);
    }

    public function category($id)
    {
        $categoryModel = new CategoryModel();
        $products = $categoryModel->getProductsByCategory($id);
        $category = $categoryModel->find($id);

        $data = [
            'title' => $category['name'],
            'products' => $products,
            'category' => $category
        ];

        return view('category', $data);
    }

    public function search()
    {
        $keyword = $this->request->getGet('q');
        $productModel = new ProductModel();

        $data = [
            'title' => 'Search: ' . $keyword,
            'products' => $productModel->searchProducts($keyword),
            'keyword' => $keyword
        ];

        return view('search', $data);
    }
}
