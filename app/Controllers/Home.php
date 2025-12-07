<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\CategoryModel;
use App\Models\ReviewModel;
use App\Models\OrderItemModel;

class Home extends BaseController
{
    public function index()
    {
        $productModel = new ProductModel();
        $categoryModel = new CategoryModel();
        $reviewModel = new ReviewModel();
        $orderItemModel = new OrderItemModel();

        // Ambil produk (limit 12)
        $products = $productModel->getProducts(12);

        // Hitung sold dan rating untuk setiap produk
        foreach ($products as &$product) {
            // Hitung total terjual dari order_items
            $sold = $orderItemModel
                ->selectSum('quantity')
                ->where('product_id', $product['id'])
                ->first();
            $product['sold'] = $sold['quantity'] ?? 0;

            // Hitung rating dari reviews
            $product['rating'] = $reviewModel->getAverageRating($product['id']);
            $product['review_count'] = $reviewModel->getTotalReviews($product['id']);
        }

        $data = [
            'title' => 'Home',
            'products' => $products,
            'categories' => $categoryModel->getCategories()
        ];

        return view('home', $data);
    }

    public function product($id)
    {
        $productModel = new ProductModel();
        $product = $productModel->getProductWithCategory($id);

        if (!$product) {
            return redirect()->to('/')->with('error', 'Product not found');
        }

        $relatedProducts = $productModel->getRelatedProducts($product['category_id'], $id, 4);

        $data = [
            'title' => $product['name'],
            'product' => $product,
            'related_products' => $relatedProducts
        ];

        return view('product_detail', $data);
    }

    public function category($id)
    {
        $categoryModel = new CategoryModel();
        $reviewModel = new ReviewModel();
        $orderItemModel = new OrderItemModel();

        $products = $categoryModel->getProductsByCategory($id);
        $category = $categoryModel->find($id);

        if (!$category) {
            return redirect()->to('/')->with('error', 'Category not found');
        }

        // Hitung sold dan rating untuk setiap produk
        foreach ($products as &$product) {
            $sold = $orderItemModel
                ->selectSum('quantity')
                ->where('product_id', $product['id'])
                ->first();
            $product['sold'] = $sold['quantity'] ?? 0;

            $product['rating'] = $reviewModel->getAverageRating($product['id']);
            $product['review_count'] = $reviewModel->getTotalReviews($product['id']);
        }

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
        $reviewModel = new ReviewModel();
        $orderItemModel = new OrderItemModel();

        $products = $productModel->searchProducts($keyword);

        // Hitung sold dan rating untuk setiap produk
        foreach ($products as &$product) {
            $sold = $orderItemModel
                ->selectSum('quantity')
                ->where('product_id', $product['id'])
                ->first();
            $product['sold'] = $sold['quantity'] ?? 0;

            $product['rating'] = $reviewModel->getAverageRating($product['id']);
            $product['review_count'] = $reviewModel->getTotalReviews($product['id']);
        }

        $data = [
            'title' => 'Search: ' . $keyword,
            'products' => $products,
            'keyword' => $keyword
        ];

        return view('search', $data);
    }
}
