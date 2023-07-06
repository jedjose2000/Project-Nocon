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
        $userLevel = $this->session->user_level;
        $data['userLevel'] = $userLevel;
        $categoryModel->select('*');
        $categoryModel->where('isCategoryArchived', 0);
        $query = $categoryModel->get();
        $result = $query->getResult();

        $supplierModel->select('*');
        $supplierModel->where('isSupplierArchived', 0);
        $query = $supplierModel->get();
        $resultSupplier = $query->getResult();

        $data["supplier"] = $resultSupplier;
        $data["updateSupplier"] = $resultSupplier;
        $data["viewSupplier"] = $resultSupplier;
        $data["category"] = $result;
        $data["updateCategory"] = $result;
        $data["viewCategory"] = $result;
        $data["result"] = $results;
        $data['permissionChecker'] = $permissionChecker;
        $data['pageTitle'] = 'Products';
        return view('products', $data);
    }

    public function checkProductNameExists()
    {
        if ($this->request->isAJAX()) {
            $txtProduct = trim($this->request->getVar('txtProduct'));
            $model = new ProductModel();

            $user = $model->where("REPLACE(productName, ' ', '')", str_replace(' ', '', $txtProduct))->first();

            if ($user) {
                return $this->response->setJSON(false);
            } else {
                return $this->response->setJSON(true);
            }
        }
    }

    public function insertProduct()
    {
        $model = new ProductModel();
        $productName = $this->request->getPost('productName');
        $brandName = $this->request->getPost('brandName');
    
        $categoryId = $this->request->getPost('categoryId');
        $supplierId = $this->request->getPost('supplierId');
        $productDescription = $this->request->getPost('productDescription');
        $unit = $this->request->getPost('unit');
        $buyPrice = $this->request->getPost('buyPrice');
        $sellPrice = $this->request->getPost('sellPrice');
        $clq = $this->request->getPost('clq');
        $willExpire = $this->request->getPost('willExpire');
    
        $model->transStart();
    
        try {
            $db = db_connect();
            $fields = $db->getFieldNames($model->table);
    
            $data = [
                'productName' => $productName,
                'productBrand' => $brandName,
                'categoryID' => $categoryId,
                'productDescription' => $productDescription,
                'unit' => $unit,
                'buyPrice' => $buyPrice,
                'sellPrice' => $sellPrice,
                'clq' => $clq,
                'willExpire' => $willExpire,
                'productCode' => ''
            ];
    
            // Check if there is an existing productId
            $productId = $this->request->getPost('productId');
            if (!empty($productId)) {
                // Perform the update operation
                $updated = $model->update($productId, $data);
                if ($updated === false) {
                    echo 'Transaction failed.';
                    $model->transRollback();
                } else {
                    // Update the productCode field
                    $productCode = 'PRD-' . str_pad($productId, 5, '0', STR_PAD_LEFT);
                    $updatedCode = $model->update($productId, ['productCode' => $productCode]);
            
                    if ($updatedCode === false) {
                        echo 'Transaction failed.';
                        $model->transRollback();
                    } else {
                        echo 'Transaction success.';
                        $model->transCommit();
                    }
                }
            } else {
                // Perform the insert operation
                foreach ($data as $field => $value) {
                    if (!in_array($field, $fields)) {
                        echo 'Transaction failed.';
                        $model->transRollback();
                        return;
                    }
                }
                $model->insert($data);
                $productId = $model->insertID();
    
                // Update the productCode field
                $productCode = 'PRD-' . str_pad($productId, 5, '0', STR_PAD_LEFT);
                $updated = $model->update($productId, ['productCode' => $productCode]);
    
                if ($updated === false) {
                    echo 'Transaction failed.';
                    $model->transRollback();
                } else {
                    echo 'Transaction success.';
                    $model->transCommit();
                }
            }
        } catch (\Exception $e) {
            log_message('error', 'Exception: ' . $e->getMessage());
            $model->transRollback();
        }
    }

    public function viewProduct(){
        $model = new ProductModel();
        $model->select('*');
        $query = $model->get();
        $result = $query->getResultArray();
        return json_encode($result);
    }

    public function checkUpdateProductNameExists(){
        if ($this->request->isAJAX()) {
            $txtProduct = trim($this->request->getVar('txtUpdateProduct'));
            $txtProductId = $this->request->getVar('txtUpdateProductId');

            $model = new ProductModel();
            $product = $model->where("REPLACE(productName, ' ', '')", str_replace(' ', '', $txtProduct))->first();

            if ($product && $product['productId'] != $txtProductId) {
                return $this->response->setJSON(false);
            } else {
                return $this->response->setJSON(true);
            }
        }
    }
    
    public function archiveAllProducts(){
        $model = new ProductModel();
        $productIds = $this->request->getPost('productId');

        // Start a database transaction
        $model->transStart();

        try {
            foreach ($productIds as $id) {
                $data = [
                    'isProductArchived' => 1
                ];
                $model->update($id, $data);
            }

            // Commit the transaction if all operations are successful
            $model->transCommit();

            echo "multi user archived";
        } catch (\Exception $e) {
            // Roll back the transaction if an error occurs
            $model->transRollback();

            echo "Error: " . $e->getMessage();
        }
    }

    public function getIDProduct(){
        $model = new ProductModel();
        $productId = $this->request->getPost('productId');
        $model->transStart();

        try {

            $data = [
                'isProductArchived' => 1
            ];
            $model->update($productId, $data);
            // Commit the transaction if all operations are successful
            $model->transCommit();

            echo "multi user archived";
        } catch (\Exception $e) {
            // Roll back the transaction if an error occurs
            $model->transRollback();

            echo "Error: " . $e->getMessage();
        }
    }
}