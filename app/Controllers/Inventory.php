<?php

namespace App\Controllers;

class Inventory extends BaseController
{
    public function index()
    {
        if (!$this->session->has("user_id")) {

            return redirect()->to("login");
        }
        $permissionChecker = new \App\Libraries\PermissionChecker();
        $data['permissionChecker'] = $permissionChecker;
        $data['pageTitle'] = 'Inventory';
        return view('inventory',$data);
    }
}