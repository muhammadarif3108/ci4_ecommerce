<?php
// app/Controllers/Auth.php
namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    public function login()
    {
        if (session()->has('user_id')) {
            return redirect()->to('/');
        }

        return view('auth/login', ['title' => 'Login']);
    }

    public function loginProcess()
    {
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $userModel = new UserModel();
        $user = $userModel->where('email', $email)->first();

        if ($user && password_verify($password, $user['password'])) {
            session()->set([
                'user_id' => $user['id'],
                'user_name' => $user['name'],
                'user_email' => $user['email'],
                'logged_in' => true
            ]);

            return redirect()->to('/')->with('success', 'Login successful');
        }

        return redirect()->back()->with('error', 'Invalid email or password');
    }

    public function register()
    {
        if (session()->has('user_id')) {
            return redirect()->to('/');
        }

        return view('auth/register', ['title' => 'Register']);
    }

    public function registerProcess()
    {
        $userModel = new UserModel();

        $data = [
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'password' => $this->request->getPost('password'),
            'phone' => $this->request->getPost('phone'),
            'address' => $this->request->getPost('address')
        ];

        if ($userModel->insert($data)) {
            return redirect()->to('/login')->with('success', 'Registration successful. Please login.');
        }

        return redirect()->back()->with('error', 'Registration failed');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/')->with('success', 'Logout successful');
    }
}
