<?php

namespace App\Controllers;

class Transaction extends BaseController
{
    public function index()
    {
        $permissionChecker = new \App\Libraries\PermissionChecker();
        $data['permissionChecker'] = $permissionChecker;
        $data['pageTitle'] = 'Reports';
        return view('transaction',$data);
    }
}
