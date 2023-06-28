<?php

namespace App\Controllers;
use App\Models\CategoryModel;
use App\Models\ProductModel;
use App\Models\SupplierModel;

class Products extends BaseController
{
    public function index()
    {
        $productModel = new ProductModel();
        $supplierModel = new SupplierModel();
        $categoryModel = new CategoryModel();
        $results = $productModel->getProductsWithSupplierAndCategory();

        if (!$this->session->has("user_id")) {

            return redirect()->to("login");
        }

        $permissionChecker = new \App\Libraries\PermissionChecker();

        $data["result"] = $results;
        $data['permissionChecker'] = $permissionChecker;
        $data['pageTitle'] = 'Products';
        return view('products',$data);
    }

}