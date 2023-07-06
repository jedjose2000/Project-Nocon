<?php

namespace App\Controllers;
use App\Models\AccountModel;

class FirstTime extends BaseController
{
    public function index()
    {

        return view('first-time');
    }


    public function forFirstTimeChangePassword(){
        $model = new AccountModel();
        $changePassword = $this->request->getPost('confirmPass');
        $userID = $this->request->getPost('userID');
        $user = $model->where('id', $userID)->first();
        if ($user) {
          $fetchID = $user['id'];
          $hashedPass = password_hash($changePassword, PASSWORD_DEFAULT);
          $data = [
            'password' => $hashedPass,
            'firstTimeLogin' => 0
          ];
          $model->update($fetchID, $data);
          return $this->response->setJSON(true);
        } else {
          return $this->response->setJSON(false);
        }
    
    }
}