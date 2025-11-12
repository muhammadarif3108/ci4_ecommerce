<?php
// app/Controllers/Admin/Auth.php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Auth extends BaseController
{
    public function login()
    {
        if (session()->get('is_admin')) {
            return redirect()->to('/admin');
        }

        return view('admin/auth/login', ['title' => 'Admin Login']);
    }

    public function loginProcess()
    {
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        // Default admin credentials (in production, this should be in database)
        if ($email === 'admin@itechstore.com' && $password === 'admin123') {
            session()->set([
                'admin_id' => 1,
                'admin_name' => 'Administrator',
                'admin_email' => $email,
                'is_admin' => true
            ]);

            return redirect()->to('/admin')->with('success', 'Login successful');
        }

        return redirect()->back()->with('error', 'Invalid email or password');
    }

    public function logout()
    {
        session()->remove(['admin_id', 'admin_name', 'admin_email', 'is_admin']);
        return redirect()->to('/admin/login')->with('success', 'Logout successful');
    }
}
