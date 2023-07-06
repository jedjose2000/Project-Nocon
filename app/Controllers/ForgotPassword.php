<?php

namespace App\Controllers;

use App\Models\AccountModel;

$email = \Config\Services::email();
$client = \Config\Services::curlrequest();
class ForgotPassword extends BaseController
{
  public function index()
  {
    $userLevel = $this->session->user_level;
    $data['userLevel'] = $userLevel;
    $data['pageTitle'] = 'Forgot Password';
    $data['userName'] = $this->session->user_username;
    return view('forgot-password', $data);
  }

  public function checkEmail()
  {
    $model = new AccountModel();
    $checkUser = $this->request->getPost('checkUser');
    $user = $model->where('username', $checkUser)->first();
    if ($user) {
      $fetchEmail = $user['email'];
      $response = [
        'success' => true,
        'email' => $fetchEmail,
        'usernameValidation' => $checkUser = $this->request->getPost('checkUser')
      ];
      return $this->response->setHeader('Content-Type', 'application/json')->setBody(json_encode($response));

      // return $this->response->setJSON(true, $fetchEmail);
    } else {
      return $this->response->setJSON(false);
    }

  }

  public function sendOTP()
  {
    $model = new AccountModel();
    $checkUser = $this->request->getPost('checkUsername');
    $user = $model->where('username', $checkUser)->first();
    if ($user) {
      $fetchEmail = $user['email'];
      $otp = mt_rand(1111, 9999);
      $expiration_time = time() + 300; // 300 seconds = 5 minutes
      $this->session->set('expiration_time', $expiration_time);
      // $this->session->set([
      //   "status" => "error",
      //   "message" => "Invalid Username or Password"
      // ]);
      $fetchID = $user['id'];
      $data = [
        'otp' => $otp
      ];
      $model->update($fetchID, $data);

      $client = \Config\Services::curlrequest();
      $payload = array(
        'from' => 'RAJ PETSHOP <from>',
        'to' => '["' . $fetchEmail . '"]',
        'subject' => 'Reset Your Password',
        'text' => 'Hi '.$checkUser. '<br><br>If you did not request this change, you can safely ignore this email.<br><br> You\'re receiving this email because you requested a password reset for your RAJ Petshop Account. To choose a new password and complete your request, please kindly input this OTP code:' . $otp,
        'html' => 'Hi '.$checkUser. '<br><br>If you did not request this change, you can safely ignore this email.<br><br>You\'re receiving this email because you requested a password reset for your RAJ Petshop Account. To choose a new password and complete your request, please input the OTP code provided below:<br><br><h1>' . $otp . '</h1>', 
      );
      $jsonData = json_encode($payload);

      $headers = [
        'Content-Type' => 'application/json',
        'Content-Length' => strlen($jsonData)
      ];

      $response = $client->request('POST', 'https://project-nocon-api.onrender.com/email', [
        'headers' => $headers,
        'body' => $jsonData
      ]);

      $body = $response->getBody();

      // return $this->response->setJSON($body[]);


      $datas = json_decode($body); // convert JSON string to PHP object

      $field = $datas->success;
      return $this->response->setJSON($field);
    } else {
      return $this->response->setJSON(false);
    }

  }

  public function checkOTP()
  {
    $model = new AccountModel();
    $checkOTP = $this->request->getPost('checkOTP');
    $checkUsername = $this->request->getPost('checkUsername');
    $user = $model->where('username', $checkUsername)->first();

    if (time() > $this->session->expiration_time) {
      // Code has expired, delete session data
      $this->session->destroy();
      return $this->response->setJSON(false);
    } else {
      // Code is still valid
      if ($user && $user['otp'] == $checkOTP) {
        $this->session->destroy();
        return $this->response->setJSON(true);
      } else {
        return $this->response->setJSON(false);
      }
    }


  }

  public function changePassword()
  {
    $model = new AccountModel();
    $changePassword = $this->request->getPost('confirmPass');
    $Username = $this->request->getPost('Username');
    $user = $model->where('username', $Username)->first();
    if ($user) {
      $fetchID = $user['id'];
      $hashedPass = password_hash($changePassword, PASSWORD_DEFAULT);
      $data = [
        'password' => $hashedPass
      ];
      $model->update($fetchID, $data);
      return $this->response->setJSON(true);
    } else {
      return $this->response->setJSON(false);
    }






  }
}