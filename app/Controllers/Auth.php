<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    public function login()
    {
    //   $hash = password_hash("123456", PASSWORD_DEFAULT);
// print_r($hash);
        if ($this->request->getMethod() === 'post') {
            $username = $this->request->getPost('username');
            $password = $this->request->getPost('password');

            $userModel = new UserModel();
            $user = $userModel->where('username', $username)->first();
           // print_r($user);die;
            if ($user && password_verify($password, $user['password_hash']) && $user['status'] == 1) {
                $this->session->set([
                    'user_id' => $user['id'],
                    'username' => $user['username'],
                    'role' => $user['role'],
                    'isLoggedIn' => true,
                ]);
                return redirect()->to('/admin');
            }

            return redirect()->back()->with('error', 'Sai tài khoản hoặc mật khẩu');
        }

        return view('auth/login', ['title' => 'Đăng nhập']);
    }

    public function logout()
    {
        $this->session->destroy();
        return redirect()->to('/login');
    }
}
