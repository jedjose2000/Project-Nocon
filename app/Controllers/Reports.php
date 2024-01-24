<?php

namespace App\Controllers;
use App\Models\TransactionHolderModel;

class Reports extends BaseController
{
    public function index()
    {
        $userLevel = $this->session->user_level;
        $data['userLevel'] = $userLevel;
        return view('reports');
    }
}
