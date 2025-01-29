<?php

namespace App\Controllers;

use App\Models\AuthModel;
use CodeIgniter\Controller;

class AuthController extends Controller
{
    public function login()
    {
        helper(['form']);
        $data = [];

        if ($this->request->getMethod() == 'POST') {
            $model = new AuthModel();
            $user = $model->where('email', $this->request->getVar('email'))->first();

            if ($user && password_verify($this->request->getVar('password'), $user['password'])) {
                session()->set([
                    'id' => $user['id'],
                    'name' => $user['name'],
                    'email' => $user['email'],
                    'isLoggedIn' => true,
                ]);

                // Redirect to the original URL or dashboard
                $redirectUrl = session()->get('redirect_url') ?? '/dashboard';
                session()->remove('redirect_url'); // Clear the redirect URL
                return redirect()->to($redirectUrl);
            } else {
                $data['error'] = 'Invalid email or password.';
            }
        }

        return view('/login', $data);
    }

    public function register()
    {
        helper(['form']);
        $data = [];

        if ($this->request->getMethod() == 'POST') {

            $model = new AuthModel();
            $model->save([
                'name' => $this->request->getVar('name'),
                'email' => $this->request->getVar('email'),
                'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
            ]);

            return redirect()->to('/login')->with('success', 'Registration successful!');
        }

        return view('/register', $data);
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
