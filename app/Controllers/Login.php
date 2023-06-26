<?php

namespace App\Controllers;
use App\Models\AccountModel;

class Login extends BaseController
{
    public function index()
    {
        $data['data'] = $this->session->message;
        $this->session->remove('message');
        return view('login',$data);
    }
    public function login()
    {
        try {
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
        } catch (\Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }
    
    
}
