<?php

namespace App\Controllers;
use App\Models\TransactionHolderModel;

class Reports extends BaseController
{
    public function index()
    {

        return view('reports');
    }
}
