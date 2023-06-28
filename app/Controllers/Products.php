<?php

namespace App\Controllers;

class Products extends BaseController
{
    public function index()
    {
        if (!$this->session->has("user_id")) {

            return redirect()->to("login");
        }

        $permissionChecker = new \App\Libraries\PermissionChecker();

        // Pass the permissionChecker object to the view
        $data['permissionChecker'] = $permissionChecker;
        $data['pageTitle'] = 'Products';
        return view('products',$data);
    }

}