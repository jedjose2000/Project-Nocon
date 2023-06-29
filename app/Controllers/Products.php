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

        $categoryModel->select('*');
        $categoryModel->where('isCategoryArchived', 0);
        $query = $categoryModel->get();
        $result = $query->getResult();

        $supplierModel->select('*');
        $supplierModel->where('isSupplierArchived', 0);
        $query = $supplierModel->get();
        $resultSupplier = $query->getResult();

        $data["supplier"] = $resultSupplier;
        $data["category"] = $result;
        $data["result"] = $results;
        $data['permissionChecker'] = $permissionChecker;
        $data['pageTitle'] = 'Products';
        return view('products',$data);
    }

    public function checkProductNameExists(){
        if ($this->request->isAJAX()) {
            $txtProduct = $this->request->getVar('txtProduct');
            $model = new ProductModel();
            $user = $model->where('productName', $txtProduct)->first();
            if ($user) {
                return $this->response->setJSON(false);
            } else {
                return $this->response->setJSON(true);
            }
        }
    }
}