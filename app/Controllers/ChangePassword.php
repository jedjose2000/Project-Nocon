<?php

namespace App\Controllers;

use App\Models\AccountModel;

class ChangePassword extends BaseController
{
  public function changePassword()
  {
    $userID = $this->session->user_id;
    $model = new AccountModel();
    $currentPass = $this->request->getPost('currentPass');
    $confirmPass = $this->request->getPost('confirmPass');
    $hashedPass = password_hash($confirmPass,PASSWORD_DEFAULT);
    $user = $model->where('id', $userID)->first();
    if (password_verify($currentPass, $user['password']) == true) {
      $data = [
        'password' => $hashedPass
      ];
      $model->update($userID, $data);
      return $this->response->setJSON(true);
    } else {
      return $this->response->setJSON(false);
    }
  }

  public function logout()
  {
    $this->session->destroy();
    return redirect()->to("login");
  }
}