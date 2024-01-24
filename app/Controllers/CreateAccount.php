<?php

namespace App\Controllers;

use App\Models\AccountModel;

class CreateAccount extends BaseController
{
    public function checkUsername()
    {
        if ($this->request->isAJAX()) {
            $username = $this->request->getVar('createUser');
            $model = new AccountModel();
            $user = $model->where('username', $username)->first();
            if ($user) {
                return $this->response->setJSON(false);
            } else {
                return $this->response->setJSON(true);
            }
        }
    }


    public function checkUsernameExists()
    {
        if ($this->request->isAJAX()) {
            $username = $this->request->getVar('hdnUserChecker');
            $model = new AccountModel();
            $user = $model->where('username', $username)->first();
            if ($user) {
                return $this->response->setJSON(false);
            } else {
                return $this->response->setJSON(true);
            }
        }
    }


    public function sendOTP()
    {
        $checkEmail = $this->request->getPost('checkEmail');
        $otp = mt_rand(1111, 9999);
        $expiration_time = time() + 300; // 300 seconds = 5 minutes
        $this->session->set('expiration_timeOTP', $expiration_time);
        $this->session->set('createOTP', $otp);
        $this->session->set('checkEmail', $checkEmail);

        $fromEmail = getenv('SENDER_EMAIL');
       
        $client = \Config\Services::curlrequest();
        $payload = array(
            'from' => $fromEmail,
            'to' => '["' . $checkEmail . '"]',
            'subject' => 'Verify your email',
            'text' => 'Your OTP number is ' . $otp,
            'html' => 'To verify your email, please input this OTP number: <br> <h1>' . $otp . '</h1>'
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
    }


    public function checkOTPCorrect()
    {
        $otp = $this->request->getPost('OTP');
        $email = $this->request->getPost('email');
        $sessionOTP = $this->session->createOTP;
        $sessionEmail = $this->session->checkEmail;
        if (time() > $this->session->expiration_timeOTP) {
            // Code has expired, delete session data
            $this->session->remove('expiration_timeOTP');
            $this->session->remove('createOTP');
            $this->session->remove('checkEmail');
            return $this->response->setJSON(false);
        } else {
            // Code is still valid
            if ($sessionOTP == $otp && $sessionEmail == $email) {
                $this->session->remove('expiration_timeOTP');
                $this->session->remove('createOTP');
                $this->session->remove('checkEmail');
                return $this->response->setJSON(true);
            } else {
                return $this->response->setJSON(false);
            }

        }
    }

    public function createAccount()
    {
        $model = new AccountModel();
        $email = $this->request->getPost('email');
        $confirmPass = 12345;
        $userLevel = $this->request->getPost('userLevel');
        $userName = $this->request->getPost('userName');
        $hashedPass = password_hash($confirmPass, PASSWORD_DEFAULT);
        $data = [
            'email' => $email,
            'username' => $userName,
            'password' => $hashedPass,
            'userLevel' => $userLevel,
            'status' => 1
        ];
        $account = $model->insert($data);
        if ($account) {
            echo "account created successfully";
        } else {
            echo "account not created successfully";
        }
    }
}