<?php

namespace App\Controllers;
use App\Models\AccountModel;

class Login extends BaseController
{
    public function index()
    {
        return view('login');
    }

    public function login(){
        $model = new AccountModel();
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $user = $model->where('username like BINARY', $username)->first();

        if (!$user || !password_verify($password, $user['password'])) {
            $this->session->set([
                "status" => "error",
                "message" => "Invalid Username or Password"
            ]);

            return redirect()->to("login");
        }

        $this->session->set("user_id", $user["id"]); //registers user in session
        $this->session->set("user_username", $user["username"]);
        return redirect()->to("dashboard");
    
    }
}
