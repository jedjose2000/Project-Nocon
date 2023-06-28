<?php

namespace App\Controllers;

class Dashboard extends BaseController
{
    public function index()
    {
        if (!$this->session->has("user_id")) {

            return redirect()->to("login");
        }
        $data['pageTitle'] = 'Dashboard';
        return view('dashboard',$data);
    }

    public function logout()
    {
      $this->session->destroy();
      return redirect()->to("login");
    }
}