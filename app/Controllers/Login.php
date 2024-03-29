<?php

namespace App\Controllers;
use App\Models\AccountModel;

class Login extends BaseController
{
    public function index()
    {
        $data['data'] = $this->session->message;
        $this->session->remove('message');

        if ($this->session->has("user_id")) {

            return redirect()->to("dashboard");
        }

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

            if($user['firstTimeLogin'] == 0){
                $this->session->set("userEmail", $user["email"]);
                $this->session->set("user_id", $user["id"]); //registers user in session
                $this->session->set("user_username", $user["username"]);
                $this->session->set("user_level", $user["userLevel"]); 
                return redirect()->to("dashboard");
            }else{
                $user_id = $user["id"];
                return redirect()->to("firstTimeLogin")->with("user_id", $user_id);
            }
    
 
        } catch (\Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }
    
    
}
