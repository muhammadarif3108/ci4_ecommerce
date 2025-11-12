<?php
// app/Controllers/Admin/Product.php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ProductModel;
use App\Models\CategoryModel;

class Product extends BaseController
{
    protected $productModel;
    protected $categoryModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
        $this->categoryModel = new CategoryModel();
    }

    public function index()
    {
        if (!session()->get('is_admin')) {
            return redirect()->to('/admin/login');
        }

        $data = [
            'title' => 'Manage Products',
            'products' => $this->productModel->getProducts()
        ];

        return view('admin/products/index', $data);
    }

    public function add()
    {
        if (!session()->get('is_admin')) {
            return redirect()->to('/admin/login');
        }

        $data = [
            'title' => 'Add New Product',
            'categories' => $this->categoryModel->findAll()
        ];

        return view('admin/products/add', $data);
    }

    public function save()
    {
        if (!session()->get('is_admin')) {
            return redirect()->to('/admin/login');
        }

        $validation = \Config\Services::validation();

        $rules = [
            'name' => 'required|min_length[3]',
            'category_id' => 'required|numeric',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'description' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $data = [
            'category_id' => $this->request->getPost('category_id'),
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
            'price' => $this->request->getPost('price'),
            'stock' => $this->request->getPost('stock')
        ];

        // Handle image upload
        $image = $this->request->getFile('image');
        if ($image && $image->isValid() && !$image->hasMoved()) {
            $newName = $image->getRandomName();
            $image->move(ROOTPATH . 'public/uploads', $newName);
            $data['image'] = $newName;
        }

        if ($this->productModel->insert($data)) {
            return redirect()->to('/admin/products')->with('success', 'Product added successfully');
        }

        return redirect()->back()->with('error', 'Failed to add product');
    }

    public function edit($id)
    {
        if (!session()->get('is_admin')) {
            return redirect()->to('/admin/login');
        }

        $product = $this->productModel->find($id);

        if (!$product) {
            return redirect()->to('/admin/products')->with('error', 'Product not found');
        }

        $data = [
            'title' => 'Edit Product',
            'product' => $product,
            'categories' => $this->categoryModel->findAll()
        ];

        return view('admin/products/edit', $data);
    }

    public function update($id)
    {
        if (!session()->get('is_admin')) {
            return redirect()->to('/admin/login');
        }

        $validation = \Config\Services::validation();

        $rules = [
            'name' => 'required|min_length[3]',
            'category_id' => 'required|numeric',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'description' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $data = [
            'category_id' => $this->request->getPost('category_id'),
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
            'price' => $this->request->getPost('price'),
            'stock' => $this->request->getPost('stock')
        ];

        // Handle image upload
        $image = $this->request->getFile('image');
        if ($image && $image->isValid() && !$image->hasMoved()) {
            // Delete old image
            $oldProduct = $this->productModel->find($id);
            if ($oldProduct['image'] && file_exists(ROOTPATH . 'public/uploads/' . $oldProduct['image'])) {
                unlink(ROOTPATH . 'public/uploads/' . $oldProduct['image']);
            }

            $newName = $image->getRandomName();
            $image->move(ROOTPATH . 'public/uploads', $newName);
            $data['image'] = $newName;
        }

        if ($this->productModel->update($id, $data)) {
            return redirect()->to('/admin/products')->with('success', 'Product updated successfully');
        }

        return redirect()->back()->with('error', 'Failed to update product');
    }

    public function delete($id)
    {
        if (!session()->get('is_admin')) {
            return redirect()->to('/admin/login');
        }

        $product = $this->productModel->find($id);

        if (!$product) {
            return redirect()->to('/admin/products')->with('error', 'Product not found');
        }

        // Delete image
        if ($product['image'] && file_exists(ROOTPATH . 'public/uploads/' . $product['image'])) {
            unlink(ROOTPATH . 'public/uploads/' . $product['image']);
        }

        if ($this->productModel->delete($id)) {
            return redirect()->to('/admin/products')->with('success', 'Product deleted successfully');
        }

        return redirect()->to('/admin/products')->with('error', 'Failed to delete product');
    }
}
