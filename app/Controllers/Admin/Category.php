<?php
// app/Controllers/Admin/Category.php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CategoryModel;

class Category extends BaseController
{
    protected $categoryModel;

    public function __construct()
    {
        $this->categoryModel = new CategoryModel();
    }

    public function index()
    {
        if (!session()->get('is_admin')) {
            return redirect()->to('/admin/login');
        }

        $data = [
            'title' => 'Manage Categories',
            'categories' => $this->categoryModel->findAll()
        ];

        return view('admin/categories/index', $data);
    }

    public function save()
    {
        if (!session()->get('is_admin')) {
            return redirect()->to('/admin/login');
        }

        $data = [
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description')
        ];

        if ($this->categoryModel->insert($data)) {
            return redirect()->to('/admin/categories')->with('success', 'Category added successfully');
        }

        return redirect()->back()->with('error', 'Failed to add category');
    }

    public function update($id)
    {
        if (!session()->get('is_admin')) {
            return redirect()->to('/admin/login');
        }

        $data = [
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description')
        ];

        if ($this->categoryModel->update($id, $data)) {
            return redirect()->to('/admin/categories')->with('success', 'Category updated successfully');
        }

        return redirect()->back()->with('error', 'Failed to update category');
    }

    public function delete($id)
    {
        if (!session()->get('is_admin')) {
            return redirect()->to('/admin/login');
        }

        if ($this->categoryModel->delete($id)) {
            return redirect()->to('/admin/categories')->with('success', 'Category deleted successfully');
        }

        return redirect()->to('/admin/categories')->with('error', 'Failed to delete category');
    }
}
